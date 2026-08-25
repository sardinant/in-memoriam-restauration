<?php
/**
 * Moteur de Recherche Hybride In Memoriam - Version 2006-2008 Multi-Skins
 * 
 * Themes disponibles : MSN Search 2006, Google 2006, Lycos 2006
 */

header('Content-Type: text/html; charset=utf-8');

$sites_im1 = array(
    array("site" => "www.benatky-castle.net", "title" => "Benatky Castle 1599", "keywords" => array("benatky", "castle", "tycho", "brahe", "1599"), "desc" => "Official historical archive and documentation regarding Benatky Castle.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/8/8d/Benatky_nad_Jizerou_zámek.jpg/240px-Benatky_nad_Jizerou_zámek.jpg"),
    array("site" => "www.bruno-giordano.net", "title" => "Giordano Bruno - Nolain 1548-1600", "keywords" => array("bruno", "giordano", "nolain", "hermetisme", "philosophie"), "desc" => "Vie et œuvres de Giordano Bruno, philosophe et hermétiste du XVIe siècle.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/7/70/Giordano_Bruno.jpg/200px-Giordano_Bruno.jpg"),
    array("site" => "www.c-maccioni.com", "title" => "Cementificio Maccioni", "keywords" => array("maccioni", "cementificio", "ciment", "industrie", "baldo"), "desc" => "Site officiel des cimenteries Maccioni - Produits et contacts.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Industrial_factory_building.jpg/240px-Industrial_factory_building.jpg"),
    array("site" => "www.cathedrale-paris.net", "title" => "Notre Dame de Paris", "keywords" => array("cathedrale", "paris", "notre", "dame", "gothique"), "desc" => "Études architecturales et histoire de la Cathédrale Notre-Dame de Paris.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/a/af/Notre-Dame_de_Paris_2013-07-24.jpg/220px-Notre-Dame_de_Paris_2013-07-24.jpg"),
    array("site" => "www.demagia.net", "title" => "The Astral Magic of the Renaissance", "keywords" => array("demagia", "magic", "astral", "renaissance", "ficino"), "desc" => "A comprehensive study on Renaissance astral magic, talismans and occult philosophy.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Ficino_Marsilio_1532.jpg/200px-Ficino_Marsilio_1532.jpg"),
    array("site" => "www.fe256.net", "title" => "Fe256.net Security System", "keywords" => array("fe256", "crypto", "encryption", "hash", "security"), "desc" => "Technical specifications for FE256 cryptographic systems.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Lock-green.svg/200px-Lock-green.svg.png"),
    array("site" => "www.hagel-gallery.com", "title" => "Hagel Gallery", "keywords" => array("hagel", "gallery", "art", "exposition", "peinture"), "desc" => "Contemporary and classical art exhibitions at Hagel Gallery.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Mona_Lisa%2C_by_Leonardo_da_Vinci%2C_from_C2RMF_retouched.jpg/200px-Mona_Lisa.jpg"),
    array("site" => "www.helenawhitford.net", "title" => "Helena Whitford Foundation", "keywords" => array("helena", "whitford", "foundation", "art", "mécénat"), "desc" => "Personal page and art foundation of Helena Whitford.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Lady_portrait_1900.jpg/200px-Lady_portrait_1900.jpg"),
    array("site" => "www.hermeticum.info", "title" => "Hermeticum.info", "keywords" => array("hermeticum", "hermes", "trismegiste", "alchimie", "occulte"), "desc" => "Ressources et textes sacrés de la tradition hermétique.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/HermesTrismegistusFloorMosaicSienaS Cathedral.jpg/220px-HermesTrismegistus.jpg"),
    array("site" => "www.hotel-mocenigo.com", "title" => "Hotel Mocenigo Venise", "keywords" => array("hotel", "mocenigo", "venise", "venezia", "palazzo"), "desc" => "Palazzo Mocenigo à Venise - Réservations et histoire du bâtiment.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Palazzo_Mocenigo_Venice.jpg/240px-Palazzo_Mocenigo_Venice.jpg"),
    array("site" => "www.ikl-network.com", "title" => "IKL Network", "keywords" => array("ikl", "network", "telecom", "reseau", "data"), "desc" => "International Knowledge Network solutions and infrastructure.", "img" => ""),
    array("site" => "www.inkdesign77.com", "title" => "Ink Design 77", "keywords" => array("inkdesign77", "design", "graphisme", "studio", "web"), "desc" => "Studio de création graphique et design visuel.", "img" => ""),
    array("site" => "www.irbca.com", "title" => "IRBCA - International Rare Books Collectors Association", "keywords" => array("irbca", "books", "rare", "collectors", "manuscrits"), "desc" => "International association dedicated to ancient and rare manuscript collectors.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/Old_book_bindings.jpg/240px-Old_book_bindings.jpg"),
    array("site" => "www.italia-libero.com", "title" => "Italia Libero", "keywords" => array("italia", "libero", "presse", "actualite", "italie"), "desc" => "Portail d'informations et actualités italiennes.", "img" => ""),
    array("site" => "www.jim-leroy.net", "title" => "Les enquêtes de la Vérité - Jim Leroy", "keywords" => array("jim", "leroy", "enquetes", "journalisme", "revelations"), "desc" => "Articles et dossiers d'investigation indépendants par Jim Leroy.", "img" => ""),
    array("site" => "www.karen-gijman.com", "title" => "Karen Gijman Portfolio", "keywords" => array("karen", "gijman", "photographie", "portfolio", "art"), "desc" => "Travaux photographiques et expositions de Karen Gijman.", "img" => ""),
    array("site" => "www.kilic-library.com", "title" => "Kilic Library - Kasim Sari Collection", "keywords" => array("kilic", "library", "kasim", "sari", "livres"), "desc" => "The private book collection and oriental studies of Kasim Sari.", "img" => ""),
    array("site" => "www.memo-geo.com", "title" => "Memo-Geo : Latitudes & Longitudes", "keywords" => array("memo-geo", "latitudes", "longitudes", "villes", "europe"), "desc" => "Base de données géographiques des coordonnées des grandes villes d'Europe.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c4/Globe_icon.svg/200px-Globe_icon.svg.png"),
    array("site" => "www.messini-yc.com", "title" => "Messini Yacht Club - Felice Maggioli", "keywords" => array("messini", "yacht", "club", "felice", "maggioli"), "desc" => "Club nautique privé et actualités de la haute société méditerranéenne.", "img" => ""),
    array("site" => "www.mysterious-world.net", "title" => "Mysterious World - Portail de l'insolite", "keywords" => array("mysterious", "world", "insolite", "paranormal", "enigmes"), "desc" => "Recherches et témoignages sur les phénomènes inexpliqués et le mystère.", "img" => ""),
    array("site" => "www.nag-hammadi.com", "title" => "The Nag Hammadi Library Archives", "keywords" => array("nag", "hammadi", "gnostique", "evangiles", "manuscrits"), "desc" => "Translations and historical analysis of the Nag Hammadi gnostic codices.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/2/22/Nag_Hammadi_codex_II.jpg/220px-Nag_Hammadi_codex_II.jpg"),
    array("site" => "www.oespg.com", "title" => "OESPG - Ordre des Éclaireurs de Saint Paul", "keywords" => array("oespg", "ordre", "eclaireurs", "saint", "paul"), "desc" => "Site d'information de l'Ordre de Saint Paul de la Grotte.", "img" => ""),
    array("site" => "www.oxstud.com", "title" => "Oxford Research Studies", "keywords" => array("oxstud", "oxford", "studies", "recherche", "academique"), "desc" => "Academic papers and historical research archives.", "img" => ""),
    array("site" => "www.persofrance.com", "title" => "PersoFrance - Annuaires de pages perso", "keywords" => array("persofrance", "annuaire", "pages", "perso", "france"), "desc" => "Annuaires des sites et pages personnelles francophones.", "img" => ""),
    array("site" => "www.rhodestravel.com", "title" => "Rhodes Travel - Voyages & Histoire", "keywords" => array("rhodestravel", "rhodes", "voyage", "epicharmou", "grece"), "desc" => "Guide touristique et culturel de l'île de Rhodes.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Rhodes_Harbour.jpg/240px-Rhodes_Harbour.jpg"),
    array("site" => "www.sabelli.net", "title" => "Sabelli Archives", "keywords" => array("sabelli", "famille", "archives", "genealogie"), "desc" => "Archives familiales et histoire de la maison Sabelli.", "img" => ""),
    array("site" => "www.sainte-inquisition.net", "title" => "L'Inquisition en France", "keywords" => array("inquisition", "sainte", "tribunal", "histoire", "moyen-age"), "desc" => "Histoire documentaire des tribunaux de la Sainte-Inquisition en France.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/Inquisition_scene.jpg/220px-Inquisition_scene.jpg"),
    array("site" => "www.skl-network.com", "title" => "SKL Network - Lorski & Gijman", "keywords" => array("skl", "network", "lorski", "jack", "gijman"), "desc" => "Agence de journalisme d'investigation SKL Network.", "img" => ""),
    array("site" => "www.tychobrahe.net", "title" => "Tycho Brahé (1546-1601)", "keywords" => array("tychobrahe", "tycho", "brahe", "astronomie", "knudstorp"), "desc" => "Observatoire et biographie de l'astronome danois Tycho Brahé.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/2/2b/Tycho_Brahe.jpg/200px-Tycho_Brahe.jpg"),
    array("site" => "www.volker-institut.com", "title" => "Volker Institut", "keywords" => array("volker", "institut", "recherche", "medecine", "psychologie"), "desc" => "Travaux et études comportementales de l'Institut Volker.", "img" => ""),
    array("site" => "www.xineph.com", "title" => "Xineph.com", "keywords" => array("xineph", "reseau", "serveur", "terminal"), "desc" => "Serveur privé et nœud de réseau Xineph.", "img" => ""),
    array("site" => "enfieldsc.net", "title" => "Enfield Shooting Club", "keywords" => array("enfield", "shooting", "club", "tir", "armes"), "desc" => "Official website of the Enfield Target Shooting Club.", "img" => ""),
    array("site" => "www.salemwitchmystery.com", "title" => "Salem Witch Mystery", "keywords" => array("salem", "witch", "mystery", "sorcieres", "procès"), "desc" => "Historical investigation into the 1692 Salem witch trials.", "img" => "https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Salem_Witch_craft_trial.jpg/240px-Salem_Witch_craft_trial.jpg"),
    array("site" => "www.phoenix-killer.info", "title" => "Phoenix-killer.info | Appel à témoins", "keywords" => array("phoenix", "killer", "lorski", "tueur", "disparition"), "desc" => "Appel à témoins et dossier public concernant les disparitions liées au tueur du Phénix.", "img" => "")
);

