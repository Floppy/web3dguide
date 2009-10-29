<?php 
   $login_config_file = "/www/web3d/www/config/vlogin_config.php";
   require_once("vlogin_core.php"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - Post A Comment</title>
<META NAME="DESCRIPTION" CONTENT="Guide to the world of VRML, with one of the best tutorials on the web.">
<META NAME="KEYWORDS" CONTENT="VRML, VRML97, Virtual Reality Modeling Language,	Tutorial, Guide, 3D,
				Computer Graphics, Web3D, Java, JavaScript, ECMAScript, Virtual Reality, Tools,
				Internet 3D, VRML Worlds, VRML Tutorial, Web3D Guide, 3D Worlds, Cyberspace, VRML Tools">
</HEAD>
<BODY BGCOLOR='#DDDDDD' TEXT='#000000' link="#ff0000" alink="#ffff00" VLINK="#DD0000">

<?php
   if ($login_userid) {
      $result = login_get_from_id($login_userid);
      echo "<P>Logged on as '{$result[nick]}' - <A HREF='/login.php'>Log out</A></P>\n";
   }
   else {
      echo "<P>Not currently logged on - <A HREF='/login.php'>Login or Register</A></P>\n";
   }
?>

<?php
   $comment_config_file = "/www/web3d/www/config/vcomment_config.php";
   require_once("vcomment_core.php");
   
   echo "<p>Due to abuse, the comment facility is currently disabled, sorry!</p>";
   //comment_process();
?>

<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="/utils/footer.js"></SCRIPT>
<SCRIPT TYPE="text/javascript">
footer('/pics/menu_lit/sitemap.gif','Sitemap','/sitemap.html');
</SCRIPT> 

</BODY>
</HTML>
