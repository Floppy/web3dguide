<?php 
   $login_config_file = "/www/web3d/www/config/vlogin_config.php";
   require_once("vlogin_core.php"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - Account Management</title>
<META NAME="DESCRIPTION" CONTENT="Guide to the world of VRML, with one of the best tutorials on the web.">
<META NAME="KEYWORDS" CONTENT="VRML, VRML97, Virtual Reality Modeling Language,	Tutorial, Guide, 3D,
				Computer Graphics, Web3D, Java, JavaScript, ECMAScript, Virtual Reality, Tools,
				Internet 3D, VRML Worlds, VRML Tutorial, Web3D Guide, 3D Worlds, Cyberspace, VRML Tools">
</HEAD>
<BODY BGCOLOR='#DDDDDD' TEXT='#000000' link="#ff0000" alink="#ffff00" VLINK="#DD0000">

<CENTER>
<H1>Account Management</H1>
<P>
<?php
   login_process();
?>
</P>
</CENTER>

<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="/utils/footer.js"></SCRIPT>
<SCRIPT TYPE="text/javascript">
footer('/pics/menu_lit/sitemap.gif','Sitemap','/sitemap.html');
</SCRIPT> 

</BODY>
</HTML>
