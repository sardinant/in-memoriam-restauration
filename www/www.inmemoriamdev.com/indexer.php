<?php
/**
 * indexer.php — construction de l'index du moteur de recherche In Memoriam
 *
 * Parcourt les sites locaux et ne retient QUE les pages d'accueil (index.*),
 * une par répertoire de navigation réel. Produit un annuaire, pas un index
 * de pages : le moteur d'origine renvoyait des sites, pas huit entrées du
 * même domaine.
 *
 * Usage (dans le dossier du script) :
 *   php indexer.php            -> écrit index.json
 *   php indexer.php --report   -> n'écrit rien, affiche ce qui serait gardé
 *                                 ou écarté, avec la raison et la longueur
 *                                 du texte utile. À lancer en premier.
 */

// ---------------------------------------------------------------------------
// CONFIGURATION
// ---------------------------------------------------------------------------

$CONFIG = [

    // Racine des sites. Un sous-dossier = un domaine.
    'racine' => 'C:/UwAmp/www',

    'sortie' => __DIR__ . '/index.json',

    // Domaines jamais indexés : le joueur doit les découvrir lui-même,
    // ou ils divulgâchent la fin.
    'domaines_exclus' => [
        'www.xineph.com',
        'www.fe256.net',
        'www.liberation-inmemoriam.fr',
        'www.inmemoriamdev.com',   // le moteur lui-meme
        'www.xinephold',           // copie de travail de xineph
        '_bruit',
        '_config',
    ],

    // Chemins exclus, testés en sous-chaîne sur l'URL complète.
    // Contenu de l'add-on et endgame.
    'chemins_exclus' => [
        '/borgo/',
        '/karen0021/',
    ],

    // Branches linguistiques à écarter (on ne garde que le français).
    // Segments de chemin, comparés tels quels.
    'langues_exclues' => array(
        'en', 'gb', 'us', 'uk', 'in',      // anglais
        'de', 'ge', 'at',                  // allemand
        'es', 'sp', 'mx',                  // espagnol
        'it', 'nl', 'be', 'pt', 'br',
        'ru', 'pl', 'jp', 'cn', 'kr', 'gr',
    ),

    // Répertoires techniques : ils ont un index.html vide posé là
    // uniquement pour bloquer le listing Apache.
    'repertoires_techniques' => [
        'images', 'image', 'img', 'css', 'js', 'inc', 'includes',
        'scripts', 'script', 'style', 'styles', 'media', 'flash',
        'swf', 'fonts', 'icons', 'thumbs', 'cgi-bin', '_vti_cnf',
    ],

    // Longueur minimale du texte utile, en caractères, après retrait
    // des scripts, styles et balises. Sous ce seuil, page coquille vide.
    // Passe d'abord --report pour caler cette valeur sur ton corpus.
    'longueur_min' => 100,

    // Intros Flash, redirections JavaScript, pages d'attente : aucun texte
    // propre, mais un <title> et souvent des <meta keywords>. Pour un
    // annuaire, une entree maigre vaut mieux qu'un site absent.
    // Mets a false pour revenir a un filtrage strict.
    'garder_si_titre' => true,

    // Noms de fichiers acceptés comme page d'accueil.
    'index_valides' => array('index.php', 'index.html', 'index.htm', 'index.shtml',
                             'index.asp', 'index.aspx', 'index.cfm',
                             'index.php3', 'index.php4', 'index.phtml'),

    // Utilises seulement si aucun index.* n'existe dans le repertoire.
    // Beaucoup de sites de 2003 ouvrent sur autre chose.
    'index_replis' => array(
        'default.htm', 'default.html', 'accueil.htm', 'accueil.html',
        'accueil.php', 'home.htm', 'home.html', 'main.htm', 'main.html',
        'sommaire.htm', 'sommaire.html', 'menu.htm', 'menu.html',
    ),

    // Pages nommees a indexer meme si ce ne sont pas des index.*.
    // Ce sont les pages profondes que le jeu fait reellement visiter :
    // articles de Liberation, fiches Trombi, pages perso. Liste tiree de
    // l'inventaire de la Confrerie Anti-Phoenix et de la soluce d'epoque.
    // Format : chemin relatif a la racine, separateurs en /.
    'pages_forcees' => array(
        // Jack Lorski
        'www.liberation.fr/im/vodkafrappee.php',
        'www.liberation.fr/im/jacklorskiadisparu.php',
        'www.liberation.fr/im/jauraisapeau.php',
        'www.liberation.fr/im/leserialkillerinnove.php',
        'www.trombi.com/inscrit__fiche_251768.cfm',
        'groups.msn.com/Niechzyjepolska/',
        // Julie Massenet
        'www.gudule.net/fiche_tromb__id_tromb_14.php',
        'www.webzinemaker.com/julie_massenet/',
        'www.cathedrale-paris.net/',
        // Volker et Nag Hammadi
        'www.jim-leroy.net/complot2.html',
        'www.nag-hammadi.com/',
        // Karen Gijman
        'natalecta.com/portrait/932/',
        'natalecta.com/portrait/932/Karen_GIJMAN.html',
        // Guido Corliano
        'www.ricochet-jeunes.org/talent__id_320.asp',
        // Manus Domini
        'www.mysterious-world.net/3forum7.html',
        // Lieux et indices cites par la soluce
        'www.skl-network.com/soth01/',
        'www.persofrance.com/mathet/',
        'www.persofrance.com/mathet/jour1.html',
        'www.persofrance.com/mathet/jour2.html',
        'www.persofrance.com/mathet/jour3.html',
        'www.persofrance.com/mathet/saintsophie.html',
        'www.demagia.net/fr/corne.html',
        'www.tychobrahe.net/fr/2prague.html',
        'www.benatky-castle.net/fr/historie.html',
        'www.rhodestravel.com/fr/Daten.html',
        'www.messini-yc.com/fr/index.html',
        'www.italia-libero.com/ghidoni/fr/index.html',
        'persocite.francite.com/alonzo/index.htm',
    ),

    // Profondeur maximale de sous-répertoires sous le domaine.
    // 2 couvre www.site.com/fr/section/ sans partir dans les feuilles.
    'profondeur_max' => 2,
];

