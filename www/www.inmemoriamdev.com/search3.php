<?php
/**
 * Moteur de recherche - In Memoriam, restauration locale
 * ------------------------------------------------------------
 * Cherche dans index.json, genere par indexer.php a partir des
 * pages reellement servies. Aucun contenu n'est ecrit a la main :
 * titres, descriptions et extraits proviennent des fichiers.
 *
 * Trois modes :
 *   complet   - tout l'index + bruit en ligne si le reseau repond
 *   horsligne - tout l'index, aucune requete reseau
 *   facile    - titres et descriptions seulement, resultats cibles
 */

header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');

// ============================================================
// CONFIGURATION
// ============================================================

// Clé Marginalia. 'public' fonctionne mais est fortement limitée et
// n'autorise pas les filtres. Clé gratuite : contact@marginalia-search.com
$MARGINALIA_CLE    = 'public';
$MARGINALIA_FILTRE = '';        // nom d'un filtre personnalise, si tu en crees un

$PAR_PAGE   = 10;
$TIMEOUT    = 3;
$INDEX_PATH = __DIR__ . '/index.json';

// Termes qui trahiraient le jeu s'ils apparaissaient dans le bruit.
$SPOILERS = array(
    'in memoriam', 'missing since january', 'dernier rituel', 'last ritual',
    'lexis numerique', 'lexis numérique', 'viennot', 'phenix', 'phoenix killer',
    'walkthrough', 'soluce', 'abandonware'
);

// ============================================================
// OUTILS
// ============================================================

function normaliser($s) {
    $s = mb_strtolower($s);
    $accents = array(
        'à'=>'a','â'=>'a','ä'=>'a','á'=>'a','ã'=>'a','å'=>'a',
        'ç'=>'c','è'=>'e','é'=>'e','ê'=>'e','ë'=>'e',
        'î'=>'i','ï'=>'i','í'=>'i','ì'=>'i',
        'ô'=>'o','ö'=>'o','ó'=>'o','ò'=>'o','õ'=>'o',
        'ù'=>'u','û'=>'u','ü'=>'u','ú'=>'u',
        'ÿ'=>'y','ñ'=>'n','œ'=>'oe','æ'=>'ae'
    );
    return strtr($s, $accents);
}

function extrait($texte, $termes, $longueur = 200) {
    if ($texte === '') return '';
    $norm = normaliser($texte);

    $pos = false;
    foreach ($termes as $t) {
        $p = mb_strpos($norm, $t);
        if ($p !== false) { $pos = $p; break; }
    }
    if ($pos === false) return mb_substr($texte, 0, $longueur) . '...';

    $debut = max(0, $pos - 60);
    $bout  = mb_substr($texte, $debut, $longueur);
    if ($debut > 0) $bout = '...' . $bout;
    if (mb_strlen($texte) > $debut + $longueur) $bout .= '...';
    return $bout;
}

function surligner($texte_echappe, $termes) {
    foreach ($termes as $t) {
        if (mb_strlen($t) < 3) continue;
        $texte_echappe = preg_replace(
            '/(' . preg_quote($t, '/') . ')/iu',
            '<b>$1</b>',
            $texte_echappe
        );
    }
    return $texte_echappe;
}

function est_spoiler($texte, $spoilers) {
    $n = normaliser($texte);
    foreach ($spoilers as $s) {
        if (mb_strpos($n, normaliser($s)) !== false) return true;
    }
    return false;
}

function requete_http($url, $timeout, $entetes = array()) {
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Evite les blocages TLS locaux
        curl_setopt($ch, CURLOPT_USERAGENT, 'InMemoriam-Restauration/1.0'); // Indispensable pour Wikipédia !
        if ($entetes) curl_setopt($ch, CURLOPT_HTTPHEADER, $entetes);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }
    $opts = array('http' => array(
        'timeout' => $timeout,
        'header' => "User-Agent: InMemoriam-Restauration/1.0\r\n"
    ));
    if ($entetes) $opts['http']['header'] .= implode("\r\n", $entetes) . "\r\n";
    return @file_get_contents($url, false, stream_context_create($opts));
}

// ============================================================
// BRUIT EN LIGNE
// ============================================================

