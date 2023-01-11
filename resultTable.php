<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="css/mynav.css">

    <title>Skrapresultat</title>
</head>

<body>
    <div style="float: left;" class="container">
        <nav>
            <div class='heading'>
                <h4>Webbskrapare för prospekt</h4>
            </div>
            <ul class='nav-links'>
                <li><a href="index.php">Home</a></li>
                <li><a href="readme.php">Hjälp</a></li>
            </ul>
            <ul class='nav-links'>
                <?php
                if (isset($_SESSION["username"])) {
                    echo "<li><a href='logout.inc.php'>Logga ut</a></li>";
                } else {
                    //echo "<li><a href='signup.php'>Registrera användare</a></li>";
                    echo "<li><a href='login.php'>Logga in</a></li>";
                    //redirects the user to index page if not logged in
                    header("location: index.php");
                    exit;
                }
                ?>
            </ul>
        </nav>
        <br>
        <div style="background-color: #8EC63F; min-height: 10vh;">
            <h2 style="text-align: center;">Skrapresultat</h2>

            <!-- <button type="button" onclick='window.location.replace("/webbskrapare/index.php")' class="btn btn-sm btn-primary">Tillbaka till Prospektlistan</button> -->
            <button type="button" onclick="deleteAllAndBackToProspektlista()" class="btn btn-sm btn-secondary">Tillbaka till Prospektlistan</button>
            <button type="button" onclick='window.location.replace("/webbskrapare/createExcel.php")' class="btn btn-sm btn-secondary">Spara data i en excelfil</button>
            <br><br>
            <label style="float: left" type="text" id="actuellProspekt"> Skrapad prospekt: <?php echo $_SESSION["prospektUrl"] ?> </label>
            <br>
        </div>
        <?php
        include 'connect.php';

        //Show all data from database
        $sqlResults = $conn->query(query: "SELECT Result_H1, Result_H2, Result_GTM, Result_UA, Result_Org FROM result_temp;");
        $html_table = "";

        if ($sqlResults !== false) {
            // Create the beginning of HTML table, and the first row with colums title
            $html_table = '
                <div class="container">
                <table class="center" border="1" cellspacing="0" cellpadding="2" style="width:100%">
                <tr style="hover {background-color: #D6EEEE;}">
                    <th>Result H1</th>
                    <th>Result H2</th>
                    <th>Result GTM</th>
                    <th>Result GA(UA)</th>
                    <th>Result OrgNo</th>
                </tr>';

            // Parse the result set, and adds each row and colums in HTML table
            foreach ($sqlResults as $row) {
                $html_table .= '
                    <tr>
                        <td>' . $row['Result_H1'] . '</td>
                        <td>' . $row['Result_H2'] . '</td>
                        <td>' . $row['Result_GTM'] . '</td>
                        <td>' . $row['Result_UA'] . '</td>
                        <td>' . $row['Result_Org'] . '</td>
                    </tr>';
            }
        }

        $conn = null;        // Disconnect

        $html_table .= '</table> </div>';           // ends the HTML table

        echo $html_table;        // display the HTML table
        ?>
    </div>

    <!--JQuery-->
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!--Datatables-->
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
    <script type="text/javascript" src="js/datatables.min.js"></script>

    <script>
        function deleteAllAndBackToProspektlista() {
            
            if (confirm('Genom att gå tillbaka raderas all skrapresultat, är det ok??')) {
                $.ajax({
                    url: 'ajax.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        key: 'deleteAllData',
                    },
                    success: function(response) {
                        alert(response);
                        location.reload();
                        window.location.replace("/webbskrapare/prospektlista.php");
                    }
                });
            }
        }
    </script>

</body>

</html>