// ---------------------------------------------------------------------------
// REPLI SI mbstring EST ABSENT
// Le PHP en ligne de commande d'UwAmp ne charge pas toujours mbstring,
// alors que celui d'Apache si. Ces implementations suffisent ici.
// ---------------------------------------------------------------------------

if (!function_exists('mb_check_encoding')) {
    function mb_check_encoding($s, $enc = 'UTF-8') {
        return $enc !== 'UTF-8' ? true : (preg_match('//u', $s) === 1);
    }
}
if (!function_exists('mb_convert_encoding')) {
    function mb_convert_encoding($s, $vers, $depuis = null) {
        if (function_exists('iconv')) {
            $r = @iconv($depuis ?: 'ISO-8859-1', $vers . '//TRANSLIT//IGNORE', $s);
            if ($r !== false) return $r;
        }
        return ($depuis === 'UTF-8') ? $s : utf8_encode($s);
    }
}
if (!function_exists('mb_strlen')) {
    function mb_strlen($s, $enc = 'UTF-8') {
        $n = preg_match_all('/./us', $s);
        return $n === false ? strlen($s) : $n;
    }
}
if (!function_exists('mb_substr')) {
    function mb_substr($s, $d, $l = null, $enc = 'UTF-8') {
        preg_match_all('/./us', $s, $m);
        $c = $l === null ? array_slice($m[0], $d) : array_slice($m[0], $d, $l);
        return implode('', $c);
    }
}

// ---------------------------------------------------------------------------

$modeRapport = in_array('--report', $argv ?? [], true);

if (!is_dir($CONFIG['racine'])) {
    fwrite(STDERR, "Racine introuvable : {$CONFIG['racine']}\n");
    exit(1);
}

$index   = [];
$ecartes = [];

foreach (scandir($CONFIG['racine']) as $domaine) {
    if ($domaine === '.' || $domaine === '..') continue;
    $cheminDomaine = $CONFIG['racine'] . '/' . $domaine;
    if (!is_dir($cheminDomaine)) continue;

    if (in_array(strtolower($domaine), array_map('strtolower', $CONFIG['domaines_exclus']), true)) {
        $ecartes[] = [$domaine, '-', 'domaine exclu'];
        continue;
    }

    parcourir($cheminDomaine, $domaine, '', 0, $CONFIG, $index, $ecartes);
}

// ---------------------------------------------------------------------------
// PAGES NOMMEES FORCEES
// ---------------------------------------------------------------------------

$dejaIndexe = array();
$empreintes = array();
foreach ($index as $e) {
    $dejaIndexe[strtolower($e['url'])] = true;
    $empreintes[md5($e['site'] . '|' . $e['texte'])] = true;
}

