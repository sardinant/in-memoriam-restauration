<?php
$login_ok = false;

// Vérification de la combinaison d'identifiants
if (isset($_POST['ident2']) && isset($_POST['pwd2'])) {
    $ident = strtoupper(trim($_POST['ident2']));
    $pwd = trim($_POST['pwd2']);
    if ($ident === 'CAROLINA' && $pwd === 'JABAMIAH') {
        $login_ok = true;
    }
} else {
    // Accès direct à la page
    $login_ok = true;
}
?>
<html>
<head>
<title>FRANCOUZSKO-ČESKÝ RODOPIS - Carolina Molikova</title>
<meta name="generator" content="Namo WebEditor v6.0">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<style type="text/css">
  .box-blue {
      border: 1px solid #000080;
      background-color: #F4F6FC;
      color: #000080;
      font-family: Arial, sans-serif;
      font-size: 8pt;
      text-align: center;
      padding: 3px 2px;
      line-height: 115%;
  }
  .box-red {
      border: 1px solid #800000;
      background-color: #FFF4F4;
      color: #800000;
      font-family: Arial, sans-serif;
      font-size: 8pt;
      text-align: center;
      padding: 3px 2px;
      line-height: 115%;
  }
  .box-block {
      background-color: #000080;
      width: 10px;
  }
</style>
</head>
<body bgcolor="white" text="blue" link="blue" vlink="blue" alink="blue" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" background="images/img1.gif" style="SCROLLBAR-BASE-COLOR: #f0f0ff">

<table align="center" cellpadding="0" cellspacing="0" width="760" style="FONT-FAMILY: Verdana">
    <tr>
        <td colspan="3" width="760" height="14" style="FONT-SIZE: 1pt">&nbsp;</td>
    </tr>
    <!-- MENU ENTÊTE -->
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
    <!-- BANNIÈRE -->
    <tr>
        <td height="96" width="760" colspan="3">
            <table cellpadding="0" cellspacing="0" width="760" height="97">
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td width="260" height="97" bgcolor="white" rowspan="3"><IMG height=96 src="images/title.gif" width=243 border=0></td>
                    <td width="96" height="97" bgcolor="white" rowspan="3" align="middle"><IMG height=64 src="images/logo_64.gif" width=64 border=0></td>
                    <td width="372" height="97" bgcolor="white" style="FONT-SIZE: 11pt" align="right" rowspan="3">
                        <p><i>První francouzsko-český rodopisný server</i></p>
                        <p>Le 1<span style="FONT-SIZE: 9pt"><sup>er</sup></span> site franco-tchèque de généalogie</p>
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
        <!-- COLONNE GAUCHE -->
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
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%">Přezdívka&nbsp;/&nbsp;Identifiant</p>
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%"><input name="ident1" style="BORDER-RIGHT: red 1px solid; BORDER-TOP: red 1px solid; FONT-SIZE: 10pt; BORDER-LEFT: red 1px solid; WIDTH: 132px; COLOR: navy; BORDER-BOTTOM: red 1px solid; FONT-FAMILY: Arial; BACKGROUND-COLOR: #fff4f4"></p>
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%">Heslo&nbsp;/&nbsp;Mot de passe</p>
                            <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%"><input type="password" name="pwd1" style="BORDER-RIGHT: red 1px solid; BORDER-TOP: red 1px solid; FONT-SIZE: 10pt; BORDER-LEFT: red 1px solid; WIDTH: 103px; COLOR: navy; BORDER-BOTTOM: red 1px solid; FONT-FAMILY: Arial; BACKGROUND-COLOR: #fff4f4">&nbsp;<input type="submit" name="formbutton1" style="FONT-SIZE: 8pt; WIDTH: 25px; COLOR: navy; FONT-FAMILY: Arial" value="OK"></p>
                        </form>
                        <p style="MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%"><A href="password.htm">Zapomměls heslo&nbsp;?<br>Mot de passe oublié&nbsp;?</a></p>
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
                    <td align="middle"><IMG height=66 src="images/Sans titre-1.gif" width=99 border=0></td>
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
        </td>

        <td width="15" style="FONT-SIZE: 1pt">&nbsp;</td>

        <!-- COLONNE DROITE -->
        <td width="581">
            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                </tr>
                <tr>
                    <td width="16" bgcolor="white">&nbsp;</td>
                    <td width="549" align="center" valign="top" bgcolor="white" style="FONT-SIZE: 8pt" colspan="3">

