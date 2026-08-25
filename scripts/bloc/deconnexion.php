<?php
/**
 * deconnexion.php — ferme la session du bloc-notes.
 * L'original ne faisait que rediriger ; on ferme aussi la session.
 */
if (session_id() === '') session_start();
$_SESSION = array();
@session_destroy();
header('Content-Type: text/html; charset=iso-8859-1');
?>
<script language="javascript">window.top.location.href="../index.html"</script>
