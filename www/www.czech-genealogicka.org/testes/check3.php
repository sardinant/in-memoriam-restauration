<?php
// check3.php - recherche dans la base genealogique franco-tcheque
// A placer dans www.czech-genealogicka.org/
//
// Le formulaire de search.htm poste le champ "name_family".
// Le site d'origine servait une page result_X.htm par initiale.
// Prerequis : renommer la page capturee  check3.php -> check3_vide.html
//             (c'est la reponse "aucune donnee disponible pour ce nom")

$nom = isset($_POST['name_family']) ? trim($_POST['name_family']) : '';
if ($nom === '' && isset($_GET['name_family'])) $nom = trim($_GET['name_family']);

header('Content-Type: text/html; charset=utf-8');

if ($nom !== '') {
    // Malko : le seul nom qui mene a une liste de resultats
    if (mb_strtolower($nom, 'UTF-8') === 'malko') {
        header('Location: result2.htm');
        exit;
    }
    // sinon : page par initiale, si elle existe
    $init = mb_strtoupper(mb_substr($nom, 0, 1, 'UTF-8'), 'UTF-8');
    $page = __DIR__ . "/result_{$init}.htm";
    if (preg_match('/^[A-Z]$/', $init) && file_exists($page)) {
        header("Location: result_{$init}.htm");
        exit;
    }
}

// aucun resultat : page d'origine
$vide = __DIR__ . '/check3_vide.html';
if (file_exists($vide)) { readfile($vide); }
else { echo '<html><head><meta charset="utf-8"></head><body bgcolor="white">'
          . '<p>Aucune donn&eacute;e n\'est disponible pour ce nom dans notre base.</p>'
          . '<p><a href="search.htm">Retour</a></p></body></html>'; }
