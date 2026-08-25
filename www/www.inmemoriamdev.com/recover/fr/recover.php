<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>IN MEMORIAM 2</title>
<style type="text/css">
<!--
.Style1 {
	color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Style2 {
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	text-decoration:none;
	font-size: 12px;
}
body {
	background-color: #000000;
}
.bloc {
border:1px;
border-color:#777777; 
border-width:thin;

}

</style>
</head>

<body>
<br>
<table width="330" border="0" align="center" cellpadding="0" cellspacing="3">
  <tr>
    <td height="30" bgcolor="#005890">
      <div align="center" class="Style1">IN MEMORIAM 2 - LE DERNIER RITUEL </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form action="arecover.php" method="post" name="supprim" id="supprim">
      <table width="330" align="center" class="bloc">
	  <tr><td>
	  <table width="320" border="0" align="center" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td width="240" align="right"><span class="Style1">LOGIN</span>
            <input name="login" type="text" id="login23"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td width="240" align="right"><span class="Style1">MOT DE PASSE
            </span>            <input name="mdp" type="text" id="mdp22"></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="#A1BCDA">
          <td height="20" colspan="3"><div align="center">
            <input name="action" type="hidden" id="action" value="1">
            <a href="#" class="Style2" onClick="document.forms.supprim.submit();">SUPPRIMER SON COMPTE</a> </div></td>
        </tr>
      </table></td></tr></table>
      </form>      </td>
  </tr>
  <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td>
	<form action="arecover.php" method="post" name="envoimdp" id="envoimdp">  
	  <table width="330" align="center"  cellpadding="0"  class="bloc" >
	    <tr><td>
  <input name="action" type="hidden" id="action" value="2"><table width="320" border="0" align="center" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td width="240" align="right"><span class="Style1">EMAIL
            </span>
          <input name="email" type="text" id="email"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20" colspan="3" bgcolor="#A1BCDA"><div align="center">            <a href="#" class="Style2"  onClick="document.forms.envoimdp.submit();">RECEVOIR MON MOT DE PASSE </a> </div></td>
      </tr>
    </table>
	</td></tr></table></form>
    </td>
  </tr>
  <tr>
    <td  height="10">
	</td></tr>
  <tr>
    <td><form action="arecover.php" method="post" name="codesms" id="codesms">  <table width="330" align="center"  cellpadding="0"  class="bloc" >
      <tr><td>
    <input name="action" type="hidden" id="action" value="3"><table width="320" border="0" align="center" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td width="240" align="right"><span class="Style1">LOGIN</span>
            <input name="login" type="text" id="login25"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="240" align="right"><span class="Style1">MOT DE PASSE </span>
            <input name="mdp" type="text" id="mdp24"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="20" colspan="3" bgcolor="#A1BCDA"><div align="center"><a href="#" class="Style2"  onClick="document.forms.codesms.submit();">RECEVOIR MON MOT DE PASSE SMS </a> </div></td>
      </tr>
    </table></td></tr></table>
    </form></td>
  </tr>
</table>
</body>
</html>
