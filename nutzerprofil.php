<?php
// bindet die header.php ein und damit den Header der Seite
include_once 'header.php';

$id_header=$_SESSION ["id"];
$bild_header = $pdo -> prepare("SELECT * FROM bilduplad WHERE user_id=$id_header");
$bild_header ->execute();
while($row_header = $bild_header->fetch()){
// echo "<li><a target='_blank' href='bild_abrufen.php?".$row['id']."'>".$row['name']."</a><br/>
// <embed src='data:".$row['format'].";base64,".base64_encode($row['datei'])."' width=''/></li>";
?>

<!doctype html>
<html lang="de">
<meta charset="utf-8">
<head>
    <title>
        Profil von: <?php session_start();
        echo $_SESSION['angemeldet']; ?>
    </title>

</head>

<body>

<div class="container-fluid">
    <div class="row">

        <div class="col-3">
            <h1>Profildaten</h1>
            <div class="profilbild-folgen">
                <?php
                echo ("<img src='data:".$row_header['format'].";base64,".base64_encode($row_header['datei'])."'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                }

                ?>
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
                $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE userid=$id ORDER BY content.id DESC");
                $statement->execute(array('beitragsid' => 1));
                while ($content = $statement->fetch()) {
                    ?>

                        <div class="beitrag">
                            <?php
                    echo "<br />" . $content['benutzername'] . ":<br />";
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