<?php
/**
 * Indexeur - In Memoriam, restauration locale
 * ------------------------------------------------------------
 * Parcourt le dossier des sites servis, extrait le titre, la
 * description meta et le texte reel de chaque page, et ecrit un
 * index.json exploitable par le moteur de recherche.
 *
 * Rien n'est invente : tout ce qui figure dans l'index provient
 * des fichiers archives.
 *
 * A lancer depuis le navigateur : http://www.inmemoriamdev.com/indexer.php
 */

set_time_limit(0);
ini_set('memory_limit', '512M');
header('Content-Type: text/html; charset=utf-8');

// ============================================================
// CONFIGURATION
// ============================================================

// Racine des sites. Par defaut : le dossier parent de ce script.
$RACINE = realpath(__DIR__ . '/..');

// Dossiers a ignorer (rangement, archives, config).
$IGNORER_DOSSIERS = array('_config', 'IM1+13', '_IM2_horsservice');

// Domaines a exclure de l'index (sites reels externes : leur contenu
// n'a pas ete ecrit par Lexis, et le joueur ne doit pas les trouver
// par une recherche interne).
$EXCLURE_SITES = array(
    // Sites reels externes : contenu non ecrit par Lexis.
    'natalecta.com', 'www.webzinemaker.com', 'www.ricochet-jeunes.org',
    'divertissements.msn.fr', 'www.gudule.net', 'www.trombi.com',
    'groups.msn.com', 'www.liberation.fr', 'persocite.francite.com',

    // Infrastructure : webmail et moteur eux-memes.
    'www.inmemoriamdev.com',

    // Divulgue le denouement d'IM2.
    'www.liberation-inmemoriam.fr',

    // --- SITES CACHES ---
    // Le joueur doit y arriver par un indice, jamais par une recherche.
    // Les indexer reviendrait a livrer la solution dans le moteur.
    'www.xineph.com',
    'www.fe256.net'
);

// Chemins caches a l'interieur de sites par ailleurs indexes.
// Le motif est teste sur le chemin relatif de chaque page.
$EXCLURE_CHEMINS = array(
    '#(^|/)mail#i',          // messageries et extranets
    '#(^|/)extranet#i',
    '#(^|/)webmail#i',
    '#(^|/)intranet#i',
    '#(^|/)login#i',
    '#(^|/)private#i',
    '#(^|/)prive#i',
);

// Extensions considerees comme des pages.
$EXT_PAGES = array('html', 'htm', 'php', 'shtml', 'asp');

// Branches linguistiques a ignorer. Le francais vit soit dans fr/,
// soit a la racine du site ; toute page dont un segment de chemin
// figure ici est ecartee.
// Retirer 'gb' de la liste si tu veux indexer l'anglais comme repli.
$LANGUES_EXCLUES = array(
    'gb', 'us', 'uk', 'en',
    'de', 'at',
    'it', 'sp', 'es', 'pt', 'br',
    'nl', 'be', 'dk', 'se', 'no', 'fi',
    'ru', 'pl', 'cz', 'gr', 'tr', 'jp', 'cn'
);

// Longueur maximale de texte conserve par page.
$MAX_TEXTE = 4000;

// Encodage suppose quand la page ne le declare pas.
// Les sites francais de 2003 sont presque tous en windows-1252.
$ENCODAGE_DEFAUT = 'Windows-1252';

// ============================================================
// OUTILS
// ============================================================

function detecter_encodage($html, $defaut) {
    // <meta charset="utf-8">
    if (preg_match('/<meta[^>]+charset\s*=\s*["\']?\s*([a-z0-9\-_]+)/i', $html, $m)) {
        $enc = strtoupper(trim($m[1]));
        if ($enc === 'ISO-8859-1') return 'Windows-1252'; // en pratique toujours du 1252
        if ($enc === 'UTF8') return 'UTF-8';
        return $enc;
    }
    // Pas de declaration : on regarde si c'est de l'UTF-8 valide.
    if (mb_check_encoding($html, 'UTF-8') && preg_match('//u', $html)) {
        // Heuristique : de l'UTF-8 valide contenant des caracteres
        // multi-octets est probablement bien de l'UTF-8.
        if (preg_match('/[\xC2-\xF4][\x80-\xBF]/', $html)) return 'UTF-8';
    }
    return $defaut;
}

