<?php
	$login_config_file = "$DOCUMENT_ROOT/config/vlogin_config.php";
	require_once("vlogin_core.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - Main</TITLE>
<META NAME="DESCRIPTION" CONTENT="Guide to the world of VRML, with one of the best tutorials on the web.">
<META NAME="KEYWORDS" CONTENT="VRML, VRML97, Virtual Reality Modeling Language,	Tutorial, Guide, 3D,
				Computer Graphics, Web3D, Java, JavaScript, ECMAScript, Virtual Reality,
				Internet 3D, VRML Worlds, VRML Tutorial, Web3D Guide, 3D Worlds, Cyberspace">
<SCRIPT TYPE="text/vbscript" LANGUAGE="VBScript" SRC="/utils/detectvrml.vbs"></SCRIPT>
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="/utils/detectvrml.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">

<!--
function ThrowError(element,message) {
        window.alert(message);
        element.select();
        element.focus();
}
function Validate() {
        //Ensure a valid email is entered
        if ((document.SUBMITFORM.EMAIL.value.length < 5) ||
            (document.SUBMITFORM.EMAIL.value.indexOf('@',0) == -1) ||
            (document.SUBMITFORM.EMAIL.value.indexOf('.',0) == -1)) {
                ThrowError(document.SUBMITFORM.EMAIL,"Invalid email address");
                return false;
        }
        return true;
}
//-->

</SCRIPT>

</HEAD>
<BODY BGCOLOR='#DDDDDD' TEXT='#000000' LINK="#ff0000" ALINK="#ffff00" VLINK="#DD0000">

<script type="text/javascript" src="http://www.makepovertyhistory.org/whiteband_small_right.js">
</script><noscript><a href="http://www.makepovertyhistory.org/">
http://www.makepovertyhistory.org</a></noscript>

<P>
<CENTER>
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
<!--
DisplayVRML('<EMBED SRC="logo/logo.wrl" WIDTH=100% HEIGHT=200>',
            '<IMG SRC="logo/logo.jpg" WIDTH=320 HEIGHT=200>');
// -->
</SCRIPT>
<NOSCRIPT>
<IMG SRC="logo/logo.jpg" WIDTH=320 HEIGHT=200>
</NOSCRIPT>
</CENTER>
<TABLE CELLSPACING='3' CELLPADDING='3' BORDER='0' WIDTH='100%'>
<TR>
<TD ALIGN=LEFT VALIGN=bottom><FONT COLOR='#7F7F7F' SIZE=-2><A HREF='http://www.floppy.org.uk/about/' TARGET='_blank'><IMG SRC='pics/portrait.gif' HEIGHT=40 WIDTH=32 BORDER='0' ALT='James'></A> The Web3D Guide is maintained by James Smith of <A HREF="http://www.vapourtech.com" TARGET="_blank">Vapour Technology</A></FONT></TD>
<TD ALIGN=RIGHT VALIGN=BOTTOM><FONT COLOR='#7F7F7F' SIZE=-2>You are visitor<BR><A HREF='/stats/'><IMG SRC='http://web3d.vapourtech.com/cgi-bin/counter?id=guide&font=indy' BORDER='0' WIDTH='84' HEIGHT='14' ALT='Hit Counter' ALIGN="MIDDLE"></A></FONT></TD>
</TR>
<TR>
<?php

   $num_news = 5;
   $num_tools = 3;
   $num_links = 3;
   $num_library = 3;
   $num_events = 2;
	$news_config_file = "$DOCUMENT_ROOT/config/vnews_config.php";
	$comment_config_file = "$DOCUMENT_ROOT/config/vcomment_config.php";
	
	// Pull in the core news functions
	include_once("vnews_core.php");
	// Pull in the core utility functions
	include_once("vutility_core.php");

   // News
   echo "<TD VALIGN='TOP'>\n";
	// Generate the news page
	news_process();
   echo"</TD>\n";

   
   // Sidebar

   echo"<TD VALIGN='TOP' WIDTH='20%'>\n";
   echo "<CENTER>\n";

   // Display login box
   echo "\n";
   echo "<TABLE CELLPADDING=2 BORDER=0 WIDTH='100%'><TD BGCOLOR='#BB0000'><TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 WIDTH='100%'>\n";
   echo "<TR><TD>\n";
   echo "<CENTER><A HREF='login.php'><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'><STRONG>Login</STRONG></FONT></A></CENTER>\n";
   echo "</TD></TR>\n";
   echo "<TR><TD BGCOLOR='#FFFFFF'>\n";
   echo "<CENTER>\n";

   if ($login_userid) {
      // Logged in
      $result = login_get_from_id($login_userid);
      echo "<FORM NAME=REMIND ACTION='$login_redirect_url' METHOD=POST>\n";
      echo "Logged in as {$result[nick]}<BR>\n";
      // Generate the logout button
      echo "<INPUT TYPE=HIDDEN NAME='mode' VALUE='LOGOUT_SUBMIT'>\n";
      echo "<INPUT TYPE=HIDDEN NAME='LOGIN_BOUNCE_REF' VALUE='" . login_generate_ref() . "'>\n";
      echo "<INPUT TYPE=SUBMIT VALUE='Logout'>\n";
      echo "</FORM>\n";
   }
   else {
      // Not logged in
      echo "<TABLE>";
      echo "<FORM NAME=LOGIN ACTION='$login_redirect_url' METHOD=POST>\n";
      echo "<INPUT TYPE=HIDDEN NAME='mode' VALUE='LOGIN_SUBMIT'>";
      echo "<INPUT TYPE=HIDDEN NAME='LOGIN_BOUNCE_REF' VALUE='" . login_generate_ref() . "'>\n";
      echo "<TR><TD>Username:</TD>\n";
      echo "<TD><INPUT TYPE=TEXT SIZE=12 MAXLENGTH=16 NAME='LOGIN_NICK' VALUE=''></TD></TR>\n";
      echo "<TR><TD>Password:</TD>\n";
      echo "<TD><INPUT TYPE=PASSWORD SIZE=12 MAXLENGTH=16 NAME='LOGIN_PASSWORD' VALUE=''></TD></TR>\n";
      echo "<TR><TD><A HREF='$login_url?mode=CREATE'>Register</A></TD>\n";
      echo "<TD><INPUT TYPE=SUBMIT VALUE='Login'></TD></TR>";
      echo "</FORM></TABLE>\n";
   }

   echo "</CENTER>\n";
   echo "</TABLE></TD></TABLE>\n";
   echo "</P>\n";

   // Poll
   require ("$DOCUMENT_ROOT/config/phpPollConfig.php3");
   require ("phpPollUI.php3");
   $poll_id = poll_getLatest();
   $poll_baseURL = "/polls";
   $results = poll_getResults($poll_id);
   echo "<P>\n";
   echo "<TABLE CELLPADDING=2 BORDER=0 WIDTH='100%'><TD BGCOLOR='#BB0000'><TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 WIDTH='100%'>\n";
   echo "<TR><TD>\n";
   echo "<CENTER><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'><STRONG>{$results[0][title]}</STRONG></FONT></CENTER>\n";
   echo "</TD></TR>\n";
   echo "<TR><TD BGCOLOR='#FFFFFF'>\n";
   poll_generateUI($poll_id, "$poll_baseURL/index.php?results=$poll_id");
   echo "<A HREF='$poll_baseURL/index.php?results=$poll_id'>Results</A> ({$results[0][votes]} votes)<BR>\n"; 
   echo "<A HREF='$poll_baseURL/index.php?list=1'>More Polls</A>\n";
   echo "</TABLE></TD></TABLE>\n";
   echo "</P>\n";


   // Search
   echo "<P>\n";
   echo "<TABLE CELLPADDING=2 BORDER=0 WIDTH='100%'><TD BGCOLOR='#BB0000'><TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 WIDTH='100%'>\n";
   echo "<TR><TD>\n";
   echo "<CENTER><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'><STRONG>Search Content</STRONG></FONT></CENTER>\n";
   echo "</TD></TR>\n";
   echo "<TR><TD BGCOLOR='#FFFFFF'>\n";
   echo "<CENTER><FORM ACTION='search.php' METHOD='POST'>\n";
   echo "<INPUT TYPE='text' NAME='search' SIZE='10'> <INPUT TYPE='submit' VALUE='Go'><BR>\n";
   echo "</FORM></CENTER>\n";
   echo "</TABLE></TD></TABLE>\n";
   echo "</P>\n";

   // Display support box
   echo "<P>\n";
   echo "<TABLE CELLPADDING=2 BORDER=0 WIDTH='100%'><TD BGCOLOR='#BB0000'><TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 WIDTH='100%'>\n";
   echo "<TR><TD>\n";
   echo "<CENTER><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'><STRONG>Support The Guide</STRONG></FONT></CENTER>\n";
   echo "</TD></TR>\n";
   echo "<TR><TD BGCOLOR='#FFFFFF'>\n";
   echo "<CENTER>\n";
   echo "<A HREF='support.html'>Make a donation</A> to help support the Guide!<BR>\n";
   echo "</CENTER>\n";
   echo "</TABLE></TD></TABLE>\n";
   echo "</P>\n";

   // Create database object
	$db = new db_mysql;
	// Set up the database object
	$db->set_db('guide');
	$db->set_user('guide', '');
	
	// Connect to the database
	if ($db->connect()) {   

      // Diary
		$cur_time = date("Y-m-d H:i:s", mktime());
		if ($db->query("SELECT id, title, event_date, event_end_date FROM events WHERE event_date >= '$cur_time' OR event_end_date >= '$cur_time' ORDER BY event_date LIMIT $num_events")) {
         echo "<P>\n";
         echo "<TABLE CELLPADDING=2 BORDER=0 WIDTH='100%'><TD BGCOLOR='#BB0000'><TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 WIDTH='100%'>\n";
         echo "<TR><TD>\n";
         echo "<CENTER><A HREF='diary/'><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'><STRONG>Diary</STRONG></FONT></A></CENTER>\n";
         echo "</TD></TR>\n";
         echo "<TR><TD BGCOLOR='#FFFFFF'>\n";
         while ($event=$db->result_fetch()) {
            $tmpdate = date_format($event[event_date],"jS M");
            echo $tmpdate;
            if ($event[event_end_date] > 0) {
               $tmpdate = date_format($event[event_end_date],"jS M");
               echo " to $tmpdate";
            }
            echo "<BR><A HREF='diary/index.php?mode=display&arg=$event[id]'>$event[title]</A><P>";
         }   
         $db->query_end();
         echo "</TD></TR>\n";
         echo "</TABLE></TD></TABLE>\n";
         echo "</P>\n";
      }

      // Latest Entries
      echo "<P>\n";
      echo "<TABLE CELLPADDING=2 BORDER=0 WIDTH='100%'><TD BGCOLOR='#BB0000'><TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 WIDTH='100%'>\n";
      echo "<TR><TD>\n";
      echo "<CENTER><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'><STRONG>Latest Content</STRONG></FONT></CENTER>\n";
      echo "</TD></TR>\n";
      
      // Tools
		if ($db->query("SELECT id, name FROM tools ORDER BY id DESC LIMIT $num_tools")) {
         echo "<TR><TD>\n";
         echo "<CENTER><A HREF='tools/'><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'>Tools</FONT></A></CENTER>\n";
         echo "</TD></TR>\n";
         echo "<TR><TD BGCOLOR='#FFFFFF'>\n";
         while ($tool=$db->result_fetch()) {
            echo "<A HREF='tools/details.php?id=$tool[id]'>$tool[name]</A><BR>";
         }   
         $db->query_end();
         echo "</TD></TR>\n";
      }
      
      // Links
		if ($db->query("SELECT title, url FROM links ORDER BY id DESC LIMIT $num_links")) {
         echo "<TR><TD>\n";
         echo "<CENTER><A HREF='links.php'><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'>Links</FONT></A></CENTER>\n";
         echo "</TD></TR>\n";
         echo "<TR><TD BGCOLOR='#FFFFFF'>\n";
         while ($link=$db->result_fetch()) {
            echo "<A HREF='$link[url]' TARGET='_blank'>$link[title]</A><BR>";
         }   
         $db->query_end();
         echo "</TD></TR>\n";
      }
      
      // Library
		if ($db->query("SELECT id, title FROM library ORDER BY id DESC LIMIT $num_library")) {
         echo "<TR><TD>\n";
         echo "<CENTER><A HREF='library/'><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'>Library</FONT></A></CENTER>\n";
         echo "</TD></TR>\n";
         echo "<TR><TD BGCOLOR='#FFFFFF'>\n";
         while ($entry=$db->result_fetch()) {
            echo "<A HREF='library/content.php?id=$entry[id]'>$entry[title]</A><BR>";
         }   
         $db->query_end();
         echo "</TD></TR>\n";
      }
      
      // Finish Latest   
      echo "</TABLE></TD></TABLE>\n";
      echo "</P>\n";

      $db->disconnect();

   }

   // Display mailing list box
   //echo "<P>\n";
   //echo "<TABLE CELLPADDING=2 BORDER=0 WIDTH='100%'><TD BGCOLOR='#BB0000'><TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 WIDTH='100%'>\n";
   //echo "<TR><TD>\n";
   //echo "<CENTER><A HREF='http://web3d.vapourtech.com/mailman/listinfo/web3dnews/'><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'><STRONG>Join The Mailing List</STRONG></FONT></A></CENTER>\n";
   //echo "</TD></TR>\n";
   //echo "<TR><TD BGCOLOR='#FFFFFF'>\n";
   //echo "<CENTER><FORM NAME='SUBMITFORM' onSubmit='return Validate();' ACTION='http://web3d.vapourtech.com/cgi-bin/emailform.pl' METHOD='POST'>\n";
   //echo "<INPUT TYPE='HIDDEN' NAME='MAILTO' VALUE='web3dnews-request@vapourtech.com'>\n";
   //echo "<INPUT TYPE='HIDDEN' NAME='SUBJECT' VALUE='subscribe'>\n";
   //echo "<INPUT TYPE='HIDDEN' NAME='RESULTPAGE' VALUE='http://web3d.vapourtech.com/main.php'>\n";
   //echo "<INPUT TYPE='HIDDEN' NAME='BODYTAG' VALUE='<BODY BGCOLOR=\"#DDDDDD\" TEXT=\"#000000\" LINK=\"#ff0000\" ALINK=\"#ffff00\" VLINK=\"#DD0000\">'>\n";
   //echo "<INPUT TYPE='HIDDEN' NAME='NAME' VALUE='Mail List Request'>\n";
   //echo "Enter email address:<BR>\n";
   //echo "<INPUT TYPE='TEXT' SIZE='10' NAME='EMAIL'>\n";
   //echo "<INPUT TYPE='HIDDEN' NAME='DATA' VALUE='Data'>\n";
   //echo "<INPUT TYPE='SUBMIT' VALUE='Join'>\n";
   //echo "</FORM></CENTER>\n";
   //echo "</TABLE></TD></TABLE>\n";
   //echo "</P>\n";

   // EFF logo
   echo "<P>\n";
   echo "<A HREF=\"http://www.eff.org/blueribbon/\" TARGET=\"_blank\"><IMG SRC=\"http://br.eff.org/br.gif\" ALT=\"Blue Ribbon Campaign icon\" HEIGHT=\"76\" WIDTH=\"112\" BORDER=\"0\" ALIGN=\"MIDDLE\"></A>\n";
   echo "</P>\n";

   // Finish Sidebar
   echo "</CENTER>\n";
   echo"</TD></TR>\n";
   echo"</TABLE>\n";

?>
<P>
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="/utils/footer.js"></SCRIPT>
<SCRIPT TYPE="text/javascript">
footer('/pics/menu_lit/sitemap.gif','Sitemap','/sitemap.html');
</SCRIPT> 

</BODY>
</HTML>
