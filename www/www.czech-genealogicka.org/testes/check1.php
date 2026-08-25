<?php
// check1.php - authentification du serveur genealogique franco-tcheque
// A placer dans www.czech-genealogicka.org/
//
// Identifiants d'origine : Carolina / jabamiah
// (jabamiah est le nom de l'ange gardien de Carolina Molikova,
//  indice laisse par elle sur le forum du site)
// Le message d'erreur d'epoque precise que la casse compte : comparaison stricte.
//
// Prerequis : renommer la page d'erreur recuperee de l'archive
//             check1.php  ->  check1_erreur.html

$ident = isset($_POST['ident1']) ? trim($_POST['ident1']) : '';
$pwd   = isset($_POST['pwd1'])   ? trim($_POST['pwd1'])   : '';

if ($ident === 'Carolina' && $pwd === 'jabamiah') {
    header('Location: result1.htm');
    exit;
}

header('Content-Type: text/html; charset=utf-8');
$err = __DIR__ . '/check1_erreur.html';
if (file_exists($err)) {
    readfile($err);
} else {
    echo '<html><head><meta charset="utf-8"></head><body bgcolor="white">';
    echo '<p><b>ERREUR !</b><br>Cet identifiant et ce mot de passe ne correspondent ';
    echo 'a aucun des membres inscrits dans notre base de donnees.</p>';
    echo '<p><a href="index.htm">Retour</a></p></body></html>';
}
