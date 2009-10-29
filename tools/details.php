<?php
	$login_config_file = "$DOCUMENT_ROOT/config/vlogin_config.php";
	require_once("vlogin_core.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - Tools</title>
<META NAME="DESCRIPTION" CONTENT="Guide to the world of VRML, with one of the best tutorials on the web.">
<META NAME="KEYWORDS" CONTENT="VRML, VRML97, Virtual Reality Modeling Language,	Tutorial, Guide, 3D,
				Computer Graphics, Web3D, Java, JavaScript, ECMAScript, Virtual Reality, Tools,
				Internet 3D, VRML Worlds, VRML Tutorial, Web3D Guide, 3D Worlds, Cyberspace, VRML Tools">
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
<!--
function ThrowError(element,message) {
	window.alert(message);
	element.select();
	element.focus();
}

function Validate() {
   // Correct result page location
   document.SUGGESTFORM.RESULTPAGE.value = document.location;
	//Ensure a comment has been entered
	if (document.COMMENTFORM.COMMENT.value.length == 0) {
		ThrowError(document.COMMENTFORM.COMMENT,"You have not entered a comment!");
		return false;
	}
	return true;
}

//-->
</SCRIPT>
</HEAD>
<body BGCOLOR='#DDDDDD' TEXT='#000000' link="#ff0000" alink="#ffff00" VLINK="#DD0000">
<CENTER><IMG SRC="/pics/titles/tools.gif" WIDTH=155 HEIGHT=60 ALT="Tools"></CENTER><P>
<?php

   /* Pull in the utility functions */
   require_once("vutility_core.php");
   /* Include logging functions */
   require_once('vlog_core.php');

   $comment_config_file = "$DOCUMENT_ROOT/config/vcomment_config.php";
   require_once("vcomment_core.php");

   /* Include guide utility functions */
   require_once("$DOCUMENT_ROOT/utils/guide_utility.php");

   echo "<CENTER><FORM ACTION='index.php' METHOD='POST'>";
   echo "<INPUT TYPE='text' NAME='search' VALUE='$search'> <INPUT TYPE='submit' VALUE='Search!'><BR>";
   echo "<A HREF='index.php'>Show Categories</A>";
   echo "</FORM></CENTER><P>";

   if ($id) {

      // Create database object
		$db = new db_mysql;
		// Set up the database object
		$db->set_db('guide');
		$db->set_user('guide', '');
		
		// Connect to the database
		if ($db->connect()) {

         // Create the logger
         $logger = new logger();
         $logger->set_db($db,'tools_log');

         // If a vote has been cast and is allowed, save it and log it.
         if ($vote && !$logger->exists($id)) {
            if ($db->query("UPDATE tools SET total_votes = total_votes+$vote-1, vote_count = vote_count+1 WHERE id = $id"))
               $logger->log($id);
            $db->query_end();
         }
         
         $query = "SELECT * FROM tools WHERE id = $id";
         if (!$db->query($query)) die ("ERROR: Could not run query '$query'. Please email <A HREF='mailto:&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;'>&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;</A> to let me know, quoting the above query.");

         $tool=$db->result_fetch();
         $db->query_end();
            
         $db->query("SELECT id, name FROM tools_categories WHERE id = $tool[category]");
         $category = $db->result_fetch();
         $db->query_end();

         echo "<CENTER>";
         echo "<TABLE CELLPADDING='2' BORDER='0' WIDTH='75%'><TR><TD BGCOLOR='#BB0000'>";
         echo "<TABLE WIDTH='100%' CELLSPACING='0' CELLPADDING='3' BORDER='0' BGCOLOR='#FFFFFF'>";
         echo "<TR BGCOLOR='#BB0000'><TD>";
         echo "<FONT FACE='Arial' SIZE='+2' COLOR='#ffffff'><STRONG>$tool[name]</STRONG></FONT> ";
         if ($category[id]) echo "<A HREF='index.php?category=$category[id]'><FONT FACE='Arial' SIZE='-1' COLOR='#C0C0C0'><EM>$category[name]</EM></FONT></A>";
         echo "</TD><TD ALIGN='RIGHT'>";
         if ($tool[essential] == 1) {
            echo "<FONT FACE='Arial' COLOR='#FFFFFF' SIZE='+1'>Essential!</FONT>\n";
         }
         echo "</TD></TR>\n";

         echo "<TR><TD VALIGN='TOP'>";
         if ($tool[vote_count]>0) {
            $numstars = 0;
            $rating = $tool[total_votes]/$tool[vote_count];
            if ($rating > 4.5) $numstars = 5;
            else if ($rating > 3.5) $numstars = 4;
            else if ($rating > 2.5) $numstars = 3;
            else if ($rating > 1.5) $numstars = 2;
            else if ($rating > 0.5) $numstars = 1;
            if ($numstars > 0) {
               echo "Rating: ";
               for ($i=0;$i<$numstars;$i++) echo "<IMG SRC='/pics/star.gif' ALT='*'>";
            }
            else echo "No rating";
            echo " <EM>($tool[vote_count] vote" . (($tool[vote_count]!=1) ? "s" : "") . ")</EM>";
         }
         else echo "No rating";
         echo "</TD><TD  VALIGN='TOP' ALIGN='RIGHT'>";


         // If they haven't voted for this one before, create a voting form
         if (!$logger->exists($id)) {
            echo "<FORM NAME='VOTINGFORM' ACTION='details.php' METHOD='POST'>";
            echo "How do you rate this product? <INPUT TYPE='HIDDEN' NAME='id' VALUE='$tool[id]'>";
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
         else echo "&nbsp;";
         echo "</TD></TR>\n";

         echo "<TR><TD>Platforms: $tool[os]</TD><TD ALIGN='RIGHT'>";
         if ($tool[download]) echo "<A HREF='$tool[download]' TARGET='_blank'><IMG SRC='/pics/tools/download.gif' WIDTH='100' HEIGHT='25' BORDER='0' ALT='Download'></A>";
         else echo "&nbsp;";
         echo "</TD></TR>\n";

         echo "<TR><TD>Price: $tool[price]</TD><TD ALIGN='RIGHT'>";
         if ($tool[buy]) echo "<A HREF='$tool[buy]' TARGET='_blank'><IMG SRC='/pics/tools/buy.gif' WIDTH='100' HEIGHT='25' BORDER='0' ALT='Buy Online'></A>";
         else echo "&nbsp;";
         echo "</TD></TR>\n";

         echo "<TR><TD>Author: $tool[author]</TD><TD ALIGN='RIGHT'>";
         if ($tool[homepage]) echo "<A HREF='$tool[homepage]' TARGET='_blank'><IMG SRC='/pics/tools/homepage.gif' WIDTH='100' HEIGHT='25' BORDER='0' ALT='Homepage'></A>";
         else echo "&nbsp;";
         echo "</TD></TR>\n";

         echo "<TR BGCOLOR='#BB0000'><TD COLSPAN='2'><FONT FACE='Arial' COLOR='#ffffff'><STRONG>Description:</STRONG></FONT></TD></TR>\n";

         echo "<TR><TD COLSPAN='2'>";
         if ($tool[longdesc]) echo "$tool[longdesc]";
         else echo "No Description";
         echo "</TD></TR>\n";
         
         echo "</TABLE></TD></TR></TABLE><P>";            
         echo "</CENTER>";
 
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
	 if ($tool[comment]) {
		// Show the post comment link
		echo "<P><A HREF='$comment_post_url?mode=POST&amp;post_article=$tool[comment]'>New Comment</A></P>\n";
		// Show the comments
		echo "<CENTER>\n";
		comment_display($tool[comment]);
		echo "</CENTER>\n";
	 }

         $logger->end();
      }

      $db->disconnect();
   }
   else {
      echo "ERROR: No tool ID specified! ";
      echo "Please return to the <A HREF='index.php'>tools</A> page and try again! ";
      echo "If this keeps happening, please notify me by mailing ";
      echo "<A HREF='mailto:&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;'>&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;</A>.";
   }
?>

<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="/utils/footer.js"></SCRIPT>
<SCRIPT TYPE="text/javascript">
footer('/pics/menu_lit/tools.gif','Tools','./');
</SCRIPT> 

</BODY>
</HTML>
