<?php
// bindet den Header in die Seite ein
include_once 'header.php';
?>

<!doctype html>
<html lang="de">
<head>
    <title>Suche</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <div class="col-3">


            </div>

            <div class="col-6">



                <?php
                    session_start();
                    if (isset($_SESSION["angemeldet"]))
                    {
                        echo "Hallo"." " .$_SESSION["angemeldet"].", nach welchem Nutzer möchtest du suchen?";
                    }
                    else {

                        header("Location:login.php");
                    }
                ?>

                <form class="form-inline my-2 my-lg-0" action="nutzersuchen.php" method="post">
                    <input class="form-control mr-sm-2" type="text" placeholder="" name="nutzersuchen" value="">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="suchen" value="Suchen">Suchen</button>
                </form>

                <?php

                if (isset($_POST['suchen'])) {

                    echo "Suchergebnisse: <br>";


                    $benutzername = $_POST['nutzersuchen'];

                // $headline = $_POST['beitragsuchen'];

                    $benutzersuche = $pdo->prepare("SELECT * FROM studylab WHERE benutzername LIKE '%$benutzername%'");

                    if ($benutzersuche->execute()) {

                        while ($row = $benutzersuche->fetch()) {

                            // echo $row ['benutzername'];

                            $nutzerid = $row['nutzerid'];



                            echo '<table>';
                            echo '<a href="nutzerprofil.php?nutzerid='.$nutzerid.'">' . $row['benutzername'];
                            echo '<table>';

                        }
                    }


                else {
                        echo "Nutzer nicht gefunden";
                    }

                }

                ?>

                </form>
            </div>

            <div class="col-3">

            </div>


        </div>
    </div>



</body>
</html>