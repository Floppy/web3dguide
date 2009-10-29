<?php
   header ("Content-type: model/vrml");
   echo "#VRML V2.0 utf8\n";

   // Calculate length
   $length = $xdim * $zdim;

   // Seed random number generator
   mt_srand ((float) microtime() * 1000000);

   // Generate random data
   $heights = array();
   for ($i=0; $i<$length; $i++) {
      $heights[$i] = mt_rand(0,256) / 256;
   }

?>

Viewpoint {
   position 0 2 10
}

Transform {
<?php
   $xtranslation = -$xdim * $xspc / 2;
   $ztranslation = -$zdim * $zspc / 2;
   echo "   translation $xtranslation 0 $ztranslation \n";
?>
   scale 1 0.25 1
   children [
      Shape {
         geometry ElevationGrid {
            solid FALSE            
<?php
   echo "            xSpacing $xspc\n";
   echo "            zSpacing $zspc\n";
   echo "            xDimension $xdim\n";
   echo "            zDimension $zdim\n";

   // Heights
   echo "            height [\n";
   for ($i=0; $i<$length; $i++) {
      echo "               $heights[$i],\n";
   }
   echo "            ]\n";
   
   // Colours
   echo "            color Color {\n";
   echo "               color [\n";
   for ($i=0; $i<$length; $i++) {
      echo "                  1 $heights[$i] 0,\n";
   }
   echo "               ]\n";
   echo "            }\n";

?>
         }
      }
   ]
}