function http_request_fast($url, $timeout = 3) {
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:2.0) Gecko/20100101 Firefox/4.0");
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    } else {
        $ctx = stream_context_create(array('http' => array('timeout' => $timeout)));
        return @file_get_contents($url, false, $ctx);
    }
}

function fetch_wikipedia_noise($query, $limit = 3) {
    $url = "https://fr.wikipedia.org/w/api.php?action=query&list=search&srsearch=" . urlencode($query) . "&format=json&utf8=1&srlimit=" . intval($limit + 5);
    $json = http_request_fast($url, 3);
    $results = array();

    if ($json) {
        $data = json_decode($json, true);
        if (isset($data['query']['search'])) {
            foreach ($data['query']['search'] as $item) {
                if (count($results) >= $limit) break;
                
                $clean_snippet = strip_tags($item['snippet']);
                $clean_snippet = html_entity_decode($clean_snippet, ENT_QUOTES, 'UTF-8');
                $title = strip_tags($item['title']);

                $title_lower = strtolower($title);
                $snippet_lower = strtolower($clean_snippet);

                $spoilers = array('in memoriam', 'dernier rituel', 'lexis numérique', 'eric viennot', 'éric viennot', 'jeu vidéo', 'jeu video', 'alternate reality');
                $is_spoiler = false;
                foreach ($spoilers as $sp) {
                    if (strpos($title_lower, $sp) !== false || strpos($snippet_lower, $sp) !== false) {
                        $is_spoiler = true;
                        break;
                    }
                }
                if ($is_spoiler) continue;

                $results[] = array(
                    'site' => 'fr.wikipedia.org',
                    'title' => $title,
                    'url' => 'https://fr.wikipedia.org/wiki/' . urlencode(str_replace(' ', '_', $title)),
                    'desc' => $clean_snippet . '...',
                    'type' => 'text'
                );
            }
        }
    }
    return $results;
}

