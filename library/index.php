<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - The VRML Developers Library</TITLE>
<META NAME="DESCRIPTION" CONTENT="Guide to the world of VRML, with one of the best tutorials on the web.">
<META NAME="KEYWORDS" CONTENT="VRML, VRML97, Virtual Reality Modeling Language,	Tutorial, Guide, 3D, FAQ,
				Computer Graphics, Web3D, Java, JavaScript, ECMAScript, Virtual Reality,
				Internet 3D, VRML Worlds, VRML Tutorial, Web3D Guide, 3D Worlds, Cyberspace">
</HEAD>
<BODY BGCOLOR='#DDDDDD' TEXT='#000000' LINK="#ff0000" ALINK="#ffff00" VLINK="#DD0000">
<P><CENTER><IMG SRC="/pics/titles/library.gif" WIDTH=213 HEIGHT=60 ALT="Library"><BR></CENTER>
<?php
   // Strip control codes
	$search = stripslashes($search);
   $s = htmlentities($search,ENT_QUOTES);

   echo "<CENTER><FORM ACTION='index.php' METHOD='POST'>";
   echo "<INPUT TYPE='text' NAME='search' VALUE='$s'> <INPUT TYPE='submit' VALUE='Search'>";
   if (($search) || isset($category) || isset($top10)) echo "<BR><A HREF='index.php'>Show Categories</A>";
   else {
      echo "<BR><A HREF='index.php?top10=1'>The Top 10</A>\n";
   }   
   echo "</FORM></CENTER><P>";

   $table_name = "library";

	// Pull in the core utility functions
	include_once("vutility_core.php");
	// Pull in the guide utility functions
	include_once("$DOCUMENT_ROOT/utils/guide_utility.php");

   // Preload library category names
   $library_category_names = preload_category_names("library_categories");

   // Create database object
	$db = new db_mysql;
	// Set up the database object
	$db->set_db('guide');
	$db->set_user('guide', '');


	// Connect to the database
	if ($db->connect()) {   

      if (($search) || ($category) || isset($top10)) {
   
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
   			$cols = array("title", "name", "shortdesc", "longdesc");
   			$numresults = $searchengine->query($cols, $id, $search, $tempresult);
   			$searchengine->end();
   			// Sort results by name
   			$sortengine = new db_sort;
   			$sortengine->set_db($db,$table_name);
   			$sortengine->query($id, "title", $tempresult, $result);
   			$sortengine->end();   			
         }
         else if ($top10) {
            // Get top 10
            if ($db->query("SELECT $id FROM $table_name WHERE vote_count != 0 ORDER BY total_votes/vote_count DESC LIMIT 10")) {
                while ($db_result = $db->result_fetch()) {
                   $result[] = $db_result[$id];
                   $numresults++;
                }					
             }
         }
         else {
            // Get categories
				if ($db->query("SELECT $id FROM $table_name WHERE categories LIKE '%$category%' ORDER BY title")) {
					while ($db_result = $db->result_fetch()) {
						$result[] = $db_result[$id];
						$numresults++;
					}					
				}
         }

         echo "<CENTER><STRONG>";
         echo "$numresults result" . (($numresults!=1) ? "s" : "") . " found";

         if ($category) {
            echo " for category \"$library_category_names[$category]\"";
         }

         echo ".</STRONG><P>\n";

         if ($numresults > 0) {
            echo "<TABLE BORDER='0' WIDTH='95%' CELLSPACING='2' CELLPADDING='5' ALIGN='CENTER'>\n";
            echo "<TR>\n";
            echo "<TD ALIGN='CENTER'><STRONG>Title</STRONG></TD>\n";
            echo "<TD ALIGN='CENTER'><STRONG>Description</STRONG></TD>\n";
            echo "<TD ALIGN='CENTER'><STRONG>Rating</STRONG></TD>\n";
            echo "<TD ALIGN='CENTER'><STRONG>Sample</STRONG></TD>\n";
            echo "<TD ALIGN='CENTER'><STRONG>PROTO</STRONG></TD>\n";
            echo "</TR>\n";
         }

         foreach ($result as $entry_id) {
				if ($db->query("SELECT id, title, shortdesc, sample, externproto, total_votes, vote_count FROM $table_name WHERE $id = $entry_id")) {
					// Get each array
					while ($entry = $db->result_fetch()) {

                  echo "<TR>\n";
                  echo "<TD><STRONG><A HREF='content.php?id=$entry[id]'>$entry[title]</A></STRONG></TD>\n";
                  echo "<TD>$entry[shortdesc]</TD>\n";
                  echo "<TD ALIGN='CENTER'>\n";
                  if ($entry[vote_count]>0) {
                     $numstars = floor(($entry[total_votes]/$entry[vote_count]) + 0.5);
                     for ($i=0;$i<$numstars;$i++) echo "<IMG SRC='/pics/star.gif' ALT='*'>";
                  }
                  echo "</TD>\n";
                  echo "<TD ALIGN='CENTER'>\n";
                  if ($entry[sample]) echo "<IMG SRC='/pics/sample.gif' ALIGN=ABSMIDDLE ALT='Sample' HEIGHT=21 WIDTH=26>";
                  echo "</TD>\n";
                  echo "<TD ALIGN='CENTER'>\n";
                  if ($entry[externproto]) echo "<IMG SRC='/pics/sample.gif' ALIGN=ABSMIDDLE ALT='EXTERNPROTO' HEIGHT=21 WIDTH=26>";
                  echo "</TD>\n";
                  echo "</TR>\n";

					}
				}
				$db->query_end();
			}

         if ($numresults > 0) {
            echo "</TABLE>\n";
         }


      }
      else {
   
         if ($db->query("SELECT * FROM library_categories ORDER BY id")) {
      
            echo "<P>\n";
            echo "Welcome to the Web3D Guide's developer library! This area contains\n";
            echo "loads of useful code samples that have been submitted by users of the Guide.\n";
            echo "Each example is shown with a 3D preview of the result, along with highlighted\n";
            echo "code and a description of how it works.\n";
            echo "Entries with PROTOs can be used directly from this site by cutting and\n";
            echo "pasting the EXTERNPROTO definition from the page. You can also download the code directly to\n";
            echo "your computer by clicking the <IMG SRC='/pics/disk.gif' HEIGHT='16' WIDTH='16' ALT='Download'>\n";
            echo "icons.\n";
            echo "<P>\n";
            echo "If you have any VRML code that you think might be useful to other developers,\n";
            echo "please submit to the library by clicking the link below!\n";
            echo "</P>\n";

            echo "<CENTER>\n";
            echo "<TABLE WIDTH='75%' CELLSPACING='10' CELLPADDING='0' BORDER='0'>";
            $col = 0;
            while ($cat=$db->result_fetch()) {
               if ($col == 0) echo "<TR VALIGN='TOP'>";
               echo "<TD><TABLE WIDTH='100%' BORDER='0' CELLSPACING='3' CELLPADDING='3'><TR>";
               echo "<TD ALIGN='CENTER' BGCOLOR='#BB0000'><A HREF='index.php?category=$cat[id]'><FONT FACE='Arial' SIZE='+1' COLOR='#ffffff'>$cat[name]</FONT></A></TD></TR>";
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
            $db->query_end();
            echo "</TABLE>";

            echo "<P><FONT FACE='Arial' SIZE='+2'><A HREF='submit.html'>Submit Code</A></FONT>\n";
            // Get number of entries
            $db->query("SELECT COUNT(id) FROM library");
            echo "<P><STRONG>";
            while ($count=$db->result_fetch()) {
               echo $count[0];
            }
            echo " entries in database</STRONG></CENTER>";
            $db->query_end();

            echo "<P><table CELLSPACING='0' CELLPADDING='3' BORDER='0' WIDTH='100%'>\n";
            echo "<tr><td HEIGHT='20' BGCOLOR='#BB0000'>\n";
            echo "<font FACE='Arial' SIZE='+1' COLOR='#FFFFFF'>VrmlPad AddIn</font>\n";
            echo "</td></tr>\n";
            echo "</table>\n";
            echo "<P>\n";
            echo "If you use ParallelGraphics' VrmlPad to write your VRML content, you can now download a plugin that will put the Library at your fingertips. This plugin adds an entry to your Tools menu which contains all the reusable EXTERNPROTOs from the library! Simply click on the one you want, and it's inserted into your file. Could it be any easier?\n";
            echo "</P>\n";
            echo "<P>\n";
            echo "To install the plugin, download the file from below, and save it as <B>libfloppy.bas</B> in your VrmlPad AddIns directory (normally C:\Program Files\ParallelGraphics\VrmlPad\AddIns). Then simply start VrmlPad and it should be there! If you have any problems, just <A HREF='mailto:&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;'>mail me</A>. Enjoy!\n";
            echo "</P>\n";
            echo "<a HREF='vrmlpad.php'><img SRC='/pics/disk.gif' BORDER='0' ALT='Download' HEIGHT=16 WIDTH=16> Download Floppy's VrmlPad Addin now!</a>\n";

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


