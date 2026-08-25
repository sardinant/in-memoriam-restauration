<?php
// Récupération des identifiants (qu'ils viennent du menu de gauche ou du bloc central)
$login = $_POST['ident1'] ?? $_POST['ident2'] ?? '';
$pwd   = $_POST['pwd1'] ?? $_POST['pwd2'] ?? '';

// Vérification : Login = Carolina ET Mot de passe = JABAMIAH (insensible à la casse)
$is_logged_in = (strcasecmp(trim($login), 'Carolina') === 0 && strcasecmp(trim($pwd), 'JABAMIAH') === 0);

// Données de l'arbre généalogique si l'utilisateur est connecté
if ($is_logged_in) {
    $arbre = [
        'titre' => 'Carolina Molikova',
        'gen1' => [
            'pere' => ['nom' => '◆', 'type' => 'm'],
            'mere' => ['nom' => '◆', 'type' => 'f'],
        ],
        'gen2' => [
            'pere' => ['nom' => 'Anton', 'prenom' => 'MALKO', 'dates' => '(1902-1982)', 'type' => 'm'],
            'mere' => ['nom' => 'Gabriela', 'prenom' => 'LEKOVA', 'dates' => '(1903-1993)', 'type' => 'f'],
        ],
        'couples_gen3' => [
            'couple1' => [
                'conjoint' => ['nom' => 'Petr', 'prenom' => 'MOLIK', 'dates' => '(1921-1999)', 'type' => 'f_style'],
                'enfant'   => ['nom' => 'Teresa', 'prenom' => 'MALKOVA', 'dates' => '(1926-1996)', 'type' => 'm_style'],
                'enfants'  => [
                    ['nom' => 'Alan', 'prenom' => 'MOLIK', 'dates' => '(1947)', 'type' => 'm'],
                    ['nom' => 'Simona', 'prenom' => 'MOLIKOVA', 'dates' => '(1949)', 'type' => 'm'],
                    ['nom' => 'Bodhan', 'prenom' => 'MOLIK', 'dates' => '(1954-1996)', 'type' => 'm'],
                ]
            ],
            'couple2' => [
                'enfant'   => ['nom' => 'Thomas Anton', 'prenom' => 'MALKO', 'dates' => '(1938-19xx)', 'type' => 'm_style'],
                'conjoint' => ['nom' => 'Marina', 'prenom' => 'KOPECKOVA', 'dates' => '(◆)', 'type' => 'f_style'],
                'enfants'  => [
                    ['nom' => '◆', 'type' => 'm'],
                    ['nom' => '◆', 'type' => 'm'],
                ]
            ]
        ]
    ];
}
?>
<html>
<head>
<title>FRANCOUZSKO-ČESKÝ RODOPIS</title>
<meta name="generator" content="Namo WebEditor v6.0">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<?php if ($is_logged_in): ?>
<style>
    /* Styles spécifiques pour l'arbre généalogique */
    .tree-box-container {
        background-color: white;
        border: 1px solid #b0b0cc;
        border-radius: 12px;
        padding: 20px;
        width: 100%;
        box-sizing: border-box;
        font-family: Verdana, Arial, sans-serif;
    }
    .tree-title {
        text-align: center;
        color: #0000aa;
        font-size: 16px;
        font-weight: bold;
        margin: 15px 0 25px 0;
    }
    .intro-grid {
        display: flex;
        justify-content: center;
        gap: 40px;
        font-size: 11px;
        color: #000080;
        margin-bottom: 30px;
        text-align: center;
    }
    .intro-grid div { width: 45%; }
    .intro-grid .separator { width: 1px; background-color: red; height: 40px; }
    .tree-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }
    
    .box {
        border: 1px solid #000;
        padding: 4px 8px;
        text-align: center;
        font-size: 10px;
        min-width: 80px;
        background: #fff;
        display: inline-block;
        color: #000;
        position: relative;
        z-index: 1;
    }
    .box-blue { border-color: #0000aa; color: #0000aa; }
    .box-red { border-color: #aa0000; color: #aa0000; background-color: #fff4f4; }
    .box-black { border-color: #000; color: #000; background-color: #f0f0f0;}
    .person-name { font-weight: bold; text-decoration: underline; display: block; }
    .person-dates { font-size: 9px; display: block; color: #000;}
    
    .couple { display: flex; gap: 15px; position: relative; }
    .line-v { width: 1px; background-color: #000; }
    .line-h-couple {
        position: absolute;
        top: 50%;
        left: 15px;
        right: 15px;
        height: 1px;
        background-color: #000;
        z-index: 0;
    }
    
    .footer-info {
        display: flex;
        justify-content: center;
        gap: 40px;
        font-size: 10px;
        margin-top: 40px;
        padding-top: 15px;
        color: #000080;
        text-align: center;
    }
    .footer-info .separator { width: 1px; background-color: red; height: 20px; }
</style>
<?php endif; ?>
</head>
<body bgcolor="white" text="blue" link="blue" vlink="blue" alink="blue" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" background="images/img1.gif" style="SCROLLBAR-BASE-COLOR: #f0f0ff">
<table align="center" cellpadding="0" cellspacing="0" width="760" style="FONT-FAMILY: Verdana">
    <tr>
        <td colspan="3" width="760" height="14" style="FONT-SIZE: 1pt">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" width="760" height="31" style="FONT-SIZE: 1pt">
            <table cellpadding="0" cellspacing="0" width="760" height="31">
                <tr style="FONT-FAMILY: Arial">
                    <td width="370" height="31">&nbsp;</td>
                    <td width="78" height="31" align="middle" style="FONT-SIZE: 8pt" background="images/menu_3.gif"><A href="index.htm"><i>Úvod</i><br>Accueil</a></td>
                    <td width="78" height="31" align="middle" style="FONT-SIZE: 8pt" background="images/menu_3.gif"><A href="new.htm"><i>Vytvořit</i><br>Créer</a></td>
                    <td width="78" height="31" align="middle" style="FONT-SIZE: 8pt" background="images/menu_3.gif"><A href="search.htm"><i>Hledat</i><br>Chercher</a></td>
                    <td width="78" height="31" align="middle" style="FONT-SIZE: 8pt" background="images/menu_3.gif"><A href="forum.htm"><i>Fórum</i><br>Forum</a></td>
                    <td width="78" height="31" align="middle" style="FONT-SIZE: 8pt" background="images/menu_3.gif"><A href="tools.htm"><i>Zdroje</i><br>Ressources</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="96" width="760" colspan="3">
            <table cellpadding="0" cellspacing="0" width="760" height="97">
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td width="260" height="97" bgcolor="white" rowspan="3"><IMG height=96 src="images/title.gif" width=243 border=0></td>
                    <td width="96" height="97" bgcolor="white" rowspan="3" align="middle"><IMG height=64 src="images/logo_64.gif" width=64 border=0></td>
                    <td width="372" height="97" bgcolor="white" style="FONT-SIZE: 11pt" align="right" rowspan="3">
                        <p><i>První francouzsko-český rodopisný server</i></p>
                        <p>Le 1<span style="FONT-SIZE: 9pt" 
           ><sup>er</sup></span> site franco-tchèque de généalogie</p>
                    </td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="65" bgcolor="white">&nbsp;</td>
                    <td width="16" height="65" bgcolor="white">&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" width="760" height="15" style="FONT-SIZE: 1pt">&nbsp;</td>
    </tr>
    
    <tr valign="top">
<?php if ($is_logged_in): ?>
        <!-- AFFICHAGE PLEINE LARGEUR (760px) DE L'ARBRE EN CAS DE SUCCÈS -->
        <td colspan="3" width="760" align="center">
            
            <div class="tree-box-container">
                <div class="tree-title"><?= htmlspecialchars($arbre['titre']) ?></div>

                <div class="intro-grid">
                    <div>
                        <i>Carolina Molikova - vítejte v rodopisu.<br>
                        Aktuálně jsou zde 4 osoby na seznamu RODINA.<br>
                        Chcete-li kontaktovat tuto osobu, klepněte <a href="#">ZDE</a>.</i>
                    </div>
                    <div class="separator"></div>
                    <div>
                        Bienvenue dans la généalogie de Carolina Molikova.<br>
                        Actuellement, 4 personnes sont dans sa liste FAMILLE.<br>
                        Pour contacter cette personne, cliquez <a href="#">ICI</a>.
                    </div>
                </div>

                <div class="tree-container">
                    
                    <!-- Génération 1 & 2 -->
                    <div class="couple" style="margin-top: 70px;">
                        <div class="line-h-couple"></div>
                        
                        <!-- Bloc d'Anton -->
                        <div style="position: relative;">
                            <div style="position: absolute; bottom: calc(100% + 15px); left: 50%; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center;">
                                <div class="couple" style="gap: 15px;">
                                    <div class="line-h-couple"></div>
                                    <div class="box box-blue" style="padding: 6px 15px; z-index: 1;"><b><?= $arbre['gen1']['pere']['nom'] ?></b></div>
                                    <div class="box box-red" style="padding: 6px 15px; z-index: 1;"><b><?= $arbre['gen1']['mere']['nom'] ?></b></div>
                                    <div style="position: absolute; top: 50%; left: 50%; width: 1px; height: calc(50% + 15px); background: #000; transform: translateX(-50%); z-index: 0;"></div>
                                </div>
                            </div>
                            
                            <div class="box box-blue" style="position: relative; z-index: 1;">
                                <span class="person-name"><?= $arbre['gen2']['pere']['nom'] ?></span>
                                <span class="person-name"><?= $arbre['gen2']['pere']['prenom'] ?></span>
                                <span class="person-dates"><?= $arbre['gen2']['pere']['dates'] ?></span>
                            </div>
                        </div>

                        <!-- Case Gabriela -->
                        <div class="box box-red" style="position: relative; z-index: 1;">
                            <span class="person-name"><?= $arbre['gen2']['mere']['nom'] ?></span>
                            <span class="person-name"><?= $arbre['gen2']['mere']['prenom'] ?></span>
                            <span class="person-dates"><?= $arbre['gen2']['mere']['dates'] ?></span>
                        </div>
                    </div>

                    <!-- Trait descendant du couple Anton/Gabriela vers la génération 3 -->
                    <div class="line-v" style="height: 15px;"></div>

                    <!-- Génération 3 & 4 -->
                    <div style="position: relative; width: 100%; display: flex; justify-content: center;">
                        <div style="position: absolute; top: 0; left: 25%; right: 25%; height: 1px; background: #000;"></div>
                        
                        <div style="width: 100%; display: flex;">
                            
                            <!-- Bloc Gauche (Centré sur TERESA) -->
                            <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                                <div class="line-v" style="height: 15px;"></div>
                                
                                <div style="position: relative;">
                                    <div style="position: absolute; top: 50%; right: 100%; width: 25px; height: 1px; background: #000; z-index: 0;"></div>
                                    
                                    <div class="box box-blue" style="position: absolute; right: calc(100% + 25px); top: 0; white-space: nowrap;">
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple1']['conjoint']['nom'] ?></span>
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple1']['conjoint']['prenom'] ?></span>
                                        <span class="person-dates"><?= $arbre['couples_gen3']['couple1']['conjoint']['dates'] ?></span>
                                    </div>
                                    
                                    <div class="box box-black" style="position: relative; z-index: 1;">
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple1']['enfant']['nom'] ?></span>
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple1']['enfant']['prenom'] ?></span>
                                        <span class="person-dates"><?= $arbre['couples_gen3']['couple1']['enfant']['dates'] ?></span>
                                    </div>
                                </div>

                                <div class="line-v" style="height: 15px;"></div>
                                
                                <!-- Enfants de Teresa -->
                                <div style="position: relative; display: flex; gap: 10px; margin-top: 15px;">
                                    <div style="position: absolute; top: -15px; left: 15%; right: 15%; height: 1px; background: #000;"></div>
                                    
                                    <?php foreach ($arbre['couples_gen3']['couple1']['enfants'] as $enfant): ?>
                                        <div style="display: flex; flex-direction: column; align-items: center; position: relative;">
                                            <div style="position: absolute; top: -15px; width: 1px; height: 15px; background: #000;"></div>
                                            <div class="box box-black">
                                                <span class="person-name"><?= $enfant['nom'] ?></span>
                                                <span class="person-name"><?= $enfant['prenom'] ?></span>
                                                <span class="person-dates"><?= $enfant['dates'] ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Bloc Droite (Centré sur THOMAS) -->
                            <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                                <div class="line-v" style="height: 15px;"></div>
                                
                                <div style="position: relative;">
                                    <div style="position: absolute; top: 50%; left: 100%; width: 25px; height: 1px; background: #000; z-index: 0;"></div>
                                    
                                    <div class="box box-red" style="position: absolute; left: calc(100% + 25px); top: 0; white-space: nowrap;">
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple2']['conjoint']['nom'] ?></span>
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple2']['conjoint']['prenom'] ?></span>
                                        <span class="person-dates"><?= $arbre['couples_gen3']['couple2']['conjoint']['dates'] ?></span>
                                    </div>
                                    
                                    <div class="box box-black" style="position: relative; z-index: 1;">
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple2']['enfant']['nom'] ?></span>
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple2']['enfant']['prenom'] ?></span>
                                        <span class="person-dates"><?= $arbre['couples_gen3']['couple2']['enfant']['dates'] ?></span>
                                    </div>
                                </div>

                                <div class="line-v" style="height: 15px;"></div>
                                
                                <!-- Enfants de Thomas -->
                                <div style="position: relative; display: flex; gap: 10px; margin-top: 15px;">
                                    <div style="position: absolute; top: -15px; left: 25%; right: 25%; height: 1px; background: #000;"></div>
                                    
                                    <?php foreach ($arbre['couples_gen3']['couple2']['enfants'] as $enfant): ?>
                                        <div style="display: flex; flex-direction: column; align-items: center; position: relative;">
                                            <div style="position: absolute; top: -15px; width: 1px; height: 15px; background: #000;"></div>
                                            <div class="box box-black" style="padding: 10px 20px;">
                                                <b><?= $enfant['nom'] ?></b>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-info">
                    <div><i>Klepnutím na podtržené jméno přejdete na rodopisný strom<br>příslušné osoby.</i></div>
                    <div class="separator"></div>
                    <div>En cliquant sur les noms soulignés, vous accédez à leur<br>propre arbre généalogique.</div>
                </div>
            </div>
            
            <table cellpadding="0" cellspacing="0" width="760">
                <tr>
                    <td width="760" height="15" style="FONT-SIZE: 1pt">&nbsp;</td>
                </tr>
            </table>

            <!-- COPYRIGHT ETENDU POUR LA VUE CONNECTEE -->
            <table cellpadding="0" cellspacing="0" width="760">
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                </tr>
                <tr>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                    <td width="24" align="middle" bgcolor="white" height="24"><IMG height=24 src="images/logo_24.gif" width=24 border=0></td>
                    <td width="680" height="25" align="middle" bgcolor="white" style="FONT-SIZE: 7pt">Copyright&nbsp;©&nbsp;2001-2004&nbsp;www.czech-genealogicka.org<br>Copyright&nbsp;©&nbsp;2003&nbsp;Loïc Web Design</td>
                    <td width="24" align="middle" bgcolor="white" height="24"><IMG height=24 src="images/logo_24.gif" width=24 border=0></td>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" width="760">
                <tr>
                    <td width="760" height="15" style="FONT-SIZE: 1pt">&nbsp;</td>
                </tr>
            </table>
        </td>

<?php else: ?>
        <!-- AFFICHAGE SIDEBAR ET ERREUR SI NON CONNECTÉ (2 colonnes) -->
        <td width="164">
            <table cellpadding="0" cellspacing="0" width="164">
                <tr>
                    <td width="16" height="16"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" width="132" bgcolor="white" style="FONT-SIZE: 1pt">&nbsp;</td>
                    <td width="16" height="16"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                </tr>
                <tr style="FONT-FAMILY: Arial">
                    <td width="16" bgcolor="white">&nbsp;</td>
                    <td width="132" bgcolor="white" valign="top" style="FONT-SIZE: 8pt">
                        <form method="post" action="check1.php">
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
           >Přezdívka&nbsp;/&nbsp;Identifiant</p>
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
           ><input name="ident1" style="BORDER-RIGHT: red 1px solid; BORDER-TOP: red 1px solid; FONT-SIZE: 10pt; BORDER-LEFT: red 1px solid; WIDTH: 132px; COLOR: navy; BORDER-BOTTOM: red 1px solid; FONT-FAMILY: Arial; BACKGROUND-COLOR: #fff4f4" 
           ></p>
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
           >Heslo&nbsp;/&nbsp;Mot de passe</p>
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
           ><input type="password" name="pwd1" style="BORDER-RIGHT: red 1px solid; BORDER-TOP: red 1px solid; FONT-SIZE: 10pt; BORDER-LEFT: red 1px solid; WIDTH: 103px; COLOR: navy; BORDER-BOTTOM: red 1px solid; FONT-FAMILY: Arial; BACKGROUND-COLOR: #fff4f4" 
           >&nbsp;<input type="submit" name="formbutton1" style="FONT-SIZE: 8pt; WIDTH: 25px; COLOR: navy; FONT-FAMILY: Arial" value="OK"></p>
                        </form>
                        <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
           ><A href="password.htm">Zapomměls heslo&nbsp;?<br>Mot de passe oublié&nbsp;?</a></p>
                    </td>
                    <td width="16" bgcolor="white">&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" width="132" bgcolor="white" style="FONT-SIZE: 1pt">&nbsp;</td>
                    <td width="16" height="16"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" height="95" width="164">
                <tr>
                    <td align="middle"><IMG height=66 src ="images/Sans titre-1.gif" width=99 border=0 ></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" width="164">
                <tr>
                    <td width="16" height="16"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" width="132" bgcolor="white" style="FONT-SIZE: 1pt">&nbsp;</td>
                    <td width="16" height="16"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                </tr>
                <tr style="FONT-FAMILY: Arial">
                    <td width="16" bgcolor="white">&nbsp;</td>
                    <td width="132" bgcolor="white" valign="top" style="FONT-SIZE: 8pt">
                        <form action="http://web.volny.cz/najdito/slovnik.php" name=f target="_blank">
                        <table cellpadding="0" cellspacing="0" width="132">
                            <tr>
                                <td width="132" align="middle" colspan="2" height="22" style="FONT-SIZE: 9pt" valign="top"><b>Slovník&nbsp;/&nbsp;Dictionnaire</b></td>
                            </tr>
                            <tr>
                                <td width="132" height="15" colspan="2"><IMG height=1 src="images/red.gif" width=132 border=0></td>
                            </tr>
                            <tr>
                                <td width="24" height="22"><input type=radio name=lang value=cz2fr checked></td>
                                <td width="108" height="22" style="FONT-SIZE: 8pt">česko-francouzský</td>
                            </tr>
                            <tr>
                                <td width="24" height="22"><input type=radio name=lang value=fr2cz></td>
                                <td width="108" height="22" style="FONT-SIZE: 8pt">franco-tchèque</td>
                            </tr>
                            <tr>
                                <td colspan="2" height="22" style="FONT-SIZE: 8pt">
                            		<p style="MARGIN-TOP: 4px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
                 >Výraz&nbsp;/&nbsp;Mot</p>
                            		<p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
                 ><input name="dotaz" style="BORDER-RIGHT: red 1px solid; BORDER-TOP: red 1px solid; FONT-SIZE: 10pt; BORDER-LEFT: red 1px solid; WIDTH: 103px; COLOR: navy; BORDER-BOTTOM: red 1px solid; FONT-FAMILY: Arial; BACKGROUND-COLOR: #fff4f4" 
                 >&nbsp;<input type="submit" name="ok" style="FONT-SIZE: 8pt; WIDTH: 25px; COLOR: navy; FONT-FAMILY: Arial" value="OK"><br><i><span style="FONT-SIZE: 7pt">bez výraz&nbsp;/&nbsp;sans accent</span></i></p>								
								</td>
                            </tr>
                        </table>
                        </form>						
                        <p align="center"><a href="http://web.volny.cz/" target="_blank"><IMG height=41 src="images/volny.png" width=132 border=0><br>web.volny.cz</a></p>
                    </td>
                    <td width="16" bgcolor="white">&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" width="132" bgcolor="white" style="FONT-SIZE: 1pt">&nbsp;</td>
                    <td width="16" height="16"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" height="15" width="164">
                <tr>
                    <td width="164" height="15" align="middle" style="FONT-SIZE: 1pt">&nbsp;</td>
                </tr>
            </table>			
			<table cellpadding="0" cellspacing="0" width="164">
                <tr>
                    <td width="16" height="16"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" width="132" bgcolor="white" style="FONT-SIZE: 1pt">&nbsp;</td>
                    <td width="16" height="16"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                </tr>
                <tr style="FONT-FAMILY: Arial">
                    <td width="16" bgcolor="white">&nbsp;</td>
                    <td width="132" bgcolor="white" valign="top" style="FONT-SIZE: 8pt">
                        <p align="center"><a href="http://www.centretcheque.org/" target="_blank"><IMG height=59 src="images/centretcheque.gif" width=132 border=0><br>www.centretcheque.org</a></p>
                        <p align="center"><a href="http://www.ifp.cz/ifp/pubCZ/home/Main/index.jet" target="_blank"><IMG height=127 src="images/ifp.jpg" width=132 border=0><br>www.ifp.cz</a></p>
                    </td>
                    <td width="16" bgcolor="white">&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" width="132" bgcolor="white" style="FONT-SIZE: 1pt">&nbsp;</td>
                    <td width="16" height="16"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" height="15" width="164">
                <tr>
                    <td width="164" height="15" align="middle" style="FONT-SIZE: 1pt">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td width="15" style="FONT-SIZE: 1pt">&nbsp;</td>
        <td width="581">
            
            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                </tr>
                <tr>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white" rowspan="2" 
         >&nbsp;</td>
                    <td width="258" align="middle" valign="top" bgcolor="white" style="FONT-SIZE: 8pt">
                        <p><i><b>VÝSLEDKY</b></i></p><i>
						<p><i>S ohledem na ochranu osobních údajů je zobrazení tohoto rodokmenu chráněno heslem. Toto heslo vám bylo zasláno e-mailem spolu s přizváním osoby, která tento rodokmen vytvořila.</i></p>
						<p><i><b>Přístup rodiny</b></i></p>
                    </td>
                    <td width="33" height="130" align="middle" valign="top" bgcolor="white"><IMG height="100%" src="images/red.gif" width=1 border=0></td>
                    <td width="258" align="middle" valign="top" bgcolor="white" style="FONT-SIZE: 8pt">
                        <p><b>RÉSULTAT</b></p>
                        <p>Par respect de la protection de la vie privée, la consultation de ces données est protégée par un mot de passe. Celui-ci vous a été délivré par e-mail lors de l'invitation lancée par la personne qui a créé cet arbre.</p>
                        <p><b>Accès Famille</b></p>
					</td>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white" rowspan="2" 
         >&nbsp;</td>
                </tr>
                <tr>
                    <td width="549" align="middle" valign="top" bgcolor="white" style="FONT-SIZE: 8pt" colspan="3">
                        <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 120%" 
           >&nbsp;</p>
                        <form method="post" action="check4.php" id=FORM1 name=FORM1>
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
           >Přezdívka&nbsp;/&nbsp;Identifiant</p>
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
           ><input name="ident2" style="BORDER-RIGHT: red 1px solid; BORDER-TOP: red 1px solid; FONT-SIZE: 10pt; BORDER-LEFT: red 1px solid; WIDTH: 189px; COLOR: navy; BORDER-BOTTOM: red 1px solid; FONT-FAMILY: Arial; BACKGROUND-COLOR: #fff4f4" 
           ></p>
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
           >Heslo&nbsp;/&nbsp;Mot de passe</p>
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%" 
           ><input type="password" name="pwd2" style="BORDER-RIGHT: red 1px solid; BORDER-TOP: red 1px solid; FONT-SIZE: 10pt; BORDER-LEFT: red 1px solid; WIDTH: 160px; COLOR: navy; BORDER-BOTTOM: red 1px solid; FONT-FAMILY: Arial; BACKGROUND-COLOR: #fff4f4" 
           >&nbsp;<input type="submit" style="FONT-SIZE: 8pt; WIDTH: 25px; COLOR: navy; FONT-FAMILY: Arial" value="OK" id=submit1 name=submit1></p>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
					<td width="581" height="15" style="FONT-SIZE: 1pt">&nbsp;</td>
				</tr>
			</table>
            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                </tr>
                <tr>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white" 
         >&nbsp;</td>
                    <td width="258" align="middle" valign="top" bgcolor="white" style="FONT-SIZE: 8pt">
                        <p><i><b>Heslo je neplatné!</b></i></p>
                    </td>
                    <td width="33" height="100%" align="middle" valign="top" bgcolor="white"><IMG height="100%" src="images/red.gif" width=1 border=0></td>
                    <td width="258" align="middle" valign="top" bgcolor="white" style="FONT-SIZE: 8pt">
                        <p><b>Mot de passe invalide&nbsp;!</b></p>
					</td>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white" 
         >&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
					<td width="581" height="15" style="FONT-SIZE: 1pt">&nbsp;</td>
				</tr>
			</table>
            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                </tr>
                <tr>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white" 
         >&nbsp;</td>
                    <td align="middle" valign="top" bgcolor="white"><a href="http://www.cesky-spolek.com"><IMG height=61 alt="Portail de la communauté Franco Tcheque" src="images/Cesky-Spolek.jpg" width=468 border=0></a></td>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white" 
         >&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>			
            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
					<td width="581" height="15" style="FONT-SIZE: 1pt">&nbsp;</td>
				</tr>
			</table>

            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                </tr>
                <tr>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white" 
         >&nbsp;</td>
                    <td width="24" align="middle" bgcolor="white" height="24"><IMG height=24 src="images/logo_24.gif" width=24 border=0></td>
                    <td width="501" height="25" align="middle" bgcolor="white" style="FONT-SIZE: 7pt">Copyright&nbsp;©&nbsp;2001-2004&nbsp;www.czech-genealogicka.org<br>Copyright&nbsp;©&nbsp;2003&nbsp;Loïc Web Design</td>
                    <td width="24" align="middle" bgcolor="white" height="24"><IMG height=24 src="images/logo_24.gif" width=24 border=0></td>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white" 
         >&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
					<td width="581" height="15" style="FONT-SIZE: 1pt">&nbsp;</td>
				</tr>
			</table>
        </td>
<?php endif; ?>
    </tr>
</table>
</body>
</html>