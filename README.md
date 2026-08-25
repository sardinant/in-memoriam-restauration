# In Memoriam

Ce dépôt contient ce qu'il faut pour jouer à *In Memoriam* (Lexis Numérique / Ubisoft, 2003) sans dépendre d'Internet ni de serveurs disparus. Les sites de l'extension *La Treizième Victime* sont inclus.

## Le projet de restauration

Conçu par Éric Viennot et le studio Lexis Numérique en 2003, *In Memoriam* est l'un des premiers ARG (*Alternate Reality Game*) grand public. Pour progresser, le joueur devait naviguer entre l'application et une cinquantaine de faux sites créés pour l'occasion, hébergeant les indices indispensables à la résolution des énigmes.

La liquidation de Lexis Numérique en 2014 a entraîné la fermeture des serveurs officiels, rendant le jeu inutilisable. Un premier projet communautaire de restauration, *In Memoriam Revival* (porté par Softbreakers), a permis de maintenir des serveurs de substitution pendant près de dix ans avant de finalement fermer à son tour, rendant le jeu de nouveau inaccessible.

Dans la continuité du travail de Simon Rodriguez (Kosua20) sur *Le Dernier Rituel* (2025), ce dépôt propose une solution entièrement locale et autonome. L'objectif est d'assurer la préservation à long terme de l'œuvre pour qu'elle reste jouable durablement, sans dépendre d'une infrastructure distante.

## Objectifs

Le serveur local installé sur la machine remplit deux rôles :

- servir les sites restaurés à leurs adresses d'origine, avec un moteur de recherche dédié pour les retrouver ;
- réimplémenter les scripts serveur du jeu dont le code n'a jamais été archivé : validation d'énigmes, bloc-notes de SKL Network, gestion du débit pour les films Shockwave.

Tout est accessible depuis l'adresse `www.inmemoriamdev.com` une fois l'installation effectuée.

## Contenu restauré & Modifications

Au-delà de la remise en route du jeu de base, ce projet intègre de nombreuses restaurations spécifiques :

- **Navigateur dédié et page d'accueil :** Création et intégration d'IMBrowser (basé sur le navigateur portable de Flashpoint) configuré avec les anciens plugins (Flash, Shockwave). Il s'ouvre directement sur une page d'accueil centralisant l'accès au jeu.
- **Moteur de recherche dédié :** Un moteur de recherche personnalisé a été mise en place. S'il demande encore un peu d'affinage, il permet de naviguer à travers la cinquantaine de sites sans subir de spoil ou le web actuel, tout en ajoutant du bruit thématisé pour chaque recherche.
- **Boîtes email et webmails :** différentes interfaces mail du jeu avec la mise en place de leurs habillages d'epoque.
- **Intranets et espaces sécurisés :** Restauration des pages protégées par identifiants/mots de passe et réimplémentation fonctionnelle du bloc-notes de SKL Network. *Note : pour faciliter l'exploration, le bloc-notes accepte désormais n'importe quel identifiant.*
- **Barre de recherche SKL :** Le moteur de recherche interne spécifique au site de SKL Network est de nouveau fonctionnel.
- **La 13e Victime :** Restauration complète des sites et du contenu de l'extension.
- **Univers étendu :** Intégration des pages et contenus promotionnels publiés avant la parution du jeu.
- **Contenu post-game :** Restauration d'une partie du contenu accessible après la fin de la trame principale.

## Compatibilité

Testé sur Windows 11 avec la version française du jeu.

L'add-on *La Treizième Victime* est couvert : les onze domaines créés pour lui sont présent, ainsi que les sites du premier jeu qu'il réutilise. La campagne n'a pas été jouée de bout en bout, en revanche, et quelques sites cités sans nom dans les solutions d'époque restent à identifier formellement.

Une partie du contenu n'a pas pu être récupérée :

- les cartons de texte `msg2` à `msg8` de `xineph.com/0016` en français, ainsi que `msg_jeu3` et `noms_latin` — la version anglaise est fournie à la place, et la substitution est signalée ;
- les vidéos de `xineph.com`, jamais capturées par les robots d'archivage ;
- le contenu des notes du bloc-notes de SKL Network : seuls les sujets et les dates ont survécu dans la capture ;
- la logique du compteur de tentatives de `Final_Game.php`, dont seuls quelques états figés sont archivés ;
- les pages derrière authentification de `skl-network.com`, en dehors du bloc-notes et de l'intranet.

## Installation

