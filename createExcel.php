<?php 

//Include the database config file
include 'connect.php';

session_start();

//Excel file name for download
$fileName = $_SESSION["prospektUrl"] . " " . date('Ymd') . ".xls";

$output = '';

//Get record from database
$query = $conn->query(query:"SELECT Result_H1, Result_H2, Result_GTM, Result_UA FROM result_temp;");

if(mysqli_num_rows($query) > 0)
{
    $output .= '
        <table class="table" bordererd="1">
            <tr>
                <th>Result_H1</th>
                <th>Result_H2</th>
                <th>Result_GTM</th>
                <th>Result_UA</th>
            </tr>
        ';
        while($row = mysqli_fetch_array($query))
        {
            $output .= '
                <tr>
                    <td>'.$row["Result_H1"].'</td>
                    <td>'.$row["Result_H2"].'</td>
                    <td>'.$row["Result_GTM"].'</td>
                    <td>'.$row["Result_UA"].'</td>
                </tr>
            ';
        }
        $output .= '</table>';
}

//Header for download
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Content-Type: application/xls");

//Render excel data
echo $output;