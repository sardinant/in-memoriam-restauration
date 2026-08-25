# gen_pac.ps1 — regenere proxy.pac depuis les dossiers reellement presents
# A lancer depuis n'importe ou.

$www    = "C:\UwAmp\www"
$sortie = "$www\proxy.pac"

# Domaines qui existent reellement sur le web : separes, pour laisser le
# choix de les rediriger ou non.
$reels = @(
    'divertissements.msn.fr','groups.msn.com','gudule.net','liberation.fr',
    'natalecta.com','persocite.francite.com','ricochet-jeunes.org',
    'trombi.com','webzinemaker.com'
)

$tous = Get-ChildItem $www -Directory |
        Where-Object { $_.Name -notmatch '^_' } |
        ForEach-Object { $_.Name -replace '^www\.','' } |
        Sort-Object -Unique

$fictifs = $tous | Where-Object { $reels -notcontains $_ }
$presentsReels = $tous | Where-Object { $reels -contains $_ }

function Bloc($liste, $indent, $commente) {
    $p = if ($commente) { "$indent// " } else { $indent }
    $l = @()
    for ($i = 0; $i -lt $liste.Count; $i += 3) {
        $g = $liste[$i..([Math]::Min($i+2, $liste.Count-1))]
        $l += $p + (($g | ForEach-Object { "`"$_`"" }) -join ', ') + ','
    }
    if ($l.Count -gt 0 -and -not $commente) {
        $l[-1] = $l[-1].TrimEnd(',')
    }
    return $l -join "`r`n"
}

$date = Get-Date -Format 'yyyy-MM-dd'

$pac = @"
// proxy.pac — In Memoriam, redirection des sites du jeu
// Genere le $date depuis le contenu de $www
//
// A declarer dans le NAVIGATEUR uniquement (configuration automatique
// du proxy). Les sites du jeu partent vers le serveur local, tout le
// reste du web reste accessible normalement.
//
// ATTENTION : le jeu lui-meme ne lit pas ce fichier. Le projector
// Director resout ses domaines par le DNS du systeme, donc les
// redirections du fichier hosts restent necessaires pour qu'il
// fonctionne. Ce fichier ne couvre que la navigation.

function FindProxyForURL(url, host) {

    // --- domaines fictifs, crees pour le jeu ---
    var jeu = [
$(Bloc $fictifs '        ' $false)
    ];

    // --- domaines existant reellement sur le web ---
    // Decommenter pour les rediriger aussi vers le serveur local.
    // Tant qu'ils sont commentes, les vrais sites restent accessibles,
    // mais les pages du jeu qu'ils hebergeaient sont introuvables.
    var reels = [
$(Bloc $presentsReels '        ' $true)
    ];

    var i;
    for (i = 0; i < jeu.length; i++) {
        if (dnsDomainIs(host, jeu[i])) return "PROXY 127.0.0.1:80";
    }
    for (i = 0; i < reels.length; i++) {
        if (dnsDomainIs(host, reels[i])) return "PROXY 127.0.0.1:80";
    }
    return "DIRECT";
}
"@

Set-Content -Path $sortie -Value $pac -Encoding ASCII
"proxy.pac regenere : $($fictifs.Count) domaines du jeu, $($presentsReels.Count) domaines reels (commentes)."
