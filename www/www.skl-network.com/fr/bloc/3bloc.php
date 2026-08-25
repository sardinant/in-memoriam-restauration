<?php
/**
 * 3bloc.php — formulaire de creation / modification / suppression
 *
 * Appele depuis affichage.php :
 *   3bloc.php?type=Creer
 *   3bloc.php?MyId=N&type=Modifier
 *   3bloc.php?MyId=N&type=Supprimer
 *
 * Reutilise le gabarit de la page de creation archivee.
 */

require_once __DIR__ . '/bloc_lib.php';
bloc_exiger_session();

$id   = isset($_GET['MyId']) ? (int) $_GET['MyId'] : 0;
$type = isset($_GET['type']) ? $_GET['type'] : "Cr\xe9er";

$notes = bloc_charger();

// --- suppression : effet immediat, puis retour a la liste ----------------
if (stripos($type, 'Supprim') === 0 && $id > 0) {
    $restant = array();
    foreach ($notes as $n) {
        if ((int) $n['id'] !== $id) $restant[] = $n;
    }
    bloc_enregistrer($restant);
    header('Content-Type: text/html; charset=iso-8859-1');
    echo '<script language="javascript">window.location.href="affichage.php"</script>';
    exit;
}

// --- creation ou modification -------------------------------------------
$sujet = '';
$texte = '';
$date  = date('d-m-Y  H:i');

if (stripos($type, 'Modifi') === 0 && $id > 0) {
    $n = bloc_trouver($notes, $id);
    if ($n !== null) {
        $sujet = $n['sujet'];
        $texte = $n['texte'];
        $date  = $n['date'];
    }
    $bouton = 'Modifier';
} else {
    $type   = "Cr\xe9er";
    $id     = 0;
    $bouton = "Cr\xe9er";
}

$page = bloc_gabarit('_gabarit_form.html');
$page = str_replace('{{ID}}',     $id > 0 ? (string) $id : '', $page);
$page = str_replace('{{TYPE}}',   bloc_echapper($type),        $page);
$page = str_replace('{{SUJET}}',  bloc_echapper($sujet),       $page);
$page = str_replace('{{TEXTE}}',  bloc_echapper($texte),       $page);
$page = str_replace('{{BOUTON}}', bloc_echapper($bouton),      $page);
$page = str_replace('{{DATE}}',   bloc_echapper($date),        $page);

header('Content-Type: text/html; charset=iso-8859-1');
echo $page;
