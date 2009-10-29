<?php

   // Pull in library support functions
   require_once("library_support.inc.php");

   send_vrml_http_headers();

   if (isset($id)) {

      // Pull in the core utility functions
	   include_once("vutility_core.php");

      // Create database object
   	$db = new db_mysql;
   	// Set up the database object
   	$db->set_db('guide');
   	$db->set_user('guide', '');
	
   	// Connect to the database
   	if ($db->connect()) {   

         $query = "SELECT id, title, source, externproto, proto, is_vrml, sample FROM library WHERE id = $id";

         if ($db->query($query)) {
   
            $source=$db->result_fetch();
            
            if ($source[is_vrml]) {
               if ($mode=="proto") {
                  if ($source[proto]) {
                     if (isset($save)) {
                        $filename = get_proto_name($source);
                        send_save_vrml_http_headers($filename);
                     }
                     echo create_proto_vrml($source);
                  }
                  else echo error_vrml("No PROTO");                  
               }
               else {
                  if ($source[sample]) {
                     if (isset($save)) {
                        $filename = $source[title];
                        send_save_vrml_http_headers($filename);
                     }
                     echo create_example_vrml($source);
                  }
                  else echo error_vrml("No Sample");
               }

            }
            else echo error_vrml("Not VRML");
            
         }
         else echo error_vrml("Bad Query");
         
      }
      else echo error_vrml("DB Failed");
      
   }
   else echo error_vrml("No ID Given");

?>
