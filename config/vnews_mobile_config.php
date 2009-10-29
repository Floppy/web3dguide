<?php
	/*
	#======================================#
	# News Config for web3d.vapourtech.com #
	#======================================#
	08/08/2001 - James Smith
	*/

	// Set the variables
	$news_id = "web3d_news";
	$news_url = "/news/mobile.php";
	$news_length = 5;
	$admin_email = "&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;";

	// Override the format
	$news_format = array(
		"article" => array(
			"start" => "",
			"end" => ""
		),
		"title" => array(
			"start" => "<P><H1>",
			"end" => "</H1></P>\n"
		),
		"poster" => array(
			"start" => "<P>\n<STRONG>Posted by ",
		),
		"date" => array(
			"format" => "G:i jS M Y",
			"end" => "</STRONG></P>\n"
		),
		"text_box" => array(
			"start" => "",
			"end" => ""
		),
		"text" => array(
			"start" => "<P>",
			"seperator" => "</P><P>",
			"end" => "</P>\n",
		),
		"comment" => array(
			"start" => "",
			"end" => "\n"
		),
	);

?>
