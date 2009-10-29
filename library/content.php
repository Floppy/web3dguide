<?php
	$login_config_file = "$DOCUMENT_ROOT/config/vlogin_config.php";
	require_once("vlogin_core.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - The VRML Developer's Library</TITLE>
<META NAME="DESCRIPTION" CONTENT="Guide to the world of VRML, with one of the best tutorials on the web.">
<META NAME="KEYWORDS" CONTENT="VRML, VRML97, Virtual Reality Modeling Language,	Tutorial, Guide, 3D, FAQ,
				Computer Graphics, Web3D, Java, JavaScript, ECMAScript, Virtual Reality,
				Internet 3D, VRML Worlds, VRML Tutorial, Web3D Guide, 3D Worlds, Cyberspace">
</HEAD>
<SCRIPT TYPE="text/vbscript" LANGUAGE="VBScript" SRC="/utils/detectvrml.vbs"></SCRIPT>
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="/utils/detectvrml.js"></SCRIPT>
<BODY BGCOLOR='#DDDDDD' TEXT='#000000' LINK="#ff0000" ALINK="#ffff00" VLINK="#DD0000">
<CENTER><IMG SRC="/pics/titles/library.gif" WIDTH=213 HEIGHT=60 ALT="Library"></CENTER>
<P>
<?php

   /* Pull in the utility functions */
   require_once("vutility_core.php");
   /* Include logging functions */
   require_once('vlog_core.php');

   $comment_config_file = "$DOCUMENT_ROOT/config/vcomment_config.php";
   require_once("vcomment_core.php");

   /* Include guide utility functions */
   require_once("$DOCUMENT_ROOT/utils/guide_utility.php");

   // Pull in library support functions
   require_once("library_support.inc.php");

   // Include VRML support functions
   require ("vvrml_core.php");

   // Create database object
	$db = new db_mysql;
	// Set up the database object
	$db->set_db('guide');
	$db->set_user('guide', '');
	
   if ($id) {

   	// Connect to the database
	   if ($db->connect()) {

         // Create the logger
         $logger = new logger();
         $logger->set_db($db,'library_log');

         // If a vote has been cast and is allowed, save it and log it.
         if ($vote && !$logger->exists($id)) {
            if ($db->query("UPDATE library SET total_votes = total_votes+$vote-1, vote_count = vote_count+1 WHERE id = $id"))
               $logger->log($id);
            $db->query_end();
         }

         $query = "SELECT * FROM library WHERE id = $id";
         if (!$db->query($query)) die ("ERROR: Could not run query '$query'. Please email <A HREF='mailto:&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;'>&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;</A> to let me know, quoting the above query.");

         $content=$db->result_fetch();
         $db->query_end();

         echo "<TABLE CELLSPACING='0' CELLPADDING='3' BORDER='0' WIDTH='100%'>\n";
         echo "<TR><TD HEIGHT='20' COLSPAN='2' BGCOLOR='#BB0000'><FONT FACE='Arial' SIZE='+1' COLOR='#FFFFFF'>$content[title]</FONT></TD></TR>\n";
         echo "</TABLE>\n";

         echo "<TABLE>\n";

         echo "<TR><TD ALIGN='RIGHT'><STRONG>Author:</STRONG></TD><TD>";
         
         if ($content[email]) echo "<A HREF='mailto:$content[email]'>";
         
         if ($content[name]) echo "$content[name]";
         else if ($content[email]) echo "$content[email]";
         else echo "Anonymous";
         
         if ($content[email]) echo "</A>";
         echo "</TD></TR>\n";

         echo "<TR><TD VALIGN='TOP' ALIGN='RIGHT'>";
         if ($content[vote_count]>0) {
            $numstars = 0;
            $rating = $content[total_votes]/$content[vote_count];
            if ($rating > 4.5) $numstars = 5;
            else if ($rating > 3.5) $numstars = 4;
            else if ($rating > 2.5) $numstars = 3;
            else if ($rating > 1.5) $numstars = 2;
            else if ($rating > 0.5) $numstars = 1;
            if ($numstars > 0) {
               echo "<STRONG>Rating:</STRONG></TD><TD>";
               for ($i=0;$i<$numstars;$i++) echo "<IMG SRC='/pics/star.gif' ALT='*'>";
            }
            else echo "<STRONG>No Rating</STRONG></TD><TD>";
            echo " <EM>($content[vote_count] vote" . (($content[vote_count]!=1) ? "s" : "") . ")</EM>";
         }
         else echo "<STRONG>No Rating</STRONG></TD><TD>";
         echo "</TD></TR>";

         if ($content[license]) {
	         echo "<TR><TD ALIGN='RIGHT'><STRONG>License:</STRONG></TD><TD>";
		 switch ($content[license]) {
		 case "GPL":
		 	echo "<A HREF='http://www.gnu.org/copyleft/gpl.html' TARGET='_blank'>GPL</A>";
			break;
		 case "LGPL":
		 	echo "<A HREF='http://www.gnu.org/copyleft/lesser.html' TARGET='_blank'>LGPL</A>";
			break;
		 case "Copyright":
		 	echo "&copy $content[name]. You may use this code without restrictions, unless stated otherwise below.";
			break;
		 }
	         echo "</TD></TR>";
	 }

         echo "</TABLE>\n";
  
         // If they haven't voted for this one before, create a voting form
         if (!$logger->exists($id)) {
            echo "<FORM NAME='VOTINGFORM' ACTION='content.php' METHOD='POST'>";
            echo "How do you rate this entry? <INPUT TYPE='HIDDEN' NAME='id' VALUE='$content[id]'>";
            echo "<SELECT NAME='vote'>";
            echo "<OPTION VALUE='0'> ";
            echo "<OPTION VALUE='1'>0";
            echo "<OPTION VALUE='2'>1";
            echo "<OPTION VALUE='3'>2";
            echo "<OPTION VALUE='4'>3";
            echo "<OPTION VALUE='5'>4";
            echo "<OPTION VALUE='6'>5";
            echo "</SELECT> ";
            echo "<INPUT TYPE='SUBMIT' VALUE='Vote!'>";
            echo "</FORM>";
         }

         if ($content[shortdesc]) {
            echo "</P><P>\n";
            echo "$content[shortdesc]\n";
         }

         if ($content[is_vrml] && $content[sample]) {
            echo "</P><P>\n";
            echo "<SCRIPT TYPE='text/javascript' LANGUAGE='JavaScript'>\n";
            echo "<!--\n";
            echo "DisplayVRML('<CENTER><EMBED SRC=\"vrml.php?id=$id\" WIDTH=\"75%\" HEIGHT=\"75%\"></CENTER>',\n";
            echo "            '<A HREF=\"vrml.php?id=$id\" TARGET=\"_blank\"><IMG SRC=\"../pics/sample.gif\" BORDER=\"0\" ALIGN=ABSMIDDLE ALT=\"Sample\" HEIGHT=21 WIDTH=26><BR>View Sample</A>');\n";
            echo "// -->\n";
            echo "</SCRIPT>\n";
            echo "<NOSCRIPT>\n";
            echo "<A HREF='vrml.php?id=$id' TARGET='_blank'><IMG SRC='../pics/sample.gif' BORDER='0' ALIGN=ABSMIDDLE ALT='Sample' HEIGHT=21 WIDTH=26><BR>View Sample</A>\n";
            echo "</NOSCRIPT>\n";
            echo "\n";
         }

         if ($content[longdesc]) {
            echo "</P><P>\n";
            echo "$content[longdesc]\n";
         }
         echo "</P>\n";

         if ($content[proto] && $content[is_vrml]) {
         
            echo "<TABLE CELLSPACING='0' CELLPADDING='3' BORDER='0' WIDTH='100%'>\n";
            echo "<TR><TD HEIGHT='20' BGCOLOR='#BB0000'>\n";
            echo "<A HREF=\"vrml.php?mode=proto&amp;id=$id&amp;save=1\"><IMG SRC=\"/pics/disk.gif\" BORDER=\"0\" ALT=\"Download\" HEIGHT=16 WIDTH=16></A>\n";
            echo "<FONT FACE='Arial' SIZE='+1' COLOR='#FFFFFF'>PROTO</FONT>\n";
            echo "</TD></TR>\n";
            echo "</TABLE>\n";

            echo "<PRE>\n";
            $source  = create_proto_vrml($content);
            echo printvrml($source,$style);
            echo "</PRE>\n";
         }

         if ($content[source]) {
            echo "<TABLE CELLSPACING='0' CELLPADDING='3' BORDER='0' WIDTH='100%'>\n";
            echo "<TR><TD HEIGHT='20' COLSPAN='2' BGCOLOR='#BB0000'>\n";
            echo "<A HREF=\"vrml.php?id=$id&amp;save=1\"><IMG SRC=\"/pics/disk.gif\" BORDER=\"0\" ALT=\"Download\" HEIGHT=16 WIDTH=16></A>\n";
            echo "<FONT FACE='Arial' SIZE='+1' COLOR='#FFFFFF'>Example Code</FONT>\n";
            echo "</TD></TR>\n";
            echo "</TABLE>\n";

            if ($content[externproto]) {
               echo "<P>\n";
               echo "If you want to use the PROTO above, copy and paste the\n";
               echo "EXTERNPROTO from the top of this example into your file.\n";
               echo "</P>\n";
            }

            echo "<PRE>\n";
            if ($content[is_vrml]) {
               $source  = create_example_vrml($content);
               echo printvrml($source,$style);
            }
            else echo $content[source];
            echo "</PRE>\n";
         }
  
         echo "<TABLE CELLSPACING='0' CELLPADDING='3' BORDER='0' WIDTH='100%'>\n";
         echo "<TR><TD HEIGHT='20' COLSPAN='2' BGCOLOR='#BB0000'><FONT FACE='Arial' SIZE='+1' COLOR='#FFFFFF'>Comments</FONT></TD></TR>\n";
         echo "</TABLE>\n";
  
	 global $login_userid;
	 global $comment_post_url;

	 // Do we have comments?
	 $comment_id = service_option("web3d_polls", "polls", "comment");
 	 if (!$comment_id)
		return;

  	 // Display the comments
	 if ($content[comment]) {
		// Show the post comment link
		echo "<P><A HREF='$comment_post_url?mode=POST&amp;post_article=$content[comment]'>New Comment</A></P>\n";
		// Show the comments
		echo "<CENTER>\n";
		comment_display($content[comment]);
		echo "</CENTER>\n";
 	 }

         $logger->end();
      }

      $db->disconnect();
   }
   else {
      echo "ERROR: No library ID specified! ";
      echo "Please return to the <A HREF='index.php'>library</A> page and try again! ";
      echo "If this keeps happening, please notify me by mailing ";
      echo "<A HREF='mailto:&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;'>&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;</A>.";
   }

?>
</P><P>

<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="/utils/footer.js"></SCRIPT>
<SCRIPT TYPE="text/javascript">
footer('/pics/menu_lit/library.gif','Library','./');
</SCRIPT> 

</BODY>
</HTML>
