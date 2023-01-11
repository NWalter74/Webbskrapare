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
    <div class="container">
        <section>
            <div class="container">
                <section>
                    <nav>
                        <div class='heading'>
                            <h4>Webbskrapare för prospekt</h4>
                        </div>
                        <ul class='nav-links'>
                            <li><a href="index.php">Hem</a></li>
                            <li><a class='active' href="readme.php">Hjälp</a></li>
                        </ul>
                        <ul class='nav-links'>
                            <?php
                            if (isset($_SESSION["username"])) {
                                echo "<li><a href='prospektlista.php'>Prospektlista</a></li>";
                                echo "<li><a href='logout.inc.php'>Logga ut</a></li>";
                            } else {
                                //echo "<li><a href='signup.php'>Registrera användare</a></li>";
                                echo "<li><a href='login.php'>Logga in</a></li>";
                            }
                            ?>
                        </ul>
                    </nav>
                    <br>

                    <div>
                        <h3 style="text-align: center;">Hjälp</h3>
                        <br>
                        <h7>- Skraptiden kan ta upp till 45 min för vissa sidor.</h7>
                        <br><br>
                    </div>

                    <main role="main" class="inner cover"></main>
                </section>
            </div>
        </section>

        <div style="background-color: #8EC63F; min-height: 15vh;"></div>

    </div>

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