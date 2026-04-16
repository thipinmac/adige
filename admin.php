<?php

declare(strict_types=1);

require __DIR__ . '/site-data.php';

const ADMIN_DEFAULT_PASSWORD = 'admin123-change';

function admin_password(): string
{
    $value = getenv('ADIGE_ADMIN_PASSWORD');
    return is_string($value) && $value !== '' ? $value : ADMIN_DEFAULT_PASSWORD;
}

function admin_is_logged_in(): bool
{
    return isset($_COOKIE['adige_admin_session']) && hash_equals($_COOKIE['adige_admin_session'], sha1(admin_password()));
}

function admin_set_session_cookie(bool $enabled): void
{
    if ($enabled) {
        setcookie('adige_admin_session', sha1(admin_password()), time() + 60 * 60 * 10, '/');
        return;
    }

    setcookie('adige_admin_session', '', time() - 3600, '/');
}

function admin_json_path(): string
{
    return __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'site-content.json';
}

function admin_save_json(string $jsonText): string
{
    $decoded = json_decode($jsonText, true);
    if (!is_array($decoded)) {
        return 'JSON inválido. Envie um objeto JSON no topo.';
    }

    $prettyJson = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($prettyJson === false) {
        return 'Falha ao serializar JSON.';
    }

    $dataDir = dirname(admin_json_path());
    if (!is_dir($dataDir) && !mkdir($dataDir, 0775, true) && !is_dir($dataDir)) {
        return 'Não foi possível criar o diretório data/.';
    }

    if (file_put_contents(admin_json_path(), $prettyJson . PHP_EOL) === false) {
        return 'Não foi possível salvar data/site-content.json.';
    }

    return '';
}


function admin_handle_upload(): string
{
    if (!isset($_FILES['image']) || !is_array($_FILES['image'])) {
        return 'Arquivo não enviado.';
    }

    $file = $_FILES['image'];
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return 'Falha no upload da imagem.';
    }

    $tmp = (string) ($file['tmp_name'] ?? '');
    if ($tmp === '' || !is_uploaded_file($tmp)) {
        return 'Upload inválido.';
    }

    $mime = (string) (mime_content_type($tmp) ?: '');
    if (!str_starts_with($mime, 'image/')) {
        return 'Apenas imagens são permitidas.';
    }

    $originalName = (string) ($file['name'] ?? 'image');
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $extension = preg_match('/^[a-z0-9]+$/', $extension) ? $extension : 'jpg';
    $targetDir = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads';

    if (!is_dir($targetDir) && !mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
        return 'Não foi possível criar assets/uploads.';
    }

    $targetName = date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
    $targetPath = $targetDir . DIRECTORY_SEPARATOR . $targetName;

    if (!move_uploaded_file($tmp, $targetPath)) {
        return 'Não foi possível mover o arquivo enviado.';
    }

    return 'OK: assets/uploads/' . $targetName;
}

$message = '';
$error = '';
$customJson = '{}';

if (is_file(admin_json_path())) {
    $existing = file_get_contents(admin_json_path());
    if (is_string($existing) && $existing !== '') {
        $customJson = $existing;
    }
}

if (($_POST['action'] ?? '') === 'login') {
    $password = (string) ($_POST['password'] ?? '');
    if (hash_equals(admin_password(), $password)) {
        admin_set_session_cookie(true);
        header('Location: admin.php');
        exit;
    }
    $error = 'Senha inválida.';
}

if (($_GET['logout'] ?? '') === '1') {
    admin_set_session_cookie(false);
    header('Location: admin.php');
    exit;
}

$isLoggedIn = admin_is_logged_in();
if ($isLoggedIn && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

        $customJson = (string) ($_POST['json_content'] ?? '{}');
        $saveError = admin_save_json($customJson);
        if ($saveError !== '') {
            $error = $saveError;
        } else {
            $message = 'Conteúdo salvo com sucesso em data/site-content.json.';
            $customJson = (string) file_get_contents(admin_json_path());
        }
    } elseif ($action === 'upload_image') {
        $uploadResult = admin_handle_upload();
        if (str_starts_with($uploadResult, 'OK: ')) {
            $message = 'Upload concluído. Caminho: ' . substr($uploadResult, 4);
        } else {
            $error = $uploadResult;
        }
    }
}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Edição | Ádige</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f5f9; color: #1d2741; }
        .wrap { width: min(1100px, 94vw); margin: 22px auto; }
        .card { background: #fff; border: 1px solid #dce1ea; padding: 16px; margin-bottom: 14px; }
        h1 { margin: 0 0 8px; font-size: 1.4rem; }
        p { margin: 0 0 10px; }
        textarea { width: 100%; min-height: 420px; font-family: Consolas, monospace; font-size: 13px; }
        .row { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }

        button { border: 0; background: #1e2b4a; color: #fff; padding: 10px 14px; cursor: pointer; }
        input[type="password"], input[type="file"] { padding: 9px; border: 1px solid #cfd6e3; }
        .ok { color: #0a6f34; }
        .err { color: #ab1d1d; }
        code { background: #f0f2f7; padding: 2px 5px; }
        .files { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 8px; }
        .item { border: 1px solid #dce1ea; padding: 8px; background: #fbfcff; }
        .item img { width: 100%; height: 130px; object-fit: cover; margin-bottom: 6px; }

    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <h1>Painel de Edição do Site</h1>
            <p>Arquivo principal de override: <code>data/site-content.json</code>.</p>
            <p>Para alterar o texto ou imagem, edite o JSON abaixo com a mesma estrutura do <code>site-data.php</code>.</p>
            <p><a href="index.php" target="_blank" rel="noreferrer">Abrir site</a> · <a href="?logout=1">Sair</a></p>
        </div>

        <?php if (!$isLoggedIn): ?>
            <div class="card">
                <form method="post">
                    <input type="hidden" name="action" value="login">
                    <div class="row">
                        <label for="password">Senha do painel</label>
                        <input id="password" type="password" name="password" required>
                        <button type="submit">Entrar</button>
                    </div>
                    <p>Defina <code>ADIGE_ADMIN_PASSWORD</code> no servidor para trocar a senha padrão.</p>
                </form>
            </div>
        <?php else: ?>
            <?php if ($message !== ''): ?><div class="card ok"><?= h($message); ?></div><?php endif; ?>
            <?php if ($error !== ''): ?><div class="card err"><?= h($error); ?></div><?php endif; ?>

            <div class="card">

                <h2>1) Upload de imagens</h2>
                <form method="post" enctype="multipart/form-data" class="row">
                    <input type="hidden" name="action" value="upload_image">
                    <input type="file" name="image" accept="image/*" required>
                    <button type="submit">Enviar imagem</button>
                </form>
                <p>Após upload, use o caminho retornado no JSON (ex: <code>assets/uploads/arquivo.jpg</code>).</p>
            </div>

            <div class="card">

                <form method="post">
                    <input type="hidden" name="action" value="save_json">
                    <textarea name="json_content"><?= h($customJson); ?></textarea>
                    <div class="row" style="margin-top: 10px;">

                    </div>
                </form>
            </div>

            <div class="card">
                <h2>Imagens enviadas</h2>
                <div class="files">
                    <?php foreach ($uploadFiles as $path): ?>
                        <?php $relative = str_replace(__DIR__ . DIRECTORY_SEPARATOR, '', $path); ?>
                        <div class="item">
                            <img src="<?= h(str_replace(DIRECTORY_SEPARATOR, '/', $relative)); ?>" alt="Upload">
                            <code><?= h(str_replace(DIRECTORY_SEPARATOR, '/', $relative)); ?></code>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
