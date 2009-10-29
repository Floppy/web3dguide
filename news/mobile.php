<?php
	$login_config_file = "$DOCUMENT_ROOT/config/vlogin_config.php";
	require_once("vlogin_core.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - Mobile Edition</TITLE>
<META NAME="HandheldFriendly" content="True">
</HEAD>
<BODY>
<?php

   if (!isset($mode)) {
      echo "<CENTER>\n";
      echo "<IMG SRC='/pics/mobilelogo.gif' ALT='Floppy&#39;s Web3D Guide'><BR>\n";
      echo "<H1>Floppy&#39;s Web3D Guide<BR>Mobile Edition</H1>\n";
      echo "web3d.vapourtech.com\n";
      echo "</CENTER><P>\n";
   }

	$event_config_file = "$DOCUMENT_ROOT/config/vevent_mobile_config.php";
	$news_config_file  = "$DOCUMENT_ROOT/config/vnews_mobile_config.php";
	$comment_config_file  = "$DOCUMENT_ROOT/config/vcomment_mobile_config.php";

	// Pull in the core news functions
	include_once("vnews_core.php");
	
   if (!isset($mode)) {
      echo "<CENTER>\n";
   }
   
   mobile_news_process();
   
   if (!isset($mode)) {
      echo "</CENTER>\n";
   }
	
   if (isset($mode)) {
      echo "<CENTER>\n";
      echo "<A HREF='mobile.php'>Back</A>\n";
      echo "</CENTER><P>\n";
   }

?>
<HR>
<STRONG>&copy; Copyright 1998-2002 Vapour Technology Ltd.<BR>www.vapourtech.com</STRONG>
</BODY>
</HTML>
