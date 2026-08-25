<?php
// webmail.php - In Memoriam 2 / Evidence : The Last Ritual
// Liste + volet de lecture, habillages d'epoque cales sur captures d'origine.
// Parametres (POST ou GET) : userid, m, skin

include("scriptIM2/credentials.php");

function val($k, $d = '') {
    if (isset($_POST[$k])) return $_POST[$k];
    if (isset($_GET[$k]))  return $_GET[$k];
    return $d;
}
// la base est en Windows-1252 : utf8_encode() casse les apostrophes typographiques
function txt($s) {
    return htmlspecialchars(mb_convert_encoding($s, 'UTF-8', 'Windows-1252'), ENT_QUOTES, 'UTF-8');
}
function dat($s, $court = false) {
    $t = strtotime($s);
    if (!$t) return htmlspecialchars($s);
    $mois = array(1=>'janv','févr','mars','avr','mai','juin','juil','août','sept','oct','nov','déc');
    if ($court) return date('j', $t) . ' ' . $mois[(int)date('n',$t)] . ' ' . date('H:i', $t);
    return date('j', $t).' '.$mois[(int)date('n',$t)].' '.date('Y à H:i:s', $t);
}

$userid = val('userid');
$msel   = val('m', '');
$skin   = val('skin', 'oe6');

$skins = array(
 'oe6' => array('nom'=>'Outlook Express 6',
   'dossiers'=>array('Boîte de réception','Boîte d\'envoi','Éléments envoyés','Éléments supprimés','Brouillons'),
   'outils'=>array('✉ Créer un message','↩ Répondre','↪ Répondre à tous','➜ Transférer','✕ Supprimer','⇅ Env./Rec.')),
 'hotmail' => array('nom'=>'MSN Hotmail',
   'dossiers'=>array('Inbox','Junk E-Mail','Drafts','Sent Messages','Trash Can'),
   'outils'=>array('✉ New','✕ Delete','⊘ Junk','🔍 Find','📁 Put in Folder','✉ Mark As Unread')),
 'caramail' => array('nom'=>'CaraMail',
   'dossiers'=>array('Écrire un message','Dossiers','Carnet d\'adresses','CaraPalette','Listes d\'information'),
   'outils'=>array('✉ Écrire','📁 Déplacer vers…','✔ Marquer comme…','⬇ Télécharger','✕ Supprimer')),
 'gmail' => array('nom'=>'Gmail 2004',
   'dossiers'=>array('Inbox','Starred','Sent Mail','All Mail','Spam','Trash'),
   'outils'=>array('Archive','Report Spam','More actions…')),
);
if (!isset($skins[$skin])) $skin = 'oe6';

