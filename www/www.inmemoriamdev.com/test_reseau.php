<?php
/**
 * Diagnostic reseau - moteur de recherche In Memoriam
 * A ouvrir : http://www.inmemoriamdev.com/test_reseau.php
 */
header('Content-Type: text/html; charset=utf-8');

function essai($nom, $url, $entetes = array()) {
    echo "<h3>$nom</h3><pre>";
    echo "URL : " . htmlspecialchars($url) . "\n";

    if (!function_exists('curl_init')) {
        echo "curl absent, essai via file_get_contents\n";
        $opts = array('http' => array('timeout' => 8));
        if ($entetes) $opts['http']['header'] = implode("\r\n", $entetes);
        $r = @file_get_contents($url, false, stream_context_create($opts));
        if ($r === false) {
            $e = error_get_last();
            echo "ECHEC : " . htmlspecialchars($e['message']) . "\n";
        } else {
            echo "OK, " . strlen($r) . " octets\n";
            echo htmlspecialchars(substr($r, 0, 400)) . "\n";
        }
        echo "</pre>"; return;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'InMemoriam-Restauration/1.0');
    if ($entetes) curl_setopt($ch, CURLOPT_HTTPHEADER, $entetes);

    $r    = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    $errn = curl_errno($ch);
    curl_close($ch);

    echo "Code HTTP : $code\n";
    if ($errn) echo "Erreur curl $errn : " . htmlspecialchars($err) . "\n";
    if ($r !== false && $r !== '') {
        echo "Recu : " . strlen($r) . " octets\n\n";
        echo htmlspecialchars(substr($r, 0, 600)) . "\n";
    } else {
        echo "Aucun contenu.\n";
    }
    echo "</pre>";
}
?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="utf-8"><title>Diagnostic reseau</title>
<style>
body{font-family:Consolas,monospace;font-size:12px;background:#111;color:#ddd;padding:25px;}
h2{color:#c9a227;font-weight:normal;letter-spacing:2px;}
h3{color:#7ac07a;font-weight:normal;margin-top:25px;}
pre{background:#1a1a1a;padding:12px;border-left:2px solid #333;overflow-x:auto;white-space:pre-wrap;}
td{padding:2px 20px 2px 0;}
</style></head><body>

<h2>DIAGNOSTIC RESEAU</h2>

<table>
<tr><td>PHP</td><td><?php echo PHP_VERSION; ?></td></tr>
<tr><td>curl</td><td><?php
    if (function_exists('curl_version')) {
        $v = curl_version();
        echo $v['version'] . ' / ' . $v['ssl_version'];
    } else echo 'ABSENT';
?></td></tr>
<tr><td>openssl</td><td><?php echo extension_loaded('openssl') ? OPENSSL_VERSION_TEXT : 'ABSENT'; ?></td></tr>
<tr><td>allow_url_fopen</td><td><?php echo ini_get('allow_url_fopen') ? 'oui' : 'non'; ?></td></tr>
</table>

<?php
essai('1. HTTP simple (sans TLS)', 'http://example.com/');
essai('2. HTTPS basique', 'https://fr.wikipedia.org/w/api.php?action=query&list=search&srsearch=jack&format=json');
essai('3. Marginalia, cle publique', 'https://api2.marginalia-search.com/search?query=jack&count=5', array('API-Key: public'));
essai('4. Marginalia, ancienne API', 'https://api.marginalia.nu/public/search/jack?count=5');
?>

<h3>Lecture</h3>
<pre>
Le test 1 echoue        -> aucune connexion sortante, ou pare-feu.
1 passe, 2 echoue       -> probleme TLS : OpenSSL trop ancien pour les
                           serveurs actuels. C'est le cas frequent avec
                           la pile PHP 7.0.3 livree par UwAmp.
2 passe, 3 echoue en 429 ou 503
                        -> la cle publique est saturee. Demander une cle
                           gratuite a contact@marginalia-search.com
3 echoue mais 4 passe   -> utiliser l'ancienne API, qui reste maintenue.
Tout passe              -> le probleme est ailleurs, dans search.php.
</pre>

</body></html>
