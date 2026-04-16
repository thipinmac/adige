<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

function respond(array $payload, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function request_data(): array
{
    $contentType = (string) ($_SERVER['CONTENT_TYPE'] ?? '');
    if (stripos($contentType, 'application/json') !== false) {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw ?: '', true);
        return is_array($data) ? $data : [];
    }

    return $_POST;
}

function env_value(string $name, string $default = ''): string
{
    $value = getenv($name);
    return is_string($value) && $value !== '' ? $value : $default;
}

function normalize(string $value): string
{
    return trim(preg_replace('/\s+/', ' ', $value) ?? '');
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    respond(['error' => 'Método não permitido.'], 405);
}

$data = request_data();
$lead = [
    'name' => normalize((string) ($data['name'] ?? '')),
    'phone' => normalize((string) ($data['phone'] ?? '')),
    'email' => normalize((string) ($data['email'] ?? '')),
    'environment' => normalize((string) ($data['environment'] ?? '')),
    'message' => normalize((string) ($data['message'] ?? '')),
    'page' => normalize((string) ($data['page'] ?? ($_SERVER['HTTP_REFERER'] ?? 'site'))),
];

if ($lead['name'] === '' || $lead['phone'] === '' || $lead['email'] === '' || $lead['environment'] === '') {
    respond(['error' => 'Preencha nome, telefone, e-mail e ambiente.'], 422);
}

if (!filter_var($lead['email'], FILTER_VALIDATE_EMAIL)) {
    respond(['error' => 'Informe um e-mail válido.'], 422);
}

$leadId = 'lead_' . date('Ymd_His') . '_' . bin2hex(random_bytes(3));
$record = [
    'id' => $leadId,
    'createdAt' => date(DATE_ATOM),
    'ip' => (string) ($_SERVER['REMOTE_ADDR'] ?? ''),
    'userAgent' => (string) ($_SERVER['HTTP_USER_AGENT'] ?? ''),
    'lead' => $lead,
];

$leadsDir = __DIR__ . DIRECTORY_SEPARATOR . 'leads';
if (!is_dir($leadsDir) && !mkdir($leadsDir, 0777, true) && !is_dir($leadsDir)) {
    respond(['error' => 'Não foi possível preparar o diretório de leads.'], 500);
}

$leadPath = $leadsDir . DIRECTORY_SEPARATOR . $leadId . '.json';
$encoded = json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($encoded === false || file_put_contents($leadPath, $encoded) === false) {
    respond(['error' => 'Falha ao salvar o lead.'], 500);
}

$mailTo = env_value('ADIGE_LEAD_EMAIL_TO', 'contato@adige.com.br');
$mailFrom = env_value('ADIGE_LEAD_EMAIL_FROM', 'no-reply@adige.com.br');
$mailSubjectPrefix = env_value('ADIGE_MAIL_SUBJECT_PREFIX', '[Ádige Lead]');
$crmWebhook = env_value('ADIGE_CRM_WEBHOOK_URL');
$crmToken = env_value('ADIGE_CRM_WEBHOOK_TOKEN');

$delivery = [
    'storage' => true,
    'email' => false,
    'crm' => false,
];

$subject = $mailSubjectPrefix . ' ' . $lead['environment'] . ' - ' . $lead['name'];
$message = implode("\n", [
    'Novo lead recebido pelo portal da Ádige.',
    '',
    'ID: ' . $leadId,
    'Nome: ' . $lead['name'],
    'Telefone: ' . $lead['phone'],
    'E-mail: ' . $lead['email'],
    'Ambiente: ' . $lead['environment'],
    'Origem: ' . $lead['page'],
    'Mensagem: ' . ($lead['message'] !== '' ? $lead['message'] : 'Não informada'),
]);
$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'From: ' . $mailFrom,
    'Reply-To: ' . $lead['email'],
];

if ($mailTo !== '') {
    $delivery['email'] = @mail($mailTo, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message, implode("\r\n", $headers));
}

if ($crmWebhook !== '') {
    $payload = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($payload !== false) {
        $requestHeaders = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
        ];
        if ($crmToken !== '') {
            $requestHeaders[] = 'Authorization: Bearer ' . $crmToken;
        }

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => implode("\r\n", $requestHeaders),
                'content' => $payload,
                'timeout' => 10,
                'ignore_errors' => true,
            ],
        ]);

        $response = @file_get_contents($crmWebhook, false, $context);
        $statusLine = $http_response_header[0] ?? '';
        $delivery['crm'] = is_string($response) && str_contains($statusLine, '200');
        if (!$delivery['crm']) {
            $delivery['crm'] = str_contains($statusLine, '201')
                || str_contains($statusLine, '202')
                || str_contains($statusLine, '204');
        }
    }
}

$hasRemoteDelivery = $delivery['email'] || $delivery['crm'];
$messageText = $hasRemoteDelivery
    ? 'Lead enviado com sucesso para o atendimento da Ádige.'
    : 'Lead salvo localmente. Configure envio de e-mail e/ou webhook de CRM no servidor para ativar o repasse automático.';

respond([
    'ok' => true,
    'id' => $leadId,
    'message' => $messageText,
    'delivery' => $delivery,
]);
