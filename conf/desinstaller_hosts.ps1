# desinstaller_hosts.ps1 — a lancer en ADMINISTRATEUR
# Retire le bloc de redirections et rend les vrais sites accessibles.

$f = "C:\Windows\System32\drivers\etc\hosts"

$txt = Get-Content $f -Raw
if ($txt -notmatch "IN MEMORIAM RESTAURATION") { "Rien a retirer."; exit }

$txt = [regex]::Replace($txt,
    '(?s)\r?\n?# --- IN MEMORIAM RESTAURATION : DEBUT ---.*?# --- IN MEMORIAM RESTAURATION : FIN ---', '')

Set-Content -Path $f -Value $txt.TrimEnd() -Encoding ASCII
ipconfig /flushdns | Out-Null
"Desinstalle."
