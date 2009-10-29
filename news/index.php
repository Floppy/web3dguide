<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - News</TITLE>
<META NAME="DESCRIPTION" CONTENT="Guide to the world of VRML, with one of the best tutorials on the web.">
<META NAME="KEYWORDS" CONTENT="VRML, VRML97, Virtual Reality Modeling Language,	Tutorial, Guide, 3D,
				Computer Graphics, Web3D, Java, JavaScript, ECMAScript, Virtual Reality,
				Internet 3D, VRML Worlds, VRML Tutorial, Web3D Guide, 3D Worlds, Cyberspace">
</HEAD>
<BODY BGCOLOR='#DDDDDD' TEXT='#000000' LINK="#ff0000" ALINK="#ffff00" VLINK="#DD0000">
<P>
<CENTER><IMG SRC='/pics/titles/news.gif' WIDTH='147' HEIGHT='60' ALT='News'></CENTER>
<P>
<?php

	$news_config_file = "$DOCUMENT_ROOT/config/vnews_config.php";
	$auth_config_file = "$DOCUMENT_ROOT/config/vauth_config.php";
	$comment_config_file = "$DOCUMENT_ROOT/config/vcomment_config.php";
	$login_config_file = "$DOCUMENT_ROOT/config/vlogin_config.php";

	// Pull in the core news functions
	include_once("vnews_core.php");
	include_once("vlogin_core.php");

   $news_format[search_box][start] = "<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0' BORDER='0' CLASS='ITEMBORDER' BGCOLOR='#BB0000'>\n";
   $news_format[search_box][end]   = "</TABLE>\n";

	if (!isset($mode)) $mode = "list";
	news_process();
	
?>
<P>

<SCRIPT TYPE="text/javascript" SRC="/utils/footer.js">
</SCRIPT><SCRIPT TYPE="text/javascript">
footer('/pics/menu_lit/sitemap.gif','Sitemap','/sitemap.html');
</SCRIPT> 

</BODY>
</HTML>