function fetch_oocities_noise($query, $limit = 6) {
    $url = "https://www.oocities.org/search?q=" . urlencode($query);
    $html = http_request_fast($url, 3);
    $results = array();

    if ($html) {
        preg_match_all('/<a[^>]*href="(\/geocities\/[^"]+|http[^"]+)"[^>]*>(.*?)<\/a>/is', $html, $matches, PREG_SET_ORDER);
        $count = 0;
        foreach ($matches as $m) {
            if ($count >= $limit) break;
            $link = (strpos($m[1], 'http') === 0) ? $m[1] : "https://www.oocities.org" . $m[1];
            $raw_title = strip_tags($m[2]);
            $title = trim(html_entity_decode($raw_title, ENT_QUOTES, 'UTF-8'));
            
            $link_lower = strtolower($link);
            $title_lower = strtolower($title);

            if (mb_strlen($title) <= 3 || 
                strpos($link_lower, '/search') !== false ||
                strpos($link_lower, 'search?') !== false ||
                strpos($title_lower, 'oocities') !== false || 
                strpos($title_lower, 'privacy') !== false ||
                strpos($title_lower, 'search') !== false ||
                strpos($title_lower, 'here') !== false ||
                strpos($title_lower, 'click') !== false ||
                $title_lower === 'here' ||
                $title_lower === 'link') {
                continue;
            }

            $results[] = array(
                'site' => 'www.oocities.org',
                'title' => 'GeoCities Archive - ' . $title,
                'url' => $link,
                'desc' => 'Page personnelle archivée de l\'époque GeoCities (1998-2005) associée aux mots-clés recherchés.',
                'type' => 'text'
            );
            $count++;
        }
    }
    return $results;
}

function fetch_wiby_noise($query, $limit = 4) {
    $url = "https://wiby.me/?q=" . urlencode($query);
    $html = http_request_fast($url, 3);
    $results = array();

    if ($html) {
        preg_match_all('/<a[^>]*href="([^"]+)"[^>]*>(.*?)<\/a>/is', $html, $matches, PREG_SET_ORDER);
        $count = 0;
        foreach ($matches as $m) {
            if ($count >= $limit) break;
            $link = trim($m[1]);
            $title = trim(strip_tags($m[2]));
            $title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');

            if (strpos($link, 'http') === 0 && mb_strlen($title) > 3 && strpos($link, 'wiby.me') === false) {
                $host = parse_url($link, PHP_URL_HOST);
                if (empty($host) || strpos($host, 'wiby') !== false) continue;

                $results[] = array(
                    'site' => $host,
                    'title' => $title,
                    'url' => $link,
                    'desc' => 'Page web rétro indexée sur la recherche textuelle Wiby.',
                    'type' => 'text'
                );
                $count++;
            }
        }
    }
    return $results;
}