foreach ($CONFIG['pages_forcees'] as $rel) {
    $rel = ltrim($rel, '/');
    $url = 'http://' . $rel;
    if (isset($dejaIndexe[strtolower($url)])) continue;

    $domaine = strtok($rel, '/');
    $chemin  = $CONFIG['racine'] . '/' . $rel;

    // un chemin en / vise l'index du repertoire
    if (substr($rel, -1) === '/' || strpos(basename($rel), '.') === false) {
        $trouve = null;
        foreach (array_merge($CONFIG['index_valides'], $CONFIG['index_replis']) as $c) {
            if (is_file(rtrim($chemin, '/') . '/' . $c)) { $trouve = rtrim($chemin, '/') . '/' . $c; break; }
        }
        $chemin = $trouve;
    } elseif (!is_file($chemin)) {
        // .php/.cfm dynamiques : parfois aspires en .html
        $variantes = array($chemin . '.html', $chemin . '.htm',
                           preg_replace('/\.(php|cfm|asp)$/i', '.html', $chemin));
        $chemin = null;
        foreach ($variantes as $v) { if ($v && is_file($v)) { $chemin = $v; break; } }
    }

    if ($chemin === null || !is_file($chemin)) {
        $ecartes[] = array($url, 'forcee', 'INTROUVABLE sur le disque');
        continue;
    }

    $html = @file_get_contents($chemin);
    if ($html === false) { $ecartes[] = array($url, 'forcee', 'lecture impossible'); continue; }
    $html = versUtf8($html);
    $txt  = texteUtile($html);
    if (mb_strlen($txt) < $CONFIG['longueur_min']) {
        $suivi = suivreInclusions($html, dirname($chemin), $CONFIG, 0);
        if ($suivi !== '') $txt = trim($txt . ' ' . $suivi);
    }
    $emp = md5($domaine . '|' . $txt);
    if (isset($empreintes[$emp])) continue;   // meme contenu deja indexe
    $empreintes[$emp] = true;

    $t  = titre($html);
    $mc = meta($html, 'keywords');
    $index[] = array(
        'url'      => $url,
        'site'     => $domaine,
        'titre'    => $t !== '' ? $t : $domaine,
        'desc'     => meta($html, 'description'),
        'motscles' => $mc,
        'texte'    => $txt !== '' ? $txt : trim($t . ' ' . $mc),
        'longueur' => mb_strlen($txt),
        'origine'  => '[page forcee]',
    );
}

// ---------------------------------------------------------------------------
// SORTIE
// ---------------------------------------------------------------------------

if ($modeRapport) {
    rapport($index, $ecartes);
    exit(0);
}

foreach ($index as &$e) unset($e['longueur']);
unset($e);

file_put_contents(
    $CONFIG['sortie'],
    json_encode(
        ['genere' => date('c'), 'entrees' => $index],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    )
);

echo count($index) . " pages indexees -> {$CONFIG['sortie']}\n";
echo count($ecartes) . " ecartees (php indexer.php --report pour le detail)\n";

// ---------------------------------------------------------------------------
// FONCTIONS
// ---------------------------------------------------------------------------

