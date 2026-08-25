// proxy.pac ??? In Memoriam, redirection des sites du jeu
// Genere le 2026-08-25 depuis le contenu de C:\UwAmp\www
//
// A declarer dans le NAVIGATEUR uniquement (configuration automatique
// du proxy). Les sites du jeu partent vers le serveur local, tout le
// reste du web reste accessible normalement.
//
// ATTENTION : le jeu lui-meme ne lit pas ce fichier. Le projector
// Director resout ses domaines par le DNS du systeme, donc les
// redirections du fichier hosts restent necessaires pour qu'il
// fonctionne. Ce fichier ne couvre que la navigation.

function FindProxyForURL(url, host) {

    // --- domaines fictifs, crees pour le jeu ---
    var jeu = [
        "2368.info", "anges-demons.net", "benatky-castle.net",
        "bruno-giordano.net", "cathedrale-paris.net", "chimie-medievale.com",
        "c-maccioni.com", "czech-genealogicka.org", "demagia.net",
        "enfieldsc.net", "falkirk.free.fr", "fe256.net",
        "hagel-gallery.com", "helenawhitford.net", "hermeticum.info",
        "hildeseite-web-de.net", "hotel-mocenigo.com", "inkdesign77.com",
        "inmemoriamdev.com", "irbca.com", "italia-libero.com",
        "jim-leroy.net", "karen-gijman.com", "kilic-library.com",
        "lanterna-magica.net", "liberation-inmemoriam.fr", "memo-geo.com",
        "messini-yc.com", "mysterious-world.net", "nag-hammadi.com",
        "oespg.com", "oxstud.com", "persofrance.com",
        "qabbalah.info", "radiozakaz-cz.net", "rhodestravel.com",
        "sabelli.net", "sainte-inquisition.net", "skl-network.com",
        "tomalt.net", "tychobrahe.net", "uk-de.org",
        "volker-institut.com", "xineph.com"
    ];

    // --- domaines existant reellement sur le web ---
    // Decommenter pour les rediriger aussi vers le serveur local.
    // Tant qu'ils sont commentes, les vrais sites restent accessibles,
    // mais les pages du jeu qu'ils hebergeaient sont introuvables.
    var reels = [
        // "divertissements.msn.fr", "groups.msn.com", "gudule.net",
        // "liberation.fr", "natalecta.com", "persocite.francite.com",
        // "ricochet-jeunes.org", "trombi.com", "webzinemaker.com",
    ];

    var i;
    for (i = 0; i < jeu.length; i++) {
        if (dnsDomainIs(host, jeu[i])) return "PROXY 127.0.0.1:80";
    }
    for (i = 0; i < reels.length; i++) {
        if (dnsDomainIs(host, reels[i])) return "PROXY 127.0.0.1:80";
    }
    return "DIRECT";
}
