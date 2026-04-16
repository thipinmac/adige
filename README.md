# Portal institucional da Ádige Ambientes

Portal em PHP com identidade visual alinhada ao site oficial da Ádige, páginas internas por ambiente e captação de leads via formulário.

## Estrutura principal

- `index.php`: home institucional
- `ambiente.php`: página interna dinâmica por ambiente usando `?slug=...`
- `site-data.php`: dados centrais da marca, ambientes, portfólio e depoimentos
- `contact.php`: endpoint de recebimento de leads
- `admin.php`: painel simples para editar textos/imagens via JSON e upload
- `style.css`: identidade visual oficial e componentes
- `app.js`: menu mobile, animações, depoimentos e envio do formulário
- `assets/`: logo e imagens locais espelhadas do site oficial
- `leads/`: armazenamento local dos leads recebidos
- `start-app.cmd` / `start-app.ps1`: inicialização local rápida do servidor PHP
- `smoke-test.cmd` / `smoke-test.ps1`: validação automatizada da aplicação local
- `setup-ubuntu.sh`: setup rápido para Ubuntu (instala dependências + smoke test)

## Como iniciar

```bat
cd D:\I.A\Codex
start-app.cmd
```

Abra `http://localhost:8000`.

## Testes locais

Para validar rapidamente a aplicação em ambiente local:

```bat
smoke-test.cmd
```

O smoke test valida:

- sintaxe de `index.php`, `ambiente.php`, `contact.php` e `site-data.php`
- resposta HTTP da home, página de ambiente, `app.js` e `style.css`
- envio de lead via `contact.php` com criação de arquivo em `leads/` (e limpeza ao final)

## Setup rápido no Ubuntu (Hyper-V)

No Ubuntu, dentro da pasta do projeto:

```bash
chmod +x setup-ubuntu.sh
./setup-ubuntu.sh
```

Comportamento padrão do script:

- instala dependências (`php`, `curl`, `git` e extensões comuns do PHP)
- valida sintaxe dos arquivos PHP principais
- executa smoke test HTTP completo (home, ambiente, assets e envio de lead)
- remove automaticamente o lead criado durante o teste

Opções úteis:

```bash
./setup-ubuntu.sh --skip-install
./setup-ubuntu.sh --serve
./setup-ubuntu.sh --port 8080
```

## Formulário real por e-mail e CRM

O endpoint `contact.php` faz três coisas:

1. valida os dados do lead
2. salva um JSON em `leads/`
3. tenta enviar por e-mail e, opcionalmente, por webhook para o CRM

### Variáveis de ambiente suportadas

- `ADIGE_LEAD_EMAIL_TO`
- `ADIGE_LEAD_EMAIL_FROM`
- `ADIGE_MAIL_SUBJECT_PREFIX`
- `ADIGE_CRM_WEBHOOK_URL`
- `ADIGE_CRM_WEBHOOK_TOKEN`

## Painel de edição (textos e imagens)

O painel fica em:

```text
/admin.php
```

Recursos:

- upload de imagens para `assets/uploads/`

### Segurança do painel

Por padrão, a senha inicial é apenas para primeiro acesso e deve ser trocada no servidor
via variável de ambiente:

```bash
export ADIGE_ADMIN_PASSWORD='uma-senha-forte-aqui'
```

### Exemplo no PowerShell

```powershell
$env:ADIGE_LEAD_EMAIL_TO='contato@adige.com.br'
$env:ADIGE_LEAD_EMAIL_FROM='no-reply@adige.com.br'
$env:ADIGE_CRM_WEBHOOK_URL='https://seu-crm.exemplo.com/webhook'
$env:ADIGE_CRM_WEBHOOK_TOKEN='seu-token'
php -S 127.0.0.1:8000 -t D:\I.A\Codex
```

## Páginas internas disponíveis

- `ambiente.php?slug=cozinhas`
- `ambiente.php?slug=dormitorios`
- `ambiente.php?slug=home-office`
- `ambiente.php?slug=salas`
- `ambiente.php?slug=closets`
- `ambiente.php?slug=banheiros`
- `ambiente.php?slug=area-de-servico`
- `ambiente.php?slug=varandas`
- `ambiente.php?slug=projetos-comerciais`
