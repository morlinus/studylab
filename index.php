<?php
include_once 'header.php';
?>

<!doctype html>
<html lang="de">
<head>
<title>Startseite</title>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
<br>
    <?php
    session_start();
    if (isset($_SESSION["angemeldet"]))
    {
        echo "Hallo"." " .$_SESSION["angemeldet"];
    }
    else {

        header("Location:login.php");
    }

    ?>
</div>
            <div class="container-fluid">
            <div class="row">
                <div class="col-10">
                    <form action="formular_abfrage_index.php" method="post">
                        <textarea name="content" class="form-control" rows="3"></textarea><br>
                        <input class="btn btn-primary" type="submit" value="Posten">

                </div>
            </div>
        </div>
            <br>
            <br>
            <?php session_start();
            if (isset($_SESSION["angemeldet"])) {
            echo "Eingeloggt ist der Benutzer " . $_SESSION['angemeldet'];
            ?><br>
<br><br>
            <div class="container">
                <div class="row">
                    <div class="col-4"
                <?php

                include "userdata.php";
                $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id");
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


</body>
</html>