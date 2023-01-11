<?php
// DELETE or set as komment before you load up the projekt!!
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
    include 'connect.php';

    session_start();

    //DELETE all from result temp table
    if($_POST['key'] == 'deleteAllData')
    {
        $conn->query(query:"DELETE FROM result_temp;");
        exit('All skrapdata har blivit raderat.');
    }

    //if there is a key from prospektlista.php - manageData - ajax
    if (isset($_POST['key']))
    {
        // function scrapeORedit in script.js
        if($_POST['key'] == 'getRowData')
        {
            $rowID = $conn->real_escape_string($_POST['rowID']);
            $sql = $conn->query(query:"SELECT PRO_NAMN, PRO_URL, PRO_URL_ALLABOLAG, PRO_EPOST, PRO_KOM FROM prospekt WHERE PRO_ID='$rowID'");
            $data = $sql->fetch_array();
            $jsonArray = array(
                'prospektName' => $data['PRO_NAMN'],
                'proUrl' => $data['PRO_URL'],
                'proUrlAllabolag' => $data['PRO_URL_ALLABOLAG'],
                'epost' => $data['PRO_EPOST'],
                'comment' => $data['PRO_KOM'],
            );

            exit(json_encode($jsonArray));
        }
      
        // function getExistingData in script.js
        if ($_POST['key'] == 'getExistingData')
        {
            $start = $conn->real_escape_string($_POST['start']);
            $limit = $conn->real_escape_string($_POST['limit']);

            $sql = $conn->query(query:"SELECT * FROM prospekt LIMIT $start, $limit");

            if ($sql->num_rows > 0)
            {
                $response = "";
                while($data = $sql->fetch_array())
                {                
                    $response .= '
                        <tr>
                            <td>'.$data["PRO_ID"].'</td>
                            
                            <td id="skapatD'.$data["PRO_ID"].'">'.$data["PRO_DT"].'</td>
                            <td id="sistÄndratD'.$data["PRO_ID"].'">'.$data["PRO_RDT"].'</td>
                            <td id="vemÄndrade'.$data["PRO_ID"].'">'.$data["PRO_RDT_AV"].'</td>
                            <td id="användareInit'.$data["PRO_ID"].'">'.$data["PRO_SKAPAD_AV"].'</td>
                            <td id="prospektName_'.$data["PRO_ID"].'">'.$data["PRO_NAMN"].'</td>
                            <td id="proURL'.$data["PRO_ID"].'">'.$data["PRO_URL"].'</td>
                            <td id="proURLAllabolag'.$data["PRO_ID"].'">'.$data["PRO_URL_ALLABOLAG"].'</td>
                            <td id="epost'.$data["PRO_ID"].'">'.$data["PRO_EPOST"].'</td>
                            <td id="comment'.$data["PRO_ID"].'">'.$data["PRO_KOM"].'</td>
                            <td>
                                <input type="button" onclick="editProspekt('.$data["PRO_ID"].')" value="Redigera" class="btn btn-sm btn-secondary">
                                <input type="button" onclick="deleteRow('.$data["PRO_ID"].')" value="Radera" class="btn btn-sm btn-danger">
                                <input type="button" onclick="scrapePage('.$data["PRO_ID"].')" value="Skrapa url" class="btn btn-sm btn-secondary">
                            </td>
                        </tr>
                    ';
                }   
                exit($response);
            }
            else
            {
                exit("end"); //it gives information to the jquery that there isn't more data in the mysql table
            }
        }
    }

    //DELETE prospekt
    $rowID = $conn->real_escape_string($_POST['rowID']);

    if($_POST['key'] == 'deleteRow')
    {
        $conn->query(query:"DELETE FROM prospekt WHERE PRO_ID='$rowID'");
        exit('Prospektet har blivit raderat i databasen');
    }

    //we escape all the things we are getting from the jquery in script.js
    $prospektName = $conn -> real_escape_string($_POST['prospektnamnSend']);
    $proUrl = $conn -> real_escape_string($_POST['proUrlSend']);
    $proUrlAllabolag = $conn -> real_escape_string($_POST['proUrlAllabolagSend']);
    $epost = $conn -> real_escape_string($_POST['epostSend']);
    $comment = $conn -> real_escape_string($_POST['kommentarSend']);

    
    $user = $_SESSION["username"];
    $userId = $_SESSION["userId"];

    //EDIT prospekt
    if ($_POST['key'] == 'updateRow')
    {
        $conn->query(query:"UPDATE prospekt SET  PRO_RDT_AV='$user' , PRO_NAMN='$prospektName' , PRO_URL='$proUrl' , PRO_URL_ALLABOLAG='$proUrlAllabolag' , PRO_EPOST='$epost' , PRO_KOM='$comment' WHERE PRO_ID='$rowID'");
        exit('success');
    }
    
    //ADD new prospekt
    if ($_POST['key'] == 'addNew')
    {
        //check if there is a prospekt with the same name in the database
        $sql = $conn->query(query:"SELECT PRO_ID FROM prospekt WHERE PRO_NAMN = '$prospektName'");
        
        if ($sql->num_rows > 0)
        {
            //return to the jquery
            exit("Prospekt med detta namn existera redan!");
        } 
        else
        {
            $conn->query(query:
            "INSERT INTO prospekt (
                PRO_SKAPAD_AV,
                PRO_RDT_AV,
                PRO_NAMN,
                PRO_URL,
                PRO_URL_ALLABOLAG,
                PRO_EPOST, 
                PRO_KOM)
        
            VALUES (
                '$userId',
                '$user',
                '$prospektName',
                '$proUrl',
                '$proUrlAllabolag',
                '$epost',
                '$comment')");
                
                //return to the jquery
            exit('Prospektet har blivit tillagd!');
        }
    }