function vers_utf8($texte, $enc) {
    if ($enc === 'UTF-8') return $texte;
    $converti = @mb_convert_encoding($texte, 'UTF-8', $enc);
    return $converti !== false ? $converti : $texte;
}

function nettoyer_texte($html) {
    // Retirer ce qui n'est pas du contenu lisible.
    $html = preg_replace('/<!--.*?-->/s', ' ', $html);
    $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', ' ', $html);
    $html = preg_replace('/<style\b[^>]*>.*?<\/style>/is', ' ', $html);
    $html = preg_replace('/<noscript\b[^>]*>.*?<\/noscript>/is', ' ', $html);

    // Les balises de bloc deviennent des separateurs, sinon les mots
    // de deux paragraphes se collent.
    $html = preg_replace('/<(br|p|div|td|tr|li|h[1-6])\b[^>]*>/i', ' ', $html);

    $texte = strip_tags($html);
    $texte = html_entity_decode($texte, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $texte = preg_replace('/\x{00A0}/u', ' ', $texte);   // espaces insecables
    $texte = preg_replace('/\s+/u', ' ', $texte);
    return trim($texte);
}

function extraire_balise($html, $motif) {
    if (preg_match($motif, $html, $m)) {
        $v = html_entity_decode(strip_tags($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return trim(preg_replace('/\s+/u', ' ', $v));
    }
    return '';
}

function url_publique($site, $relatif) {
    $relatif = str_replace('\\', '/', $relatif);
    // Une page d'accueil se cite par son dossier, pas par son fichier.
    $relatif = preg_replace('#(^|/)index\.(html?|php|shtml)$#i', '$1', $relatif);
    $url = 'http://' . $site . '/' . ltrim($relatif, '/');
    return rtrim($url, '/') === 'http://' . $site ? 'http://' . $site . '/' : $url;
}

// ============================================================
// PARCOURS
// ============================================================

$debut = microtime(true);
$index = array();
$par_site = array();
$avertissements = array();

if (!$RACINE || !is_dir($RACINE)) {
    die("<p style='color:red'>Racine introuvable : " . htmlspecialchars($RACINE) . "</p>");
}

$dossiers = array();
foreach (scandir($RACINE) as $d) {
    if ($d === '.' || $d === '..') continue;
    if (!is_dir($RACINE . DIRECTORY_SEPARATOR . $d)) continue;
    if ($d[0] === '_') continue;
    if (in_array($d, $IGNORER_DOSSIERS, true)) continue;
    if (strpos($d, '.') === false) continue;              // un domaine contient un point
    if (in_array($d, $EXCLURE_SITES, true)) continue;
    $dossiers[] = $d;
}
sort($dossiers);

foreach ($dossiers as $site) {
    $base = $RACINE . DIRECTORY_SEPARATOR . $site;
    $par_site[$site] = array('pages' => 0, 'vides' => 0, 'langues' => 0, 'caches' => 0);

    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($it as $fichier) {
        if (!$fichier->isFile()) continue;

        $ext = strtolower($fichier->getExtension());
        if (!in_array($ext, $EXT_PAGES, true)) continue;
        if ($fichier->getSize() > 2 * 1024 * 1024) continue;   // page anormalement grosse

        $relatif = ltrim(substr($fichier->getPathname(), strlen($base)), '\\/');

        // Ecarter les branches linguistiques etrangeres
        $segments = preg_split('#[\\\\/]#', strtolower($relatif));
        $etrangere = false;
        foreach ($segments as $seg) {
            if (in_array($seg, $LANGUES_EXCLUES, true)) { $etrangere = true; break; }
        }
        if ($etrangere) { $par_site[$site]['langues']++; continue; }

        // Ecarter les zones cachees (messageries, extranets, espaces prives)
        $cache = false;
        foreach ($EXCLURE_CHEMINS as $motif) {
            if (preg_match($motif, str_replace('\\', '/', $relatif))) { $cache = true; break; }
        }
        if ($cache) { $par_site[$site]['caches']++; continue; }

        $brut = @file_get_contents($fichier->getPathname());
        if ($brut === false || $brut === '') continue;

        $enc  = detecter_encodage($brut, $ENCODAGE_DEFAUT);
        $html = vers_utf8($brut, $enc);

        $titre = extraire_balise($html, '/<title[^>]*>(.*?)<\/title>/is');
        $desc  = extraire_balise($html, '/<meta[^>]+name\s*=\s*["\']description["\'][^>]*content\s*=\s*["\'](.*?)["\']/is');
        if ($desc === '') {
            $desc = extraire_balise($html, '/<meta[^>]+content\s*=\s*["\'](.*?)["\'][^>]*name\s*=\s*["\']description["\']/is');
        }

        $texte = nettoyer_texte($html);

        // Une page de frameset n'a ni texte ni interet : on la signale
        // sans l'indexer, sinon elle pollue les resultats.
        $est_frameset = (bool) preg_match('/<frameset\b/i', $html);
        if ($est_frameset && mb_strlen($texte) < 40) {
            $par_site[$site]['vides']++;
            continue;
        }

        if ($titre === '' && $texte === '') {
            $par_site[$site]['vides']++;
            continue;
        }

        $index[] = array(
            'site'  => $site,
            'url'   => url_publique($site, $relatif),
            'titre' => $titre,
            'desc'  => $desc,                                  // vide si la page n'en declare pas
            'texte' => mb_substr($texte, 0, $MAX_TEXTE),
        );
        $par_site[$site]['pages']++;
    }

    if ($par_site[$site]['pages'] === 0) {
        $avertissements[] = "$site : aucune page indexee";
    }
}

// ============================================================
// ECRITURE
// ============================================================

$sortie = __DIR__ . DIRECTORY_SEPARATOR . 'index.json';
$donnees = array(
    'genere_le' => date('c'),
    'sites'     => count($dossiers),
    'pages'     => count($index),
    'entrees'   => $index,
);

$ok = @file_put_contents(
    $sortie,
    json_encode($donnees, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
);

$duree = round(microtime(true) - $debut, 1);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Indexeur - In Memoriam</title>
<style>
  body { font-family: Consolas, monospace; font-size: 13px; background:#111; color:#ddd; padding:30px; }
  h1 { font-size:18px; font-weight:normal; letter-spacing:2px; color:#c9a227; }
  table { border-collapse: collapse; margin-top:15px; }
  td, th { padding:3px 14px 3px 0; text-align:left; border-bottom:1px solid #222; }
  th { color:#888; font-weight:normal; }
  .zero { color:#e05252; }
  .ok { color:#7ac07a; }
  .avert { color:#e0a852; margin-top:20px; }
</style>
</head>
<body>

<h1>INDEXEUR</h1>

<p>
  <?php echo count($dossiers); ?> sites parcourus &middot;
  <b><?php echo count($index); ?></b> pages indexees &middot;
  <?php echo $duree; ?> s<br>
  <?php if ($ok): ?>
    <span class="ok">index.json ecrit (<?php echo round($ok / 1024); ?> Ko)</span>
  <?php else: ?>
    <span class="zero">Echec d'ecriture de index.json - verifier les droits du dossier</span>
  <?php endif; ?>
</p>

<?php if ($avertissements): ?>
<div class="avert">
  <?php foreach ($avertissements as $a) echo htmlspecialchars($a) . "<br>"; ?>
</div>
<?php endif; ?>

<table>
  <tr><th>Site</th><th>Pages FR</th><th>Vides</th><th>Autres langues</th><th>Caches</th></tr>
  <?php foreach ($par_site as $s => $c): ?>
  <tr>
    <td><?php echo htmlspecialchars($s); ?></td>
    <td class="<?php echo $c['pages'] ? '' : 'zero'; ?>"><?php echo $c['pages']; ?></td>
    <td><?php echo $c['vides'] ?: ''; ?></td>
    <td style="color:#666"><?php echo $c['langues'] ?: ''; ?></td>
    <td style="color:#a06"><?php echo $c['caches'] ?: ''; ?></td>
  </tr>
  <?php endforeach; ?>
</table>

</body>
</html>
