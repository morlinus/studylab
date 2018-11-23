<!doctype html>
<html lang="de">
<meta charset="utf-8">
<head>
    <title>
        Profil von: <?php session_start();
        echo $_SESSION['angemeldet']; ?>
    </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="studylab.css" rel="stylesheet">

</head>

<body>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


<body>

<div id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <a class="navbar-brand" href="#">StudiLAB</a>
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/index.php">Startseite</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/nutzerprofil.php">Profil</a>
                </li>
            </ul>

            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Suche" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Suche</button>
            </form>


            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Nutzer
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Profil bearbeiten</a><br/>
                    <a class="dropdown-item" href="#">Profilbild bearbeiten</a><br/>
                    <a class="dropdown-item" href="#">Logout</a><br/>
                </div>

                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/34/PICA.jpg/440px-PICA.jpg" href="#" alt="Nutzerprofilbild" class="rounded-circle">

            </div>

        </div>


    </nav>

</div>
<br>

<div class="container">
    <div class="row">

        <div class="col-sm-3">
            <h1>Profildaten</h1>
        </div>

        <div class="col-sm-6">
            <?php
            session_start();
            $id=$_SESSION["id"];
            if (isset($_SESSION["angemeldet"])) {
            echo "Eingeloggt ist der Benutzer " . $_SESSION['angemeldet'];
            ?>
            <div class="">
                <?php

                include "userdata.php";
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

            <div class="col-sm-3">
                Schreibe einen Post:
                <form action="formular_abfrage.php" method="post">
                    <textarea name="content" class="form-control" rows="3"></textarea><br>
                    <input class="btn btn-primary" type="submit" value="Posten">

            </div>

        </div>



    </div>
</div>

   <footer class="page-footer navbar-inverse">

            <div class="footer-copyright text-center py-3">© 2018 Copyright:
                <a href="#">StudiLAB.com</a>
                <a href="https://mars.iuk.hdm-stuttgart.de/~as325/impressum.html">Impressum</a>
            </div>

   </footer>

<body/>

</html>