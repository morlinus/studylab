<?php
// schaut durch die Session, ob der Nutzer angemeldet ist
session_start();
if (isset($_SESSION["angemeldet"]))
{

}
else {
    // Falls der Nutzer nicht angemeldet ist, wird er mit header auf die Login-Seite geleitet
    header("Location:login.php");
}

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
            


            <!-- Einteilung in das Grid-System -->
            <div class="col-lg-3 col-md-1 col-sm-1">

            </div>

            <!-- Einteilung in das Grid-System -->
            <div class="col-lg-6 col-md-10 col-sm-10 col-">

                <div class="row justify-content-lg-center justify-content-md-center justify-content-sm-center">
                    <div class="" style="">
                        <img src="https://mars.iuk.hdm-stuttgart.de/~as325/Studylab_Suche.png" alt="" style="width: 350px;">
                    </div>
                </div>

                <br>

                <div class="suche">
                    <div class="shadow-suche p-3 mb-5 bg-white rounded">
                        <div class="text-suche">

                <?php
                    session_start();
                    if (isset($_SESSION["angemeldet"]))
                    {
                        echo "Hallo"." " .$_SESSION["angemeldet"].", nach welchem Nutzer möchtest du suchen?"."<br/>"."<br/>";
                    }
                    else {

                        header("Location:login.php");
                    }
                ?>
                        </div>

                        <div class="suche-formular">
                <!-- hier kann der User den Benutzer eingeben, den er suchen möchte -->
                <form class="form-inline my-2 my-lg-0" action="nutzersuchen.php" method="post" style="width: 40%; margin:auto;">
                    <input class="suchfeld form-control mr-sm-2" type="text" placeholder="" name="nutzersuchen" value="">
                    <button class="suchfeld btn btn-secondary" type="submit" name="suchen" value="Suchen">Suchen</button>
                </form>

                <br>
                        </div>
                </div>


                <?php
                // gibt die Sachen aus, die im Formular eingeben wurden
                if (isset($_POST['suchen'])) {

                ?>


                    <!-- hier werden die Suchergebnisse ausgegeben -->
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

                            // hier werden die ausgegebenen Suchergebnisse gestyled
                            echo '<div class="col-12-suche">';
                            echo '<ul class="kommentar2">';
                            echo("<img src='data:" . $row_suche['format'] . ";base64," . base64_encode($row_suche['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                            echo " ";
                            echo ('<a class="suchen-ergebnisse" href="profil_folgen2.php?studylab='.htmlspecialchars($studilab,ENT_HTML401).'">' . $row['benutzername'] .'</a>'."<br>". $row["name"]." ". $row ["nachname"]);
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

            <!-- Einteilung in das Grid-System -->
            <div class="col-lg-3 col-md-1 col-sm-1">

            </div>

        </div>
    </div>

</body>

<!-- Einbindung des Sticky-Footers-->
<?php
session_start();
include_once 'footer.php';
?>

</html>

