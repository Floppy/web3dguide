<?php
	/*
	#======================================#
	# News Config for web3d.vapourtech.com #
	#======================================#
	08/08/2001 - James Smith
	*/

	// Set the variables
	$news_id = "web3d_news";
	$news_url = "/news/index.php";
	$news_length = 6;
	$admin_email = "&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;";

	// Override the format
	$news_format = array(
		"article" => array(
			"start" => "<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0' BORDER='0' CLASS='ITEMBORDER' BGCOLOR='#BB0000'>\n",
			"end" => "</TABLE>\n<BR>\n"
		),
		"title" => array(
			"start" => "<TR><TD>\n<P CLASS='SECTIONTITLE'><FONT FACE='Arial' COLOR='#FFFFFF' SIZE='+1'>",
			"end" => "</FONT></P>\n</TD>\n"
		),
		"poster" => array(
			"start" => "<TD ALIGN='RIGHT'>\n<P CLASS='SECTIONDATE'>\n<FONT FACE='Arial' COLOR='#FFFFFF' SIZE='-1'>Posted by ",
		),
		"date" => array(
			"format" => "G:i jS M Y",
			"end" => "</FONT></P>\n</TD></TR>\n"
		),
		"text_box" => array(
			"start" => "<TR><TD COLSPAN='2'>\n<TABLE WIDTH='100%' CELLPADDING='4' CELLSPACING='0' BORDER='0' COLS='2' CLASS='ITEM' BGCOLOR='#FFFFFF'>\n<TR><TD ALIGN='JUSTIFY'>\n",
			"end" => "</TD></TR>\n</TABLE>\n"
		),
		"text" => array(
			"start" => "<P CLASS='SECTIONITEM'>",
			"seperator" => "</P><P>",
			"end" => "<BR>\n</P>\n",
		),
		"read_more" => array(
			"start" => "<P CLASS='SECTIONDATE'>",
			"text" => "Read more...",
		),
		
		"search_box" => array(
			"start" => "<!--<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0' BORDER='0' CLASS='ITEMBORDER' BGCOLOR='#BB0000'>\n",
			"end" => "-->",
		),

		"search_title" => array(
			"start" => "<TR><TD>\n<P CLASS='SECTIONTITLE'><FONT FACE='Arial' COLOR='#FFFFFF' SIZE='+1'>",
			"end" => "</FONT></P>\n</TD></TR>\n"
		),
		"search_text" => array(
			"start" => "<TR><TD>\n<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0' BORDER='0' COLS='2' CLASS='ITEM' BGCOLOR='#FFFFFF'>\n<TR><TD>\n<CENTER>",
			"text" => "Search",
			"end" => "</CENTER>\n</TD></TR>\n</TABLE>\n</TD></TR>\n"
		),
		
		"list_box" => array(
			"start" => "<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0' BORDER='0' CLASS='ITEMBORDER' BGCOLOR='#BB0000'>\n",
		),
		"list_title" => array(
			"start" => "<TR><TD>\n<P CLASS='SECTIONTITLE'><FONT FACE='Arial' COLOR='#FFFFFF' SIZE='+1'>",
			"search_text" => "News",
			"end" => "</FONT></P>\n</TD></TR>\n"
		),
		"list_text" => array(
			"start" => "<TR><TD>\n<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0'  BORDER='0'CLASS='ITEM' BGCOLOR='#FFFFFF'>\n<TR><TD>\n<TABLE BORDER='0' WIDTH='100%'>\n",
			"end" => "</TABLE>\n</TD></TR>\n</TABLE>\n</TD></TR>\n"
		),
		"list_date" => array(
			"start" => "<TR><TD WIDTH='20%'>\n<P>",
			"format" => "jS M Y",
		),
		"list_name" => array(
			"start" => "<TD WIDTH='60%'>\n<P>",
		),
		"list_poster" => array(
			"start" => "<TD WIDTH='20%'>\n<P ALIGN='RIGHT'> Posted by ",
		),
	);

?>
