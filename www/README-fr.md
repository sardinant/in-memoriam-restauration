# In Memoriam: Le Dernier Rituel

Ce dépôt contient une archive de tous les sites et services nécessaires pour pouvoir jouer au jeu In Memoriam Le Dernier Rituel (aussi publié sous le titre Evidence The Last Ritual), du début à la fin, et sans avoir à se référer à des guides en ligne ou à aller chercher des sites archivés sur l'Internet Archive. Attention, ce projet ne couvre pas (encore) le premier jeu (In Memoriam) ni son extension.

## Un projet de restauration

Suite à la fermeture de Lexis Numerique en 2014, Le Dernier Rituel n'est plus jouable: lors de la création d'un compte dans le jeu, il n'est plus possible de recevoir l'email contenant le mot de passe de connexion, certains des puzzles initiaux sont manquants, ainsi que la plupart des sites web conçus spécialement pour le jeu.
Ce projet vise à fournir une solution (relativement) facile à mettre en oeuvre pour contourner ces problèmes. Tout est géré localement sur l'ordinateur de l'utilisateur, qui execute un petit serveur HTTP local pendant que le jeu tourne.

Les problèmes ci-dessus sont très similaires à ceux qui impactent le premier jeu In Memorial, pour lequel le "In Memoriam Revival Project" a été créé vers 2014 ; malheureusement, ce projet est maintenant hors-ligne, sans sources ni données accessibles. Ca a cependant été l'inspiration pour ce nouveau projet, qui pourra un jour être étendu pour couvrir le premier jeu.

### Objectifs

Le serveur local que nous allons configurer sur l'ordinateur de l'utilisateur a deux rôles : 

