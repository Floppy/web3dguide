<?php

   // Pull in the core news functions
   include_once("vnews_core.php");

   // Set the variables
   $news_id = "web3d_news";
   $news_url = "http://web3d.vapourtech.com/news/index.php";
   $news_length = 5;
   $admin_email = "&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;";
   $rss_title = "Floppy's Web3D Guide";
   $rss_url   = "http://web3d.vapourtech.com";
   $rss_desc  = "The latest Web3D news";

   // Generate the RSS page
   rss_news_process();

?>
