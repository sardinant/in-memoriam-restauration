<?php
/**
 * bloc.php — affichage d'un sujet dans la fenetre secondaire
 *
 * Appele depuis affichage.php par MM_openBrWindow('bloc.php?MyId=N').
 */

require_once __DIR__ . '/bloc_lib.php';
bloc_exiger_session();

$id = isset($_GET['MyId']) ? (int) $_GET['MyId'] : 0;
$n  = bloc_trouver(bloc_charger(), $id);

header('Content-Type: text/html; charset=iso-8859-1');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SKL Network - Bloc-notes</title>
<style>
body  { background:#FFFFFF; margin:12px; }
.t    { font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#333333; }
.s    { font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#DE182C; font-weight:bold; }
.d    { font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#999999; }
.c    { font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;
        white-space:pre-wrap; word-wrap:break-word; }
hr    { border:0; border-top:1px solid #CCCCCC; }
a     { color:#666666; font-size:10px; font-family:Arial, Helvetica, sans-serif; }
</style>
</head>
<body>
<?php if ($n === null): ?>
  <p class="t">Sujet introuvable.</p>
<?php else: ?>
  <div class="s"><?php echo bloc_echapper($n['sujet']); ?></div>
  <div class="d"><?php echo bloc_echapper($n['date']); ?></div>
  <hr>
  <div class="c"><?php echo nl2br(bloc_echapper($n['texte'])); ?></div>
<?php endif; ?>
<hr>
<a href="#" onClick="window.close();return false;">Fermer</a>
</body>
</html>
