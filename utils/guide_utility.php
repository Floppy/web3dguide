<?php
	/*
	#==================================#	
	# Guide-specific Utility Functions #
	#==================================#	
	10/08/2001 - James Smith
	*/

/*
#===--- comment_form
Creates a standard comment form
*/
	function comment_form($subject, $resultpage, $bodytag) {

      $mailto = '&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;';   
	
      echo "<FORM NAME='COMMENTFORM' onSubmit='return Validate();' ACTION='http://web3d.vapourtech.com/cgi-bin/emailform.pl' METHOD='POST'>\n";
      echo "<INPUT TYPE='HIDDEN' NAME='MAILTO' VALUE='$mailto'>\n";
      echo "<INPUT TYPE='HIDDEN' NAME='SUBJECT' VALUE='$subject'>\n";
      echo "<INPUT TYPE='HIDDEN' NAME='RESULTPAGE' VALUE='$resultpage'>\n";
      echo "<INPUT TYPE=\"HIDDEN\" NAME=\"BODYTAG\" VALUE=\"$bodytag\">\n";
      echo "<TABLE BORDER='0'>\n";
      echo "<TR><TD ALIGN='RIGHT'><STRONG>Name:</STRONG></TD><TD><INPUT TYPE='TEXT' SIZE='42' NAME='NAME' VALUE='Anonymous'></TD></TR>\n";
      echo "<TR><TD ALIGN='RIGHT'><STRONG>Email address:</STRONG></TD><TD><INPUT TYPE='TEXT' SIZE='42' NAME='EMAIL'></TD></TR>\n";
      echo "<TR><TD ALIGN='RIGHT' VALIGN='TOP'><STRONG>Comment:</STRONG></TD><TD><TEXTAREA COLS='40' ROWS='3' NAME='COMMENT'></TEXTAREA></TD></TR>\n";
      echo "<TR><TD></TD><TD><INPUT TYPE='SUBMIT' VALUE='Submit Comment'> <INPUT TYPE='RESET' VALUE='Reset'></TD></TR>\n";
      echo "<TR><TD></TD><TD>NOTE: Comments do not appear immediately! Only submit once!</TD></TR>\n";
      echo "</TABLE></FORM>";
   }

/*
#===--- get_category_name
Looks up an individual category name in a table
THIS WILL BREAK STUFF - DO NOT USE
*/

   function get_category_name($category_id,$category_table) {

      $name = "";

      // Create database object
	   $cat_db = new db_mysql;
   	// Set up the database object
	   $cat_db->set_db('guide');
   	$cat_db->set_user('guide', '');
   	
   	// Connect to the database
	   if ($cat_db->connect()) {

         if ($cat_db->query("SELECT name FROM $category_table WHERE id = $category_id")) {
            $category = $cat_db->result_fetch();
            $name = $category[name];
         }
         $cat_db->query_end();
	   
	      $cat_db->disconnect();
	   }
	   return $name;
      
   }

/*
#===--- preload_category_names
Create an associative array of category names
*/

   function preload_category_names($category_table) {

      $names = array();

      // Create database object
	   $cat_db = new db_mysql;
   	// Set up the database object
	   $cat_db->set_db('guide');
   	$cat_db->set_user('guide', '');
   	
   	// Connect to the database
	   if ($cat_db->connect()) {

         if ($cat_db->query("SELECT id, name FROM $category_table ORDER BY id")) {
            // Load each category into array
            while($cat = $cat_db->result_fetch()) {
               $names[$cat[id]] = $cat[name];
            }
         }
         $cat_db->query_end();
	   
	      $cat_db->disconnect();
	   }      

	   return $names;
      
   }
