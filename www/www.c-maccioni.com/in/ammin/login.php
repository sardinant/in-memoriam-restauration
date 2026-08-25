<?php
$login = strtolower(trim($_REQUEST['login'] ?? ''));
$passe = trim($_REQUEST['passe'] ?? '');

if ($login === 'f.maggioli' && $passe === 'Nonnafina') {
    header('Location: mail_1.html');
    exit;
} else {
    header('Location: pasok.html');
    exit;
}
?>
