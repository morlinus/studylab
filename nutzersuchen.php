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

            <div class="col-lg-3 col-md-1 col-sm-1">

            </div>

            <div class="col-lg-6 col-md-10 col-sm-10 col-">

                <br>
                <br>

                <div class="suche">

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
                    <input class="suchfeld form-control mr-sm-2" type="text" placeholder="" name="nutzersuchen" value="">
                    <button class="suchfeld btn btn-secondary" type="submit" name="suchen" value="Suchen">Suchen</button>
                </form>

                <br>



                <?php

                if (isset($_POST['suchen'])) {

                ?>



                    <h5> <?php echo "Suchergebnisse: <br>";?> </h5><br>


                <?php
                    $benutzername = $_POST['nutzersuchen'];

                // $headline = $_POST['beitragsuchen'];

                    $benutzersuche = $pdo->prepare("SELECT * FROM studylab WHERE benutzername LIKE '%$benutzername%'");

                    if ($benutzersuche->execute()) {

                        while ($row = $benutzersuche->fetch()) {

                            // echo $row ['benutzername'];

                            $studilab = $row['id'];

                            $bild_suche = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id='$studilab'");
                            $bild_suche->execute();
                            $row_suche = $bild_suche->fetch();

                            echo '<div class="col-12-ergebnisse">';
                            echo '<ul class="suchen-tabelle">';
                            echo("<img src='data:" . $row_suche['format'] . ";base64," . base64_encode($row_suche['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                            echo " ";
                            echo ('<a class="suchen-ergebnisse" href="profil_folgen2.php?studylab='.$studilab.'">' . $row['benutzername'] .'</a>'."<br>". $row["name"]." ". $row ["nachname"]);
                            //echo "<br>". $row["name"]." ". $row ["nachname"];
                            echo '</ul>';
                            echo '</div>';


                        }
                    }


                else {
                        echo "Nutzer nicht gefunden";
                    }

                }

                ?>

                </div>

            </div>

            <div class="col-lg-3 col-md-1 col-sm-1">

            </div>

        </div>
    </div>

</body>

<?php
session_start();
include_once 'footer.php';
?>

</html>

