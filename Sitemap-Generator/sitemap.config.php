<?php
/*
Sitemap Generator by Slava Knyazev. Further acknowledgements in the README.md file. 

Website: https://www.knyz.org/
I also live on GitHub: https://github.com/knyzorg
Contact me: Slava@KNYZ.org
*/

//Make sure to use the latest revision by downloading from github: https://github.com/knyzorg/Sitemap-Generator-Crawler

/* Usage
Usage is pretty strait forward:
- Configure the crawler by editing this file.
- Select the file to which the sitemap will be saved
- Select URL to crawl
- Configure blacklists, accepts the use of wildcards (example: http://example.com/private/* and *.jpg)
- Generate sitemap
- Either send a GET request to this script or run it from the command line (refer to README file)
- Submit to Google
- Setup a CRON Job execute this script every so often

It is recommended you don't remove the above for future reference.
*/

//set execution time to unlimited
ini_set('max_execution_time', 1200);

// function shutdown() 
// { 
//     $a=error_get_last(); 
//      if($a==null)   
//          echo "No errors"; 
//      else 
//           print_r($a); 
// }
// register_shutdown_function('shutdown'); 
// ini_set('max_execution_time',10); 
// while(10) {header("Location: http://localhost/prospektpdfdesigner/webbscraper.php");}

// Default site to crawl
// $site = "https://www.knyz.org/";

// $inputProspektUrl_value = "";
// $site = "";
// $forum = simplexml_load_file('result.xml');
// /* delete value */
// unset($forum->item[0]);

$inputProspektUrl_value = $_POST['inputProspektUrl'];
$site = $inputProspektUrl_value;

session_start();
$_SESSION["prospektUrl"] = $inputProspektUrl_value;

// Default sitemap filename
// $file = "sitemap.xml";
$file = "result.xml";
$permissions = 0644;

// Depth of the crawl, 0 is unlimited
$max_depth = 2;

// Show changefreq
$enable_frequency = false;

// Show priority
$enable_priority = false;

// Default values for changefreq and priority
$freq = "daily";
$priority = "1";

// Add lastmod based on server response. Unreliable and disabled by default.
$enable_modified = false;

// Disable this for misconfigured, but tolerable SSL server.
$curl_validate_certificate = true;

// The pages will be excluded from crawl and sitemap.
// Use for exluding non-html files to increase performance and save bandwidth.
$blacklist = array(
    "*.jpg",
    "*/secrets/*",
    "https://www.knyz.org/supersecret"
);

// Enable this if your site do requires GET arguments to function
$ignore_arguments = false;

// Not yet implemented. See issue #19 for more information.
$index_img = false;

//Index PDFs
$index_pdf = true;

// Set the user agent for crawler
$crawler_user_agent = "Mozilla/5.0 (compatible; Sitemap Generator Crawler; +https://github.com/knyzorg/Sitemap-Generator-Crawler)";

// Header of the sitemap.xml
$xmlheader ='<?xml version="1.0" encoding="UTF-8"?>
<urlset
xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

// Optionally configure debug options
$debug = array(
    "add" => true,
    "reject" => false,
    "warn" => false
);


//Modify only if configuration version is broken
$version_config = 2;
