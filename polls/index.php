<?php
	$login_config_file = "$DOCUMENT_ROOT/config/vlogin_config.php";
	require_once("vlogin_core.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - Polls</title>
<META NAME="DESCRIPTION" CONTENT="Guide to the world of VRML, with one of the best tutorials on the web.">
<META NAME="KEYWORDS" CONTENT="VRML, VRML97, Virtual Reality Modeling Language,	Tutorial, Guide, 3D, FAQ,
				Computer Graphics, Web3D, Java, JavaScript, ECMAScript, Virtual Reality,
				Internet 3D, VRML Worlds, VRML Tutorial, Web3D Guide, 3D Worlds, Cyberspace">
<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
<!--
function ThrowError(element,message) {
	window.alert(message);
	element.select();
	element.focus();
}

function Validate() {
	//Ensure a name is entered
	if (document.COMMENTFORM.NAME.value.length == 0) {
		ThrowError(document.COMMENTFORM.NAME,"You have not entered a name!");
		return false;
	}
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
<CENTER><IMG SRC="/pics/titles/polls.gif" WIDTH=157 HEIGHT=60 ALT="Polls"></CENTER>
<P>

<?php

require_once("$DOCUMENT_ROOT/config/phpPollConfig.php3");
require_once('phpPollUI.php3');
require_once("vutility_core.php");

$comment_config_file = "$DOCUMENT_ROOT/config/vcomment_config.php";
require_once("vcomment_core.php");

$poll_baseURL = "/polls";

if (isset($results)) {
	Results($results);
	DisplayComments($results);
}
elseif (isset($vote)) {
	Vote($vote);
}
else {
	ListPolls();
}

/* List all the currently available polls */

function ListPolls() {
   global $list;
   global $DOCUMENT_ROOT;

   // include news config for formatting rules
   include ("$DOCUMENT_ROOT/config/vnews_config.php");

   if (!isset($list)) {
      Vote(poll_getLatest());
      echo "</P><P>\n";
    	echo "<CENTER><FONT SIZE='+1'><STRONG>Previous Polls</STRONG></FONT></P></CENTER>\n";
   }

	echo "<TABLE WIDTH='100%' BORDER=0 CELLPADDING=2 CELLSPACING=0 CLASS='ITEM'>\n<TR><TD>\n";
	echo "<CENTER>\n<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=2>\n";

	$polls = poll_listPolls();
	if (isset($list)) $start = 1;
	else $start = 2;
	for ($count = count($polls)-$start; $count >= 0; $count--) {
		$id = $polls[$count][0];
		$poll_title = $polls[$count][1];
		$date = date($news_format[list_date][format],$polls[$count][2]);
		echo "<TR>\n";
		echo "<TD BGCOLOR='#BB0000' VALIGN='TOP'><P><FONT FACE='Arial' COLOR='#FFFFFF'>$poll_title</FONT></P></TD>\n";
		echo "<TD BGCOLOR='#BB0000' VALIGN='TOP'><P><FONT FACE='Arial' COLOR='#FFFFFF'>$date</FONT></P></TD>\n";
		echo "<TD BGCOLOR='#BB0000' VALIGN='TOP'><P><A HREF='index.php?vote=$id'><FONT FACE='Arial' COLOR='#FFFFFF'>Vote</FONT></A></P></TD>\n";
		echo "<TD BGCOLOR='#BB0000' VALIGN='TOP'><P><A HREF='index.php?results=$id'><FONT FACE='Arial' COLOR='#FFFFFF'>Results</FONT></A></P></TD>\n";
		echo("</TR>\n");
	}

	echo "</TABLE>\n</CENTER>\n</TD></TR>\n</TABLE>\n";

}

/* Display the results of a selected poll */

function Results($poll_id) {
	global $poll_baseURL;
   global $DOCUMENT_ROOT;

   // include news config for formatting rules
   include ("$DOCUMENT_ROOT/config/vnews_config.php");

	$results = poll_getResults($poll_id);

	$date = date($news_format[list_date][format],$results[0][timeStamp]);

	echo "<CENTER>\n";
	echo "<P><FONT SIZE='+1'><STRONG>{$results[0][title]}</STRONG></FONT><BR>Posted on $date</P>\n";
	echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=0 CLASS='ITEM'>\n<TR><TD>\n";

	for ($i = 1; $i < count($results); $i++) {
		echo "<TR><TD ALIGN='RIGHT'><P>{$results[$i][text]}</P></TD>\n";
		$width = ($results[$i][votes] / $results[0][votes]) * 350;
		echo "<TD><P><IMG SRC='bar0.gif' WIDTH='2' HEIGHT='20' BORDER='0' ALT=''><IMG SRC='bar1.gif' WIDTH='$width' HEIGHT='20' BORDER='0' ALT=''><IMG SRC='bar2.gif' WIDTH='2' HEIGHT='20' BORDER='0' ALT=''></P></TD>\n";
		$percent = intval(($results[$i][votes] / $results[0][votes]) * 100);
		echo "<TD><P>$percent%</P></TD>\n";
		echo "<TD><P>{$results[$i][votes]} votes</P></TD></TR>\n";
	}

	echo "<TR><TD COLSPAN=2></TD><TD><P>Total:</P></TD>\n";
	echo "<TD><P>{$results[0][votes]} votes</P></TD></TR>\n";
	echo "</TABLE>\n";
	echo "<P><A HREF='$poll_baseURL/index.php?list=1'>List all polls</A></P></CENTER>\n";

}

/* Vote on a selected poll */

function Vote($poll_id) {

  global $vote;
	global $poll_baseURL;

	$results = poll_getResults($poll_id);

	echo "<CENTER>";

  echo "<P>\n";
  echo "<TABLE CELLPADDING=2 BORDER=0 WIDTH='20%'><TD BGCOLOR='#BB0000'><TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 WIDTH='100%'>\n";
  echo "<TR><TD>\n";
  echo "<CENTER><FONT FACE='Arial' COLOR='#FFFFFF'SIZE='-1'><STRONG>{$results[0][title]}</STRONG></FONT></CENTER><P>\n";
  echo "</TD></TR>\n";
  echo "<TR><TD BGCOLOR='#FFFFFF'>\n";
  poll_generateUI($poll_id, "$poll_baseURL/index.php?results=$poll_id");
  echo "<A HREF='$poll_baseURL/index.php?results=$poll_id'>Results</A> ({$results[0][votes]} votes)<BR>\n";
  echo "</TABLE></TD></TABLE>\n";
  echo "</P>\n";

  if (isset($vote)) echo "<P><A HREF='$poll_baseURL/index.php?list=1'>List all polls</A></P>\n";
  
  echo "</CENTER>\n";
}


/* Display comments for a selected poll */
function DisplayComments($poll_id) {
	global $login_userid;
	global $comment_post_url;

	// Do we have comments?
	$comment_id = service_option("web3d_polls", "polls", "comment");
	if (!$comment_id)
		return;

	// Get the poll_desc db
	$db = new db_mysql;
	$db->set_db('guide');
	$db->set_user('guide');
	if ($db->connect()) {
		// Get the article for the poll
		$query = "SELECT article FROM poll_desc WHERE pollID = '$poll_id'";
		$db->query($query);
		$article = 0;
		if ($db->result_max() > 0) {
			$result = $db->result_fetch();
			$article = $result[article];
		}
		$db->query_end();
	}
	else {
		error("Unable to open poll description for comments");
	}

	// Display the comments
	if ($article) {
		echo "<CENTER>\n<P>\n";
		// Show the post comment link
		echo "<A HREF='$comment_post_url?mode=POST&amp;post_article=$article'>Post a comment</A></P>\n";
		// Show the comments
		comment_display($article);
		echo "</CENTER>\n";
	}

	// Close the db
	$db->disconnect();
}

?>

</P><P>

<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="/utils/footer.js"></SCRIPT>
<SCRIPT TYPE="text/javascript">
footer('/pics/menu_lit/sitemap.gif','Sitemap','/sitemap.html');
</SCRIPT> 

</BODY>
</HTML>