<?php if ($login_ok): ?>
                        <!-- AFFICHAGE DE L'ARBRE (SI ACCÈS VALIDE) -->
                        <p style="font-size:11pt; color:blue; font-weight:bold; margin-top:5px; margin-bottom:12px;">Carolina Molikova</p>
                        
                        <table cellpadding="0" cellspacing="0" width="530" style="font-size:8pt;">
                            <tr>
                                <td width="245" align="center" valign="top">
                                    <i>Carolina Molikova - vítejte v rodopisu.<br>
                                    Aktuálně jsou zde 4 osoby na seznamu RODINA.<br>
                                    Chcete-li kontaktovat tuto osobu, klepněte ZDE.</i>
                                </td>
                                <td width="40" align="center" valign="middle">
                                    <img src="images/red.gif" width="1" height="40" border="0">
                                </td>
                                <td width="245" align="center" valign="top">
                                    <i>Bienvenue dans la généalogie de Carolina Molikova.<br>
                                    Actuellement, 4 personnes sont dans sa liste FAMILLE.<br>
                                    Pour contacter cette personne, cliquez ICI.</i>
                                </td>
                            </tr>
                        </table>

                        <br>

                        <!-- STRUCTURE DE L'ARBRE SANS LIENS -->
                        <table cellpadding="0" cellspacing="0" border="0" align="center" style="font-family:Arial; font-size:8pt;">
                            <!-- GÉNÉRATION 1 -->
                            <tr>
                                <td align="center">
                                    <table cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td class="box-blue" width="80" height="24" align="center" valign="middle">◆</td>
                                            <td class="box-block" width="10"></td>
                                            <td class="box-red" width="80" height="24" align="center" valign="middle">◆</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center"><div style="height:12px; width:1px; background:#000080; margin:0 auto;"></div></td>
                            </tr>

                            <!-- GÉNÉRATION 2 -->
                            <tr>
                                <td align="center">
                                    <table cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td class="box-blue" width="90" align="center" valign="middle">Anton<br><b>MÁLKO</b><br><span style="font-weight:normal; font-size:7pt;">(1902-1982)</span></td>
                                            <td class="box-block" width="10"></td>
                                            <td class="box-red" width="90" align="center" valign="middle">Gabriela<br><b>LÉKOVÁ</b><br><span style="font-weight:normal; font-size:7pt;">(1903-1993)</span></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center"><div style="height:12px; width:1px; background:#000080; margin:0 auto;"></div></td>
                            </tr>

                            <!-- EMBANCHEMENT HORIZONTAL -->
                            <tr>
                                <td align="center">
                                    <table cellpadding="0" cellspacing="0" border="0" width="220">
                                        <tr>
                                            <td width="100%" height="1" style="background:#000080;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <!-- GÉNÉRATION 3 (COUPLES) -->
                            <tr>
                                <td align="center">
                                    <table cellpadding="0" cellspacing="0" border="0">
                                        <tr valign="top">
                                            <!-- COUPLE GAUCHE -->
                                            <td align="center">
                                                <div style="height:10px; width:1px; background:#000080; margin:0 auto;"></div>
                                                <table cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td class="box-red" width="85" align="center">Petr<br><b>MOLIK</b><br><span style="font-weight:normal; font-size:7pt;">(1921-1999)</span></td>
                                                        <td class="box-block" width="10"></td>
                                                        <td class="box-blue" width="85" align="center">Teresa<br><b>MÁLKOVA</b><br><span style="font-weight:normal; font-size:7pt;">(1926-1996)</span></td>
                                                    </tr>
                                                </table>

                                                <!-- GÉNÉRATION 4 GAUCHE (3 ENFANTS) -->
                                                <div style="height:12px; width:1px; background:#000080; margin:0 auto;"></div>
                                                <table cellpadding="0" cellspacing="0" border="0" width="130">
                                                    <tr><td height="1" style="background:#000080;"></td></tr>
                                                </table>
                                                <table cellpadding="0" cellspacing="0" border="0">
                                                    <tr valign="top">
                                                        <td align="center">
                                                            <div style="height:8px; width:1px; background:#000080; margin:0 auto;"></div>
                                                            <div class="box-blue" style="width:58px; padding:3px 2px;">Alan<br><b>MOLIK</b><br><span style="font-weight:normal; font-size:7pt;">(1947)</span></div>
                                                        </td>
                                                        <td width="4"></td>
                                                        <td align="center">
                                                            <div style="height:8px; width:1px; background:#000080; margin:0 auto;"></div>
                                                            <div class="box-blue" style="width:64px; padding:3px 2px;">Simona<br><b>MOLIKOVÁ</b><br><span style="font-weight:normal; font-size:7pt;">(1949)</span></div>
                                                        </td>
                                                        <td width="4"></td>
                                                        <td align="center">
                                                            <div style="height:8px; width:1px; background:#000080; margin:0 auto;"></div>
                                                            <div class="box-blue" style="width:64px; padding:3px 2px;">Bodhan<br><b>MOLIK</b><br><span style="font-weight:normal; font-size:7pt;">(1954-1996)</span></div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td width="30"></td>

                                            <!-- COUPLE DROITE -->
                                            <td align="center">
                                                <div style="height:10px; width:1px; background:#000080; margin:0 auto;"></div>
                                                <table cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td class="box-blue" width="95" align="center">Thomas Anton<br><b>MÁLKO</b><br><span style="font-weight:normal; font-size:7pt;">(1938-19xx)</span></td>
                                                        <td class="box-block" width="10"></td>
                                                        <td class="box-red" width="85" align="center">Marina<br><b>KOPECKOVÁ</b><br><span style="font-weight:normal; font-size:7pt;">(◆)</span></td>
                                                    </tr>
                                                </table>

                                                <!-- GÉNÉRATION 4 DROITE (2 ENFANTS) -->
                                                <div style="height:12px; width:1px; background:#000080; margin:0 auto;"></div>
                                                <table cellpadding="0" cellspacing="0" border="0" width="70">
                                                    <tr><td height="1" style="background:#000080;"></td></tr>
                                                </table>
                                                <table cellpadding="0" cellspacing="0" border="0">
                                                    <tr valign="top">
                                                        <td align="center">
                                                            <div style="height:8px; width:1px; background:#000080; margin:0 auto;"></div>
                                                            <div class="box-blue" style="width:48px; height:28px; line-height:28px; padding:0;">◆</div>
                                                        </td>
                                                        <td width="16"></td>
                                                        <td align="center">
                                                            <div style="height:8px; width:1px; background:#000080; margin:0 auto;"></div>
                                                            <div class="box-blue" style="width:48px; height:28px; line-height:28px; padding:0;">◆</div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <br><br>

                        <!-- PIED DE PAGE ARBRE -->
                        <table cellpadding="0" cellspacing="0" width="530" style="font-size:7.5pt; margin-bottom:10px;">
                            <tr>
                                <td width="245" align="center" valign="top">
                                    <i>Klepnutím na podtržené jméno přejdete na rodopisný strom příslušné osoby.</i>
                                </td>
                                <td width="40" align="center" valign="middle">
                                    <img src="images/red.gif" width="1" height="25" border="0">
                                </td>
                                <td width="245" align="center" valign="top">
                                    <i>En cliquant sur les noms soulignés, vous accédez à leur propre arbre généalogique.</i>
                                </td>
                            </tr>
                        </table>