function bruit_marginalia($q, $cle, $filtre, $timeout, $spoilers) {
    // 1. Essai sur l'API v2
    $url = 'https://api2.marginalia-search.com/search?query=' . urlencode($q) . '&count=20&dc=2';
    if ($filtre !== '') $url .= '&filter=' . urlencode($filtre);

    $json = requete_http($url, $timeout, array('API-Key: ' . $cle));

    // 2. Si api2 renvoie une erreur de quota (429) ou echoue, bascule automatique sur l'ancienne API
    if (!$json || strpos($json, 'Daily Limit Exceeded') !== false) {
        $url_legacy = 'https://api.marginalia.nu/public/search/' . urlencode($q) . '?count=10';
        $json = requete_http($url_legacy, $timeout);
    }

    if (!$json) return array();

    $data = json_decode($json, true);
    if (!isset($data['results'])) return array();

    $out = array();
    foreach ($data['results'] as $r) {
        $titre = isset($r['title']) ? $r['title'] : '';
        $desc  = isset($r['description']) ? $r['description'] : '';
        if (est_spoiler($titre . ' ' . $desc . ' ' . $r['url'], $spoilers)) continue;

        $hote = parse_url($r['url'], PHP_URL_HOST);
        $out[] = array(
            'url'    => $r['url'],
            'titre'  => $titre !== '' ? $titre : $hote,
            'site'   => $hote,
            'desc'   => $desc,
            'score'  => 5,
            'externe'=> true,
        );
    }
    return $out;
}

function bruit_wikipedia($q, $timeout, $spoilers, $limite = 4) {
    $url = 'https://fr.wikipedia.org/w/api.php?action=query&list=search&srsearch='
         . urlencode($q) . '&format=json&utf8=1&srlimit=' . intval($limite + 4);
    $json = requete_http($url, $timeout);
    if (!$json) return array();

    $data = json_decode($json, true);
    if (!isset($data['query']['search'])) return array();

    $out = array();
    foreach ($data['query']['search'] as $item) {
        if (count($out) >= $limite) break;
        $titre = strip_tags($item['title']);
        $desc  = html_entity_decode(strip_tags($item['snippet']), ENT_QUOTES, 'UTF-8');
        if (est_spoiler($titre . ' ' . $desc, $spoilers)) continue;

        $out[] = array(
            'url'    => 'https://fr.wikipedia.org/wiki/' . urlencode(str_replace(' ', '_', $titre)),
            'titre'  => $titre,
            'site'   => 'fr.wikipedia.org',
            'desc'   => $desc . '...',
            'score'  => 4,
            'externe'=> true,
        );
    }
    return $out;
}
function bruit_wiby($q, $timeout, $spoilers, $limite = 6) {
    $url = "https://wiby.me/?q=" . urlencode($q);
    $html = requete_http($url, $timeout);
    $out = array();

    if ($html) {
        preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/is', $html, $matches, PREG_SET_ORDER);
        foreach ($matches as $m) {
            if (count($out) >= $limite) break;
            $link = trim($m[1]);
            $titre = trim(strip_tags($m[2]));
            $titre = html_entity_decode($titre, ENT_QUOTES, 'UTF-8');

            if (strpos($link, 'http') === 0 && mb_strlen($titre) > 3 && strpos($link, 'wiby.me') === false) {
                if (est_spoiler($titre . ' ' . $link, $spoilers)) continue;
                $hote = parse_url($link, PHP_URL_HOST);
                $out[] = array(
                    'url'    => $link,
                    'titre'  => $titre,
                    'site'   => $hote,
                    'desc'   => 'Page web rétro indexée sur la recherche Wiby.',
                    'score'  => 3,
                    'externe'=> true
                );
            }
        }
    }
    return $out;
}

// ============================================================
// RECHERCHE DANS L'INDEX
// ============================================================

$q      = isset($_GET['q'])      ? trim($_GET['q'])   : '';
$engine = isset($_GET['engine']) ? $_GET['engine']    : 'msn';
$mode   = isset($_GET['mode'])   ? $_GET['mode']      : 'complet';
$page   = isset($_GET['page'])   ? max(1, intval($_GET['page'])) : 1;

