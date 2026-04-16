$ErrorActionPreference = "Stop"

$phpCommand = Get-Command php -ErrorAction SilentlyContinue

if (-not $phpCommand) {
    throw "Nao encontrei o comando 'php'. Rode antes .\\install-php-local.ps1 ou abra um novo terminal."
}

$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path

Write-Host "Subindo app em http://localhost:8000 ..."
& $phpCommand.Source -S localhost:8000 -t $projectRoot
