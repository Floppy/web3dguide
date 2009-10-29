<?php
	/*
	#=======================================#
	# Event Config for web3d.vapourtech.com #
	#=======================================#
	14/08/2001 - James Smith
	*/

	// Set the variables
	$event_id = "web3d_diary";
	$event_url = "/diary/index.php";
	$event_length = 3;
	$admin_email = "&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;";
   $disable_previous = true;

	// Override the format
	$event_format = array(
		"summary_title" => array(
			"start" => "<P><CENTER><FONT FACE='Arial' SIZE='+1'>",
			"end" => "</FONT></CENTER></P>\n"
		),
		
		"article" => array(
			"start" => "<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0' BORDER='0' CLASS='ITEMBORDER' BGCOLOR='#BB0000'>\n",
			"end" => "</TABLE><P>\n"
		),
		"event_date" => array(
			"start" => "<TR><TD WIDTH='25%' VALIGN='TOP'>\n<P CLASS='SECTIONTITLE'><FONT FACE='Arial' COLOR='#FFFFFF' SIZE='-1'>",
			"to" => " - ",
			"format" => "jS M Y",
			"end" => "</FONT></TD>\n"
		),
		"title" => array(
			"start" => "<TD ALIGN='CENTER' VALIGN='TOP'><FONT FACE='Arial' COLOR='#FFFFFF' SIZE='+1'>",
			"end" => "</FONT></P>\n</TD>\n"
		),
		"poster" => array(
			"start" => "<TD ALIGN='RIGHT' WIDTH='25%' VALIGN='TOP'>\n<P CLASS='SECTIONDATE'>\n<FONT FACE='Arial' COLOR='#FFFFFF' SIZE='-1'>Posted by ",
		),
		"date" => array(
			"start" => " on ",
			"format" => "jS M Y",
			"end" => "</FONT></P>\n</TD></TR>\n"
		),
		"text_box" => array(
			"start" => "<TR><TD COLSPAN='3'>\n<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0' BORDER='0' COLS='2' CLASS='ITEM' BGCOLOR='#FFFFFF'>\n<TR><TD>\n",
			"end" => "</TD></TR>\n</TABLE>\n"
		),
		"text" => array(
			"start" => "",
			"seperator" => "</P><P>",
			"end" => "\n"
		),
		"read_more" => array(
			"start" => "<P>",
			"text" => "Details",
			"end" => "\n",
		),
		
		"search_box" => array(
			"start" => "<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0' BORDER='0' CLASS='ITEMBORDER' BGCOLOR='#BB0000'>\n",
			"end" => "</TABLE>\n"
		),
		"search_title" => array(
			"start" => "<TR><TD>\n<P CLASS='SECTIONTITLE'><FONT FACE='Arial' COLOR='#FFFFFF' SIZE='+1'>",
			"text" => "Search Events",
			"end" => "</FONT></P>\n</TD></TR>\n"
		),
		"search_text" => array(
			"start" => "<TR><TD>\n<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0' BORDER='0' COLS='2' CLASS='ITEM' BGCOLOR='#FFFFFF'>\n<TR><TD>\n<CENTER>",
			"text" => "Search",
			"end" => "</CENTER>\n</TD></TR>\n</TABLE>\n</TD></TR>\n"
		),
		"list_link" => array(
			"start" => "<BR>",
			"text" => "List all events",
			"end" => "\n"
		),
		
		"list_box" => array(
			"start" => "<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0' BORDER='0' CLASS='ITEMBORDER' BGCOLOR='#BB0000'>\n",
			"end" => "</TABLE>\n"
		),
		"list_title" => array(
			"start" => "<TR><TD>\n<P CLASS='SECTIONTITLE'><FONT FACE='Arial' COLOR='#FFFFFF' SIZE='+1'>",
			"list_text" => "Event List",
			"search_text" => "Search Results",
			"end" => "</FONT></P>\n</TD></TR>\n"
		),
		"list_text" => array(
			"start" => "<TR><TD>\n<TABLE WIDTH='100%' CELLPADDING='2' CELLSPACING='0'  BORDER='0'CLASS='ITEM' BGCOLOR='#FFFFFF'>\n<TR><TD>\n<TABLE BORDER='0' WIDTH='100%'>\n",
			"end" => "</TABLE>\n</TD></TR>\n</TABLE>\n</TD></TR>\n"
		),
		"search_results" => array(
			"start" => "<P>",
			"end" => "</P>\n"
		),
		"list_date" => array(
			"start" => "<TR><TD WIDTH='20%'>\n<P>",
			"format" => "jS M Y",
			"end" => "</P>\n</TD>\n"
		),
		"list_name" => array(
			"start" => "<TD WIDTH='60%'>\n<P>",
			"end" => "</P></TD>\n"
		),
		"list_poster" => array(
			"start" => "<TD WIDTH='20%'>\n<P ALIGN='RIGHT'> Posted by ",
			"end" => "</P>\n</TD></TR>\n"
		),
	);

?>