if (!in_array($engine, array('msn','google','lycos'), true)) $engine = 'msn';
if (!in_array($mode, array('complet','horsligne','facile'), true)) $mode = 'complet';

$resultats = array();
$total = 0;
$index_absent = false;
$duree = 0;

if (!file_exists($INDEX_PATH)) {
    $index_absent = true;
} elseif ($q !== '') {
    $t0 = microtime(true);

    $data = json_decode(file_get_contents($INDEX_PATH), true);
    $entrees = isset($data['entrees']) ? $data['entrees'] : array();

    $termes = array_values(array_filter(
        preg_split('/\s+/', normaliser($q)),
        function ($t) { return mb_strlen($t) >= 3; }
    ));

    if ($termes) {
        foreach ($entrees as $e) {
            $n_titre = normaliser($e['titre']);
            $n_desc  = normaliser($e['desc']);
            $n_site  = normaliser($e['site']);
            $n_texte = ($mode === 'facile') ? '' : normaliser($e['texte']);

            $score = 0; $touches = 0; $dans_texte = false;

            foreach ($termes as $t) {
                // Mot entier : sans les deux \b, "jack" trouve "Jackson",
                // "hijack" et "jacket". Les termes sont deja normalises
                // (accents retires), donc \b se comporte correctement.
                $m = '/\b' . preg_quote($t, '/') . '\b/u';
                $trouve = false;

                if (preg_match($m, $n_titre)) { $score += 12; $trouve = true; }
                if (preg_match($m, $n_desc))  { $score += 4;  $trouve = true; }
                if (preg_match($m, $n_site))  { $score += 8;  $trouve = true; }

                if ($n_texte !== '') {
                    $n = preg_match_all($m, $n_texte);
                    if ($n > 0) { $score += min($n, 8); $trouve = true; $dans_texte = true; }
                }

                if ($trouve) $touches++;
            }

            if ($touches === 0) continue;

            // Une page qui contient tous les termes vaut bien mieux
            // qu'une page qui n'en contient qu'un.
            $score *= (1 + ($touches - 1) * 0.8);

            $resultats[] = array(
                'url'    => $e['url'],
                'titre'  => $e['titre'] !== '' ? $e['titre'] : $e['url'],
                'site'   => $e['site'],
                // La meta description est souvent la barre de navigation,
                // identique sur toutes les pages du site. Des qu'un terme
                // figure dans le corps, on affiche l'extrait contextuel :
                // lui distingue les pages entre elles.
                'desc'   => ($dans_texte || $e['desc'] === '')
                              ? extrait($e['texte'], $termes)
                              : $e['desc'],
                'score'  => $score,
                'externe'=> false,
            );
        }
    }

    // --- Bruit en ligne ---
    if ($mode === 'complet' && $termes) {
        $externes = bruit_marginalia($q, $MARGINALIA_CLE, $MARGINALIA_FILTRE, $TIMEOUT, $SPOILERS);
        
        // Si Marginalia ne renvoie presque rien, on appelle les renforts
        if (count($externes) < 5) {
            $externes = array_merge($externes, bruit_wikipedia($q, $TIMEOUT, $SPOILERS, 5));
            $externes = array_merge($externes, bruit_wiby($q, $TIMEOUT, $SPOILERS, 5));
        }
        $resultats = array_merge($resultats, $externes);
    }
    usort($resultats, function ($a, $b) {
        if ($a['score'] == $b['score']) return 0;
        return ($a['score'] < $b['score']) ? 1 : -1;
    });

// ------------------------------------------------------------
    // Composition des pages
    // ------------------------------------------------------------
    // Deux regles, dans cet ordre :
    //   - au plus MAX_JEU pages du jeu par ecran de resultats,
    //     le reste est du bruit ;
    //   - jamais deux fois le meme domaine sur un meme ecran.
    // L'ordre d'affichage depend de la precision de la recherche.

    $MAX_JEU  = 2;
    $MAX_SITE = 2;

    $jeu = array(); $bruit = array();
    foreach ($resultats as $r) {
        if (empty($r['externe'])) $jeu[] = $r; else $bruit[] = $r;
    }

    $prendre = function (&$src, &$reporte, &$vus, $n, $max_site) {
        $pris = array();
        while (count($pris) < $n && count($src) > 0) {
            $r = array_shift($src);
            $s = $r['site'];
            if (isset($vus[$s]) && $vus[$s] >= $max_site) { $reporte[] = $r; continue; }
            $vus[$s] = isset($vus[$s]) ? $vus[$s] + 1 : 1;
            $pris[] = $r;
        }
        return $pris;
    };

    $ordonne = array();
    $garde_fou = 0;
    
    // On compte les mots pour appliquer la regle de placement In Memoriam
    $nb_mots = count($termes); 

    while ((count($jeu) > 0 || count($bruit) > 0) && $garde_fou++ < 500) {
        $vus = array();
        $reporte_jeu = array();
        $reporte_bruit = array();

        // On extrait les blocs pour l'ecran actuel
        $ecran_jeu = $prendre($jeu, $reporte_jeu, $vus, $MAX_JEU, $MAX_SITE);
        $ecran_bruit = $prendre($bruit, $reporte_bruit, $vus, $PAR_PAGE - count($ecran_jeu), $MAX_SITE);

        // Bruit insuffisant : on complete avec le jeu.
        if (count($ecran_jeu) + count($ecran_bruit) < $PAR_PAGE && count($jeu) > 0) {
            $ecran_jeu = array_merge($ecran_jeu, $prendre($jeu, $reporte_jeu, $vus, $PAR_PAGE - count($ecran_bruit) - count($ecran_jeu), $MAX_SITE));
        }

        // --- L'ASTUCE DU PLACEMENT EST ICI ---
        $ecran = array();
        if ($nb_mots === 1 && count($ecran_bruit) > 0) {
            // 1 seul mot (ex: "jack") : le jeu est relegué apres le bruit (en fin de page)
            $ecran = array_merge($ecran_bruit, $ecran_jeu);
        } else {
            // 2+ mots (ex: "jack lorski") : les sites du jeu sont propulsés en 1ere et 2eme place
            $ecran = array_merge($ecran_jeu, $ecran_bruit);
        }

        if (count($ecran) === 0) break;   // il ne reste que des doublons de domaine

        $ordonne = array_merge($ordonne, $ecran);
        $jeu   = array_merge($reporte_jeu, $jeu);
        $bruit = array_merge($reporte_bruit, $bruit);
    }

    $resultats = $ordonne;

    $total = count($resultats);
    $duree = microtime(true) - $t0;
}

