<?php
// Données de l'arbre généalogique
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
?>
<html>
<head>
<title>FRANCOUZSKO-ČESKÝ RODOPIS</title>
<meta name="generator" content="Namo WebEditor v6.0">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<style>
    /* Styles spécifiques pour l'arbre généalogique intégré dans l'ancien design */
    .tree-box-container {
        background-color: white;
        border: 1px solid #b0b0cc;
        border-radius: 12px;
        padding: 20px;
        width: 100%;
        box-sizing: border-box;
        margin-top: 10px;
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
    .intro-grid div {
        width: 45%;
    }
    .intro-grid .separator {
        width: 1px;
        background-color: red;
        height: 40px;
    }
    .tree-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }
    
    /* Configuration des cases */
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
    
    /* Lignes de liaison de base */
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
    .footer-info .separator {
        width: 1px;
        background-color: red;
        height: 20px;
    }
</style>
</head>
<body bgcolor="white" text="blue" link="blue" vlink="blue" alink="blue" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" background="images/img1.gif" style="SCROLLBAR-BASE-COLOR: #f0f0ff">
<table align="center" cellpadding="0" cellspacing="0" width="760" style="FONT-FAMILY: Verdana">
    <tr>
        <td colspan="3" width="760" height="14" style="FONT-SIZE: 1pt">&nbsp;</td>
    </tr>
    <!-- Menu -->
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
    <!-- Header -->
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
    
    <!-- ARBRE GÉNÉALOGIQUE -->
    <tr>
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
                            
                            <!-- Parents d'Anton (Génération 1) - Position absolue au-dessus d'Anton -->
                            <div style="position: absolute; bottom: calc(100% + 15px); left: 50%; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center;">
                                <div class="couple" style="gap: 15px;">
                                    <div class="line-h-couple"></div>
                                    <div class="box box-blue" style="padding: 6px 15px; z-index: 1;"><b><?= $arbre['gen1']['pere']['nom'] ?></b></div>
                                    <div class="box box-red" style="padding: 6px 15px; z-index: 1;"><b><?= $arbre['gen1']['mere']['nom'] ?></b></div>
                                    <!-- Trait vertical qui sort du milieu des parents et s'allonge jusqu'à Anton -->
                                    <div style="position: absolute; top: 50%; left: 50%; width: 1px; height: calc(50% + 15px); background: #000; transform: translateX(-50%); z-index: 0;"></div>
                                </div>
                            </div>
                            
                            <!-- Case Anton -->
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
                        <!-- Trait horizontal reliant les deux colonnes (de Teresa à Thomas) -->
                        <div style="position: absolute; top: 0; left: 25%; right: 25%; height: 1px; background: #000;"></div>
                        
                        <div style="width: 100%; display: flex;">
                            
                            <!-- Bloc Gauche (Centré sur TERESA) -->
                            <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                                <!-- Trait descendant jusqu'à Teresa -->
                                <div class="line-v" style="height: 15px;"></div>
                                
                                <div style="position: relative;">
                                    <!-- Trait horizontal rattachant Petr -->
                                    <div style="position: absolute; top: 50%; right: 100%; width: 25px; height: 1px; background: #000; z-index: 0;"></div>
                                    
                                    <!-- Petr (Greffé sur le côté de Teresa) -->
                                    <div class="box box-blue" style="position: absolute; right: calc(100% + 25px); top: 0; white-space: nowrap;">
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple1']['conjoint']['nom'] ?></span>
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple1']['conjoint']['prenom'] ?></span>
                                        <span class="person-dates"><?= $arbre['couples_gen3']['couple1']['conjoint']['dates'] ?></span>
                                    </div>
                                    
                                    <!-- Teresa (Le point central de l'alignement) -->
                                    <div class="box box-black" style="position: relative; z-index: 1;">
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple1']['enfant']['nom'] ?></span>
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple1']['enfant']['prenom'] ?></span>
                                        <span class="person-dates"><?= $arbre['couples_gen3']['couple1']['enfant']['dates'] ?></span>
                                    </div>
                                </div>

                                <!-- Trait descendant depuis le milieu de Teresa vers les enfants -->
                                <div class="line-v" style="height: 15px;"></div>
                                
                                <!-- Enfants de Teresa -->
                                <div style="position: relative; display: flex; gap: 10px; margin-top: 15px;">
                                    <!-- Ligne horizontale des enfants -->
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
                                <!-- Trait descendant jusqu'à Thomas -->
                                <div class="line-v" style="height: 15px;"></div>
                                
                                <div style="position: relative;">
                                    <!-- Trait horizontal rattachant Marina -->
                                    <div style="position: absolute; top: 50%; left: 100%; width: 25px; height: 1px; background: #000; z-index: 0;"></div>
                                    
                                    <!-- Marina (Greffée sur le côté de Thomas) -->
                                    <div class="box box-red" style="position: absolute; left: calc(100% + 25px); top: 0; white-space: nowrap;">
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple2']['conjoint']['nom'] ?></span>
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple2']['conjoint']['prenom'] ?></span>
                                        <span class="person-dates"><?= $arbre['couples_gen3']['couple2']['conjoint']['dates'] ?></span>
                                    </div>
                                    
                                    <!-- Thomas (Le point central de l'alignement) -->
                                    <div class="box box-black" style="position: relative; z-index: 1;">
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple2']['enfant']['nom'] ?></span>
                                        <span class="person-name"><?= $arbre['couples_gen3']['couple2']['enfant']['prenom'] ?></span>
                                        <span class="person-dates"><?= $arbre['couples_gen3']['couple2']['enfant']['dates'] ?></span>
                                    </div>
                                </div>

                                <!-- Trait descendant depuis le milieu de Thomas vers les enfants -->
                                <div class="line-v" style="height: 15px;"></div>
                                
                                <!-- Enfants de Thomas -->
                                <div style="position: relative; display: flex; gap: 10px; margin-top: 15px;">
                                    <!-- Ligne horizontale des enfants -->
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

        </td>
    </tr>
    
    <!-- Footer / Copyright -->
    <tr>
        <td colspan="3" width="760" height="15" style="FONT-SIZE: 1pt">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">
            <table cellpadding="0" cellspacing="0" width="760" align="center">
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
        </td>
    </tr>
</table>
</body>
</html>