function parcourir($chemin, $domaine, $relatif, $profondeur, $CONFIG, &$index, &$ecartes)
{
    $urlDossier = 'http://' . $domaine . '/' . ($relatif === '' ? '' : $relatif . '/');

    // --- la page d'accueil de ce répertoire -------------------------------
    $fichier = null;
    $repli   = false;
    foreach ($CONFIG['index_valides'] as $candidat) {
        if (is_file($chemin . '/' . $candidat)) { $fichier = $candidat; break; }
    }
    if ($fichier === null) {
        foreach ($CONFIG['index_replis'] as $candidat) {
            if (is_file($chemin . '/' . $candidat)) { $fichier = $candidat; $repli = true; break; }
        }
    }
    // Dernier recours a la racine d'un domaine : le premier document HTML
    // venu. Mieux vaut une porte d'entree approximative que pas de site.
    if ($fichier === null && $profondeur === 0) {
        $tous = glob($chemin . '/*.{htm,html,php,shtml}', GLOB_BRACE);
        if ($tous) { sort($tous); $fichier = basename($tous[0]); $repli = true; }
    }

    if ($fichier === null) {
        if ($profondeur === 0) {
            $ecartes[] = array($domaine, '-', 'AUCUN index.* ni repli - absent du moteur');
        }
    } else {
        $motif = motifExclu($urlDossier, $CONFIG);
        if ($motif !== null) {
            $ecartes[] = array($urlDossier, '-', $motif);
        } else {
            $html  = @file_get_contents($chemin . '/' . $fichier);
            if ($html === false) {
                $ecartes[] = array($urlDossier, '-', 'lecture impossible');
            } else {
                $html  = versUtf8($html);
                $texte = texteUtile($html);

                // Les pages d'accueil de 2003 sont souvent de simples
                // <frameset> ou des redirections meta : aucun texte propre,
                // mais ce sont de vraies portes d'entree. On va chercher le
                // contenu dans les documents qu'elles appellent.
                $suivi = '';
                if (mb_strlen($texte) < $CONFIG['longueur_min']) {
                    $suivi = suivreInclusions($html, $chemin, $CONFIG, 0);
                    if ($suivi !== '') {
                        $texte = trim($texte . ' ' . $suivi);
                    }
                }
                $len = mb_strlen($texte);

                $t   = titre($html);
                $mc  = meta($html, 'keywords');
                $ds  = meta($html, 'description');
                $maigre = false;

                if ($len < $CONFIG['longueur_min']) {
                    if ($CONFIG['garder_si_titre'] && ($t !== '' || $mc !== '')) {
                        // on indexe sur le titre et les mots-cles
                        $texte  = trim($t . ' ' . $ds . ' ' . str_replace(',', ' ', $mc) . ' ' . $texte);
                        $len    = mb_strlen($texte);
                        $maigre = true;
                    } else {
                        $ecartes[] = array($urlDossier, $len . ' car.',
                                           'aucun texte, aucun titre');
                    }
                }

                if ($len === 0 || (!$maigre && $len < $CONFIG['longueur_min'])) {
                    // deja signale ci-dessus
                } else {
                    $index[] = array(
                        'url'      => $urlDossier,
                        'site'     => $domaine,
                        'titre'    => $t !== '' ? $t : $domaine,
                        'desc'     => $ds,
                        'motscles' => $mc,
                        'texte'    => $texte,
                        'longueur' => $len,
                        'origine'  => ($repli ? $fichier : '')
                                      . ($suivi !== '' ? ' +frames' : '')
                                      . ($maigre ? ' [titre seul]' : ''),
                    );
                }
            }
        }
    }

    // --- descente dans les sous-répertoires -------------------------------
    if ($profondeur >= $CONFIG['profondeur_max']) return;

    foreach (scandir($chemin) as $sous) {
        if ($sous === '.' || $sous === '..') continue;
        $cheminSous = $chemin . '/' . $sous;
        if (!is_dir($cheminSous)) continue;

        $nom = strtolower($sous);
        if (in_array($nom, $CONFIG['repertoires_techniques'], true)) continue;
        if (in_array($nom, $CONFIG['langues_exclues'], true)) {
            $ecartes[] = [$domaine . '/' . ltrim($relatif . '/' . $sous, '/'), '-', 'branche linguistique'];
            continue;
        }

        parcourir(
            $cheminSous,
            $domaine,
            $relatif === '' ? $sous : $relatif . '/' . $sous,
            $profondeur + 1,
            $CONFIG, $index, $ecartes
        );
    }
}

function motifExclu($url, $CONFIG)
{
    foreach ($CONFIG['chemins_exclus'] as $frag) {
        if (stripos($url, $frag) !== false) return 'chemin exclu (' . $frag . ')';
    }
    return null;
}

/** Les pages de 2003 sont en ISO-8859-1 la plupart du temps. */
function versUtf8($html)
{
    $charset = null;
    if (preg_match('/charset\s*=\s*["\']?\s*([\w\-]+)/i', substr($html, 0, 2048), $m)) {
        $charset = strtoupper($m[1]);
    }
    // Une declaration peut mentir : page ré-enregistrée en UTF-8 par un
    // outil d'archivage tout en gardant son ancien <meta charset>.
    // Si le contenu contient de vraies sequences multi-octets UTF-8
    // valides, on croit les octets plutot que la declaration.
    $semble_utf8 = mb_check_encoding($html, 'UTF-8')
                   && preg_match('/[\xC2-\xF4][\x80-\xBF]/', $html);

    if ($charset === null) {
        $charset = $semble_utf8 ? 'UTF-8' : 'ISO-8859-1';
    } elseif ($charset !== 'UTF-8' && $semble_utf8) {
        $charset = 'UTF-8';
    }
    if ($charset !== 'UTF-8') {
        $conv = @mb_convert_encoding($html, 'UTF-8', $charset);
        if ($conv !== false) $html = $conv;
    }
    return $html;
}

