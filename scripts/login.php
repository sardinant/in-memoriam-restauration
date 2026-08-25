<?php
/**
 * login.php — validation de l'enigme "What is her city?" (0016/jeu3)
 *
 * L'original vivait sur le serveur de Lexis et n'a jamais ete archive :
 * la Wayback Machine n'a capture que le cas d'echec, un simple renvoi
 * vers jeu3_error.html. D'ou une reponse juste refusee systematiquement.
 *
 * Ce script retablit la comparaison. Il conserve le mecanisme d'origine
 * (window.top.location.href) plutot qu'une redirection HTTP, car la page
 * est appelee depuis une fenetre ouverte par script.
 */

// --- reglages ------------------------------------------------------------
// Reponses acceptees, en minuscules et sans accents.
$REPONSES = array('amsterdam');

// Page servie en cas de reussite. A ajuster si l'enchainement differe.
$SUCCES = 'jeu4.html';

// Page servie en cas d'echec — celle que l'original renvoyait toujours.
$ECHEC  = 'jeu3_error.html';
// -------------------------------------------------------------------------

$saisie = isset($_GET['login']) ? $_GET['login'] : '';

// normalisation : minuscules, accents retires, espaces et ponctuation ecartes
$n = $saisie;
if (function_exists('iconv')) {
    $conv = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $n);
    if ($conv !== false && $conv !== '') $n = $conv;
}
$n = strtolower($n);
$n = preg_replace('/[^a-z0-9]/', '', $n);

$ok = in_array($n, $REPONSES, true);

$cible = $ok ? $SUCCES : $ECHEC;

header('Content-Type: text/html; charset=iso-8859-1');
?>
<script language="javascript">window.top.location.href="<?php echo $cible; ?>"</script>
