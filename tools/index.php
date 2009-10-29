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

   // Strip control codes
	$search = stripslashes($search);
   $s = htmlentities($search,ENT_QUOTES);

   echo "<CENTER><FORM ACTION='index.php' METHOD='POST'>";
   echo "<INPUT TYPE='text' NAME='search' VALUE='$s'> <INPUT TYPE='submit' VALUE='Search'>";
   if (($search) || ($essential) || ($category) || ($top10)) echo "<BR><A HREF='index.php'>Show Categories</A>";
   else {
      echo "<BR><A HREF='index.php?essential=1'>The Essentials</A> - <A HREF='index.php?top10=1'>Top 10 Tools</A>\n";
   }
   echo "</FORM></CENTER><P>";

	/* Pull in the utility functions */
	require_once("vutility_core.php");
	/* Pull in the guide utility functions */
	require_once("$DOCUMENT_ROOT/utils/guide_utility.php");

   // Preload tool category names
   $tool_category_names = preload_category_names("tools_categories");

   $table_name = "tools";
	
   // Create database object
	$db = new db_mysql;
	// Set up the database object
	$db->set_db('guide');
	$db->set_user('guide', '');
	
	// Connect to the database
	if ($db->connect()) {
   
      if (($search) || ($essential) || ($category) || ($top10)) {

         // Setup search engine
         $searchengine = new db_search;
         $searchengine->set_db($db,$table_name);
         // Set search params
			$result = array();
			$id = "id";
			$numresults = 0;
		
         if ($search) {
            // Run search
            $tempresult = array();
   			$cols = array("name", "shortdesc", "longdesc", "author");
   			$numresults = $searchengine->query($cols, $id, $search, $tempresult);
   			$searchengine->end();
   			// Sort results by name
   			$sortengine = new db_sort;
   			$sortengine->set_db($db,$table_name);
   			$sortengine->query($id, "name", $tempresult, $result);
   			$sortengine->end();   			
         }
         else if ($essential) {
            // Get essential
				if ($db->query("SELECT $id FROM $table_name WHERE essential = '1' ORDER BY name")) {
					while ($db_result = $db->result_fetch()) {
						$result[] = $db_result[$id];
						$numresults++;
					}					
				}
         }
         else if ($top10) {
            // Get top 10
            if ($db->query("SELECT $id FROM tools WHERE vote_count != 0 ORDER BY total_votes/vote_count DESC LIMIT 10")) {
                while ($db_result = $db->result_fetch()) {
                   $result[] = $db_result[$id];
                   $numresults++;
                }					
             }
         }
         else {
            // Get by category
				if ($db->query("SELECT $id FROM $table_name WHERE category = $category ORDER BY name")) {
					while ($db_result = $db->result_fetch()) {
						$result[] = $db_result[$id];
						$numresults++;
					}					
				}
         }

         echo "<CENTER><STRONG>";
         echo "$numresults result" . (($numresults!=1) ? "s" : "") . " found";

         if ($category) {
            echo " for category \"$tool_category_names[$category]\"";
         }

         echo ".</STRONG><P>\n";

			foreach ($result as $entry_id) {
				if ($db->query("SELECT id, name, category, shortdesc, essential, vote_count, total_votes, price, os, homepage, download, buy FROM $table_name WHERE $id = $entry_id")) {
					// Get each array
					while ($tool = $db->result_fetch()) {

                  echo "<TABLE CELLPADDING='2' BORDER='0' WIDTH='75%'><TR><TD BGCOLOR='#BB0000'>";
                  echo "<TABLE WIDTH='100%' CELLSPACING='0' CELLPADDING='3' BORDER='0' BGCOLOR='#FFFFFF'>";
                  echo "<TR BGCOLOR='#BB0000'>";
                  echo "<TD COLSPAN='2' ALIGN='LEFT'>";
                  echo "<FONT FACE='Arial' SIZE='+1' COLOR='#ffffff'><STRONG>$tool[name]</STRONG></FONT> ";
                  if ($search || $essential) {
                     $tool_category = $tool[category];
                     echo "<A HREF='index.php?category=$tool_category'><FONT FACE='Arial' SIZE='-1' COLOR='#C0C0C0'><EM>$tool_category_names[$tool_category]</EM></FONT></A>";
                  }
                  echo "</TD>";
         
                  echo "<TD COLSPAN='2' ALIGN='RIGHT'>";
                  if ($tool[essential] == 1) {
                     echo "<FONT FACE='Arial' COLOR='#FFFFFF' SIZE='+1'>Essential!</FONT>\n";
                  }
                  if ($tool[vote_count]>0) {
                     $numstars = 0;
                     $rating = $tool[total_votes]/$tool[vote_count];
                     if ($rating > 4.5) $numstars = 5;
                     else if ($rating > 3.5) $numstars = 4;
                     else if ($rating > 2.5) $numstars = 3;
                     else if ($rating > 1.5) $numstars = 2;
                     else if ($rating > 0.5) $numstars = 1;
                     for ($i=0;$i<$numstars;$i++) echo "<IMG SRC='/pics/star.gif' ALT='*'>";
                  }
                  echo "</TD>";
            
                  echo "</TR>";
                  echo "<TR>";
                  echo "<TD COLSPAN='2'><STRONG>Price: $tool[price]</STRONG></TD>";
                  echo "<TD COLSPAN='2'><STRONG>OS: $tool[os]</STRONG></TD>";
                  echo "</TR>";
                  echo "<TR>";
                  echo "<TD COLSPAN='4'>";
                  echo "$tool[shortdesc]";
                  echo "</TD>";
                  echo "<TR>";
                  echo "<TD ALIGN='CENTER'><A HREF='details.php?id=$tool[id]'><IMG SRC='/pics/tools/moreinfo.gif' ALT='Comment on and rate this product!' WIDTH='100' HEIGHT='25' BORDER='0'></A></TD>";
                  if (!$tool[homepage]) echo "<TD ALIGN='CENTER'><IMG SRC='/pics/tools/homepage_inactive.gif' ALT='Inactive' WIDTH='100' HEIGHT='25' BORDER='0'></TD>";
                  else echo "<TD ALIGN='CENTER'><A HREF='$tool[homepage]' TARGET='_blank'><IMG SRC='/pics/tools/homepage.gif' ALT='Visit the authors homepage' WIDTH='100' HEIGHT='25' BORDER='0'></A></TD>";
                  if (!$tool[download]) echo "<TD ALIGN='CENTER'><IMG SRC='/pics/tools/download_inactive.gif' ALT='Inactive' WIDTH='100' HEIGHT='25' BORDER='0'></TD>";
                  else echo "<TD ALIGN='CENTER'><A HREF='$tool[download]' TARGET='_blank'><IMG SRC='/pics/tools/download.gif' ALT='Download the product' WIDTH='100' HEIGHT='25' BORDER='0'></A></TD>";
                  if (!$tool[buy]) echo "<TD ALIGN='CENTER'><IMG SRC='/pics/tools/buy_inactive.gif' ALT='Inactive' WIDTH='100' HEIGHT='25' BORDER='0'></TD>";
                  else echo "<TD ALIGN='CENTER'><A HREF='$tool[buy]' TARGET='_blank'><IMG SRC='/pics/tools/buy.gif' ALT='Buy online!' WIDTH='100' HEIGHT='25' BORDER='0'></A></TD>";
                  echo "</TR>";
                  echo "</TABLE></TD></TR></TABLE><P>";

					}
				}
				$db->query_end();
			}

      }
      else {

         echo "<CENTER><TABLE WIDTH='75%' CELLSPACING='10' CELLPADDING='0' BORDER='0'>";
         $col = 0;

         $db->query("SELECT * FROM tools_categories ORDER BY id");
         while ($category=$db->result_fetch()) {
            if ($col == 0) echo "<TR VALIGN='TOP'>";
            echo "<TD><TABLE WIDTH='100%' BORDER='0' CELLSPACING='3' CELLPADDING='3'><TR>";
            echo "<TD ALIGN='CENTER' BGCOLOR='#BB0000'><A HREF='index.php?category=$category[id]'><FONT FACE='Arial' SIZE='+1' COLOR='#ffffff'>$category[name]</FONT></A></TD></TR>";
            echo "<TR VALIGN='TOP'><TD ALIGN='CENTER'>$category[description]</TD></TR></TABLE></TD>";
            if ($col == 2) $col = 0;
            else $col++;
            if ($col == 0) echo "</TR>";
         }
         if ($col != 0) {
           for ( ; $col<3; $col++) {
              echo "<TD>&nbsp;</TD>";
              if ($col == 2) echo "</TR>";
           }
         }
         echo "</TABLE>";

         $db->query_end();

         // Get number of entries
         $db->query("SELECT COUNT(id) FROM tools");
         echo "<STRONG>";
         while ($count=$db->result_fetch()) {
            echo $count[0];
         }
         echo " tools in database</STRONG></CENTER>";
         $db->query_end();
      
      }

      $db->disconnect();
   }
?>
<P>

<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="/utils/footer.js"></SCRIPT>
<SCRIPT TYPE="text/javascript">
footer('/pics/menu_lit/sitemap.gif','Sitemap','/sitemap.html');
</SCRIPT> 

</BODY>
</HTML>