/** Texte lisible : sans scripts, styles, head, commentaires ni balises. */
function texteUtile($html)
{
    $t = preg_replace('#<(script|style|head|noscript)\b[^>]*>.*?</\1>#is', ' ', $html);
    $t = preg_replace('#<!--.*?-->#s', ' ', $t);
    $t = strip_tags($t);
    $t = html_entity_decode($t, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $t = preg_replace('/\x{00A0}/u', ' ', $t);
    return trim(preg_replace('/\s+/u', ' ', $t));
}

function titre($html)
{
    if (preg_match('#<title[^>]*>(.*?)</title>#is', $html, $m)) {
        return trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($m[1]), ENT_QUOTES, 'UTF-8')));
    }
    return '';
}

function meta($html, $nom)
{
    $p = '#<meta[^>]+name\s*=\s*["\']?' . preg_quote($nom, '#') . '["\']?[^>]*>#i';
    if (preg_match($p, $html, $m) && preg_match('#content\s*=\s*"([^"]*)"#i', $m[0], $c)) {
        return trim(html_entity_decode($c[1], ENT_QUOTES, 'UTF-8'));
    }
    return '';
}

// ---------------------------------------------------------------------------
// RAPPORT
// ---------------------------------------------------------------------------

function pad($s, $n)
{
    $l = mb_strlen($s);
    if ($l > $n) return mb_substr($s, 0, $n - 1) . '~';
    return $s . str_repeat(' ', $n - $l);
}

function tableau($titre, array $lignes, array $entetes)
{
    echo "\n" . $titre . "\n";

    if (!$lignes) { echo "  (aucune)\n"; return; }

    $n = count($entetes);
    $w = array();
    for ($i = 0; $i < $n; $i++) {
        $w[$i] = mb_strlen($entetes[$i]);
        foreach ($lignes as $l) $w[$i] = max($w[$i], mb_strlen((string)$l[$i]));
        $w[$i] = min($w[$i], 78);
    }

    $sep = '+'; foreach ($w as $x) $sep .= str_repeat('-', $x + 2) . '+';

    echo $sep . "\n|";
    for ($i = 0; $i < $n; $i++) echo ' ' . pad($entetes[$i], $w[$i]) . ' |';
    echo "\n" . $sep . "\n";

    foreach ($lignes as $l) {
        echo '|';
        for ($i = 0; $i < $n; $i++) echo ' ' . pad((string)$l[$i], $w[$i]) . ' |';
        echo "\n";
    }
    echo $sep . "\n";
}

