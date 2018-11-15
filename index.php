<!doctype html>
<html lang="de">
<head>

    <meta charset="utf-8">
<!-- Fügt den Namen der eingeloggten Person in den Titel ein -->
<title>Startseite</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user- scalable=yes">

    <!--verschiebt den Conatiner an den rechten Seitenrand -->
    <style>
       .pull-right {
           float: right; !important;
           margin-right: 10px;
       }

       .page-footer{
           background-color: lightgray;
           color: white;
           position: absolute;
           bottom: 0px;
           width: 100%;
       }

    </style>

</head>
<div id="header">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">StudiLAB</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/index.php">Startseite</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/logout.php">Logout</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/nutzerprofil.php">Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/impressum.html">Impressum</a>
            </li>
        </ul>
    </div>
</nav>
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



</html>