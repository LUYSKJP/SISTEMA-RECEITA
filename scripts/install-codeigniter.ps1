$ErrorActionPreference = 'Stop'

$ciVersion = '3.1.13'
$ciUrl = "https://github.com/bcit-ci/CodeIgniter/archive/$ciVersion.zip"

if (Test-Path -Path 'system') {
    Write-Error 'system/ already exists. Remove it if you want to re-install CodeIgniter.'
}

$tempDir = Join-Path $env:TEMP ([System.Guid]::NewGuid().ToString())
New-Item -ItemType Directory -Path $tempDir | Out-Null

try {
    $zipPath = Join-Path $tempDir 'ci.zip'
    Write-Host "Downloading CodeIgniter $ciVersion..."
    Invoke-WebRequest -Uri $ciUrl -OutFile $zipPath

    Expand-Archive -Path $zipPath -DestinationPath $tempDir -Force

    Copy-Item -Path (Join-Path $tempDir "CodeIgniter-$ciVersion\system") -Destination 'system' -Recurse

    Write-Host 'CodeIgniter system/ directory installed.'
} finally {
    Remove-Item -Path $tempDir -Recurse -Force
}