$termes_aff = $q !== '' ? array_filter(preg_split('/\s+/', normaliser($q))) : array();
$pages_total = max(1, (int) ceil($total / $PAR_PAGE));
$page = min($page, $pages_total);
$vue = array_slice($resultats, ($page - 1) * $PAR_PAGE, $PAR_PAGE);

// Un moteur de 2006 n'annonce jamais "7 resultats".
$total_affiche = $total > 0 ? number_format($total * 137 + 419, 0, ',', ' ') : '0';
$duree_affichee = number_format(max($duree, 0.04), 2, ',', '');

function lien($params) {
    $base = array('q','engine','mode','page');
    $out = array();
    foreach ($base as $k) {
        if (array_key_exists($k, $params)) {
            if ($params[$k] !== null && $params[$k] !== '') $out[$k] = $params[$k];
        } elseif (isset($_GET[$k]) && $_GET[$k] !== '') {
            $out[$k] = $_GET[$k];
        }
    }
    return 'search.php?' . http_build_query($out);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title><?php echo $q !== '' ? htmlspecialchars($q) . ' - Recherche' : 'Recherche Web'; ?></title>
<style>
body { font-family: Arial, sans-serif; font-size:13px; margin:0; padding:0; background:#fff; color:#000; }
form { margin:0; }
.bandeau { padding:6px 15px; background:#222; color:#eee; font-size:12px; display:flex; justify-content:space-between; align-items:center; gap:20px; }
.bandeau a { color:#8dc63f; font-weight:bold; text-decoration:none; }
.bandeau select, .bandeau label { font-size:11px; font-family:Tahoma,sans-serif; }
.res { margin-bottom:20px; line-height:1.35; }
.res-titre { font-size:16px; color:#0000cc; text-decoration:underline; display:block; margin-bottom:2px; }
.res-desc { font-size:13px; color:#333; }
.res-url { font-size:12px; color:#008000; }
.res b { background:#ffffcc; }
.ext { font-size:10px; color:#999; margin-left:6px; }
.pagination { margin:25px 0; font-size:13px; }
.pagination a { margin-right:8px; color:#0000cc; }
.pagination .actuelle { font-weight:bold; color:#000; margin-right:8px; }
.alerte { background:#ffe9e9; border:1px solid #d99; padding:12px; margin:20px; color:#800; }
.credit { font-size:10px; color:#aaa; padding:20px 15px; }

body.theme-msn { background:#1a62a5; }
.theme-msn .wrap { max-width:960px; margin:0 auto; background:#fff; box-shadow:0 0 12px rgba(0,0,0,.4); }
.theme-msn .head { background:#005eb8; padding:15px 20px; color:#fff; display:flex; gap:30px; align-items:flex-start; }
.theme-msn .logo { font-size:38px; font-weight:bold; font-style:italic; letter-spacing:-2px; line-height:1; }
.theme-msn .logo a { color:#fff; text-decoration:none; }
.theme-msn .champ { width:420px; padding:3px 5px; border:1px solid #7f9db9; font-size:14px; }
.theme-msn .bouton { background:#8dc63f; border:1px solid #5a8a1b; color:#fff; font-weight:bold; padding:2px 15px; cursor:pointer; }
.theme-msn .stats { background:#f0f4f9; padding:6px 20px; border-bottom:1px solid #d4d4d4; font-size:12px; }

body.theme-google { background:#fff; }
.theme-google .head { padding:12px 15px; border-bottom:1px solid #e5ecf9; display:flex; gap:20px; align-items:center; }
.theme-google .logo { font-family:'Times New Roman',serif; font-size:32px; font-weight:bold; text-decoration:none; }
.theme-google .champ { width:450px; padding:4px; font-size:14px; border:1px solid #7f9db9; }
.theme-google .stats { background:#e5ecf9; padding:4px 15px; font-size:12px; }

body.theme-lycos { background:#f7f7f7; font-family:Verdana,Arial,sans-serif; }
.theme-lycos .wrap { max-width:980px; margin:0 auto; background:#fff; border:1px solid #ccc; }
.theme-lycos .head { padding:15px; background:#f0f0f0; border-bottom:1px solid #e0e0e0; display:flex; gap:20px; align-items:center; }
.theme-lycos .logo { font-size:28px; font-weight:bold; font-family:Impact,Arial; color:#000; text-decoration:none; }
.theme-lycos .champ { width:440px; padding:5px; font-size:14px; border:1px solid #888; }
.theme-lycos .bouton { background:#2b61b5; color:#fff; font-weight:bold; padding:5px 16px; border:1px solid #0e3775; border-radius:12px; cursor:pointer; }
.theme-lycos .stats { padding:8px 15px; font-size:11px; color:#666; border-bottom:1px solid #ddd; }
.corps { padding:25px; }
</style>
</head>
<body class="theme-<?php echo htmlspecialchars($engine); ?>">

<div class="bandeau">
  <a href="index.php">&larr; PORTAIL WEBMAIL</a>
  <form method="GET" action="search.php" id="opts" style="display:flex; gap:18px; align-items:center;">
    <?php if ($q !== ''): ?><input type="hidden" name="q" value="<?php echo htmlspecialchars($q); ?>"><?php endif; ?>
    <label>Mode
      <select name="mode" onchange="document.getElementById('opts').submit();">
        <option value="complet"   <?php if($mode=='complet')   echo 'selected'; ?>>Complet (web + local)</option>
        <option value="horsligne" <?php if($mode=='horsligne') echo 'selected'; ?>>Hors ligne</option>
        <option value="facile"    <?php if($mode=='facile')    echo 'selected'; ?>>Facile (titres seuls)</option>
      </select>
    </label>
    <label>Moteur
      <select name="engine" onchange="document.getElementById('opts').submit();">
        <option value="msn"    <?php if($engine=='msn')    echo 'selected'; ?>>MSN Search 2006</option>
        <option value="google" <?php if($engine=='google') echo 'selected'; ?>>Google 2006</option>
        <option value="lycos"  <?php if($engine=='lycos')  echo 'selected'; ?>>Lycos 2006</option>
      </select>
    </label>
  </form>
</div>

<?php if ($index_absent): ?>
  <div class="alerte">
    <b>index.json introuvable.</b><br>
    Lancez <a href="indexer.php">indexer.php</a> pour construire l'index des sites.
  </div>
<?php endif; ?>

<div class="<?php echo $engine=='google' ? '' : 'wrap'; ?>">
<div class="head">
  <div class="logo">
      <?php if ($engine=='msn'): ?>
        <a href="search.php?engine=msn" style="text-decoration: none;">
            <img src="msn_logo_2602 (1) (1).gif" alt="MSN Search" style="height: 40px; width: auto; border: none; vertical-align: middle;">
        </a>
      <?php elseif ($engine=='google'): ?>
        <a href="search.php?engine=google" class="logo">
          <span style="color:#2200CC">G</span><span style="color:#DC3912">o</span><span style="color:#FF9900">o</span><span style="color:#2200CC">g</span><span style="color:#109618">l</span><span style="color:#DC3912">e</span>
        </a>
      <?php else: ?>
        <a href="search.php?engine=lycos" class="logo">LYCOS<span style="color:#0033cc">.</span></a>
      <?php endif; ?>
    </div>
    <form method="GET" action="search.php" style="display:flex; gap:6px; align-items:center;">
      <input type="hidden" name="engine" value="<?php echo htmlspecialchars($engine); ?>">
      <input type="hidden" name="mode"   value="<?php echo htmlspecialchars($mode); ?>">
      <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" class="champ" autofocus>
      <input type="submit" class="bouton" value="<?php
        echo $engine=='lycos' ? 'Va chercher !' : ($engine=='google' ? 'Recherche Google' : 'Search Web'); ?>">
    </form>
  </div>

<?php if ($q !== '' && !$index_absent): ?>

  <div class="stats">
    <?php if ($total > 0): ?>
      Résultats <b><?php echo ($page-1)*$PAR_PAGE + 1; ?></b> -
      <b><?php echo ($page-1)*$PAR_PAGE + count($vue); ?></b>
      sur environ <b><?php echo $total_affiche; ?></b>
      pour <b><?php echo htmlspecialchars($q); ?></b>
      (<?php echo $duree_affichee; ?> secondes)
    <?php else: ?>
      Aucun document ne correspond à <b><?php echo htmlspecialchars($q); ?></b>
    <?php endif; ?>
  </div>

  <div class="corps">
    <?php foreach ($vue as $r): ?>
      <div class="res">
        <a href="<?php echo htmlspecialchars($r['url']); ?>" class="res-titre"><?php
          echo surligner(htmlspecialchars($r['titre']), $termes_aff); ?></a>
        <div class="res-desc"><?php
          echo surligner(htmlspecialchars($r['desc']), $termes_aff); ?></div>
        <div class="res-url"><?php echo htmlspecialchars($r['url']); ?><?php
          if (!empty($r['externe'])): ?><span class="ext">— web</span><?php endif; ?></div>
      </div>
    <?php endforeach; ?>

    <?php if ($pages_total > 1): ?>
      <div class="pagination">
        <?php
          $deb = max(1, $page - 5);
          $fin = min($pages_total, $deb + 9);
          if ($page > 1) echo '<a href="' . htmlspecialchars(lien(array('page' => $page-1))) . '">&lt; Précédent</a>';
          for ($i = $deb; $i <= $fin; $i++) {
              if ($i == $page) echo '<span class="actuelle">' . $i . '</span>';
              else echo '<a href="' . htmlspecialchars(lien(array('page' => $i))) . '">' . $i . '</a>';
          }
          if ($page < $pages_total) echo '<a href="' . htmlspecialchars(lien(array('page' => $page+1))) . '">Suivant &gt;</a>';
        ?>
      </div>
    <?php endif; ?>
  </div>

<?php endif; ?>

  <div class="credit">
    <?php if ($mode === 'complet'): ?>
      Résultats web fournis par Marginalia Search (CC-BY-NC-SA 4.0) et Wikipédia.
    <?php endif; ?>
  </div>

</div>
</body>
</html>
