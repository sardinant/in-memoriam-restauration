# installer_hosts.ps1 — a lancer en ADMINISTRATEUR
# Ajoute les redirections des domaines du jeu vers le serveur local.

$f     = "C:\Windows\System32\drivers\etc\hosts"
$www   = "C:\UwAmp\www"
$debut = "# --- IN MEMORIAM RESTAURATION : DEBUT ---"
$fin   = "# --- IN MEMORIAM RESTAURATION : FIN ---"

if (-not (Test-Path $www)) { "Dossier $www introuvable."; exit 1 }

$txt = Get-Content $f -Raw
if ($txt -match [regex]::Escape($debut)) { "Deja installe. Lancer d'abord desinstaller_hosts.ps1."; exit }

$lignes = @($debut)
$lignes += Get-ChildItem $www -Directory | ForEach-Object {
    $sans = $_.Name -replace '^www\.',''
    "127.0.0.1`t$($_.Name)`t$sans"
}
$lignes += $fin

$lignes | Add-Content $f -Encoding ASCII
ipconfig /flushdns | Out-Null
"Installe : $($lignes.Count - 2) domaines rediriges."
"Les vrais sites (liberation.fr, trombi.com...) sont inaccessibles tant que le bloc est actif."
