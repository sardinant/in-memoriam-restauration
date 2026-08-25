<?php
// index.php - authentification de l'extranet SKL Network
// A placer dans www.skl-network.com/fr/extranet/
//
// Identifiants d'origine, attestes sur le forum de la Confrerie Anti-Phoenix
// (message du 4 decembre 2003) : login j.lorski / mot de passe atlantic.
// L'indice etait la voiture de Jack, une Atlantic.

$login = isset($_POST['login']) ? strtolower(trim($_POST['login'])) : '';
$passe = isset($_POST['passe']) ? strtolower(trim($_POST['passe'])) : '';

if ($login === 'j.lorski' && $passe === 'atlantic') {
    header('Location: mail.php?id=1');
    exit;
}

// echec : page d'origine recuperee depuis l'Internet Archive
header('Content-Type: text/html; charset=iso-8859-1');
echo '<script>alert("Veuillez entrer votre bon login. Merci.")</script>';
echo '<script language="javascript">window.top.location.href="../index.html"</script>';
