# Droits et statut du dépôt

Ce dépôt est un travail de préservation, sans but lucratif.

## Ce qui appartient à autrui

**Le jeu et le contenu des sites.** *In Memoriam* (2003) et l'ensemble
de ses ressources — pages, images, animations, textes, films Director —
sont l'œuvre de Lexis Numérique, publiée par Ubisoft. Lexis Numérique a
été liquidée en 2014 ; les droits appartiennent à leurs ayants droit.

Les sites reconstruits ici ont été récupérés depuis des archives
publiques du web. Ils sont republiés dans le seul but de rendre le jeu
jouable, celui-ci étant devenu inutilisable après la fermeture des
serveurs d'origine. Aucune copie du jeu lui-même n'est distribuée : il
faut le posséder pour se servir de ce dépôt.

**Le correctif de 2005.** Les fichiers de `patch_lexis_2005/` sont ceux
d'une mise à jour officielle de Lexis Numérique, extraits de leur
installeur parce que celui-ci ne fonctionne plus. Ils sont redistribués
tels quels, sans modification.

**Le navigateur.** Distribué en release attachée, il dérive de
*Flashpoint Navigator*, du projet BlueMaxima's Flashpoint, sous licence
libre. Il embarque les greffons Shockwave et Flash d'Adobe, qui sont
propriétaires et ne sont plus distribués par leur éditeur. Leur
inclusion relève de la même logique de préservation : sans eux, aucun
site du jeu ne fonctionne.

Toute demande de retrait émanant d'un ayant droit sera honorée.

## Ce qui est original

Le code écrit pour ce projet est placé dans le domaine public, ou sous
licence CC0 si votre juridiction ne le permet pas. Reprenez-le,
modifiez-le, redistribuez-le sans condition :

- le moteur de recherche (`moteur/indexer.php`, `moteur/search.php`)
- les scripts serveur réimplémentés (`scripts/`), dont le bloc-notes,
  la validation de l'énigme jeu3, le limiteur de débit et la passerelle
  de recherche
- les scripts d'installation (`conf/*.ps1`)
- la documentation

Les gabarits HTML du bloc-notes (`scripts/bloc/_*.html`) sont extraits
des pages archivées et relèvent du premier paragraphe, pas de celui-ci.

## Modifications apportées aux sites

Toutes les modifications faites aux sites reconstruits sont enregistrées
dans l'historique des commits. Il est donc possible de retrouver l'état
exact de chaque fichier tel qu'il a été récupéré, et de voir ce qui a
été ajouté, complété ou recréé.

Les cas où une ressource a dû être remplacée par sa version d'une autre
langue, ou déclarée perdue, sont signalés dans le `README.md`.