function rapport(array $index, array $ecartes)
{
    // --- repartition par domaine, le plus utile en premier -------------
    $parSite = array();
    foreach ($index as $e) {
        $s = $e['site'];
        $parSite[$s] = isset($parSite[$s]) ? $parSite[$s] + 1 : 1;
    }
    arsort($parSite);

    $l = array();
    foreach ($parSite as $site => $nb) {
        $l[] = array($nb, $site, $nb > 8 ? '<-- arborescence profonde' : '');
    }
    tableau('REPARTITION PAR DOMAINE (' . count($parSite) . ' sites, ' . count($index) . ' pages)',
            $l, array('Nb', 'Domaine', ''));

    // --- domaines vraiment absents : zero page indexee ------------------
    // Un domaine sans index.* a sa racine n'est pas perdu si un de ses
    // sous-repertoires a ete retenu. On ne signale que le vrai vide.
    $presents = array();
    foreach ($index as $e) $presents[$e['site']] = true;

    $orphelins = array();
    $deja      = array();
    foreach ($ecartes as $e) {
        if ($e[1] === 'forcee') continue;   // traitees dans leur propre tableau
        $d = strtok(str_replace(array('http://', 'https://'), '', $e[0]), '/');
        if (isset($presents[$d]) || isset($deja[$d])) continue;
        if (strpos($e[2], 'exclu') !== false) continue;
        $deja[$d]    = true;
        $orphelins[] = array($d, $e[2]);
    }
    tableau('DOMAINES ABSENTS DU MOTEUR - zero page retenue (' . count($orphelins) . ')',
            $orphelins, array('Domaine', 'Cause'));

    // --- pages forcees non resolues : a corriger a la main -------------
    $forceesKO = array();
    foreach ($ecartes as $e) {
        if ($e[1] === 'forcee') $forceesKO[] = array($e[0], $e[2]);
    }
    tableau('PAGES FORCEES INTROUVABLES - chemin a verifier (' . count($forceesKO) . ')',
            $forceesKO, array('URL attendue', 'Cause'));

    // --- motifs d'exclusion --------------------------------------------
    $motifs = array();
    foreach ($ecartes as $e) {
        $m = preg_replace('/\s*\(.*\)$/', '', $e[2]);
        $motifs[$m] = isset($motifs[$m]) ? $motifs[$m] + 1 : 1;
    }
    arsort($motifs);
    $l = array();
    foreach ($motifs as $m => $nb) $l[] = array($nb, $m);
    tableau('ECARTEES PAR MOTIF (' . count($ecartes) . ')', $l, array('Nb', 'Motif'));

    // --- les plus courtes : c'est la que se cale le seuil ---------------
    usort($index, function ($a, $b) { return $a['longueur'] - $b['longueur']; });
    $l = array();
    foreach (array_slice($index, 0, 15) as $e) {
        $l[] = array($e['longueur'], $e['url'], $e['titre']);
    }
    tableau('LES 15 PLUS COURTES RETENUES — verifie le seuil ici',
            $l, array('Car.', 'URL', 'Titre'));

    if (in_array('--tout', $GLOBALS['argv'], true)) {
        $l = array();
        foreach ($index as $e) $l[] = array($e['longueur'], $e['url'], $e['titre']);
        tableau('TOUTES LES RETENUES', $l, array('Car.', 'URL', 'Titre'));
        $l = array();
        foreach ($ecartes as $e) $l[] = array($e[0], $e[2]);
        tableau('TOUTES LES ECARTEES', $l, array('Cible', 'Motif'));
    }

    echo "\nRien n'a ete ecrit. Relance sans --report quand le tri te convient.\n";
    echo "Detail complet : php indexer.php --report --tout\n";
}

/**
 * Recupere le texte des documents appeles par une page vide :
 * <frame src>, <iframe src>, et <meta http-equiv="refresh" ... url=>.
 * Deux niveaux au maximum, avec garde anti-boucle.
 */
function suivreInclusions($html, $dossier, $CONFIG, $niveau, &$vus = array())
{
    if ($niveau > 2) return '';

    $cibles = array();

    if (preg_match_all('#<(?:frame|iframe)\b[^>]*\bsrc\s*=\s*["\']?([^"\'>\s]+)#i', $html, $m)) {
        foreach ($m[1] as $c) $cibles[] = $c;
    }
    if (preg_match('#<meta[^>]+http-equiv\s*=\s*["\']?refresh["\']?[^>]*>#i', $html, $mm)
        && preg_match('#url\s*=\s*["\']?([^"\'>\s]+)#i', $mm[0], $mu)) {
        $cibles[] = $mu[1];
    }
    // redirections JavaScript : document.location = "...", window.location.href = '...'
    if (preg_match_all('#(?:document|window|top|self)\s*\.\s*location(?:\s*\.\s*(?:href|replace))?\s*(?:=|\()\s*["\']([^"\']+)["\']#i', $html, $mj)) {
        foreach ($mj[1] as $c) $cibles[] = $c;
    }

    $texte = '';
    foreach ($cibles as $src) {
        $src = html_entity_decode($src, ENT_QUOTES, 'UTF-8');
        if (preg_match('~^(https?:|ftp:|javascript:|mailto:|\#)~i', $src)) continue;

        $f = normaliser($dossier . '/' . $src);
        if ($f === null || isset($vus[$f]) || !is_file($f)) continue;
        $vus[$f] = true;

        $sous = @file_get_contents($f);
        if ($sous === false) continue;
        $sous = versUtf8($sous);

        $texte .= ' ' . texteUtile($sous);
        $texte .= ' ' . suivreInclusions($sous, dirname($f), $CONFIG, $niveau + 1, $vus);
    }

    return trim(preg_replace('/\s+/u', ' ', $texte));
}

/** Resout les ../ et ./ d'un chemin de fichier. */
function normaliser($chemin)
{
    $chemin = str_replace('\\', '/', $chemin);
    $morceaux = array();
    foreach (explode('/', $chemin) as $m) {
        if ($m === '' || $m === '.') {
            if (count($morceaux) === 0) $morceaux[] = $m;
            continue;
        }
        if ($m === '..') { array_pop($morceaux); continue; }
        $morceaux[] = $m;
    }
    return implode('/', $morceaux);
}
