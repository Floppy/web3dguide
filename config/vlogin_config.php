<?php
	/*
	#=======================================#
	# Login Config for web3d.vapourtech.com #
	#=======================================#
   Copyright 2002 Vapour Technology Ltd.
	17/01/2002 - Warren Moore
	*/

	// Set the variables
	$login_id = "web3d_login";
	$login_url = "/login.php";
   $login_confirm_url = "http://web3d.vapourtech.com/login.php";
   $login_redirect_url = "/auth.php";
   $login_cookie = "web3d_user_login";
	$login_mailman_email = "web3dnews-request@vapourtech.com";
	$admin_email = "webmaster@vapourtech.net";

	// Override the format
   $login_format = array(
      "main_dialog" => array(
         "start" => "<TABLE BORDER=0 CELLPADDING=4>\n",
      ),
      "main_nick" => array(
         "start" => "<TR><TD COLSPAN=2>\n<CENTER><B>Login</B></CENTER>\n</TD></TR>\n<TR><TD>\n<DIV ALIGN=RIGHT>Username</SPAN>\n</TD>\n<TD>\n",
      ),
      "main_password" => array(
         "start" => "<TR><TD>\n<DIV ALIGN=RIGHT>Password</SPAN>\n</TD>\n<TD>\n",
      ),

      
      "create_dialog" => array(
         "start" => "<TABLE BORDER=0 CELLPADDING=4>\n",
      ),

      "remind_dialog" => array(
         "start" => "<TABLE BORDER=0 CELLPADDING=4>\n",
      ),
      
      "logout_dialog" => array(
         "text_post_username" => "'.<BR><A HREF='main.php'>Back to the front</A></P>\n",
      ),
	);

?>
