<?php
/**
 * bloc_lib.php — socle commun du bloc-notes SKL Network
 *
 * Les scripts serveur d'origine (identifier.php, inserer.php, bloc.php,
 * 3bloc.php) vivaient chez Lexis et n'ont jamais ete archives : la
 * Wayback Machine n'a capture que des pages d'erreur PHP figees, avec
 * les chemins /home/sites_web/ du serveur de l'epoque.
 *
 * Cette reimplementation reprend les memes URL, les memes noms de champs
 * et le meme gabarit HTML que les pages archivees. Les notes sont
 * stockees dans un simple fichier JSON a cote des scripts.
 */

if (session_id() === '') session_start();

define('BLOC_FICHIER', __DIR__ . '/bloc_notes.json');

/** Le joueur est-il connecte ? */
function bloc_connecte()
{
    return !empty($_SESSION['bloc_ouvert']);
}

/** Renvoie vers la page de connexion si la session n'est pas ouverte. */
function bloc_exiger_session()
{
    if (bloc_connecte()) return;
    header('Content-Type: text/html; charset=iso-8859-1');
    echo '<script language="javascript">window.top.location.href="../3bloc_index.php"</script>';
    exit;
}

/** Charge les notes. Au premier appel, restaure celles d'origine. */
function bloc_charger()
{
    if (!is_file(BLOC_FICHIER)) {
        $depart = __DIR__ . '/bloc_notes_defaut.json';
        if (is_file($depart)) {
            @copy($depart, BLOC_FICHIER);
        } else {
            return array();
        }
    }
    $brut = @file_get_contents(BLOC_FICHIER);
    if ($brut === false) return array();
    $n = json_decode($brut, true);
    return is_array($n) ? $n : array();
}

/** Enregistre les notes. */
function bloc_enregistrer($notes)
{
    // les plus recentes en tete, comme sur la page d'origine
    usort($notes, 'bloc_comparer');
    $json = json_encode($notes);
    return @file_put_contents(BLOC_FICHIER, $json) !== false;
}

function bloc_comparer($a, $b)
{
    if ($a['date'] === $b['date']) return $b['id'] - $a['id'];
    return strcmp($b['date'], $a['date']);
}

/** Retrouve une note par son identifiant. */
function bloc_trouver($notes, $id)
{
    foreach ($notes as $n) {
        if ((int) $n['id'] === (int) $id) return $n;
    }
    return null;
}

/** Identifiant libre, dans la plage de ceux d'origine. */
function bloc_nouvel_id($notes)
{
    $max = 28000;
    foreach ($notes as $n) {
        if ((int) $n['id'] > $max) $max = (int) $n['id'];
    }
    return $max + 1;
}

/** Charge un gabarit HTML extrait des pages archivees. */
function bloc_gabarit($nom)
{
    $f = __DIR__ . '/' . $nom;
    return is_file($f) ? file_get_contents($f) : '';
}

/**
 * Les pages du site sont en ISO-8859-1. Les donnees saisies arrivent
 * dans cet encodage et y sont conservees, pour rester coherent avec le
 * gabarit d'origine.
 */
function bloc_echapper($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'ISO-8859-1');
}
