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
            <nav>
                <div class='heading'>
                    <h4>Webbskrapare för prospekt</h4>
                </div>
                <ul class='nav-links'>
                    <li><a class='active' href="index.php">Hem</a></li>
                    <li><a href="readme.php">Hjälp</a></li>
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

            <br><br>
            <div>
                <h3 style="text-align: center;">Examensarbete av Nicole Walter 2022</h3>
                <br><br>
                <?php
                if (isset($_SESSION["username"])) {
                    echo "<h2>Hej och välkommen " . $_SESSION["username"] . "</h2>";
                } else {
                    // echo "<h2>Vänligen logga in eller registrera dig... </h2>";
                    echo "<h2>Vänligen logga in... </h2>";
                }
                ?>
                <br>
            </div>
            <div style="background-color: #8EC63F; min-height: 15vh;"></div>
        </section>
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