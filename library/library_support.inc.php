<?php

   function send_save_vrml_http_headers($name) {
      header('Content-type: application/octet-stream');
      header('Content-Disposition: attachment; filename="' . $name . '.wrl"');
      header('Pragma: no-cache');
      header('Expires: 0');
   }

   function send_vrml_http_headers() {
      header ("Content-type: model/vrml");
   }

   function vrml_header() {
      return "#VRML V2.0 utf8\n";
   }

   function error_vrml($string) {
      // Print header
      $vrml  = vrml_header();
      // Print error text
      $vrml .= "Transform { translation -2 0 0 children [\n";
      $vrml .= "Shape {\n";
      $vrml .= "  geometry Text {\n";
      $vrml .= "    string \"$string\"\n";
      $vrml .= "    length 4\n";
      $vrml .= "  }\n";
      $vrml .= "}\n";
      $vrml .= "]}\n";
      // Return
      return $vrml;
   }

   /* create_proto_vrml
    * requires $entry to be an array with a proto entry.
    */
   function create_proto_vrml($entry) {
      // Print header
      $vrml  = vrml_header();
      $vrml .= "\n";
      $vrml .="$entry[proto]\n";
      // Done
      return $vrml;
   }

   /* create_example_vrml
    * requires $entry to be an array with enternproto, source, and id entries.
    */
   function create_example_vrml($entry) {
      // Print header
      $vrml  = vrml_header();
      $vrml .= "\n";
      // Print EXTERNPROTO definition if available
      if ($entry[externproto]) {
         $vrml .= "$entry[externproto]\n";
         $vrml .= "[\n";
         $vrml .= create_externproto_url($entry);
         $vrml .= "]\n";
         $vrml .= "\n";                
      }
      // Print source
      $vrml .= "$entry[source]";
      // Done
      return $vrml;
   }

   /* get_proto_name
    * creates a URL for an externproto definition
    * requires $entry to be an array with id and externproto entries.
    */
   function create_externproto_url($entry) {
      if ($entry[id]) {
         global $SERVER_NAME;
         $proto_name = get_proto_name($entry);
         if ($proto_name) {
            $url .= "   \"";
            $url .= "$proto_name.wrl#$proto_name";
            $url .= "\"\n";
         }
         $url .= "   \"http://";
         $url .= $SERVER_NAME;
         $url .= "/library/vrml.php?mode=proto&id=$entry[id]";
         if ($proto_name) {
            $url .= "#$proto_name";
         }
         $url .= "\"\n";
         return $url;
      }
   }

   /* get_proto_name
    * extracts the name of the proto being used in an externproto definition
    * requires $entry to be an array with an externproto entry.
    */
   function get_proto_name($entry) {
      if($entry[externproto]) {
         // Split string along spaces
         $arr = explode(" ",$entry[externproto]);
         // Find the word EXTERNPROTO
         $i=0;
         while ($arr[$i]) {
            if ($arr[$i] == "EXTERNPROTO") break;
            $i++;
         }
         // Pick out the next word
         $name = $arr[$i+1];
         // Return word
         return $name;
      }
   }

?>