function fetch_image_noise($query, $limit = 8) {
    $url = "https://fr.wikipedia.org/w/api.php?action=query&generator=search&gsrsearch=" . urlencode($query) . "&prop=pageimages|extracts&pithumbsize=250&format=json&utf8=1&gsrlimit=" . intval($limit + 5);
    $json = http_request_fast($url, 3);
    $results = array();

    if ($json) {
        $data = json_decode($json, true);
        if (isset($data['query']['pages'])) {
            foreach ($data['query']['pages'] as $page) {
                if (count($results) >= $limit) break;
                if (isset($page['thumbnail']['source'])) {
                    $title_lower = strtolower($page['title']);
                    if (strpos($title_lower, 'in memoriam') !== false || strpos($title_lower, 'lexis') !== false) {
                        continue;
                    }
                    $results[] = array(
                        'title' => $page['title'],
                        'img_url' => $page['thumbnail']['source'],
                        'width' => $page['thumbnail']['width'],
                        'height' => $page['thumbnail']['height'],
                        'site' => 'fr.wikipedia.org',
                        'page_url' => 'https://fr.wikipedia.org/wiki/' . urlencode(str_replace(' ', '_', $page['title']))
                    );
                }
            }
        }
    }
    return $results;
}

function fetch_balanced_noise($query, $limit = 12) {
    $oocities = fetch_oocities_noise($query, 6);
    $wiby = fetch_wiby_noise($query, 4);
    $wiki = fetch_wikipedia_noise($query, 2);

    $combined = array();
    while (!empty($oocities) || !empty($wiby) || !empty($wiki)) {
        if (!empty($oocities)) $combined[] = array_shift($oocities);
        if (!empty($wiby)) $combined[] = array_shift($wiby);
        if (!empty($wiki)) $combined[] = array_shift($wiki);
    }

    return array_slice($combined, 0, $limit);
}

// Params GET
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$engine = isset($_GET['engine']) ? $_GET['engine'] : 'msn';
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'web';
$disable_noise = isset($_GET['no_noise']) && $_GET['no_noise'] == '1';

$combined_results = array();
$image_results = array();

