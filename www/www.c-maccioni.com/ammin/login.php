<?php
$login = isset($_REQUEST['login']) ? strtolower(trim($_REQUEST['login'])) : '';
$passe = isset($_REQUEST['passe']) ? strtolower(trim($_REQUEST['passe'])) : '';

if ($login === 'f.maggioli' && $passe === 'nonnafina') {
    header('Location: mail_1.html');
    exit;
} else {
    header('Location: pasok.html');
    exit;
}
?>