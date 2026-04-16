$ErrorActionPreference = "Stop"

$phpCommand = Get-Command php -ErrorAction SilentlyContinue

if (-not $phpCommand) {
    throw "Nao encontrei o comando 'php'. Rode antes .\\install-php-local.ps1 ou abra um novo terminal."
}

$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path

Write-Host "Validando sintaxe PHP..."
& $phpCommand.Source -l (Join-Path $projectRoot "index.php")
& $phpCommand.Source -l (Join-Path $projectRoot "ambiente.php")
& $phpCommand.Source -l (Join-Path $projectRoot "contact.php")
& $phpCommand.Source -l (Join-Path $projectRoot "site-data.php")

Write-Host "Subindo servidor temporario para smoke test..."
$proc = Start-Process `
    -FilePath $phpCommand.Source `
    -ArgumentList "-S", "127.0.0.1:8000", "-t", $projectRoot `
    -WorkingDirectory $projectRoot `
    -PassThru

Start-Sleep -Seconds 2

$createdLeadPath = $null

try {
    $index = Invoke-WebRequest -Uri "http://127.0.0.1:8000/" -UseBasicParsing
    $environment = Invoke-WebRequest -Uri "http://127.0.0.1:8000/ambiente.php?slug=cozinhas" -UseBasicParsing
    $environmentMissing = Invoke-WebRequest -Uri "http://127.0.0.1:8000/ambiente.php?slug=inexistente" -UseBasicParsing -SkipHttpErrorCheck
    $js = Invoke-WebRequest -Uri "http://127.0.0.1:8000/app.js" -UseBasicParsing
    $css = Invoke-WebRequest -Uri "http://127.0.0.1:8000/style.css" -UseBasicParsing

    if ($index.StatusCode -ne 200) {
        throw "Index respondeu com status $($index.StatusCode)"
    }

    if ($environment.StatusCode -ne 200) {
        throw "ambiente.php respondeu com status $($environment.StatusCode)"
    }

    if ([int]$environmentMissing.StatusCode -ne 404) {
        throw "ambiente.php deveria responder 404 para slug inexistente."
    }

    if ($js.StatusCode -ne 200) {
        throw "app.js respondeu com status $($js.StatusCode)"
    }

    if ($css.StatusCode -ne 200) {
        throw "style.css respondeu com status $($css.StatusCode)"
    }

    if ($index.Content -notmatch "Solicitar Orçamento") {
        throw "O HTML da home nao contem a CTA esperada."
    }

    if ($environment.Content -notmatch "Jornada do ambiente") {
        throw "A pagina de ambiente nao contem a secao esperada."
    }

    $leadPayload = @{
        name = "Smoke Test"
        phone = "(63) 99999-0000"
        email = "smoke.test@example.com"
        environment = "Cozinhas"
        message = "Teste automatico local"
        page = "smoke-test"
    }

    $leadResponse = Invoke-RestMethod -Uri "http://127.0.0.1:8000/contact.php" -Method Post -Body $leadPayload

    if (-not $leadResponse.ok) {
        throw "contact.php nao retornou ok=true."
    }

    if (-not $leadResponse.id) {
        throw "contact.php nao retornou ID do lead."
    }

    if (-not $leadResponse.delivery.storage) {
        throw "contact.php deveria confirmar armazenamento local do lead."
    }

    $createdLeadPath = Join-Path $projectRoot ("leads/" + $leadResponse.id + ".json")
    if (-not (Test-Path $createdLeadPath)) {
        throw "Arquivo do lead nao foi criado em leads/."
    }

    Write-Host ""
    Write-Host "Smoke test concluido com sucesso."
    Write-Host "Home: 200"
    Write-Host "Ambiente (slug valido): 200"
    Write-Host "Ambiente (slug invalido): 404"
    Write-Host "JavaScript: 200"
    Write-Host "CSS: 200"
    Write-Host "contact.php (POST): OK"
}
finally {
    if ($createdLeadPath -and (Test-Path $createdLeadPath)) {
        Remove-Item -Path $createdLeadPath -Force
    }

    if ($proc -and -not $proc.HasExited) {
        Stop-Process -Id $proc.Id -Force
    }
}
