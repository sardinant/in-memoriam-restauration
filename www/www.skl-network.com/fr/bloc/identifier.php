<?php
/**
 * identifier.php — ouverture de session du bloc-notes
 *
 * L'original verifiait le couple identifiant / mot de passe contre la
 * base de SKL Network. Ces comptes n'existent plus et n'ont jamais ete
 * archives : toute saisie est donc acceptee.
 */

require_once __DIR__ . '/bloc_lib.php';

$_SESSION['bloc_ouvert'] = true;

$login = '';
foreach (array('login', 'identifiant', 'user', 'pseudo') as $k) {
    if (isset($_POST[$k]) && $_POST[$k] !== '') { $login = $_POST[$k]; break; }
    if (isset($_GET[$k])  && $_GET[$k]  !== '') { $login = $_GET[$k];  break; }
}
$_SESSION['bloc_login'] = $login;

header('Content-Type: text/html; charset=iso-8859-1');
?>
<script language="javascript">window.location.href="affichage.php"</script>