if ($q !== '') {
    $terms = array_values(array_filter(explode(' ', strtolower($q))));
    $term_count = count($terms);

    $game_matches = array();
    foreach ($sites_im1 as $item) {
        $matched_terms_count = 0;
        $title_lower = strtolower($item['title']);
        $desc_lower = strtolower($item['desc']);
        $site_lower = strtolower($item['site']);

        foreach ($terms as $term) {
            if (mb_strlen($term) < 2) continue;
            
            $found = false;
            if (strpos($site_lower, $term) !== false ||
                strpos($title_lower, $term) !== false ||
                strpos($desc_lower, $term) !== false) {
                $found = true;
            } else {
                foreach ($item['keywords'] as $kw) {
                    if (strpos(strtolower($kw), $term) !== false) {
                        $found = true;
                        break;
                    }
                }
            }

            if ($found) {
                $matched_terms_count++;
            }
        }

        if ($matched_terms_count > 0) {
            $item['matched_count'] = $matched_terms_count;
            $item['url'] = (strpos($item['site'], 'http') === 0) ? $item['site'] : 'http://' . $item['site'];
            $game_matches[] = $item;
        }
    }

    usort($game_matches, function($a, $b) {
        return $b['matched_count'] - $a['matched_count'];
    });

    if ($tab === 'images') {
        foreach ($game_matches as $gm) {
            if (!empty($gm['img'])) {
                $image_results[] = array(
                    'title' => $gm['title'],
                    'img_url' => $gm['img'],
                    'width' => 240,
                    'height' => 180,
                    'site' => $gm['site'],
                    'page_url' => $gm['url']
                );
            }
        }
        $ext_images = fetch_image_noise($q, 12);
        $image_results = array_merge($image_results, $ext_images);
    } else {
        if ($disable_noise) {
            $combined_results = $game_matches;
        } else {
            $noise_results = fetch_balanced_noise($q, 12);

            if (!empty($game_matches)) {
                $top_game_site = $game_matches[0];
                $matched_count = $top_game_site['matched_count'];

                if ($matched_count >= 2 || $term_count >= 2) {
                    $target_position = rand(1, 2);
                    $final_list = $noise_results;
                    if (count($final_list) < $target_position) {
                        $final_list[] = $top_game_site;
                    } else {
                        array_splice($final_list, $target_position, 0, array($top_game_site));
                    }
                    for ($i = 1; $i < count($game_matches); $i++) {
                        $final_list[] = $game_matches[$i];
                    }
                    $combined_results = $final_list;
                } else {
                    $final_list = $noise_results;
                    $relegate_position = min(count($final_list), 7);
                    array_splice($final_list, $relegate_position, 0, array($top_game_site));
                    $combined_results = $final_list;
                }
            } else {
                $combined_results = $noise_results;
            }

            $image_preview_list = fetch_image_noise($q, 4);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $q !== '' ? htmlspecialchars($q) . ' - Recherche' : 'Recherche Web 2006'; ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; padding: 0; background-color: #ffffff; color: #000000; }
        a { text-decoration: underline; }
        form { margin: 0; padding: 0; }
        
        /* Barre supérieure commune */
        .top-bar { padding: 6px 15px; background: #222; color: #eee; font-size: 12px; display: flex; justify-content: space-between; align-items: center; }
        .top-bar a { color: #8dc63f; font-weight: bold; text-decoration: none; }
        .mode-toggle { font-size: 11px; font-family: Tahoma, sans-serif; background: #333; color: #fff; padding: 3px 8px; border-radius: 3px; border: 1px solid #555; }

        /* Styles génériques des résultats */
        .res-item { margin-bottom: 20px; line-height: 1.3; }
        .res-title { font-size: 16px; margin-bottom: 2px; display: block; font-weight: normal; color: #0000cc; }
        .res-snippet { font-size: 13px; color: #333333; margin-bottom: 3px; }
        .res-meta { font-size: 12px; }
        .res-url { color: #008000; }

        /* Bloc Aperçu Images 2006 */
        .img-preview-box { background: #f4f7fc; border: 1px solid #c2d7ed; padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .img-preview-title { font-weight: bold; font-size: 13px; color: #003399; margin-bottom: 8px; display: flex; justify-content: space-between; }
        .img-grid-inline { display: flex; gap: 12px; overflow-x: auto; }
        .img-card { text-align: center; font-size: 11px; width: 110px; }
        .img-card img { width: 100px; height: 75px; object-fit: cover; border: 1px solid #999; padding: 2px; background: #fff; }

        /* Grille Mode Images 2006 */
        .images-results-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 20px; padding: 10px 0; }
        .img-result-item { background: #fff; border: 1px solid #e0e0e0; padding: 8px; text-align: center; font-size: 11px; }
        .img-result-item img { max-width: 140px; max-height: 110px; border: 1px solid #ccc; display: block; margin: 0 auto 6px auto; }
        .img-result-dim { color: #666; font-size: 10px; margin-top: 2px; }

        /* ================= THEME MSN 2006 ================= */
        body.theme-msn { background-color: #1a62a5; }
        .theme-msn .msn-wrapper { width: 100%; max-width: 960px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 0 12px rgba(0,0,0,0.4); }
        .theme-msn .msn-top-bar { background-color: #5b94d6; color: white; font-size: 11px; padding: 4px 15px; display: flex; justify-content: space-between; font-family: Tahoma, sans-serif; }
        .theme-msn .msn-header { background-color: #005eb8; padding: 15px 20px; color: white; display: flex; align-items: flex-start; gap: 30px; }
        .theme-msn .msn-logo-area { font-size: 38px; font-weight: bold; font-style: italic; letter-spacing: -2px; line-height: 1; margin-top: -5px; }
        .theme-msn .msn-nav { font-size: 12px; font-weight: bold; margin-bottom: 8px; }
        .theme-msn .msn-nav a { color: white; text-decoration: none; margin-right: 15px; }
        .theme-msn .msn-nav a.active { text-decoration: underline; color: #8dc63f; }
        .theme-msn .msn-search-form { display: flex; gap: 5px; align-items: center; margin: 0; }
        .theme-msn .msn-search-input { width: 420px; padding: 3px 5px; border: 1px solid #7f9db9; font-size: 14px; }
        .theme-msn .msn-search-btn { background: #8dc63f; border: 1px solid #5a8a1b; color: white; font-weight: bold; padding: 2px 15px; font-size: 12px; cursor: pointer; }
        .theme-msn .msn-welcome-bar { background-color: #e3effa; border-bottom: 1px solid #c2d7ed; padding: 5px 20px; font-size: 11px; font-weight: bold; color: #003399; display: flex; justify-content: space-between; text-transform: uppercase; }
        .theme-msn .msn-welcome-bar a { color: #003399; text-decoration: none; }
        .theme-msn .stats-bar { background-color: #f0f4f9; padding: 6px 15px; border-bottom: 1px solid #d4d4d4; font-size: 12px; color: #333; text-align: left; }

        /* ================= THEME GOOGLE 2006 ================= */
        body.theme-google { background-color: #ffffff; font-family: Arial, sans-serif; }
        .google-header { padding: 12px 15px; border-bottom: 1px solid #e5ecf9; display: flex; align-items: center; gap: 20px; }
        .google-logo-text { font-family: 'Times New Roman', Georgia, serif; font-size: 32px; font-weight: bold; letter-spacing: -1px; text-decoration: none; }
        .google-logo-blue { color: #2200CC; }
        .google-logo-red { color: #DC3912; }
        .google-logo-yellow { color: #FF9900; }
        .google-logo-green { color: #109618; }
        .google-nav-tabs { background: #e5ecf9; padding: 4px 15px 0 15px; font-size: 13px; font-weight: bold; border-bottom: 1px solid #3366cc; }
        .google-nav-tabs a { color: #0000cc; text-decoration: none; padding: 4px 12px; display: inline-block; background: #f1f5fc; border: 1px solid #b2c9ed; border-bottom: none; margin-right: 4px; border-radius: 3px 3px 0 0; }
        .google-nav-tabs a.active { background: #ffffff; border-color: #3366cc; border-bottom: 1px solid #ffffff; color: #000000; margin-bottom: -1px; }
        .google-search-bar { padding: 10px 15px; background: #ffffff; display: flex; align-items: center; gap: 10px; }
        .google-input { width: 450px; padding: 4px; font-size: 14px; border: 1px solid #7f9db9; }
        .google-btn { padding: 3px 10px; font-size: 13px; cursor: pointer; }
        .google-stats-bar { background: #e5ecf9; padding: 4px 15px; font-size: 12px; color: #000; }

        /* ================= THEME LYCOS 2006 ================= */
        body.theme-lycos { background-color: #f7f7f7; font-family: Verdana, Arial, sans-serif; }
        .lycos-wrapper { max-width: 980px; margin: 0 auto; background: #ffffff; border: 1px solid #cccccc; }
        .lycos-black-bar { background: #111111; color: #ffffff; padding: 5px 15px; font-size: 11px; display: flex; justify-content: space-between; align-items: center; }
        .lycos-black-bar a { color: #ffffff; text-decoration: none; margin-left: 10px; }
        .lycos-header-box { padding: 15px; background: #f0f0f0; border-bottom: 1px solid #e0e0e0; display: flex; align-items: center; gap: 20px; }
        .lycos-logo-img { height: 50px; width: auto; object-fit: contain; }
        .lycos-tabs { font-size: 11px; font-weight: bold; margin-bottom: 6px; }
        .lycos-tabs a { color: #0033cc; text-decoration: none; margin-right: 12px; }
        .lycos-tabs a.active { color: #000000; text-decoration: underline; }
        .lycos-search-row { display: flex; align-items: center; gap: 8px; }
        .lycos-input { width: 440px; padding: 5px; font-size: 14px; border: 1px solid #888; border-radius: 2px; }
        
        /* Bouton "Va chercher !" style pilule 2006 */
        .lycos-btn {
            background: linear-gradient(to bottom, #5d92d8, #1b53a1);
            background-color: #2b61b5;
            color: #ffffff;
            font-weight: bold;
            font-size: 13px;
            padding: 5px 16px;
            border: 1px solid #0e3775;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
            text-shadow: 0 1px 1px rgba(0,0,0,0.5);
        }
        .lycos-btn:hover { background: #1b53a1; }
    </style>
</head>
<body class="theme-<?php echo htmlspecialchars($engine); ?>">

    <!-- Barre supérieure de contrôle -->
    <div class="top-bar">
        <div>
            <a href="index.php">← ACCÈS PORTAIL WEBMAIL</a>
        </div>

        <form method="GET" action="search.php" id="engineForm" style="display:flex; align-items:center; gap:15px;">
            <?php if($q !== ''): ?><input type="hidden" name="q" value="<?php echo htmlspecialchars($q); ?>"><?php endif; ?>
            <input type="hidden" name="tab" value="<?php echo htmlspecialchars($tab); ?>">
            
            <label class="mode-toggle">
                <input type="checkbox" name="no_noise" value="1" <?php if($disable_noise) echo 'checked'; ?> onchange="document.getElementById('engineForm').submit();">
                🎯 Désactiver le bruit (Jeu uniquement)
            </label>

            <div class="engine-selector">
                Moteur : 
                <select name="engine" onchange="document.getElementById('engineForm').submit();">
                    <option value="msn" <?php if($engine == 'msn') echo 'selected'; ?>>MSN Search 2006</option>
                    <option value="google" <?php if($engine == 'google') echo 'selected'; ?>>Google 2006</option>
                    <option value="lycos" <?php if($engine == 'lycos') echo 'selected'; ?>>Lycos 2006</option>
                </select>
            </div>
        </form>
    </div>

    <!-- ==================== SKIN 1 : MSN SEARCH 2006 ==================== -->
    <?php if ($engine == 'msn'): ?>
        <div style="text-align: left; padding: 20px 0;">
            <div class="msn-wrapper">
                <div class="msn-top-bar">
                    <div>Mardi 31 Octobre 2006</div>
                    <div><a href="#" style="color:white; text-decoration:none;">Télécharger Messenger 8.0</a></div>
                </div>
                
                <div class="msn-header">
                    <div class="msn-logo-area">
                        <a href="search.php?engine=msn" style="color:white;text-decoration:none;">msn<sup style="font-size:14px;color:#8dc63f;margin-left:2px;">&#x2713;</sup></a>
                    </div>
                    <div style="flex-grow:1;">
                        <div class="msn-nav">
                            <a href="search.php?q=<?php echo urlencode($q); ?>&engine=msn&tab=web<?php echo $disable_noise?'&no_noise=1':''; ?>" class="<?php echo $tab=='web'?'active':''; ?>">Web</a> 
                            <a href="search.php?q=<?php echo urlencode($q); ?>&engine=msn&tab=images<?php echo $disable_noise?'&no_noise=1':''; ?>" class="<?php echo $tab=='images'?'active':''; ?>">Images</a> 
                            <a href="#">News</a> <a href="#">Local</a>
                        </div>
                        <form class="msn-search-form" method="GET" action="search.php">
                            <input type="hidden" name="engine" value="msn">
                            <input type="hidden" name="tab" value="<?php echo htmlspecialchars($tab); ?>">
                            <?php if($disable_noise): ?><input type="hidden" name="no_noise" value="1"><?php endif; ?>
                            <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" class="msn-search-input" autofocus>
                            <input type="submit" value="Search Web" class="msn-search-btn">
                        </form>
                    </div>
                </div>

                <div class="msn-welcome-bar">
                    <span style="color:#666;">Bienvenue</span>
                    <a href="index.php">ACCÈS WEBMAIL</a>
                </div>

                <?php if ($q !== ''): ?>
                    <div class="stats-bar">
                        Résultats <b>1</b> - <b><?php echo $tab=='images'?count($image_results):count($combined_results); ?></b> pour <b><?php echo htmlspecialchars($q); ?></b>
                    </div>
                    
                    <div style="padding: 25px;">
                        <?php if ($tab === 'images'): ?>
                            <div class="images-results-grid">
                                <?php foreach ($image_results as $img_item): ?>
                                    <div class="img-result-item">
                                        <a href="<?php echo htmlspecialchars($img_item['page_url']); ?>" target="_blank">
                                            <img src="<?php echo htmlspecialchars($img_item['img_url']); ?>" alt="Img">
                                        </a>
                                        <a href="<?php echo htmlspecialchars($img_item['page_url']); ?>" style="color:#0000cc; font-weight:bold; text-decoration:none;" target="_blank">
                                            <?php echo htmlspecialchars(mb_strimwidth($img_item['title'], 0, 20, '...')); ?>
                                        </a>
                                        <div class="img-result-dim"><?php echo $img_item['width']; ?> x <?php echo $img_item['height']; ?> px</div>
                                        <div style="color:#008000; font-size:10px;"><?php echo htmlspecialchars($img_item['site']); ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <?php if (!empty($image_preview_list)): ?>
                                <div class="img-preview-box">
                                    <div class="img-preview-title">
                                        <span>📷 Aperçu d'images pour <i><?php echo htmlspecialchars($q); ?></i></span>
                                        <a href="search.php?q=<?php echo urlencode($q); ?>&engine=msn&tab=images<?php echo $disable_noise?'&no_noise=1':''; ?>" style="font-size:11px;">Voir plus d'images &raquo;</a>
                                    </div>
                                    <div class="img-grid-inline">
                                        <?php foreach ($image_preview_list as $prev_img): ?>
                                            <div class="img-card">
                                                <a href="<?php echo htmlspecialchars($prev_img['page_url']); ?>" target="_blank">
                                                    <img src="<?php echo htmlspecialchars($prev_img['img_url']); ?>" alt="Img">
                                                </a>
                                                <div style="color:#008000; font-size:10px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?php echo htmlspecialchars($prev_img['site']); ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php foreach ($combined_results as $item): ?>
                                <div class="res-item">
                                    <a href="<?php echo htmlspecialchars($item['url']); ?>" class="res-title" target="_blank"><?php echo htmlspecialchars($item['title']); ?></a>
                                    <div class="res-snippet"><?php echo htmlspecialchars($item['desc']); ?></div>
                                    <div class="res-meta">
                                        <span class="res-url"><?php echo htmlspecialchars($item['url']); ?></span>
                                        - <a href="#" style="color:#666; font-size:11px;" onclick="return false;">En cache</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    <!-- ==================== SKIN 2 : GOOGLE 2006 ==================== -->
    <?php elseif ($engine == 'google'): ?>
        <div style="text-align:left;">
            <div class="google-nav-tabs">
                <a href="search.php?q=<?php echo urlencode($q); ?>&engine=google&tab=web<?php echo $disable_noise?'&no_noise=1':''; ?>" class="<?php echo $tab=='web'?'active':''; ?>">Web</a>
                <a href="search.php?q=<?php echo urlencode($q); ?>&engine=google&tab=images<?php echo $disable_noise?'&no_noise=1':''; ?>" class="<?php echo $tab=='images'?'active':''; ?>">Images</a>
                <a href="#">Groupes</a>
                <a href="#">Actualités</a>
            </div>

            <form method="GET" action="search.php" class="google-search-bar">
                <input type="hidden" name="engine" value="google">
                <input type="hidden" name="tab" value="<?php echo htmlspecialchars($tab); ?>">
                <?php if($disable_noise): ?><input type="hidden" name="no_noise" value="1"><?php endif; ?>
                
                <a href="search.php?engine=google" class="google-logo-text">
                    <span class="google-logo-blue">G</span><span class="google-logo-red">o</span><span class="google-logo-yellow">o</span><span class="google-logo-blue">g</span><span class="google-logo-green">l</span><span class="google-logo-red">e</span>
                </a>
                <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" class="google-input" autofocus>
                <input type="submit" value="Recherche Google" class="google-btn">
            </form>

            <?php if ($q !== ''): ?>
                <div class="google-stats-bar">
                    Résultats <b>1</b> - <b><?php echo $tab=='images'?count($image_results):count($combined_results); ?></b> sur environ <b><?php echo count($combined_results)*42 + 12; ?></b> pour <b><?php echo htmlspecialchars($q); ?></b> (0,11 secondes)
                </div>

                <div style="padding: 20px 15px; max-width: 800px;">
                    <?php if ($tab === 'images'): ?>
                        <div class="images-results-grid">
                            <?php foreach ($image_results as $img_item): ?>
                                <div class="img-result-item">
                                    <a href="<?php echo htmlspecialchars($img_item['page_url']); ?>" target="_blank">
                                        <img src="<?php echo htmlspecialchars($img_item['img_url']); ?>" alt="Img">
                                    </a>
                                    <a href="<?php echo htmlspecialchars($img_item['page_url']); ?>" style="color:#0000cc; font-weight:bold; text-decoration:none;" target="_blank">
                                        <?php echo htmlspecialchars(mb_strimwidth($img_item['title'], 0, 20, '...')); ?>
                                    </a>
                                    <div class="img-result-dim"><?php echo $img_item['width']; ?> x <?php echo $img_item['height']; ?> px</div>
                                    <div style="color:#008000; font-size:10px;"><?php echo htmlspecialchars($img_item['site']); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <?php foreach ($combined_results as $item): ?>
                            <div class="res-item">
                                <a href="<?php echo htmlspecialchars($item['url']); ?>" class="res-title" target="_blank"><?php echo htmlspecialchars($item['title']); ?></a>
                                <div class="res-snippet"><?php echo htmlspecialchars($item['desc']); ?></div>
                                <div class="res-meta">
                                    <span class="res-url"><?php echo htmlspecialchars($item['url']); ?></span>
                                    - <a href="#" style="color:#7777cc;" onclick="return false;">En cache</a>
                                    - <a href="#" style="color:#7777cc;" onclick="return false;">Pages similaires</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    <!-- ==================== SKIN 3 : LYCOS 2006 ==================== -->
    <?php elseif ($engine == 'lycos'): ?>
        <div class="lycos-wrapper">
            <div class="lycos-black-bar">
                <div style="font-weight:bold;">LYCOS SEARCH NETWORK</div>
                <div>
                    <a href="index.php">My Lycos</a> | 
                    <a href="index.php">Mail</a> | 
                    <a href="#">Aide</a>
                </div>
            </div>

            <div class="lycos-header-box">
                <!-- Emplacement de ton image Lycos (ex: lycos.png) -->
                <div>
                    <img src="lycos.png" alt="Lycos" class="lycos-logo-img" onerror="this.style.display='none'; document.getElementById('lycos-alt-logo').style.display='block';">
                    <div id="lycos-alt-logo" style="display:none; font-size:28px; font-weight:bold; font-family:Impact, Arial; color:#000;">
                        LYCOS<span style="color:#0033cc;">.</span>
                    </div>
                </div>

                <div style="flex-grow:1;">
                    <div class="lycos-tabs">
                        <a href="search.php?q=<?php echo urlencode($q); ?>&engine=lycos&tab=web<?php echo $disable_noise?'&no_noise=1':''; ?>" class="<?php echo $tab=='web'?'active':''; ?>">Web</a>
                        <a href="#">Personnes</a>
                        <a href="#">Pages Jaunes</a>
                        <a href="#">Shopping</a>
                        <a href="search.php?q=<?php echo urlencode($q); ?>&engine=lycos&tab=images<?php echo $disable_noise?'&no_noise=1':''; ?>" class="<?php echo $tab=='images'?'active':''; ?>">Images & Audio</a>
                    </div>

                    <form method="GET" action="search.php" class="lycos-search-row">
                        <input type="hidden" name="engine" value="lycos">
                        <input type="hidden" name="tab" value="<?php echo htmlspecialchars($tab); ?>">
                        <?php if($disable_noise): ?><input type="hidden" name="no_noise" value="1"><?php endif; ?>
                        
                        <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" class="lycos-input" autofocus>
                        <input type="submit" value="Va chercher !" class="lycos-btn">
                    </form>
                </div>
            </div>

            <?php if ($q !== ''): ?>
                <div style="padding: 20px; text-align:left;">
                    <div style="font-size:11px; color:#666; margin-bottom:15px; border-bottom:1px solid #ddd; padding-bottom:5px;">
                        Résultats Lycos pour <b><?php echo htmlspecialchars($q); ?></b>
                    </div>

                    <?php if ($tab === 'images'): ?>
                        <div class="images-results-grid">
                            <?php foreach ($image_results as $img_item): ?>
                                <div class="img-result-item">
                                    <a href="<?php echo htmlspecialchars($img_item['page_url']); ?>" target="_blank">
                                        <img src="<?php echo htmlspecialchars($img_item['img_url']); ?>" alt="Img">
                                    </a>
                                    <a href="<?php echo htmlspecialchars($img_item['page_url']); ?>" style="color:#0000cc; font-weight:bold; text-decoration:none;" target="_blank">
                                        <?php echo htmlspecialchars(mb_strimwidth($img_item['title'], 0, 20, '...')); ?>
                                    </a>
                                    <div class="img-result-dim"><?php echo $img_item['width']; ?> x <?php echo $img_item['height']; ?> px</div>
                                    <div style="color:#008000; font-size:10px;"><?php echo htmlspecialchars($img_item['site']); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <?php foreach ($combined_results as $item): ?>
                            <div class="res-item">
                                <a href="<?php echo htmlspecialchars($item['url']); ?>" class="res-title" target="_blank"><?php echo htmlspecialchars($item['title']); ?></a>
                                <div class="res-snippet"><?php echo htmlspecialchars($item['desc']); ?></div>
                                <div class="res-meta">
                                    <span class="res-url"><?php echo htmlspecialchars($item['url']); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</body>
</html>