<?php

   // Pull in library support functions
   require_once("library_support.inc.php");

   // Pull in the core utility functions
   include_once("vutility_core.php");

   // Create database object
   $db = new db_mysql;
   // Set up the database object
   $db->set_db('guide');
   $db->set_user('guide', '');
	
   // Connect to the database
   if ($db->connect()) {   

   $query = "SELECT id, title, name, externproto FROM library WHERE externproto != ''";

   if ($db->query($query)) {

      // Send header
      header('Content-type: application/octet-stream');
      header('Content-Disposition: attachment; filename="libfloppy.bas"');
      header('Pragma: no-cache');
      header('Expires: 0');
      
   
      while ($source=$db->result_fetch()) {

         $name = get_proto_name($source);

         // Create header comments
         $vb  = "# Floppy's Web3D Guide: Library Entry $source[id]\n";
         $vb .= "# =====----------------------------------\n";
         $vb .= "# Title:       ";
         $vb .= $source[title];
         $vb .= "\n# Author:      ";
         $vb .= $source[name];
         $vb .= "\n# Description: http://web3d.vapourtech.com/library/content.php?id=";
         $vb .= $source[id];
         $vb .= "\n# =====----------------------------------\n";
         // Add EXTERNPROTO
         $vb .= "$source[externproto]\n";
         $vb .= "[\n";
         $vb .= create_externproto_url($source);
         $vb .= "]";

         // Replace double quotes
         $vb = str_replace("\"", "\"\"", $vb);

         // Replace line endings
         $vb = str_replace("\r", "", $vb);
         $vb = str_replace("\n", "\" + vbCrLf\ndoc.Selection = \"", $vb);

         // Add start and end;
         $vb = "doc.Selection = \"" . $vb;
         $vb .= "\" + vbCrLf\n";


         // Add Extra VB Code
         // At the beginning (in reverse order)
         $vb = "Set doc = Window.Documents.Active\n" . $vb;
         $vb = "Sub $name\n" . $vb;
         $vb = "BindCommand \"$name\", \"$source[title]\", \"Externprotos|Floppy's Web3D Guide|$source[title]\"\n" . $vb;
         // And at the end...
         $vb .= "doc.Saved = False\n";
         $vb .= "End Sub\n\n";

         // Print code
         echo $vb;

      }
   }
   else echo "Bad Query";
       
}
else echo "DB Failed";
?>
