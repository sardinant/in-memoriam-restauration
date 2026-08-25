<?php
/**
 * redirect.php — passerelle vers le moteur de recherche local
 *
 * Les sites du jeu embarquent une barre de recherche MSN dont le
 * formulaire poste vers redirect.php. A l'epoque, ce script renvoyait
 * vers le vrai MSN Search. Ici, il renvoie vers le moteur reconstruit.
 *
 * A deposer dans chaque site qui possede une telle barre, au meme niveau
 * que la page qui contient le formulaire.
 */

// --- reglage -------------------------------------------------------------
$MOTEUR = 'http://www.inmemoriamdev.com/search.php';
// -------------------------------------------------------------------------

// le formulaire poste en POST, mais certaines pages utilisent GET
$q = '';
if (isset($_POST['q']))      { $q = $_POST['q']; }
elseif (isset($_GET['q']))   { $q = $_GET['q']; }

$q = trim($q);

// Les pages du jeu sont en ISO-8859-1, le moteur travaille en UTF-8.
// Sans conversion, une recherche accentuee arrive cassee.
if ($q !== '' && !preg_match('//u', $q)) {
    if (function_exists('mb_convert_encoding')) {
        $q = mb_convert_encoding($q, 'UTF-8', 'ISO-8859-1');
    } elseif (function_exists('iconv')) {
        $conv = @iconv('ISO-8859-1', 'UTF-8//IGNORE', $q);
        if ($conv !== false) $q = $conv;
    } else {
        $q = utf8_encode($q);
    }
}

$cible = $MOTEUR;
if ($q !== '') {
    $cible .= '?q=' . rawurlencode($q);
}

header('Location: ' . $cible, true, 302);
exit;