function lien($u,$s,$m=null){
    $x='webmail.php?userid='.urlencode($u).'&skin='.urlencode($s);
    if($m!==null)$x.='&m='.intval($m);
    return htmlspecialchars($x);
}
?><!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Webmail</title>
<style>
*{box-sizing:border-box}
html,body{height:100%}
body{margin:0;font:13px Tahoma,Verdana,Arial,sans-serif;background:#fff;color:#000}
a{text-decoration:none}
#app{display:flex;flex-direction:column;height:100vh}
#zone{flex:1 1 auto;display:flex;min-height:0}
#cote{flex:0 0 200px;overflow:auto;padding:8px 0;font-size:13px}
#cote .grp{font-weight:bold;padding:6px 12px}
#cote .doss{padding:5px 12px 5px 26px}
#cote .doss.actif{font-weight:bold}
#centre{flex:1 1 auto;display:flex;flex-direction:column;min-width:0}
#liste{flex:0 0 42%;overflow:auto;min-height:120px}
#lecture{flex:1 1 auto;overflow:auto;background:#fff}
#lecture .dedans{padding:16px 22px}
table.msgs{width:100%;border-collapse:collapse;font-size:13px}
table.msgs th{text-align:left;padding:6px 10px;position:sticky;top:0;font-weight:bold;font-size:12px}
table.msgs td{padding:6px 10px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
table.msgs td a{display:block;color:inherit}
table.msgs td.ic{width:26px;text-align:center;padding:6px 2px}
.entete{padding:12px 22px;font-size:13px}
.entete div{margin:3px 0}
.entete b{display:inline-block;width:70px;text-align:right;margin-right:10px;font-weight:bold}
.corps{line-height:1.65;font-size:14px;margin-top:4px;white-space:normal}
.corps a{text-decoration:underline}
.vide{padding:28px;font-style:italic;color:#666}
#outils{padding:6px 12px;display:flex;gap:6px;align-items:center;flex-wrap:wrap;font-size:12px}
#outils .b{padding:3px 9px;cursor:default;border-radius:2px}
#etat{padding:5px 12px;font-size:12px;display:flex;gap:18px;align-items:center;flex-wrap:wrap}
#etat select{font:12px Tahoma,Arial,sans-serif}

/* ===== OUTLOOK EXPRESS 6 ===== */
body.oe6 #titre{background:linear-gradient(#0a5fd4,#4b96e8);color:#fff;font:bold 13px Tahoma;padding:5px 10px}
body.oe6 #outils{background:linear-gradient(#fdfdfd,#e6e3dc);border-bottom:1px solid #a0a0a0}
body.oe6 #outils .b{border:1px solid transparent}
body.oe6 #outils .b:hover{border:1px solid #b6bdd2;background:#e3eafc}
body.oe6 #bandeau{background:#fff;border-bottom:1px solid #a0a0a0;padding:6px 12px;font-weight:bold;color:#333}
body.oe6 #etat{background:#f1efe9;border-bottom:1px solid #d4d0c8}
body.oe6 #cote{background:#fff;border-right:1px solid #a0a0a0}
body.oe6 #cote .grp{background:#e6e3dc;border-bottom:1px solid #d4d0c8}
body.oe6 table.msgs th{background:linear-gradient(#fdfdfd,#ebe9e2);border-right:1px solid #c3c3bb;
  border-bottom:1px solid #a0a0a0;font-weight:normal}
body.oe6 table.msgs tr td{border-bottom:1px solid #f0f0f0}
body.oe6 table.msgs tr.nonlu td{font-weight:bold}
body.oe6 table.msgs tr:hover td{background:#eef3fa}
body.oe6 table.msgs tr.sel td{background:#316ac5;color:#fff}
body.oe6 .entete{background:#f1efe9;border-bottom:1px solid #a0a0a0}
body.oe6 a{color:#000}
body.oe6 .corps a{color:#0000c0}

/* ===== MSN HOTMAIL ===== */
body.hotmail{font-family:Verdana,Tahoma,Arial,sans-serif}
body.hotmail #titre{background:linear-gradient(#5aa0d0,#336799);color:#fff;padding:11px 16px;
  font:bold 19px Verdana;letter-spacing:.5px}
body.hotmail #titre sup{font-size:10px}
body.hotmail #bandeau{background:#4891C6;color:#fff;padding:6px 16px;font-size:12px}
body.hotmail #outils{background:#fff;border-bottom:1px solid #cfe2ef}
body.hotmail #outils .b{color:#336799}
body.hotmail #etat{background:#f4f9fc;border-bottom:1px solid #DAEBF5}
body.hotmail #cote{background:#DAEBF5;border-right:1px solid #b9d4e6}
body.hotmail #cote .grp,body.hotmail #cote .doss{color:#336799}
body.hotmail table.msgs th{background:#DAEBF5;color:#336799;border-bottom:2px solid #336799;font-weight:normal}
body.hotmail table.msgs tr td{border-bottom:1px solid #eef4f8}
body.hotmail table.msgs tr.nonlu td{background:#FEF7E5;font-weight:bold}
body.hotmail table.msgs tr.sel td{background:#336799;color:#fff}
body.hotmail table.msgs tr.sel a{color:#fff}
body.hotmail .entete{background:#DAEBF5;border-bottom:1px solid #b9d4e6}
body.hotmail a{color:#336799}

/* ===== CARAMAIL ===== */
body.caramail{font-family:Arial,Helvetica,sans-serif}
body.caramail #titre{background:#000;color:#fff;padding:9px 14px;font:bold 17px Arial}
body.caramail #titre span{color:#FFD031}
body.caramail #onglets{background:#4F70C0;color:#fff;padding:0 6px;font-size:12px}
body.caramail #onglets span{padding:6px 13px;display:inline-block}
body.caramail #onglets span.on{background:#243a80;font-weight:bold}
body.caramail #bandeau{background:#4F70C0;color:#fff;padding:6px 14px;font-weight:bold;border-top:1px solid #7f97d6}
body.caramail #outils{background:#EFF7FF;border-bottom:1px solid #CEE7FF}
body.caramail #outils .b{border:1px solid #CEE7FF;background:#fff}
body.caramail #etat{background:#fff;border-bottom:1px solid #CEE7FF}
body.caramail #cote{background:#EFF7FF;border-right:1px solid #CEE7FF}
body.caramail #cote .grp{background:#CEE7FF;color:#243a80}
body.caramail #cote .doss{color:#243a80}
body.caramail table.msgs th{background:#4F70C0;color:#fff}
body.caramail table.msgs tr:nth-child(even) td{background:#EFF7FF}
body.caramail table.msgs tr td{border-bottom:1px solid #dceaf9}
body.caramail table.msgs tr.nonlu td{font-weight:bold}
body.caramail table.msgs tr.sel td{background:#FFD031;color:#000}
body.caramail .entete{background:#EFF7FF;border:1px solid #CEE7FF;margin:12px 22px 0;padding:12px}
body.caramail a{color:#243a80}

/* ===== GMAIL 2004 ===== */
body.gmail{font-family:Arial,sans-serif;font-size:13px}
body.gmail #titre{padding:10px 14px;font:bold 26px Arial;color:#c00;letter-spacing:-1px}
body.gmail #titre span{color:#333;font-size:11px;font-weight:normal;letter-spacing:0}
body.gmail #outils{background:#fff;border-bottom:1px solid #C6DDFF}
body.gmail #outils .b{border:1px solid #b5b5b5;background:linear-gradient(#fff,#eee);border-radius:3px}
body.gmail #etat{background:#C6DDFF}
body.gmail #cote{background:#fff;border-right:1px solid #EFEFEF}
body.gmail #cote .grp{color:#c00;font-size:14px}
body.gmail table.msgs th{background:#EFEFEF;color:#666;font-weight:normal;border-bottom:1px solid #C6DDFF}
body.gmail table.msgs tr td{border-bottom:1px solid #EFEFEF}
body.gmail table.msgs tr.nonlu td{font-weight:bold;background:#fff}
body.gmail table.msgs tr:hover td{background:#f7f7f7}
body.gmail table.msgs tr.sel td{background:#C6DDFF}
body.gmail .entete{border-bottom:1px solid #EFEFEF}
body.gmail a{color:#0000cc}
</style></head>
<body class="<?php echo htmlspecialchars($skin); ?>">
<?php
$conn = new mysqli($servername, $username, $password, "last_ritual_db");
if ($conn->connect_error) { echo '<div class="vide"><b>ERREUR</b> — base inaccessible. <a href="index.php">Retour</a></div></body></html>'; exit; }
$tb = "messages_" . lastritual_encode($userid);
$sql = "SELECT fromname, fromadr, subject, body, time, delai,
        FROM_UNIXTIME(UNIX_TIMESTAMP(time)+delai) FROM ".$tb."
        WHERE UNIX_TIMESTAMP(time)+delai <= UNIX_TIMESTAMP()
        ORDER BY UNIX_TIMESTAMP(time)+delai DESC";
$msgs=array();
if($r=$conn->query($sql)){ while($x=$r->fetch_row())$msgs[]=$x; $r->close(); }
else { echo '<div class="vide"><b>ERREUR</b> — messages introuvables.</div>'; $conn->close(); echo '</body></html>'; exit; }
$conn->close();
$n=count($msgs); $sel=($msel==='')?0:intval($msel); if($sel<0||$sel>=$n)$sel=0;
$u=htmlspecialchars($userid); $S=$skins[$skin];
?>
<div id="app">
<?php if($skin==='oe6'): ?>
  <div id="titre">Boîte de réception - Outlook Express</div>
<?php elseif($skin==='hotmail'): ?>
  <div id="titre">msn<sup>M</sup> Hotmail</div>
  <div id="bandeau"><?php echo $u; ?>@hotmail.com &nbsp;·&nbsp; Messenger : <b>Online</b></div>
<?php elseif($skin==='caramail'): ?>
  <div id="titre">LYCOS <span>CaraMail</span></div>
  <div id="onglets"><span>Accueil</span><span>Recherche</span><span>Chaînes</span><span class="on">Caramail</span><span>MultiMania</span><span>Mobile</span><span>Shopping</span></div>
<?php else: ?>
  <div id="titre">Gmail <span>by Google &nbsp;BETA</span></div>
<?php endif; ?>

<div id="outils">
  <?php foreach($S['outils'] as $b): ?><span class="b"><?php echo $b; ?></span><?php endforeach; ?>
</div>

<?php if($skin==='oe6'): ?><div id="bandeau">📁 Boîte de réception</div>
<?php elseif($skin==='caramail'): ?><div id="bandeau">Vous êtes ici : Mail &gt; Boîte de réception</div><?php endif; ?>

<div id="etat">
  <a href="index.php">&lt; Accueil</a>
  <span>Utilisateur : <b><?php echo $u; ?></b></span>
  <span><b><?php echo $n; ?></b> message<?php echo $n>1?'s':''; ?></span>
  <a href="<?php echo lien($userid,$skin,$sel); ?>">Actualiser</a>
  <form method="get" action="webmail.php" style="display:inline">
    <input type="hidden" name="userid" value="<?php echo $u; ?>">
    <input type="hidden" name="m" value="<?php echo $sel; ?>">
    <select name="skin" onchange="this.form.submit()">
    <?php foreach($skins as $k=>$s): ?><option value="<?php echo $k; ?>"<?php if($k===$skin)echo ' selected'; ?>><?php echo $s['nom']; ?></option><?php endforeach; ?>
    </select><noscript><input type="submit" value="OK"></noscript>
  </form>
</div>

<div id="zone">
  <div id="cote">
    <div class="grp"><?php echo $skin==='gmail'?'Compose Mail':'Dossiers'; ?></div>
    <?php foreach($S['dossiers'] as $i=>$d): ?>
      <div class="doss<?php echo $i===0?' actif':''; ?>"><?php echo htmlspecialchars($d); ?><?php if($i===0&&$n) echo ' ('.$n.')'; ?></div>
    <?php endforeach; ?>
  </div>
  <div id="centre">
    <div id="liste">
    <?php if(!$n): ?><div class="vide">Aucun message pour le moment.</div><?php else: ?>
      <table class="msgs">
        <tr><th style="width:26px"></th><th style="width:24%">Expéditeur</th><th>Objet</th><th style="width:150px">Date</th></tr>
        <?php foreach($msgs as $i=>$r): $cl=($i===$sel)?'sel':($i<2?'nonlu':''); $L=lien($userid,$skin,$i); ?>
        <tr class="<?php echo $cl; ?>">
          <td class="ic"><a href="<?php echo $L; ?>"><?php echo $i<2?'✉':'📩'; ?></a></td>
          <td><a href="<?php echo $L; ?>"><?php echo txt($r[0]); ?></a></td>
          <td><a href="<?php echo $L; ?>"><?php echo txt($r[2]); ?></a></td>
          <td><a href="<?php echo $L; ?>"><?php echo dat($r[6],true); ?></a></td>
        </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
    </div>
    <div id="lecture">
    <?php if($n): $r=$msgs[$sel]; ?>
      <div class="entete">
        <div><b>De :</b><?php echo txt($r[0]); ?> &lt;<?php echo txt($r[1]); ?>&gt;</div>
        <div><b>Date :</b><?php echo dat($r[6]); ?></div>
        <div><b>Objet :</b><b style="width:auto;text-align:left;margin:0"><?php echo txt($r[2]); ?></b></div>
      </div>
      <div class="dedans"><div class="corps"><?php
        echo nl2br(preg_replace('#((?:https?://|www\.)[^\s<]+)#i','<a href="http://$1">$1</a>', txt($r[3])));
      ?></div></div>
    <?php endif; ?>
    </div>
  </div>
</div>
</div>
</body></html>
