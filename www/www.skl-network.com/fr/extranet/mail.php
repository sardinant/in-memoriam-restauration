<?php
// mail.php - extranet SKL Network
// Sert les pages statiques mail__id_N.php recuperees depuis l'archive.
// A placer dans www.skl-network.com/fr/extranet/

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

if ($id < 1 || $id > 25) { $id = 1; }

$fichier = __DIR__ . "/mail__id_{$id}.php";

if (!file_exists($fichier)) {
    header('Content-Type: text/html; charset=iso-8859-1');
    echo "<html><body bgcolor=\"#FFFFFF\">";
    echo "<p style=\"font-family:Arial;font-size:9pt\">Message indisponible.</p>";
    echo "</body></html>";
    exit;
}

// les pages d'origine sont en ISO-8859-1 sans balise charset
header('Content-Type: text/html; charset=iso-8859-1');
readfile($fichier);
