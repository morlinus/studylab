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
<title>Startseite</title>
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

            </div>

            <div class="col-6">


                <br>
                <br>



                <!-- Dies ist die Form, damit der User einen Post schreiben kann -->
                <form action="formular_abfrage_index.php" method="post">
                    <textarea name="content" class="form-control" rows="3"></textarea><br>
                    <input class="btn btn-primary" type="submit" value="Posten">
                    <br>
                    <br>
                </form>


                    <?php
                    // stellt die Verbindung zur Datenbank her
                    include "userdata.php";
                    // zeigt die Post aus der Datenbank an - muss noch so erweitert werde, dass nur die Post von sich selbst und den Leuten, denen man folgt angezeigt wird
                    $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id ORDER BY content.id DESC");
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
                    ?>


            </div>

        </div>
    </div>

</body>

<?php
session_start();
include_once 'footer.php';
?>

</html>