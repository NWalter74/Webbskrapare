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

    <title>Webbskrapare för prospekt</title>
</head>

<body>
    <div style="float: left;" class="container">
        <section>
            <div class="container">
                <div id="tableManager" class="modal fade">
                    <!-- to can show from the jquery -->
                    <div class="modal-dialog">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Nytt prospekt</h3> <!-- header inputmask add new -->
                            </div>

                            <div class="modal-body">
                                <div id="editContent" style="overflow-y: scroll; height: 300px;">
                                    <input type="text" class="form-control" id="prospektName" placeholder="Prospektnamn..."><br>
                                    <input type="text" class="form-control" id="proUrl" placeholder="Pro Url..."><br>
                                    <input type="text" class="form-control" id="proUrlAllabolag" placeholder="Pro Url Allabolag..."><br>
                                    <input type="email" class="form-control" id="epost" placeholder="Epost..."><br>
                                    <textarea class="form-control" id="comment" placeholder="Din kommentar..."></textarea><br>
                                    <input type="hidden" id="editRowID" value="0">
                                </div>

                                <div id="scrapeContent" style="display: none;">
                                    <form method="POST" action="/webbskrapare/Sitemap-Generator/sitemap.php">
                                        <input type="text" class="form-control" id="proUrlScrape" name="inputProspektUrl" value=""><br>
                                        <input type="hidden" id="scrapeRowID" value="0">
                                        <button type="submit" class="btn btn-sm btn-secondary">Skrapa sida</button>
                                    </form>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <input type="button" class="btn btn-sm btn-secondary" id="closeBtn" value="Stäng" data-dismiss="modal" style="display: none;">
                                <input type="button" class="btn btn-sm btn-success" id="manageBtn" value="Spara i databasen" onclick="manageData('addNew')">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-md-offset-2">
                        <nav>
                            <div class='heading'>
                                <h4>Webbskrapare för prospekt</h4>
                            </div>
                            <ul class='nav-links'>
                                <li><a href="index.php">Hem</a></li>
                                <li><a href="readme.php">Hjälp</a></li>
                            </ul>
                            <ul class='nav-links'>
                                <?php
                                if (isset($_SESSION["username"])) {
                                    echo "<li><a class='active' href='prospektlista.php'>Prospektlista</a></li>";
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

                            <h2 style="text-align: center;">Prospektlista</h2>

                            <!-- Add new prospekt button -->
                            <div>
                                <input style="float: right" type="button" class="btn btn-sm btn-secondary" id="addNew" value="Lägg till nytt prospekt">
                                <label style="float: left" type="text" id="actuellUser"> Inloggad användare: <?php echo $_SESSION["username"] ?> </label>
                            </div>
                            <br><br>
                        </div>
                        <div class="clearfix">
                            <!-- Table with database data -->
                            <table style="float: left;" class="table table-striped table-hover table-bordered" id="myTable">
                                <thead>
                                    <tr>
                                        <!-- datatable header -->
                                        <td>ID</td>
                                        <td>Skapat</td>
                                        <td>Senast ändrat</td>
                                        <td>Vem ändrade sist</td>
                                        <td>Användare</td>
                                        <td>Prospektnamn</td>
                                        <td>Pro Url</td>
                                        <td>Pro Url Allabolag</td>
                                        <td>Epost</td>
                                        <td>Kommentar</td>
                                        <td>Alternativ</td>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--JQuery-->
        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!--Datatables-->
        <link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
        <script type="text/javascript" src="js/datatables.min.js"></script>

        <!-- jquery functions -->
        <script src="js/script.js" type="text/javascript"></script>

</body>

</html>