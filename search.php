<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"> 
<HTML>
<HEAD>
<TITLE>Floppy's Web3D Guide - Search</TITLE>
</HEAD>
<BODY BGCOLOR='#DDDDDD' TEXT='#000000' LINK="#ff0000" ALINK="#ffff00" VLINK="#DD0000">
<CENTER>
<IMG SRC="/pics/titles/search.gif" WIDTH="196" HEIGHT="60" ALT="Search"><P>
<?php

   // Strip control codes
	$search = stripslashes($search);
   $s = htmlentities($search,ENT_QUOTES);

   echo "<FORM ACTION='search.php' METHOD='POST'>\n";
   echo "<INPUT TYPE='text' NAME='search' VALUE='$s'> <INPUT TYPE='submit' VALUE='Search!'><BR>\n";
   echo "</FORM></CENTER>\n";

   if ($search) {
      
		$news_config_file = "$DOCUMENT_ROOT/config/vnews_config.php";
		$event_config_file = "$DOCUMENT_ROOT/config/vevent_config.php";
		$auth_config_file = "$DOCUMENT_ROOT/config/vauth_config.php";

   	/* Pull in the utility functions */
   	require_once("vutility_core.php");
	   // Pull in the core news functions
	   include_once("vnews_core.php");

      // News search

	   // Setup search params
	   $mode = "search";
	   $arg = $search;
	   // Generate the news search section
      news_process();

	   // Pull in the core event functions
	   include_once("vevent_core.php");
      // Diary search
      echo '<P>';
      // Setup event manager params
		$event_format[list_title][search_text] = "Diary";
      $event_format[search_box][start] = "<!--";
      $event_format[search_box][end] = "-->";
	   // Generate the event search section
      event_process();

	   // Pull in the guide utility functions
	   include_once("$DOCUMENT_ROOT/utils/guide_utility.php");

      // Preload tool category names
      $tool_category_names = preload_category_names("tools_categories");

      // Preload link category names
      $link_category_names = preload_category_names("links_categories");

      // Create database object for other searches
	   $db = new db_mysql;
   	// Set up the database object
	   $db->set_db('guide');
   	$db->set_user('guide', '');

      if ($db->connect()) {
      
         // Tools search
         echo "<P>";
      
         // Create search object
         $searchengine = new db_search();

         // Setup search engine
         $table_name = "tools";
         $searchengine->set_db($db,$table_name);
         
			$cols = array("name", "author", "shortdesc", "longdesc");
			$id = "id";
			$result = array();
			$tempresult = array();
			$numresults = $searchengine->query($cols, $id, $search, $tempresult);
			$searchengine->end();
			$news_format[list_title][search_text] = "Tools";

			// Sort results by name
			$sortengine = new db_sort;
			$sortengine->set_db($db,$table_name);
			$sortengine->query($id, "name", $tempresult, $result);
			$sortengine->end();   			


         // Start result box
   		echo $news_format[list_box][start];
	   	// Display the list box title
   		echo $news_format[list_title][start];
	   	echo $news_format[list_title][search_text];
		   echo $news_format[list_title][end];

			echo $news_format[list_text][start];
			echo $news_format[search_results][start];
			echo "Found $numresults tool". ($numresults != 1 ? "s" : "") ."  matching <I>'$search'</I></P>\n";
			echo $news_format[search_results][end];

			foreach ($result as $search_id) {
				if ($db->query("SELECT id, name, category, shortdesc FROM $table_name WHERE $id = $search_id")) {
   				// Get each array
	   			while ($tool = $db->result_fetch()) {
		   			// Output tool details
			   		echo "<TR>";
				   	echo "<TD VALIGN='top'><A HREF='/tools/details.php?id=$tool[id]'>$tool[name]</A></TD><TD VALIGN='top'>$tool[shortdesc]</TD><TD VALIGN='top' ALIGN='right'>";
				   	$tool_category = $tool[category];
                  echo "<A HREF='/tools/index.php?category=$tool_category'><FONT FACE='Arial' SIZE='-1' COLOR='#7F7F7F'><EM>$tool_category_names[$tool_category]</EM></FONT></A>\n";
	   				echo "</TD></TR>\n";
		   		}
			   }
				$db->query_end();
   		}
			echo $news_format[list_text][end];
			echo $news_format[list_box][end];
			$searchengine->end();

         
         // Links search
         echo "<P>";
         
         // Setup search engine
         $table_name = "links";
         $searchengine->set_db($db,$table_name);
         
			$cols = array("title", "description");
			$id = "id";
			$result = array();
			$tempresult = array();
			$numresults = $searchengine->query($cols, $id, $search, $tempresult);
			$searchengine->end();
			$news_format[list_title][search_text] = "Links";
         
			// Sort results by name
			$sortengine = new db_sort;
			$sortengine->set_db($db,$table_name);
			$sortengine->query($id, "title", $tempresult, $result);
			$sortengine->end();   			

         // Start result box
   		echo $news_format[list_box][start];
	   	// Display the list box title
   		echo $news_format[list_title][start];
	   	echo $news_format[list_title][search_text];
		   echo $news_format[list_title][end];

			echo $news_format[list_text][start];
			echo $news_format[search_results][start];
			echo "Found $numresults link". ($numresults != 1 ? "s" : "") ."  matching <I>'$search'</I></P>\n";
			echo $news_format[search_results][end];
      
			foreach ($result as $search_id) {
				if ($db->query("SELECT title, url, category, description FROM $table_name WHERE $id = $search_id")) {
					// Get each array
					while ($link = $db->result_fetch()) {
						// Output link details
						echo "<TR>";
						echo "<TD VALIGN='top'><A HREF='$link[url]' TARGET='_blank'>$link[title]</A></TD><TD VALIGN='top'>$link[description]</TD><TD VALIGN='top' ALIGN='right'>";
				   	$link_category = $link[category];
                  echo "<A HREF='/links.php?category=$link_category'><FONT FACE='Arial' SIZE='-1' COLOR='#7F7F7F'><EM>$link_category_names[$link_category]</EM></FONT></A>\n";
						echo "</TD></TR>\n";
					}
				}
				$db->query_end();
			}
			echo $news_format[list_text][end];
			echo $news_format[list_box][end];
			$searchengine->end();


         // Library search
         echo "<P>";
         
         // Setup search engine
         $table_name = "library";
         $searchengine->set_db($db,$table_name);
         
         // Create search object
         $table_name = "library";
         $searchengine = new db_search();
         $searchengine->set_db($db,$table_name);
         
			$cols = array("title", "shortdesc", "longdesc", "name");
			$id = "id";
			$result = array();
			$tempresult = array();
			$numresults = $searchengine->query($cols, $id, $search, $tempresult);
			$searchengine->end();
			$news_format[list_title][search_text] = "Library";
         
			// Sort results by name
			$sortengine = new db_sort;
			$sortengine->set_db($db,$table_name);
			$sortengine->query($id, "title", $tempresult, $result);
			$sortengine->end();   			

         // Start result box
   		echo $news_format[list_box][start];
	   	// Display the list box title
   		echo $news_format[list_title][start];
	   	echo $news_format[list_title][search_text];
		   echo $news_format[list_title][end];

			echo $news_format[list_text][start];
			echo $news_format[search_results][start];
			echo "Found $numresults entr". ($numresults != 1 ? "ies" : "y") ."  matching <I>'$search'</I></P>\n";
			echo $news_format[search_results][end];
      
			foreach ($result as $search_id) {
				if ($db->query("SELECT id, title, shortdesc FROM $table_name WHERE $id = $search_id")) {
					// Get each array
					while ($entry = $db->result_fetch()) {
						// Output link details
						echo "<TR>";
						echo "<TD VALIGN='top'><A HREF='/library/content.php?id=$entry[id]'>$entry[title]</A></TD>";
						echo "<TD VALIGN='top'>$entry[shortdesc]</TD></TR>\n";
					}
				}
				$db->query_end();
			}
			echo $news_format[list_text][end];
			echo $news_format[list_box][end];
         $searchengine->end();
         

         // Poll search
         echo "<P>";
         
         // Setup search engine
         $table_name = "poll_desc";
         $searchengine->set_db($db,$table_name);
         
			$cols = array("pollTitle");
			$id = "pollID";
			$result = array();
			$tempresult = array();
			$numresults = $searchengine->query($cols, $id, $search, $tempresult);
			$searchengine->end();
			$news_format[list_title][search_text] = "Polls";
                  
			// Sort results by name
			$sortengine = new db_sort;
			$sortengine->set_db($db,$table_name);
			$sortengine->query($id, "timeStamp", $tempresult, $result, true);
			$sortengine->end();   			

         // Start result box
   		echo $news_format[list_box][start];
	   	// Display the list box title
   		echo $news_format[list_title][start];
	   	echo $news_format[list_title][search_text];
		   echo $news_format[list_title][end];

			echo $news_format[list_text][start];
			echo $news_format[search_results][start];
			echo "Found $numresults poll". ($numresults != 1 ? "s" : "") ."  matching <I>'$search'</I></P>\n";
			echo $news_format[search_results][end];
      
			foreach ($result as $search_id) {
				if ($db->query("SELECT pollID, pollTitle, timeStamp FROM $table_name WHERE $id = $search_id")) {
					// Get each array
					while ($poll = $db->result_fetch()) {
						// Output link details
						echo "<TR>";
						echo "<TD VALIGN='top'><A HREF='polls/index.php?vote=$poll[pollID]'>$poll[pollTitle]</A></TD>";
						$date = date($news_format[list_date][format],$poll[timeStamp]);
						echo "<TD VALIGN='top' ALIGN='RIGHT'>$date</TD></TR>\n";
					}
				}
				$db->query_end();
			}
			echo $news_format[list_text][end];
			echo $news_format[list_box][end];
         $searchengine->end();


         // Dump database
         $db->disconnect();
      }
      
   }
   
?>
<P>

<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="/utils/footer.js"></SCRIPT>
<SCRIPT TYPE="text/javascript">
footer('/pics/menu_lit/sitemap.gif','Sitemap','/sitemap.html');
</SCRIPT> 

</BODY>
</HTML>

