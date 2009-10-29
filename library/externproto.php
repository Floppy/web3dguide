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

   $query = "SELECT id, title, name, externproto, license FROM library WHERE externproto != ''";

   if ($db->query($query)) {

      // Send header
      header('Content-type: model/vrml');
      header('Content-Disposition: attachment; filename="libfloppy.wrl"');
      header('Pragma: no-cache');
      header('Expires: 0');

      echo "#VRML V2.0 utf8\n";
      echo "#!Description: Floppy's Web3D Guide PROTO Library\n\n";
   
      while ($source=$db->result_fetch()) {

         $name = get_proto_name($source);

         // Create header comments
         $proto  = "# Floppy's Web3D Guide: Library Entry $source[id]\n";
         $proto .= "# =====----------------------------------\n";
         $proto .= "# Title:       ";
         $proto .= $source[title];
         $proto .= "\n# Author:      ";
         $proto .= $source[name];
         $proto .= "\n# Description: http://web3d.vapourtech.com/library/content.php?id=";
         $proto .= $source[id];
         if ($source[license]) {
            $proto .= "\n# License:     ";
            $proto .= $source[license];
         }
         $proto .= "\n# =====----------------------------------\n";
         // Add EXTERNPROTO
         $proto .= "$source[externproto]\n";
         $proto .= "[\n";
         $proto .= create_externproto_url($source);
         $proto .= "]\n\n";

         echo $proto;

      }
   }
   else echo "Bad Query";
       
}
else echo "DB Failed";
?>
