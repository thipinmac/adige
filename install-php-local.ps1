$ErrorActionPreference = "Stop"

$packageId = "PHP.PHP.8.3"

Write-Host "Instalando PHP 8.3 via winget..."
winget install --id $packageId -e --accept-package-agreements --accept-source-agreements

$phpExe = Get-ChildItem `
    -Path "$env:LOCALAPPDATA\Microsoft\WinGet\Packages" `
    -Filter php.exe `
    -Recurse `
    -ErrorAction SilentlyContinue |
    Where-Object { $_.FullName -like "*PHP.PHP.8.3*" } |
    Select-Object -First 1 -ExpandProperty FullName

if (-not $phpExe) {
    throw "Nao foi possivel localizar o php.exe apos a instalacao."
}

$phpDir = Split-Path $phpExe -Parent
$userPath = [Environment]::GetEnvironmentVariable("Path", "User")

if ($userPath -notlike "*$phpDir*") {
    [Environment]::SetEnvironmentVariable("Path", "$userPath;$phpDir", "User")
    Write-Host "PHP adicionado ao PATH do usuario."
}

$env:Path = "$env:Path;$phpDir"

Write-Host "Validando instalacao..."
& $phpExe -v

Write-Host ""
Write-Host "PHP pronto para uso."
Write-Host "Se o comando 'php' ainda nao funcionar neste terminal, abra uma nova janela do PowerShell."
