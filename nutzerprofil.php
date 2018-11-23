<?php
// bindet die header.php ein und damit den Header der Seite
include_once 'header.php';
?>

<!doctype html>
<html lang="de">
<meta charset="utf-8">
<head>
    <title>
        <!-- übernimmt den Namen des eingeloggten Nutzer ins den Titel der Seite -->
        Profil von: <?php session_start();
        echo $_SESSION['angemeldet']; ?>
    </title>


</head>

<body>

<div class="container">
    <div class="row">

        <div class="col-sm-3">
            <h1>Profildaten</h1>
        </div>

        <div class="col-sm-6">
            <?php
            //startet die Session und übernimmt die ID des Nutzers, die beim Login übergeben wurde
            session_start();
            $id=$_SESSION["id"];
            if (isset($_SESSION["angemeldet"])) {
            echo "Eingeloggt ist der Benutzer " . $_SESSION['angemeldet'];
            ?>
            <div class="">
                <?php
                // Zeigt die Postings des User an
                // Stellt die Verbindung zur Datenbank her
                include "userdata.php";
                // wählt aus der Datenbank die entsprechenden Beiträge aus
                $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE userid= $id");
                $statement->execute(array('beitragsid' => 1));
                while ($content = $statement->fetch()) {
                    echo "<br />" . $content['benutzername'] . " schrieb:<br />";
                    echo $content['text'] . "<br /><br />";
                }
                }
                else {
                    echo "nicht angemeldet.";
                }
                ?>
            </div>



        </div>

        <div class="col-sm-3">
                <!-- Der User kann hier einen Post schreiben -->
                Schreibe einen Post:
                <form action="formular_abfrage.php" method="post">
                    <textarea name="content" class="form-control" rows="3"></textarea><br>
                    <input class="btn btn-primary" type="submit" value="Posten">

        </div>

    </div>
</div>


<body/>

</html>