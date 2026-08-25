<?php
/**
 * inserer.php — enregistrement d'un sujet du bloc-notes
 *
 * Recoit le formulaire de 3bloc.php : MyId, type, sujet_bloc, texte_bloc.
 */

require_once __DIR__ . '/bloc_lib.php';
bloc_exiger_session();

$id    = isset($_POST['MyId'])       ? (int) $_POST['MyId'] : 0;
$type  = isset($_POST['type'])       ? $_POST['type']       : '';
$sujet = isset($_POST['sujet_bloc']) ? trim($_POST['sujet_bloc']) : '';
$texte = isset($_POST['texte_bloc']) ? trim($_POST['texte_bloc']) : '';

// le formulaire d'origine limite le sujet a 150 caracteres
if (function_exists('mb_substr')) {
    $sujet = mb_substr($sujet, 0, 150, 'ISO-8859-1');
} else {
    $sujet = substr($sujet, 0, 150);
}

if ($sujet === '' && $texte === '') {
    header('Content-Type: text/html; charset=iso-8859-1');
    echo '<script language="javascript">window.location.href="affichage.php"</script>';
    exit;
}

$notes = bloc_charger();

if (stripos($type, 'Modifi') === 0 && $id > 0) {
    foreach ($notes as $i => $n) {
        if ((int) $n['id'] === $id) {
            $notes[$i]['sujet'] = $sujet;
            $notes[$i]['texte'] = $texte;
            $notes[$i]['date']  = date('Y-m-d');
            break;
        }
    }
} else {
    $notes[] = array(
        'id'    => bloc_nouvel_id($notes),
        'date'  => date('Y-m-d'),
        'sujet' => $sujet,
        'texte' => $texte,
    );
}

bloc_enregistrer($notes);

header('Content-Type: text/html; charset=iso-8859-1');
?>
<script language="javascript">window.location.href="affichage.php"</script>