Voir `INSTALLATION.md`. En résumé : installer UwAmp, copier `www/` dedans, copier la configuration Apache, lancer le script qui ajoute les redirections, puis dézipper et démarrer le navigateur fourni.

Il faut compter un quart d'heure.

## Bugs connus

Deux blocages, de même origine : du code de 2003 qui suppose une machine lente, mis en échec par du matériel moderne.

### L'énigme BOS — non résolu

Après avoir révélé la première photographie, le fondu au blanc ne se dissipe pas et la seconde ne devient jamais révélable.

Le manuel d'origine mentionne ce blocage en l'attribuant, dans la fiction, à une instabilité provoquée par le Phœnix, et conseille de relancer le jeu. Le problème était donc connu avant la sortie. Aucun des trois correctifs officiels ne le traite : le contenu extrait de la mise à jour de 2005 ne contient ni `scp_103` ni aucune référence à la scène.

*Cause.* Le jeu ne fixe aucun tempo, donc la boucle Director tourne à la vitesse maximale que permet la machine. Le delta temporel est calculé depuis `the milliSeconds`, dont la résolution est d'une milliseconde, et plaqué sur un plancher de 0,001 s. Le fondu décrémente alors l'opacité du voile de 0,2 point par image, en dessous du pas de quantification de `sprite.blend` qui est un entier de 0 à 100. La valeur ne bouge jamais. Le voile reste opaque et, placé au premier plan, absorbe les clics destinés aux cases.

*Contournement.* Brider la fréquence d'images du processus avec un limiteur comme BES (Battle Encoder Shirasé). Les limiteurs de carte graphique et les enveloppes DirectDraw n'ont aucun effet : Director compose la scène en logiciel puis l'affiche via GDI.

*Correction propre.* Ajouter `puppetTempo(60)` à la fin du handler `prepareMovie` du script `INIT SHARED`, dans `c_com`. Une ligne, valable pour toutes les scènes. Nécessite Director 8.5 pour recompiler le cast.

### Les films Shockwave de xineph — résolu

Les `.dcr` restaient bloqués sur leur écran de chargement, à `0 (0)% of 0k`.

Ces films appellent `tellStreamStatus()` et attendent que le plugin leur rapporte l'avancement du téléchargement ; ils ne démarrent qu'à réception de l'état `Complete`. Shockwave 8.5 servait les films par flux progressif, Shockwave 12 charge le fichier entièrement avant de démarrer — et depuis un serveur local il arrive instantanément, donc l'événement n'arrive jamais.

`stream_dcr.php` sert les films à débit limité, ce qui rétablit les rapports d'avancement. Aucun fichier du jeu n'est modifié.

## Codes de développement

Des codes laissés par les développeurs sont toujours actifs. Ils ne figurent dans aucune documentation d'époque et ont été retrouvés en décompilant le script `INIT SHARED` du cast `c_com`.

Taper `lexis19` en cours de partie, sans rien valider, active le mode debug. Il est enregistré dans la sauvegarde et reste actif ensuite.

| Touches | Effet |
|---|---|
| `Maj+F` | Affiche le compteur d'images par seconde |
| `Maj+→` | Valide l'énigme en cours |
| `Maj+↑` | Passe au niveau suivant |
| `Maj+↓` | Réduit la fenêtre |
| `Maj+←` | Coupe le texte d'aide en cours |

Trois autres codes existent, propres à certaines énigmes : `symi1975`, `mithra` et `quattro`.

Le compteur d'images sert à vérifier le bridage nécessaire à l'énigme BOS.

## Le correctif officiel de 2005

`Patch_InMemoriam_2005_09_05.EXE` ne s'installe plus : il cherche une clé de registre posée par l'installeur d'origine. Son contenu a été extrait à la main et se trouve dans `patch_lexis_2005/` — dix-huit casts de scripts à copier dans `Data\Media\Dir\Cst\`, après sauvegarde des originaux.

Les chemins d'auteur laissés dans les fichiers montrent qu'il cumule trois vagues de correctifs. Quinze scènes sont corrigées, dont plusieurs énigmes entièrement réécrites.

## Le moteur de recherche

`indexer.php` parcourt le système de fichiers et ne retient que les pages d'accueil, soit une entrée par site ou par branche de navigation. L'indexation exhaustive produisait près de deux mille entrées, avec huit résultats du même domaine pour une seule recherche, ce qui ne ressemble pas à ce que renvoyait un moteur de 2003. Le résultat tient autour de 96 pages sur 49 sites.

