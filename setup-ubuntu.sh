#!/usr/bin/env bash
set -euo pipefail

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PORT="8000"
SKIP_INSTALL="false"
SKIP_TESTS="false"
SERVE_AFTER="false"

log() {
  printf '\n[setup] %s\n' "$1"
}

fail() {
  printf '\n[setup][erro] %s\n' "$1" >&2
  exit 1
}

usage() {
  cat <<USAGE
Uso: ./setup-ubuntu.sh [opções]

Opções:
  --skip-install   Pula instalação de dependências via apt
  --skip-tests     Pula validações automáticas (lint + smoke HTTP)
  --serve          Mantém servidor HTTP no final (0.0.0.0:<porta>)
  --port <porta>   Define porta (padrão: 8000)
  -h, --help       Exibe esta ajuda
USAGE
}

while [[ $# -gt 0 ]]; do
  case "$1" in
    --skip-install)
      SKIP_INSTALL="true"
      shift
      ;;
    --skip-tests)
      SKIP_TESTS="true"
      shift
      ;;
    --serve)
      SERVE_AFTER="true"
      shift
      ;;
    --port)
      [[ $# -ge 2 ]] || fail "Informe o valor de --port"
      PORT="$2"
      shift 2
      ;;
    -h|--help)
      usage
      exit 0
      ;;
    *)
      fail "Opção inválida: $1"
      ;;
  esac
done

if ! [[ "$PORT" =~ ^[0-9]{2,5}$ ]]; then
  fail "Porta inválida: $PORT"
fi

run_with_privilege() {
  if [[ "${EUID}" -eq 0 ]]; then
    "$@"
  elif command -v sudo >/dev/null 2>&1; then
    sudo "$@"
  else
    fail "sudo não encontrado; execute como root ou instale sudo."
  fi
}

install_dependencies() {
  log "Instalando dependências (php, git, curl)..."

  if ! command -v apt-get >/dev/null 2>&1; then
    fail "apt-get não encontrado. Este script foi feito para Ubuntu/Debian."
  fi

  run_with_privilege apt-get update
  run_with_privilege apt-get install -y php php-cli php-curl php-xml php-mbstring git curl
}

require_command() {
  command -v "$1" >/dev/null 2>&1 || fail "Comando obrigatório não encontrado: $1"
}

lint_php() {
  log "Validando sintaxe PHP"
  local files=(index.php ambiente.php contact.php site-data.php)

  for file in "${files[@]}"; do
    php -l "$PROJECT_ROOT/$file"
  done
}

smoke_http() {
  log "Executando smoke test HTTP na porta $PORT"

  local server_pid=""
  local lead_id=""
  local lead_file=""
  local response

  php -S "127.0.0.1:$PORT" -t "$PROJECT_ROOT" >/tmp/adige_setup_server.log 2>&1 &
  server_pid=$!

  cleanup() {
    if [[ -n "${lead_file:-}" && -f "$lead_file" ]]; then
      rm -f "$lead_file"
    fi
    if [[ -n "${server_pid:-}" ]] && kill -0 "$server_pid" >/dev/null 2>&1; then
      kill "$server_pid" >/dev/null 2>&1 || true
    fi
  }
  trap cleanup EXIT

  sleep 2

  [[ "$(curl -s -o /tmp/adige_home.html -w '%{http_code}' "http://127.0.0.1:$PORT/")" == "200" ]] || fail "Home não retornou 200"
  [[ "$(curl -s -o /tmp/adige_ambiente.html -w '%{http_code}' "http://127.0.0.1:$PORT/ambiente.php?slug=cozinhas")" == "200" ]] || fail "Ambiente válido não retornou 200"
  [[ "$(curl -s -o /tmp/adige_ambiente_404.html -w '%{http_code}' "http://127.0.0.1:$PORT/ambiente.php?slug=inexistente")" == "404" ]] || fail "Ambiente inválido não retornou 404"
  [[ "$(curl -s -o /tmp/adige_app.js -w '%{http_code}' "http://127.0.0.1:$PORT/app.js")" == "200" ]] || fail "app.js não retornou 200"
  [[ "$(curl -s -o /tmp/adige_style.css -w '%{http_code}' "http://127.0.0.1:$PORT/style.css")" == "200" ]] || fail "style.css não retornou 200"

  grep -q "Solicitar Orçamento" /tmp/adige_home.html || fail "Home sem CTA esperada"
  grep -q "Jornada do ambiente" /tmp/adige_ambiente.html || fail "Página de ambiente sem seção esperada"

  response="$(curl -s -X POST "http://127.0.0.1:$PORT/contact.php" \
    -d 'name=Smoke Ubuntu' \
    -d 'phone=(63) 99999-0000' \
    -d 'email=smoke.ubuntu@example.com' \
    -d 'environment=Cozinhas' \
    -d 'message=Teste automatico' \
    -d 'page=setup-ubuntu')"

  lead_id="$(php -r '
    $d = json_decode(stream_get_contents(STDIN), true);
    if (!is_array($d) || empty($d["ok"]) || empty($d["id"]) || empty($d["delivery"]["storage"])) {
      fwrite(STDERR, "Resposta inválida do contact.php\\n");
      exit(1);
    }
    echo $d["id"];
  ' <<<"$response")"

  lead_file="$PROJECT_ROOT/leads/$lead_id.json"
  [[ -f "$lead_file" ]] || fail "Arquivo de lead não foi criado"

  log "Smoke test concluído com sucesso"
  log "Lead de teste criado e removido: $lead_id"
}

main() {
  cd "$PROJECT_ROOT"

  if [[ "$SKIP_INSTALL" == "false" ]]; then
    install_dependencies
  else
    log "Pulando instalação de dependências (--skip-install)"
  fi

  require_command php
  require_command curl

  php -v | head -n 1

  if [[ "$SKIP_TESTS" == "false" ]]; then
    lint_php
    smoke_http
  else
    log "Pulando testes (--skip-tests)"
  fi

  if [[ "$SERVE_AFTER" == "true" ]]; then
    log "Subindo servidor para acesso na rede: http://0.0.0.0:$PORT"
    exec php -S "0.0.0.0:$PORT" -t "$PROJECT_ROOT"
  else
    log "Finalizado. Para subir o app manualmente: php -S 0.0.0.0:$PORT -t $PROJECT_ROOT"
  fi
}

main "$@"