* remplacer le serveur officiel du jeu (à l'addresse `www.inmemoriamdev.com`) pour gérer les comptes utilisateurs, suivre la progression et envoyer des emails
* permettre l'accès à tous les sites web qui fournissaient des indices et réponses pour les énigmes du jeu, initialement créés et hébergés par les développeurs du jeu

Le premier est accompli en n'envoyant non pas des vrais mails, mais en fournissant un faux site de messagerie où il est possible de lire tous les faux emails envoyés par les différents protagonistes (le "webmail").
Le second est accompli en fournissant des redirections depuis les URLs des sites webs vers des copies restaurées et hébergées localement, ainsi qu'un faux moteur de recherche.

Le webmail et le moteur de recherche sont accessibles depuis l'URL `www.inmemoriamdev.com` une fois que tout est configuré et lancé.

### Compatibilité

Le projet a été testé sous Windows 11 du début à la fin du jeu avec :

* la version US vendue sur 4 CD-ROMS (disponible sur l'Internet Archive: https://archive.org/details/evidence-the-last-ritual-usa-canada/)
* la version française 1 DVD (copie personnelle que j'ai acheté à l'époque)

	Note: seule la version anglophone des sites a été restaurée et testée. Sur certains sites les versions FR/ES/DE ont automatiquement bénéficiées de la restauration des images, etc, mais sans garantie.

Bien que la plus grande partie du contenu ait été restaurée, certaines données n'ont pas pu être récupérées du serveur de jeu ou des sites webs, notamment:

* Certaines images sur `www.castelodosmouros.com`, `www.clairekettley.net`, `www.viagensnotempo.com`
* Certaines sections de sites webs qui étaient derrière des logins: `www.losamigosdedante.org`, `www.naadirossem.net`, `www.phoenix-investigators.org`, `www.skl-network.com`
* Les vidéos sur `www.phoenix-investigators.org`, `www.smokingbug.com`, `www.xineph.com`
* Une page Flash manquante intitulée "Mission" sur `www.st-dominic-f.org`
* Certains blogs ont des pages secondaires manquantes (articles non nécessaires, archives, catégories) : `www.alcina-cooking.com`, `www.californianbloggers.com`, `www.clairekettley.net`, `www.julie-webzine.net`, `www.theo-makarios.info`
* `www.psykokronik.net` est une reconstruction complète à partir de données parcellaires
* Les messages SMS que le serveur pouvait envoyer au téléphone du joueur sont définitivement perdus

### Améliorations possibles

* Restaurer certaines des données web manquantes mentionnées ci-dessus (à partir de backups privés ?)
* Trouver quelqu'un avec un backup des messages SMS
* Certains emails sont envoyés vers le serveur avec une condition additionnelle (`mail_cond.php`), que le serveur ignore pour le moment
* Gérer la mise à jour/suppression de comptes utilisateurs, ainsi que d'autres requêtes du jeu (`verif_level_player.php` ?)
* Etendre le support au premier jeu In Memoriam / Missing Since January
* Etendre le support à l'extension du premier jeu La 13ème Victime

## Installation

* Installer un serveur Apache/PHP/MySQL portable: j'ai utilisé [UwAmp](https://www.uwamp.com/) avec succès tout au long du projet. Il peut être installé dans n'importe quel dossier en mode "portable". L'installation ci dessous utilise la dernière version d'UwAmp, les numéros de versions PHP et MySQL peuvent changer dans de futures installations.
* Cloneer ce dépôt repository dans le dossier `UwAmp/www/` 
* Copier `_config/httpd_uwamp.conf` dans `UwAmp/bin/apache/conf/`
* Copier `_config/my_uwamp.ini` dans `UwAmp/bin/database/mysql-5.7.11/`
* Copier `_config/php_uwamp.ini` dans `UwAmp/bin/php/php-7.0.3/`
* Ajouter les lignes contenues dans le fichier `_config/hosts` au fichier `hosts` de votre système. Si vous nêtes pas familier avec ce fichier, il permet de déclarer des redirections d'une URL ou un domaine vers un autre, pour toutes les applications sur votre ordinateur. Ce [guide WikiHow](https://www.wikihow.com/Edit-the-Hosts-File-on-Windows) peut vous aider à comprendre comment l'éditer.

La première fois que vous jouez:

* Lancer l'executable UwAmp
* Dans le panneau "Configuration", indiquer la version PHP (7.0.3), la version MySQL (5.7.11) et mettre Apache en "Offline Mode".
* Démarrer le serveur UwAmp
* Lancer le jeu
* Créer un nouveau compte, en spécifiant un nom d'utilisateur et une (fausse) addresse mail. Je recommande d'indiquer une addresse de la forme username@inmemoriamdev.com, ainsi en utilisant le bouton "Messagerie"/"Mail" dans le jeu, votre navigateur ouvrira directement le pseudo-webmail du projet. Vous pouvez indiquer si vous avez déjà joué au premier jeu ou non (certains emails seront différents). Certaines versions du jeu offraient aussi la possibilité de recevoir des SMS, mais ceci ne fonctionnera pas là.
* Une fois la création validée, cliquer sur le boutton pour ouvrir le pseudo-webmail à l'addresse `www.inmemoriamdev.com`. Vous devriez avoir reçu un premier email contenant le mot de passe à saisir dans le jeu.
* Se connecter dans le jeu et commencer à jouer.

Puis, chaque fois que vous voulez jouer au jeu :

* Lancer le serveur UwAmp
* Lancer le jeu
* Vérifiez vos 'emails' en vous rendant sur `www.inmemoriamdev.com` avec votre navigateur :)

Lorsque que vous voulez mettre fin à une session de jeu :

* Quitter le jeu
* Arrêter le serveur dans le paneau UwAmp (ou en passant par l'icone dans la barre d'état)

### Notes

Pour avoir un point de redondance, le mot de passe est aussi stocké dans `www/www.inmemoriamdev.com/scriptIM2/password.txt`, et toutes les requêtes reçues du jeu sont aussi loggées dans `www/www.inmemoriamdev.com/scriptIM2/log.txt`. Le mot de passe peut aussi être récupéré depuis le fichier de sauvegarde du jeu, dans `%USERPROFILE%/Documents/Evidence Save Games/USER_*/user.cfg`, 15 octets _after_ l'addresse email.

La base de données MySQL doit avoir un utilisateur `root` avec le mot de passe `root`, comme configuré dans `www.inmemoriamdev.com/scriptIM2/credentials.php`. C'est le cas par défaut en utilisant UwAmp en isolation pour ce projet. Il est aussi possible d'éditer ce fichier avant de lancer le serveur et le jeu pour la première fois, pour indiquer un utilisateur et mot de passe personnalisé.

## Remerciements

* [The J Man](https://www.justgamesretro.com/evidence-the-last-ritual-offline-guide) pour avoir fourni un fuide détaillé des réponses aux puzzles et des liens vers les archives des sites web correspondants
* [Inferno](https://www.gameboomers.com/wtcheats/pcEe/Evidence/evidencelevel1.htm) pour avoir écrit un guide très détaillé avec des références supplémentaires
* [123Pazu](https://www.youtube.com/@123Pazu) et [FactOfSin](https://www.youtube.com/@FactOfSin) pour avoir uploadé les deux seuls vidéos de let's play du jeu sur YouTube
* L'[Internet Archive](http://archive.org) pour avoir hebergé des copies de certains des sites web
* [hartator](https://github.com/hartator/wayback-machine-downloader) pour la maintenance d'un outil de récupération automatique de sites web depuis l'Internet Archive
* [Softbreakers](http://www.softbreakers.com/p/xinephcom.html) pour le premier In Memoriam Revival Project




