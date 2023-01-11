<?php

include 'connect.php';
include 'ajax.php';

ini_set('max_execution_time',0);

// function shutdown() 
// { 
//     $a=error_get_last(); 
//      if($a==null)   
//          echo "No errors"; 
//      else 
//           print_r($a); 
// }
// register_shutdown_function('shutdown'); 
// ini_set('max_execution_time',0); 
// while(0) {header("Location: resultTable.php");}
// will die after 1 sec and print error

$conn->query(query:"DELETE FROM result_temp;");

$urls = array();  
$h1Value = "";
$h2VaLue = "";
$gtmString = "";
$uaString = "";
$orgString = "";

$DomDocument = new DOMDocument();
$DomDocument->preserveWhiteSpace = false;
$DomDocument->load('C:/xampp/htdocs/Webbskrapare/Sitemap-Generator/result.xml');
$DomNodeList = "";
$DomNodeList = $DomDocument->getElementsByTagName('loc');

//makes an array with only the loc elements from result.xml
foreach($DomNodeList as $url) 
{
    $urls[] = $url->nodeValue;
}

//takes all url one by one in urls array. single url saves into $page
for($i = 0; $i < count($urls); $i++) 
{
    $page = $urls[$i];

    //$page = urlencode($page);

    //gets html content from $page
    $htmlString = file_get_contents($page);

    //Create a new DOMDocument object.
    $htmlDom = new DOMDocument;

    libxml_use_internal_errors(true);

    $htmlString = str_replace("\0", '', $htmlString);

    //Load the HTML string into our DOMDocument object.
    @$htmlDom->loadHTML($htmlString);

    libxml_use_internal_errors(false);

    //Scrape after GTM -------------------------------------------------
    //Google Tag Manager ID (also called Container ID). It starts with GTM- and then some letters/numbers
    $gtmSearch =  strchr($htmlString,"GTM-");
    $findGTM = 'GTM-';
    $findGTMEnd;

    if(null != $gtmSearch)
    {
        $gtmResult = $gtmSearch;

        $gtmIndex = strpos($gtmSearch,$findGTM);

        if($gtmIndex >= 0)
        {
            if(strpos($gtmSearch, '"') !== FALSE)
            {
                $gtmSearch = substr($gtmSearch, 0, strpos($gtmSearch, '"'));
                $gtmString = $gtmSearch;
            }

            if(strpos($gtmSearch, '\'') !== FALSE)
            {
                $findGTMEnd = '\'';

                $gtmEndIndex = strpos($gtmSearch,$findGTMEnd);
        
                if($gtmEndIndex >= 0)
                {
                    $gtmString = substr($gtmResult,$gtmIndex,$gtmEndIndex - $gtmIndex);
                }
            }
        }
    }

    //Scrape after UA -------------------------------------------------

    //The Google Analytic property has the following structure: UA-12345678-3 UA stands for Universial Analytics 
    //(current version of Google Analytics)
    //The number in the middle is the Account ID an at the end is the Index number of the property in the account (from 1-50)
    $uaSearch =  strchr($htmlString,"UA-");
    $findUA = 'UA-';
    $findUAEnd = '\'';

    if(null != $uaSearch)
    {
        $uaResult = $uaSearch;
        
        $uaIndex = strpos($uaSearch,$findUA);
        
        if($uaIndex >= 0)
        {
            $uaEndIndex = strpos($uaSearch,$findUAEnd);      
        
            if($uaEndIndex >= 0)
            {
                $prelUAResult = substr($uaResult, $uaIndex,$uaEndIndex - $uaIndex);
                
                //for seeking after - when last number is just one character long or two characters long
              
                if(($uaEndIndex - $uaIndex > 2) && (('-' == substr($prelUAResult,$uaEndIndex - 2, 1)) || ('-' == substr($prelUAResult,$uaEndIndex - 3, 1)) ) )
                {
                    $uaString = substr($uaResult,$uaIndex,$uaEndIndex - $uaIndex);
                }
            }
	    }
    }

    //Scrape after Organisationnumber-----------------------------------
    $orgSearch =  strchr($htmlString,"Org");
    $pattern = "/\d{6}[-\s]?\d{4}/";

    $orgFound = preg_match($pattern, $orgSearch, $matches);

    if($orgFound == 1)
    {
        $orgSearch = strchr($matches[0], "-");

        if($orgSearch == true)
        {
            $orgString = $matches[0];
        }
    }   
}

//Insert the string into mysql
$conn->query(query: "INSERT INTO result_temp (Result_GTM, Result_UA, Result_Org) VALUES ('$gtmString', '$uaString', '$orgString')");


//takes all url one by one in urls array. single url saves into $page
for($i = 0; $i < count($urls); $i++) 
{
    $page = $urls[$i];

    //gets html content from $page
    $htmlString = file_get_contents($page);

    //Create a new DOMDocument object.
    $htmlDom = new DOMDocument;

    libxml_use_internal_errors(true);

    $htmlString = str_replace("\0", '', $htmlString);

    //Load the HTML string into our DOMDocument object.
    @$htmlDom->loadHTML($htmlString);

    libxml_use_internal_errors(false);

    //Scrape after H1 -------------------------------------------------
    // //Extract all h1 elements / tags from the HTML.
    $h1Tags = $htmlDom->getElementsByTagName('h1');

    // // Array to store H1 headings
    $extractedH1Tags = [];

    // // Loop for h1
    foreach($h1Tags as $h1Tag){

        //Get the node value of h1 tag
        $h1Value = trim($h1Tag->nodeValue);
    
        $extractedH1Tags[] = $h1Value;
    }

    // // takes an input array and returns a new array without duplicate values.
    $resultsh1 = array_unique($extractedH1Tags);

    // //takes the array and makes a string out of it seperated with komma
    $resultsh1String = implode(", ", $resultsh1);
    //------------------------------------------------------------------

    //Scrape after H2 -------------------------------------------------
    //Extract all h2 elements / tags from the HTML.
    $h2Tags = $htmlDom->getElementsByTagName('h2');

    // Array to store H2 headings
    $extractedH2Tags = [];

    // Loop for h2
    foreach($h2Tags as $h2Tag)
    {
        //Get the node value of h2 tag
        $h2Value = trim($h2Tag->nodeValue);
    
        $extractedH2Tags[] = $h2Value;
    }

    // takes an input array and returns a new array without duplicate values.
    $resultsh2 = array_unique($extractedH2Tags);

    //takes the array and makes a string out of it seperated with komma
    $resultsh2String = implode(", ", $resultsh2);
    //------------------------------------------------------------------

    //Insert the string into mysql
    $conn->query(query: "INSERT INTO result_temp (Result_H1, Result_H2) VALUES ('$resultsh1String', '$resultsh2String')");
}

header("Location: resultTable.php");