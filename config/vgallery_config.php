<?php

	$user = "guide";
	$db_name = "guide";
	$email = "&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;";

	$format = array(
		"gallery" => array(
			"start" => "<TABLE WIDTH='100%' COLS='$max_cols' BORDER='0'>\n",
			"end" => "</TABLE>\n"
		),
		"group" => array(
			"start" => "<TR><TD HEIGHT='20' BGCOLOR='#BB0000' COLSPAN='$max_cols'><FONT FACE='Arial' SIZE='+1'>\n",
			"end" => "</FONT></TD></TR>\n"
		),
		"title" => array(
			"start" => "<TABLE WIDTH='100%' BORDER='0'><TR><TD HEIGHT='20' BGCOLOR='#BB0000'><FONT FACE='Arial' SIZE='+1'>\n",
			"end" => "</FONT></TD></TR></TABLE>\n",
		),
		"menu_prev" => array(
			"start" => "",
			"end" => " <",
		),
		"menu_next" => array(
			"start" => " > ",
			"end" => "",
		),
	);
	
?>