<?php else: ?>
                        <!-- ERREUR SI MAUVAIS MOT DE PASSE -->
                        <table cellpadding="0" cellspacing="0" width="581">
                            <tr>
                                <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                                <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                                <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                            </tr>
                            <tr>
                                <td width="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                                <td width="258" align="middle" valign="top" bgcolor="white" style="FONT-SIZE: 8pt">
                                    <p><i><b>Heslo je neplatné!</b></i></p>
                                </td>
                                <td width="33" height="100%" align="middle" valign="top" bgcolor="white"><IMG height="100%" src="images/red.gif" width=1 border=0></td>
                                <td width="258" align="middle" valign="top" bgcolor="white" style="FONT-SIZE: 8pt">
                                    <p><b>Mot de passe invalide&nbsp;!</b></p>
                                </td>
                                <td width="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                                <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                                <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                            </tr>
                        </table>
<?php endif; ?>

                    </td>
                    <td width="16" bgcolor="white">&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" width="581">
                <tr><td width="581" height="15" style="FONT-SIZE: 1pt">&nbsp;</td></tr>
            </table>

            <!-- BANNIÈRE -->
            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hd.gif" width=16 border=0></td>
                </tr>
                <tr>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                    <td align="middle" valign="top" bgcolor="white"><a href="http://www.cesky-spolek.com"><IMG height=61 alt="Portail de la communauté Franco Tcheque" src="images/Cesky-Spolek.jpg" width=468 border=0></a></td>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" width="581">
                <tr><td width="581" height="15" style="FONT-SIZE: 1pt">&nbsp;</td></tr>
            </table>

            <!-- FOOTER -->
            <table cellpadding="0" cellspacing="0" width="581">
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/hg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
                <tr>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                    <td width="24" align="middle" bgcolor="white" height="24"><IMG height=24 src="images/logo_24.gif" width=24 border=0></td>
                    <td width="501" height="25" align="middle" bgcolor="white" style="FONT-SIZE: 7pt">Copyright&nbsp;©&nbsp;2001-2004&nbsp;www.czech-genealogicka.org<br>Copyright&nbsp;©&nbsp;2003&nbsp;Loïc Web Design</td>
                    <td width="24" align="middle" bgcolor="white" height="24"><IMG height=24 src="images/logo_24.gif" width=24 border=0></td>
                    <td width="16" style="FONT-SIZE: 1pt" bgcolor="white">&nbsp;</td>
                </tr>
                <tr>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bg.gif" width=16 border=0></td>
                    <td height="16" style="FONT-SIZE: 1pt" bgcolor="white" colspan="3">&nbsp;</td>
                    <td width="16" height="16" style="FONT-SIZE: 1pt"><IMG height=16 src="images/bd.gif" width=16 border=0></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>