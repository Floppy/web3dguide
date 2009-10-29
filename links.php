<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - Links</title>
<META NAME="DESCRIPTION" CONTENT="Guide to the world of VRML, with one of the best tutorials on the web.">
<META NAME="KEYWORDS" CONTENT="VRML, VRML97, Virtual Reality Modeling Language,	Tutorial, Guide, 3D,
				Computer Graphics, Web3D, Java, JavaScript, ECMAScript, Virtual Reality, Links,
				Internet 3D, VRML Worlds, VRML Tutorial, Web3D Guide, 3D Worlds, Cyberspace, VRML Tools">
</HEAD>
<body BGCOLOR='#DDDDDD' TEXT='#000000' link="#ff0000" alink="#ffff00" VLINK="#DD0000">
<CENTER><IMG SRC="pics/titles/links.gif" WIDTH=148 HEIGHT=60 ALT="Links"></CENTER><P>
<?php
   // Strip control codes
	$search = stripslashes($search);
   $s = htmlentities($search,ENT_QUOTES);

   $table_name = "links";

	// Pull in the core utility functions
	include_once("vutility_core.php");
	// Pull in the guide utility functions
	include_once("$DOCUMENT_ROOT/utils/guide_utility.php");

   // Preload link category names
   $link_category_names = preload_category_names("links_categories");

   // Create database object
	$db = new db_mysql;
	// Set up the database object
	$db->set_db('guide');
	$db->set_user('guide', '');

	// Connect to the database
	if ($db->connect()) {   

      echo "<CENTER><FORM ACTION='links.php' METHOD='POST'>";
      echo "<INPUT TYPE='text' NAME='search' VALUE='$s'> <INPUT TYPE='submit' VALUE='Search'>";
      if (($search) || ($category)) echo "<BR><A HREF='links.php'>Show Categories</A>";
      else {
         // Get by category
      	if ($db->query("SELECT url FROM $table_name ORDER BY rand() LIMIT 1")) {
				while ($db_result = $db->result_fetch()) {
               echo "<BR><A HREF='$db_result[url]' TARGET='_blank'>Feeling Adventurous?</A>";
				}					
            $db->query_end();
			}
      }
      echo "</FORM></CENTER><P>";
	
      if (($search) || ($category)) {
   
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
   			$cols = array("title", "description");
   			$numresults = $searchengine->query($cols, $id, $search, $tempresult);
   			$searchengine->end();
   			// Sort results by name
   			$sortengine = new db_sort;
   			$sortengine->set_db($db,$table_name);
   			$sortengine->query($id, "title", $tempresult, $result);
   			$sortengine->end();   			
         }
         else {
            // Get by category
				if ($db->query("SELECT $id FROM $table_name WHERE category = $category ORDER BY title")) {
					while ($db_result = $db->result_fetch()) {
						$result[] = $db_result[$id];
						$numresults++;
					}					
				}
         }

         echo "<CENTER><STRONG>";
         echo "$numresults result" . (($numresults!=1) ? "s" : "") . " found";

         if ($category) {
            echo " for category \"$link_category_names[$category]\"";
         }

         echo ".</STRONG><P>\n";

			foreach ($result as $entry_id) {
				if ($db->query("SELECT title, url, category, description FROM $table_name WHERE $id = $entry_id")) {
					// Get each array
					while ($link = $db->result_fetch()) {
						// Output link details
                  echo "<TABLE COLS='1'  WIDTH='75%' BORDER='0'>";
                  echo "<TD ALIGN='LEFT'>";
                  echo "<A HREF='$link[url]' TARGET='_blank'><FONT FACE='Arial' SIZE='+1'><STRONG>$link[title]</STRONG></FONT></A>\n";
                  if ($search) {
                     $link_category = $link[category];
                     echo "<A HREF='links.php?category=$link_category'><FONT FACE='Arial' SIZE='-1' COLOR='#7F7F7F'><EM>$link_category_names[$link_category]</EM></FONT></A>";
                  }
                  echo "</TD></TR>";
                  echo "<TR><TD>$link[description]</TD></TR>";
                  echo "</TABLE><P>";

					}
				}
				$db->query_end();
			}

      }
      else {
   
         if ($db->query("SELECT * FROM links_categories ORDER BY id")) {
   
            echo "<CENTER>\n";
            echo "<TABLE COLS='3' WIDTH='75%' CELLSPACING='10' CELLPADDING='0' BORDER='0'>";
            $col = 0;
            while ($cat=$db->result_fetch()) {
               if ($col == 0) echo "<TR VALIGN='TOP'>";
               echo "<TD><TABLE WIDTH='100%' BORDER='0' CELLSPACING='3' CELLPADDING='3'><TR>";
               echo "<TD ALIGN='CENTER' BGCOLOR='#BB0000'><A HREF='links.php?category=$cat[id]'><FONT FACE='Arial' SIZE='+1' COLOR='#ffffff'>$cat[name]</FONT></A></TD></TR>";
               echo "<TR VALIGN='TOP'><TD ALIGN='CENTER' >$cat[description]</TD></TR></TABLE></TD>";
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
            $db->query("SELECT COUNT(id) FROM links");
            echo "<STRONG>";
            while ($count=$db->result_fetch()) {
               echo $count[0];
            }
            echo " links in database</STRONG></CENTER>";
            $db->query_end();

         }
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
