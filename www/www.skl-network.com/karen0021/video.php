<?php
// video.php - selecteur de format video (RealPlayer / QuickTime)
// A placer dans www.skl-network.com/karen0021/
//
// Sert les pages statiques recuperees depuis l'Internet Archive :
//   video__type_real.php  -> lecteur RealPlayer, appelle karen.rpm
//   video__type_qt.php    -> lecteur QuickTime,  appelle karen.mov
//
// NOTE : karen.rm et karen.mov n'ont jamais ete archives. Les lecteurs
// s'affichent mais la video est absente. Voir MANQUANTS.md

$type = isset($_GET['type']) ? strtolower(trim($_GET['type'])) : '';

if ($type === 'qt' || $type === 'real') {
    $fichier = __DIR__ . "/video__type_{$type}.php";
} else {
    $fichier = __DIR__ . "/video_.php";
}

header('Content-Type: text/html; charset=iso-8859-1');

if (file_exists($fichier)) {
    readfile($fichier);
} else {
    echo '<html><body bgcolor="#999999"></body></html>';
}
