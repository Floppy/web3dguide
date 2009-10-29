<?php
	/*
	#=========================================#
	# Comment Config for web3d.vapourtech.com #
	#=========================================#
   Copyright 2002 Vapour Technology Ltd.
	17/01/2002 - Warren Moore
	*/

	// Set the variables
	$comment_id = "web3d_comment";
   $comment_post_url = "/news/post.php";
	$admin_email = "webmaster@vapourtech.net";
	$comment_mod_email = "&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;";

	// Override the format
	$comment_format = array(
      "item" => array(
         "start" => "<TABLE WIDTH='100%' BORDER=0>\n",
      ),
      "item_title_box" => array(
         "start" => "<TR><TD BGCOLOR='#C0C0C0'>\n",
         "end" => "</TD></TR>\n"
      ),
      "item_title" => array(
         "start" => "<FONT FACE='Arial'><B>",
         "end" => "</B></FONT><BR>\n"
      ),
      "item_user" => array(
         "start" => "by '",
         "end" => "'"
      ),
      "item_comment" => array(
         "start" => "<TR><TD BGCOLOR='#FFFFFF'>\n",
      ),
      "item_reply" => array(
         "text" => "<FONT FACE='Arial' SIZE='-1'>Reply</FONT>",
      ),

      "post_preview" => array(
         "start" => "<P><FONT FACE='Arial'><B>Preview</B></FONT><BR>\n",
      ),
      "post_title" => array(
         "start" => "<P><FONT FACE='Arial'><B>Title</FONT></B> ",
      ),
      "post_comment" => array(
         "start" => "<P><FONT FACE='Arial'><B>Comment</B></FONT><BR>\n",
      ),
      
      "submit" => array(
         "text" => "Thank you for posting!<BR>\n<A HREF='/main.php'>Back to the front</A>\n",
      )
	);

?>
