<?php
// Schaut durch die Session, ob der Nutzer angemeldet ist
session_start();
if (isset($_SESSION["angemeldet"]))
{

}
else {
    // Falls der Nutzer nicht angemeldet ist, wird er mit header auf die Login-Seite geleitet
    header("Location:login.php");
}

// Bindet den Header in die Seite ein
include "header.php";
?>

<!doctype html>
<html lang="de">
<meta charset="utf-8">
<head>
    <title> Themen Übersicht </title>
</head>


<body>

<div class="row justify-content-lg-center justify-content-md-center justify-content-sm-center">
    <div class="" style="">
        <img src="https://mars.iuk.hdm-stuttgart.de/~lm092/Studylab_Themen.png" alt="" style="width: 350px;">
    </div>
</div>

<div class="row justify-content-lg-center justify-content-md-center justify-content-sm-center">

    <div class="card" style="width: 20rem;">
        <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/hdm.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">#HdM</h5>
            <p class="card-text">Beiträge, die allgemein die HdM betreffen.</p>
            <a href="themen.php?themen=hdm" class="btn btn-primary">Alle Beiträge</a>
        </div>
    </div>



    <div class="card" style="width: 20rem;">
        <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/bib3.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">#Bib</h5>
            <p class="card-text">Beiträge rund um die Bibliothek, kurz Bib.</p>
            <a href="themen.php?themen=bib" class="btn btn-primary">Alle Beiträge</a>
        </div>
    </div>


    <div class="card" style="width: 20rem;">
        <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/mensa.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">#Mensa</h5>
            <p class="card-text">Alle Beiträge zur Mensa findest du hier.</p>
            <a href="themen.php?themen=mensa" class="btn btn-primary">Alle Beiträge</a>
        </div>
    </div>

    <div class="card" style="width: 20rem;">
        <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/hilfe.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">#Hilfe</h5>
            <p class="card-text">Fragen und Antworten, hier bist du richtig.</p>
            <a href="themen.php?themen=hilfe" class="btn btn-primary">Alle Beiträge</a>
        </div>
    </div>

    <div class="card" style="width: 20rem;">
        <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/wg.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">#Wg</h5>
            <p class="card-text">Beiträge rund um das Wohnheim und zum Thema Wg.</p>
            <a href="themen.php?themen=wg" class="btn btn-primary">Alle Beiträge</a>
        </div>
    </div>

    <div class="card" style="width: 20rem;">
        <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/fundbüro.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">#Fundbüro</h5>
            <p class="card-text">Du hast etwas gefunden oder Verloren?</p>
            <a href="themen.php?themen=fundbüro" class="btn btn-primary">Alle Beiträge</a>
        </div>
    </div>

    <div class="card" style="width: 20rem;">
        <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/suche.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">#Suche</h5>
            <p class="card-text">Du suchst etwas spezielles, nutze dieses Hashtag.</p>
            <a href="themen.php?themen=suche" class="btn btn-primary">Alle Beiträge</a>
        </div>
    </div>

    <div class="card" style="width: 20rem;">
        <img class="card-img-top" src="https://mars.iuk.hdm-stuttgart.de/~lm092/veranstalktungen.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">#Veranstaltungen</h5>
            <p class="card-text">Alles zum Thema Veranstaltungen.</p>
            <a href="themen.php?themen=veranstaltung" class="btn btn-primary">Alle Beiträge</a>
        </div>
    </div>

</div>


<div class="row">

    <div class="col-lg-1 col-md-1 col-sm-1">

    </div>

    <div class="col-lg-10 col-md-10 col-sm-10 col-">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
                <div class="beitrag-suche">

                    <h5>Ist das richtige Thema noch nicht dabei?</h5>
                    <h5>Hier kannst du danach suchen</h5>

                    <!-- Hier kann der User die Themen eingeben,  nach denen er suchen möchte -->
                    <form class="form-inline my-2 my-lg-0" action="themenuebersicht.php" method="post" style="width: fit-content; margin: auto;">
                        <input class="suchfeld form-control mr-sm-2" type="text" placeholder="" name="themenuebersicht" value="" required>
                        <button class="suchfeld btn btn-secondary" type="submit" name="suchen" value="Suchen">Suchen</button>
                    </form>

                    <br>
                </div>
        </div>
                    <?php
                    // Gibt die Daten aus, die im Formular eingeben wurden
                    if (isset($_POST['suchen'])) {
                    ?>



                        <h5 style="text-align: center"> <?php echo "Suchergebnisse: <br>";?> </h5>

                        <br>


                        <?php
                        //Themensuche wird ausgeführt

                        $suchethemen = $_POST['themenuebersicht'];


                        $themensuche = $pdo->prepare("SELECT * FROM content WHERE themen LIKE '%$suchethemen%'");

                        if ($themensuche->execute()) {

                            while ($row = $themensuche->fetch()) {


                                $themalink = $row['themen'];
                                $studilab2 = $row["userid"];

                                $bild_suche = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id='$studilab2'");
                                $bild_suche->execute();
                                $row_suche = $bild_suche->fetch();

                            echo '<div class="col-12-ergebnisse">';
                            echo '<ul class="kommentar2">';
                            //Suchergebnisse werden ausgegeben und dargestellt
                            echo ("<img src='https://mars.iuk.hdm-stuttgart.de/~lm092/Studylab_quadrat.png' width='' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                            echo " ";
                            echo '<a class="suchen-ergebnisse" href="themen.php?themen='.$themalink.'">'."Beitrag zum Thema "."#". $row['themen'].'</a>';
                            //echo "<br>". $row["name"]." ". $row ["nachname"];
                            echo '</ul>';
                            echo '</div>';

                            }
                        }

                        else {
                            echo "Keine passenden Themen gefunden";
                        }

                    }

                    ?>


    </div>

    <div class="col-lg-1 col-md-1 col-sm-1">

    </div>

</div>

</body>

<!-- Einbindung des Sticky-Footers-->
<?php
session_start();
include_once 'footer.php';
?>
</html>