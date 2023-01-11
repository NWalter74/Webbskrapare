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

    <title>REGISTRERA Användare</title>
</head>

<body>
    <div class="container">
        <section>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
                <ul>
                    <?php
                        if (isset($_SESSION["username"])) {
                            echo "<li><a href='prospektlista.php'>Prospektlista</a></li>";
                            echo "<li><a href='logout.inc.php'>Logga ut</a></li>";
                        } else {
                            echo "<li><a href='signup.php'>Registrera användare</a></li>";
                            echo "<li><a href='login.php'>Logga in</a></li>";
                        }
                    ?>
                </ul>
            </nav>

            <h2>Registrera användare</h2>

            <form action="sign.inc.php" method="post">
                <input type="text" name="userID" placeholder="Användar Id..."><br>
                <input type="text" name="username" placeholder="Användarnamn..."><br>
                <input type="password" name="pwd" placeholder="Lösenord..."><br>
                <input type="password" name="pwdRepeat" placeholder="Repetera lösenordet..."><br>
                <button type="submit" name="submit">Registrera dig</button>
            </form>

            <?php 
                if(isset($_GET["error"]))
                {
                    if($_GET["error"] == "emptyinput")
                    {
                        echo "<p>Du måste fylla i alla fält!</p>";
                    }
                    else if ($_GET["error"] == "invalidUsername")
                    {
                        echo "<p>Välj ett lämpligt användarnamn!</p>";
                    }
                    else if ($_GET["error"] == "passwordsDontMatch")
                    {
                        echo "<p>Lösenord och repeterad lösenord är inte detsamma!</p>";
                    }
                    else if ($_GET["error"] == "usernameExists")
                    {
                        echo "<p>Det finns redan en användare med samma användarnamn! Vänligen välj ett annat användarnamn!</p>";
                    }
                    else if ($_GET["error"] == "stmtfailed")
                    {
                        echo "<p>Något gick fel! Snälla försök igen!</p>";
                    }
                    else if ($_GET["error"] == "none")
                    {
                        echo "<p>Du är nu registrerat som användare!</p>";
                    }
                }
            ?>
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