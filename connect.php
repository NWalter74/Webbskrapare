<?php
// DELETE or set as komment before you load up the projekt!!
error_reporting(E_ALL);
ini_set('display_errors', '1');

$host = "localhost";
$userName = "root";
$password = "";
$dbName = "kundregisterwebb";
        
//mysqli newest version
$conn = new mysqli($host, $userName, $password, $dbName);

// Uppkopplingstest
if ($conn->connect_error) 
{
    die("Kunde inte koppla upp till databasen: " . $conn->connect_error);
}