<?php
/**
 * stream_dcr.php — sert les films Shockwave en flux progressif
 *
 * Pourquoi : les .dcr de xineph appellent tellStreamStatus() et attendent
 * que le plugin leur rapporte l'avancement du telechargement. Ils ne
 * demarrent qu'a reception de l'etat "Complete". Servi depuis un Apache
 * local, le fichier arrive instantanement : le plugin ne rapporte rien,
 * bytesTotal reste a 0, et le film attend indefiniment sur sa frame de
 * chargement ("0 (0)% of 0k").
 *
 * Ce script retablit un debit comparable a une connexion de 2003. Aucun
 * fichier du jeu n'est modifie.
 *
 * Installation : voir .htaccess fourni a cote.
 */

// --- reglage -------------------------------------------------------------
// Debit en octets par seconde. 56 Ko/s ~ ADSL bas de gamme de 2003.
// Monter si les films demarrent bien mais que l'attente est trop longue,
// descendre s'ils restent bloques.
$DEBIT = 56 * 1024;

$MORCEAU = 4096;          // taille d'un envoi, en octets
$RACINE  = __DIR__;       // les fichiers servis doivent rester sous ce dossier
// -------------------------------------------------------------------------

$demande = isset($_GET['f']) ? $_GET['f'] : '';

// pas de remontee d'arborescence
$demande = str_replace('\\', '/', $demande);
if ($demande === '' || strpos($demande, '..') !== false) {
    header('HTTP/1.1 400 Bad Request');
    exit('Requete invalide');
}

$chemin = realpath($RACINE . '/' . ltrim($demande, '/'));
if ($chemin === false || strpos($chemin, realpath($RACINE)) !== 0 || !is_file($chemin)) {
    header('HTTP/1.1 404 Not Found');
    exit('Introuvable');
}

$ext = strtolower(pathinfo($chemin, PATHINFO_EXTENSION));
$types = array(
    'dcr' => 'application/x-director',
    'dxr' => 'application/x-director',
    'dir' => 'application/x-director',
    'cct' => 'application/x-director',
    'cst' => 'application/x-director',
    'cxt' => 'application/x-director',
    'swa' => 'application/x-director',
);
if (!isset($types[$ext])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Type non servi');
}

$taille = filesize($chemin);

// --- couper tout ce qui pourrait tamponner la sortie ----------------------
@ini_set('zlib.output_compression', '0');
@ini_set('output_buffering', '0');
@ini_set('implicit_flush', '1');
@set_time_limit(0);
while (ob_get_level() > 0) { ob_end_clean(); }
ob_implicit_flush(true);

// --- en-tetes ------------------------------------------------------------
// Content-Length est indispensable : c'est lui qui donne bytesTotal au
// plugin, donc au film. Sans lui, on retombe sur "of 0k".
header('Content-Type: ' . $types[$ext]);
header('Content-Length: ' . $taille);
header('Accept-Ranges: none');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('X-Accel-Buffering: no');

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'HEAD') exit;

// --- envoi progressif ----------------------------------------------------
$pause = (int) round(($MORCEAU / $DEBIT) * 1000000);   // microsecondes

$fh = fopen($chemin, 'rb');
if ($fh === false) {
    header('HTTP/1.1 500 Internal Server Error');
    exit;
}

while (!feof($fh)) {
    if (connection_aborted()) break;
    echo fread($fh, $MORCEAU);
    flush();
    if ($pause > 0) usleep($pause);
}
fclose($fh);
