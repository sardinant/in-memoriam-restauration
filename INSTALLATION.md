# Installation

Un quart d'heure, dont l'essentiel à installer UwAmp. Windows 10 ou 11.

Tout est déjà en place dans le paquet : les sites, les scripts, l'index
de recherche et le navigateur. Il n'y a rien à assembler.

---

## 1. Le serveur

Installez **UwAmp** depuis [uwamp.com](http://www.uwamp.com). Lancez-le une
fois et démarrez Apache, le temps qu'il crée son arborescence.

Copiez ensuite le contenu du dossier `www/` dans `C:\UwAmp\www\`.

## 2. La configuration

Copiez `conf/httpd_uwamp.conf` dans `C:\UwAmp\bin\apache\conf\`, en
écrasant le fichier existant. Redémarrez Apache depuis UwAmp — arrêt
complet, puis relance.

C'est bien `httpd_uwamp.conf` qu'il faut remplacer, pas `httpd.conf` :
UwAmp régénère le second depuis le premier à chaque démarrage.

## 3. Les redirections

Le jeu appelle une cinquantaine de sites par leur vrai nom de domaine. Il
faut donc dire à Windows d'aller les chercher sur votre machine.

Clic droit sur `conf/installer_hosts.ps1`, **Exécuter avec PowerShell**,
en acceptant l'élévation. Si Windows refuse — c'est fréquent avec les
fichiers téléchargés — ouvrez PowerShell en administrateur et lancez :

```powershell
powershell -ExecutionPolicy Bypass -File .\installer_hosts.ps1
```

Vérifiez en ouvrant `http://www.skl-network.com/` dans n'importe quel
navigateur : le site doit s'afficher.

## 4. Le navigateur
IMBrowser est basé sur le navigateur portable du projet Flashpoint.
Il a été modifié pour servir de navigateur principal pendant que vous jouez 
à *In Memoriam* et s'ouvre directement sur la page de connexion,
avec Shockwave et Flash déjà intégrés.

-Créez un dossier `Navigateur` à la racine de votre installation, 
puis dézippez-y le contenu de `imbrowser.zip`.

-Lancez ensuite `Navigateur/IMBrowser.exe`.Lancez `navigateur/IMBrowser.exe`. Il s'ouvre sur le moteur de recherche
du jeu, avec Shockwave et Flash déjà en place.

C'est tout. Vous pouvez jouer.

---

## Pour le jeu lui-même

Deux choses à faire une fois, du côté du jeu et non du serveur.

**Le correctif officiel de 2005.** Copiez les dix-huit fichiers de
`patch_lexis_2005/` dans `Data\Media\Dir\Cst\`, après avoir sauvegardé
les originaux. Ce correctif ne s'installe plus tout seul : il cherche une
clé de registre qui n'existe plus, d'où les fichiers extraits à la main.

**Le bridage de la fréquence d'images.** L'énigme *BOS* se bloque sur les
machines modernes — le jeu tourne si vite que son calcul de fondu ne
progresse plus. Récupérez **BES** (Battle Encoder Shirasé), un utilitaire
sans installation : ciblez le processus du jeu et ajustez la limitation
jusqu'à une soixantaine d'images par seconde.

Pour mesurer, tapez `lexis19` en cours de partie — c'est le mode debug
laissé par les développeurs — puis `Maj+F`. Les limiteurs de carte
graphique ne servent à rien ici : Director dessine sa scène en logiciel.

---

## Quand vous avez fini de jouer

Les redirections masquent neuf sites qui existent réellement, dont
`liberation.fr` et `trombi.com`. En 2003, *Libération* hébergeait
vraiment un faux article sur la disparition de Jack Lorski, accessible
uniquement par leur moteur de recherche.

`conf/desinstaller_hosts.ps1` retire les redirections et rend l'accès
normal. À relancer avant de rejouer.

---

## Si quelque chose cloche

**Un site en affiche un autre.** Il manque un VirtualHost. Vérifiez que
le bon fichier de configuration a été remplacé, et qu'Apache a bien
redémarré.

**Le navigateur part sur le vrai site.** La redirection n'est pas active :
relancez `installer_hosts.ps1`.

**Une modification de configuration disparaît au redémarrage.** Elle a été
faite dans `httpd.conf` au lieu de `httpd_uwamp.conf`.

**Un film Shockwave reste noir avec `0 (0)% of 0k`.** Le fichier
`.htaccess` de `www.xineph.com` a été perdu à la copie — c'est un fichier
caché, certains outils l'ignorent.

Le `README.md` détaille les bugs connus, leurs causes et ce qui reste
irrécupérable.
