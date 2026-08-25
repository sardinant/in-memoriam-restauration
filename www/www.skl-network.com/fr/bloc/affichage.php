<?php
/**
 * affichage.php — liste des sujets du bloc-notes
 *
 * Reprend l'entete, le gabarit de ligne et le pied extraits de la page
 * archivee, et genere les lignes depuis le stockage local.
 */

require_once __DIR__ . '/bloc_lib.php';
bloc_exiger_session();

$notes = bloc_charger();

$lignes = '';
$gabarit = bloc_gabarit('_gabarit_ligne.html');

foreach ($notes as $n) {
    $l = $gabarit;
    $l = str_replace('{{DATE}}',  bloc_echapper($n['date']),  $l);
    $l = str_replace('{{ID}}',    (int) $n['id'],             $l);
    $l = str_replace('{{SUJET}}', bloc_echapper($n['sujet']), $l);
    $lignes .= $l;
}

if ($lignes === '') {
    $lignes = '<tr><td align="center">'
            . '<font size="2" face="Arial, Helvetica, sans-serif">'
            . '<i>Aucun sujet pour le moment.</i></font></td></tr>';
}

header('Content-Type: text/html; charset=iso-8859-1');
echo bloc_gabarit('_entete.html');
echo $lignes;
echo bloc_gabarit('_pied.html');
