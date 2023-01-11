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

    <title>LOGGA IN</title>
</head>

<body>
    <div class="container">
        <section>
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
                        echo "<li><a href='prospektlista.php'>Prospektlista</a></li>";
                        echo "<li><a href='logout.inc.php'>Logga ut</a></li>";
                    } else {
                        ///echo "<li><a href='signup.php'>Registrera användare</a></li>";
                        echo "<li><a class='active' href='login.php'>Logga in</a></li>";
                    }
                    ?>
                </ul>
            </nav>
            <br>
            <h2 style="text-align: center;">Logga In</h2>

            <form style="text-align: center;" action="login.inc.php" method="post">
                <input type="text" name="username" placeholder="Användarnamn..."><br>
                <input type="password" name="pwd" placeholder="Lösenord..."><br><br>
                <button type="submit" name="submit">Logga in</button>
            </form>

            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Du måste fylla i alla fält!</p>";
                } else if ($_GET["error"] == "wronglogin") {
                    echo "<p>Något är fel med din loggindata!</p>";
                }
            }
            ?>
            <br>
            <div style="background-color: #8EC63F; min-height: 15vh;"></div>

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