# In Memoriam (2003) — restauration de l'infrastructure web

Reconstruction hors-ligne des sites web fictifs d'*In Memoriam*
(Lexis Numérique / Ubisoft, 2003), de son moteur de recherche interne
et de ses scripts serveur.

Le jeu s'appuie sur une cinquantaine de sites réellement hébergés à
l'époque. Les serveurs ont été coupés en 2014, à la liquidation de Lexis
Numérique : le jeu est depuis injouable en l'état. Ce dépôt permet de le
faire tourner intégralement en local, sans dépendre d'aucun service
tiers.

---

## Contenu

| Dossier | Contenu |
|---|---|
| `www/` | Les sites reconstruits, un dossier par domaine |
| `conf/` | VirtualHosts Apache, entrées `hosts`, scripts d'installation |
| `moteur/` | Le moteur de recherche : `indexer.php`, `search.php` |
| `scripts/` | Scripts serveur réimplémentés : `login.php`, `stream_dcr.php` |
| `navigateur/` | Navigateur portable préconfiguré avec Shockwave et Flash |
| `patch_lexis_2005/` | Le correctif officiel de 2005, extrait de son installeur |
| `doc/` | Notes techniques et bugs connus |

---

## Installation

**1. Serveur.** Installer UwAmp, puis copier le contenu de `www/` dans
`C:\UwAmp\www\`. Un dossier par domaine, directement à la racine.

**2. VirtualHosts.** Reporter les blocs de `conf/httpd_uwamp.conf` dans
le modèle d'UwAmp (`bin\apache\conf\httpd_uwamp.conf`). **Pas** dans
`httpd.conf` : ce dernier est régénéré à chaque démarrage et vos
modifications seraient perdues. Redémarrer Apache.

**3. Redirections.** Lancer `conf/installer_hosts.ps1` en administrateur.
Il ajoute une ligne par domaine, encadrée par des marqueurs, et vide le
cache DNS. `conf/desinstaller_hosts.ps1` retire le bloc.

> Certains domaines du jeu existent réellement — `liberation.fr`,
> `trombi.com`, `ricochet-jeunes.org`, `groups.msn.com`. Tant que la
> redirection est active, les vrais sites sont inaccessibles. C'est
> inhérent au jeu : en 2003, *Libération* hébergeait réellement ces
> fausses pages.

**4. Navigateur.** Lancer `navigateur/IMBrowser.exe`. Il embarque
Shockwave et Flash, sans proxy, et s'ouvre sur le moteur de recherche.

**5. Index de recherche.** Depuis `www\www.inmemoriamdev.com\` :

```
php indexer.php --report    (vérification, n'écrit rien)
php indexer.php             (génère index.json)
```

**Vérification.** `httpd.exe -S` doit lister un VirtualHost par domaine.
Tout domaine manquant retombe sur le vhost par défaut et renvoie le
contenu d'un autre site.

---

## Le moteur de recherche

`indexer.php` parcourt le système de fichiers et ne retient que les pages
d'accueil — une entrée par site ou par branche de navigation. C'est un
annuaire, pas un index de pages : l'indexation exhaustive produisait près
de deux mille entrées, avec huit résultats du même domaine pour une seule
recherche, ce qui ne ressemble à rien de ce que renvoyait un moteur de
2003. Le résultat tourne autour de 96 pages sur 49 sites.

Le script gère les particularités du corpus : encodages ISO-8859-1 mal
déclarés, pages d'accueil réduites à un `<frameset>`, redirections par
`<meta refresh>` ou par JavaScript, intros Flash sans aucun texte — ces
dernières sont indexées sur leur `<title>` et leurs `<meta keywords>`
plutôt qu'écartées.

Une liste `pages_forcees` en tête du fichier ajoute les pages profondes
que le jeu fait réellement visiter et qui ne sont pas des index :
articles de *Libération*, fiche Trombi de Lorski, `complot2.html` de Jim
Leroy, pages d'indices. Elle est tirée de l'inventaire de la Confrérie
Anti-Phoenix et de la solution d'époque.

Sont exclus les contenus que le joueur doit découvrir seul :
`xineph.com`, `fe256.net`, `liberation-inmemoriam.fr`, et les branches
`borgo` et `karen0021` de `skl-network.com`. Les versions non
francophones sont également filtrées.

`search.php` pondère les termes par leur fréquence **sur l'ensemble du
corpus**. La version d'origine mesurait site par site, ce qui rendait
introuvable tout domaine d'une seule page : son unique occurrence valait
100 % de fréquence, donc un poids nul.

---

## Scripts serveur réimplémentés

**`login.php`** — validation de l'énigme « What is her city? »
(`0016/jeu3`). L'original vivait chez Lexis ; la Wayback Machine n'a
capturé que le cas d'échec, un renvoi systématique vers
`jeu3_error.html`. Le script rétablit la comparaison, insensible à la
casse et aux accents.

**`stream_dcr.php`** — limiteur de débit pour les films Director. Voir
plus bas.

---

## Bugs connus

Deux blocages distincts, de même nature : du code de 2003 qui suppose une
machine et un réseau lents, mis en échec par du matériel moderne.

### L'énigme BOS (scène 103) — non résolu

Après avoir révélé la première photographie, le fondu au blanc ne se
dissipe pas et la seconde ne devient jamais révélable.

Le manuel d'origine documente ce blocage en le romançant : il l'attribue
à une « instabilité » provoquée par le Phœnix et conseille de quitter le
jeu et de le relancer. Le problème était donc connu de l'éditeur avant la
sortie. **Aucun des trois correctifs officiels ne le traite** — le
contenu extrait de la mise à jour de 2005 ne contient ni `scp_103` ni
aucune référence à la scène.

*Cause.* Le jeu ne fixe aucun tempo : la boucle Director tourne à la
vitesse maximale que permet la machine. Le delta temporel global est
calculé depuis `the milliSeconds`, dont la résolution est d'une
milliseconde, et plaqué sur un plancher de 0,001 s. Le fondu décrémente
alors l'opacité du voile de 0,2 point par image — sous le pas de
quantification de `sprite.blend`, qui est un entier de 0 à 100. La valeur
ne bouge jamais. Le voile reste opaque et, placé au premier plan, absorbe
les événements souris destinés aux cases.

*Contournement.* Brider la fréquence d'images du processus. Un limiteur
comme **BES** (Battle Encoder Shirasé) fonctionne. Les limiteurs GPU et
les enveloppes DirectDraw n'ont **aucun effet** : Director compose la
scène en logiciel puis l'affiche via GDI. Pour mesurer le résultat, le
jeu embarque un compteur d'images — voir la section *Codes de
développement*.

*Correction propre.* Ajouter `puppetTempo(60)` à la fin du handler
`prepareMovie` du script `INIT SHARED`, dans `c_com`. Une ligne, valable
pour toutes les scènes. Nécessite Director 8.5 pour recompiler le cast :
les tentatives de modification directe du bytecode se sont soldées par un
refus au chargement.

### Les films Shockwave de xineph — résolu

Les `.dcr` restaient bloqués sur leur écran de chargement, affichant
`0 (0)% of 0k`.

*Cause.* Ces films appellent `tellStreamStatus()` et attendent que le
plugin leur rapporte l'avancement du téléchargement ; ils ne démarrent
qu'à réception de l'état `"Complete"`. En 2003, Shockwave 8.5 servait les
films par flux progressif. Shockwave 12 charge le fichier entièrement
avant de démarrer le film, et depuis un serveur local il arrive
instantanément : `bytesTotal` reste à zéro et l'événement final n'arrive
jamais.

*Correction.* `stream_dcr.php` sert les films à débit limité — 56 Ko/s
par défaut, réglable en tête du script — ce qui rétablit les rapports
d'avancement. Aucun fichier du jeu n'est modifié. Le `.htaccess` fourni
route les demandes vers lui et désactive la compression, qui fausserait
`Content-Length`.

---

## Codes de développement

Des codes laissés par les développeurs sont toujours actifs dans le jeu.
Ils ne figurent dans aucune documentation d'époque : ils ont été
retrouvés en décompilant le script `INIT SHARED` du cast `c_com`.

**Activation.** Taper **`lexis19`** en cours de partie, sans rien valider.
Le gestionnaire clavier écoute en permanence ; dès la dernière lettre,
le mode est actif. Comme il est enregistré dans la sauvegarde, il le
reste d'une session à l'autre.

**Raccourcis débloqués :**

| Touches | Effet |
|---|---|
| `Maj+F` | Affiche le compteur d'images par seconde |
| `Maj+→` | Valide l'énigme en cours |
| `Maj+↑` | Passe au niveau suivant |
| `Maj+↓` | Réduit la fenêtre |
| `Maj+←` | Coupe le texte d'aide en cours |

**Codes propres à certaines énigmes**, sur le même principe :
`symi1975`, `mithra` et `quattro`.

Le compteur d'images est particulièrement utile ici : c'est lui qui
permet de vérifier le bridage nécessaire à l'énigme BOS, décrite plus
bas.

---

## Le correctif officiel de 2005

`Patch_InMemoriam_2005_09_05.EXE` refuse de s'installer sur une copie du
jeu : il cherche une clé de registre posée par l'installeur d'origine.
Son contenu a donc été extrait à la main — c'est un installeur Wise, dont
la charge utile est une série de flux deflate après les sections PE.

`patch_lexis_2005/` contient les dix-huit casts de scripts à copier dans
`Data\Media\Dir\Cst\`. Les chemins d'auteur laissés dans les fichiers
montrent que le correctif cumule trois vagues (`Patch 1.1`, `1.2`,
`2.2`). Quinze scènes sont corrigées, dont plusieurs énigmes entièrement
réécrites — le suffixe `_02` sur `s601_PEPISOTH`, `s702_CHTISAR`,
`s802_LACHORI` et `s805_SICHET` en témoigne.

**Sauvegarder les fichiers de 2003 avant de copier.** Ce sont ceux du
pressage d'origine, ils ont une valeur documentaire.

---

## Notes de compatibilité

Le DRM SafeDisc 2 du pressage d'origine ne fonctionne plus depuis
Windows Vista.

La scène est figée à 800 × 600 dans la configuration de chaque film, avec
des coordonnées de sprites absolues. Aucune augmentation de résolution
n'est possible, et elle n'apporterait rien : les éléments graphiques sont
des bitmaps produits pour cette définition. Pour jouer en plein écran,
passer l'affichage en 800 × 600 et laisser le GPU mettre à l'échelle.

Le fichier INI d'un projector Director doit porter **exactement** le nom
de l'exécutable, espaces compris, sinon il est ignoré. `In Memoriam.ini`
active `DisplayFullLingoErrorText`, qui transforme les erreurs de script
en messages détaillés — précieux pour diagnostiquer.

Les sites utilisant Shockwave ne fonctionnent que dans un navigateur
32 bits. Le navigateur fourni règle la question.

---

## Outils utilisés

| Outil | Usage |
|---|---|
| **UwAmp** | Serveur Apache + PHP local |
| **ProjectorRays** | Décompilation des casts Director protégés |
| **BES** | Bridage de la fréquence d'images pour l'énigme BOS |
| **7-Zip** | Ouverture des archives (inopérant sur les installeurs Wise) |
| **Resource Hacker** | Remplacement des icônes des exécutables |
| **Wayback Machine (CDX)** | Inventaire et récupération des ressources |

Pour télécharger un binaire depuis l'Archive sans corruption, l'URL doit
contenir `id_` après le timestamp — sans lui, la barre d'outils est
injectée dans le fichier.

`dgVoodoo2` a été testé et **ne sert à rien** ici : Director ne passe pas
par DirectDraw pour la composition de la scène, seulement pour la vidéo.

---

## Ce qui reste à faire

- Énigme des trois portes de `0016` : la porte 1 s'ouvre sur une fenêtre
  noire, cause non identifiée.
- Persistance des options de compatibilité de Shockwave, qui ne se
  sauvegardent pas d'une session à l'autre.
- Mesurer le seuil exact de fréquence d'images au-delà duquel BOS se
  bloque.
- Vérifier si d'autres scènes utilisent la même comparaison stricte sur
  `sprite.blend`.
- Répertoire du mini-jeu `xineph.com` : ressources de la branche
  française, énigme `Final_Game.dcr` et son compteur `gtry`.

---

## Sources et remerciements

Les ressources ont été récupérées via les archives web, et plusieurs
images perdues reconstruites. Le *In Memoriam Revival Project* de
Softbreakers a maintenu des serveurs de remplacement et diffuse le
correctif de 2005. La *Confrérie Anti-Phoenix* a documenté l'inventaire
des sites et la couche ARG postérieure au jeu. Le navigateur portable
dérive de **Flashpoint Navigator**, du projet BlueMaxima's Flashpoint,
sous licence libre.

Le jeu et l'ensemble de son contenu appartiennent à leurs ayants droit.
Ce dépôt est un travail de préservation, sans but lucratif.
