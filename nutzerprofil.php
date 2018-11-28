<?php
// bindet die header.php ein und damit den Header der Seite
include_once 'header.php';
?>

<!doctype html>
<html lang="de">
<meta charset="utf-8">
<head>
    <title>
        Profil von: <?php session_start();
        echo $_SESSION['angemeldet']; ?>
    </title>
<style type="text/css">
    .content{
        width: 80%;
        margin:100px auto;
        border: 1px solid #cbcbcb;
        border-radius: 20px;
    }
    .post{
        width: 95%;
        margin: 10px auto;
        border: 1px solid #cbcbcb;
        padding: 10px;
        border-radius: 20px;
    }

</style>

</head>

<body>

<div class="container-fluid">
    <div class="row">

        <div class="col-3">
            <h1>Profildaten</h1>
            <div class="profilbild-folgen">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/34/PICA.jpg/440px-PICA.jpg" alt="Nutzerprofilbild" class="profilbild">
                <button type="button" class="btn btn-success">Folgen</button>
            </div>
        </div>

        <div class="col-6">

            <?php
            //startet die Session und übernimmt die ID des Nutzers, die beim Login übergeben wurde
            session_start();
            $id=$_SESSION["id"];
            if (isset($_SESSION["angemeldet"])) {

            ?>

                <?php
                // Zeigt die Postings des User an
                // Stellt die Verbindung zur Datenbank her
                include "userdata.php";
                // wählt aus der Datenbank die entsprechenden Beiträge aus
                $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE userid= $id ORDER BY content.id DESC");
                $statement->execute(array('beitragsid' => 1));
                while ($content = $statement->fetch()) {
                    ?>
                    <div class="content">
                        <div class="post">
                            <?php
                    echo "<br />" . $content['benutzername'] . " schrieb:<br />";
                    echo $content['text'] . "<br /><br />";

                    ?>
                    <form action="socialfuntktionen.php" method="post">
                        <input class="btn btn-primary" type="button" name="like" value="Gefällt mir!">
                    </form>
                            <br>
                    <form action="kommentieren.php" method="post">
                        <textarea name="Kommentar" class="form-control" placeholder="Kommentieren" rows="1"></textarea><br>
                        <input class="btn btn-primary" type="submit" name="Kommentieren" value="Kommentieren"></submit>
                    </form>
                            <br>
                        </div>
                        </div>

                        <?php
                }
                }
                else {
                    echo "nicht angemeldet.";
                }
                ?>
        </div>

        <div class="col-3">
                <!-- Der User kann hier einen Post schreiben -->
                Schreibe einen Post:
                <form action="formular_abfrage.php" method="post">
                    <textarea name="content" class="form-control" rows="3"></textarea><br>
                    <input class="btn btn-primary" type="submit" value="Posten">

        </div>

    </div>
</div>
</body>

<?php
session_start();
include_once 'footer.php';
?>

</html>