Le script gère les particularités du corpus : encodages mal déclarés, pages d'accueil réduites à un `<frameset>`, redirections par `meta refresh` ou JavaScript, intros Flash sans texte. Une liste d'inclusions forcées ajoute les pages profondes que le jeu fait visiter et qui ne sont pas des index — articles de *Libération*, fiche Trombi, pages d'indices.

Les contenus que le joueur doit découvrir seul sont exclus de l'index.

## Ce qu'il reste à accomplir

- **Restaurer les assets manquants :** Continuer la recherche des médias non capturés par les robots d'archivage (notamment les vidéos et messages de `xineph.com`).
- **Assets et interfaces multilingues :** Les versions internationales des sites n'ont pas encore été traitées, et la page de connexion (*login*) multilingue reste à développer.
- **Exploiter le DVD Bonus :** Fouiller le DVD de la version Collector, qui devrait contenir une partie des fichiers web disparus (comme la vidéo post-game de Karen).
- **Ressusciter les emails du Phœnix et le post-game :** Rendre jouables toutes les énigmes post-game et trouver une solution pour restaurer les emails envoyés par le tueur. Ceux-ci n'étaient pas dans le code du jeu mais envoyés en temps réel par Éric Viennot et les équipes de Lexis Numérique à l'époque.
- **Archivage de la communauté :** Héberger et archiver le wiki de la *Confrérie Anti-Phoenix* dans son état de 2006.
- **Résoudre l'énigme des trois portes de `0016` :** La première ouvre actuellement une fenêtre noire, cause non identifiée.
- **Compteur de tentatives :** Réimplémenter la logique de `Final_Game.php`.
- **Paramètres Shockwave :** Trouver un moyen de conserver les options de compatibilité Shockwave d'une session à l'autre.
- **BOS :** Mesurer le seuil exact de FPS au-delà duquel l'énigme se bloque.
- **Vérification globale :** Jouer *La Treizième Victime* de bout en bout pour valider l'absence de liens cassés.
- **Moteur de recherche :** Améliorer l'habillage visuel de l'interface et affiner la pertinence des résultats renvoyés.
## Notes

Les redirections du fichier `hosts` masquent neuf domaines qui existent réellement, dont `liberation.fr` et `trombi.com`. En 2003, *Libération* hébergeait un vrai faux article sur la disparition de Jack Lorski. `desinstaller_hosts.ps1` retire le bloc quand vous avez fini de jouer.

Le fichier INI d'un projector Director doit porter exactement le nom de l'exécutable, espaces compris, sinon il est ignoré — y compris son réglage `DisplayFullLingoErrorText`, qui rend les erreurs de script lisibles et sert beaucoup au diagnostic.

Les sites utilisant Shockwave ne fonctionnent que dans un navigateur 32 bits. Le navigateur fourni règle la question.

Toutes les modifications apportées aux sites restaurés sont enregistrées dans l'historique des commits, et donc réversibles.

## Remerciements

- **À mon épouse**, qui un soir d'été a voulu faire des jeux d'enquêtes.
- **La Confrérie Anti-Phoenix**, dont le wiki recense les sites, les personnages et toute la couche d'énigmes qui a suivi le jeu. Vingt ans après, c'est toujours la meilleure documentation existante, et c'est leur inventaire qui a permis de savoir quoi chercher. Leur passion, reconnue par Éric Viennot lui-même, mérite tout autant l'archivage que le jeu en lui-même.
- **Simon Rodriguez (kosua20)** pour sa restauration d'*Evidence: The Last Ritual*, dont les scripts serveur ont servi de point de départ ici : les points d'entrée des deux jeux portent les mêmes noms.
- **Softbreakers** pour le *In Memoriam Revival Project*, qui a maintenu des serveurs de remplacement pendant des années et diffusé le correctif de 2005.
- **Internet Archive** pour avoir conservé des pages que plus personne ne regardait.
- **BlueMaxima's Flashpoint**, dont dérive le navigateur portable fourni ici.
- **ProjectorRays**, sans lequel rien n'aurait pu être décompilé.

## Droits

Le jeu et son contenu appartiennent à leurs ayants droit. Ce dépôt est un travail de préservation sans but lucratif et ne distribue aucune copie du jeu : il faut le posséder pour s'en servir.

Le détail figure dans `DROITS.md`, y compris ce qui est original ici et peut être repris librement.

Toute demande de retrait émanant d'un ayant droit sera honorée.
