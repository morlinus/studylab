<?php
/**
 * Created by PhpStorm.
 * User: linusmorlinghaus
 * Date: 14.12.18
 * Time: 09:50
 */
include "header.php";
?>

<!doctype html>
<html lang="de">
<meta charset="utf-8">
<head>
    <title> Themen Übersicht </title>

</head>


<body>
<div class="row">
    <div class="col-lg-12">Das sind die beliebtesten Themen</div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/hdm.jpg" alt="">
            <div class="card-body">
                <h5 class="card-title">#HdM</h5>
                <p class="card-text">Beiträge, die allgemein die HdM betreffen</p>
                <a href="#" class="btn btn-primary">Alle Beiträge</a>
            </div>
        </div></div>
    <div class="col-lg-3 col-md-6">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/bib3.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">#Bib</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Alle Beiträge</a>
            </div>
        </div></div>
    <div class="col-lg-3 col-md-6">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/mensa.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">#Mensa</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Alle Beiträge</a>
            </div>
        </div></div>
    <div class="col-lg-3 col-md-6">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/hilfe.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">#Hilfe</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Alle Beiträge</a>
            </div>
        </div></div>

</div>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/wg.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">#Wg</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Alle Beiträge</a>
            </div>
        </div></div>
    <div class="col-lg-3 col-md-6">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/fundbüro.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">#Fundbüro</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Alle Beiträge</a>
            </div>
        </div></div>
    <div class="col-lg-3 col-md-6">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/suche.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">#Suche</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Alle Beiträge</a>
            </div>
        </div></div>
    <div class="col-lg-3 col-md-6">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/veranstalktungen.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">#Veranstaltungen</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Alle Beiträge</a>
            </div>
        </div></div>

</div>
<div class="row">
    <div class="col-lg-12">Das richtige Thema noch nicht dabei? Hier kannst du danach suchen

        <!-- hier kann der User den Themen eingeben,  nach denen er suchen möchte -->
        <form class="form-inline my-2 my-lg-0" action="nutzersuchen.php" method="post">
            <input class="suchfeld form-control mr-sm-2" type="text" placeholder="" name="nutzersuchen" value="">
            <button class="suchfeld btn btn-secondary" type="submit" name="suchen" value="Suchen">Suchen</button>
        </form>

        <br>
        <?php
        // gibt die Sachen aus, die im Formular eingeben wurden
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
                    echo htmlspecialchars('<a class="suchen-ergebnisse" href="profil_folgen2.php?studylab='.$studilab.'">' . $row['benutzername'] .'</a>'."<br>". $row["name"]." ". $row ["nachname"], ENT_HTML401);
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

</body>
</html>