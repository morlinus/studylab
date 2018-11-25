<?php
// bindet den Header in die Seite ein
include_once 'header.php';
?>

<!doctype html>
<html lang="de">
<head>
<title>Startseite</title>
</head>
<body>


    <div class="container-fluid">
        <div class="row">
            <div class="col-3">

            </div>

            <div class="col-6">

                <?php
                // startet die Session, um zu erkennen, welcher Nutzer eingeloggt ist und vom wem er die Inhalte auf der Startseite anzeigen soll
                session_start();
                if (isset($_SESSION["angemeldet"])) {
                echo "Eingeloggt ist der Benutzer " . $_SESSION['angemeldet'];
                ?>
                <br>
                <br>


                <?php
                // schaut durch die Session, ob der Nutzer angemeldet ist
                session_start();
                if (isset($_SESSION["angemeldet"]))
                {
                    echo "Hallo"." " .$_SESSION["angemeldet"];
                }
                else {
                    // Falls der Nutzer nicht angemeldet ist, wird er mit header auf die Login-Seite geleitet
                    header("Location:login.php");
                }

                ?>
                <br>
                <br>



                <!-- Dies ist die Form, damit der User einen Post schreiben kann -->
                <form action="formular_abfrage_index.php" method="post">
                    <textarea name="content" class="form-control" rows="3"></textarea><br>
                    <input class="btn btn-primary" type="submit" value="Posten">
                    <br>
                    <br>




                    <?php
                    // stellt die Verbindung zur Datenbank her
                    include "userdata.php";
                    // zeigt die Post aus der Datenbank an - muss noch so erweitert werde, dass nur die Post von sich selbst und den Leuten, denen man folgt angezeigt wird
                    $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id");
                    $statement->execute(array('beitragsid' => 1));
                    while ($content = $statement->fetch()) {
                        echo "<br />" . $content['benutzername'] . " schrieb:<br />";
                        echo $content['text'] . "<br /><br />";
                    }
                    }
                    ?>
            </div>

        </div>
    </div>

</body>
</html>