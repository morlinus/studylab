<?php
session_start();
// bindet den Datenbankzugriff ein
include 'userdata.php';

// übernimmt die Daten auf der Session
$id_header=$_SESSION ["id"];

// holt die ID und das dazugehörige Profilbild aus der Datenbank 
$benutzername_header = $pdo->prepare("SELECT * FROM studylab WHERE id = '$id_header' ");
$benutzername_header->execute();
$benutzer_name = $benutzername_header->fetch();

$bild_header = $pdo -> prepare("SELECT * FROM bilduplad WHERE user_id=$id_header");
$bild_header ->execute();
$row_header = $bild_header->fetch()


?>


<!doctype html>
<html lang="de">
<meta charset="utf-8">


<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Einbindung Stylesheet-->
    <link href="studylab.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.mim.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">


</head>

<body>

<div class="navbar-custom shadow-sm">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container-fluid">

            <!-- Einteilung Grid-System -->
            <div class="col-12-header col-s-12-header">

                <!-- Wenn man auf das StudiLAB Logo klickt, wird man auf die Startseite geleitet -->
                <a class="navbar-brand" href="index.php"><img src="https://mars.iuk.hdm-stuttgart.de/~as325/Studylab.png" alt="" height="50" width="120"></a>

                <!-- Toggler-Item ab einer bestimmten Breite -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Startseite</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="nutzerprofil.php">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="themenuebersicht.php">Themen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="nutzersuchen.php">Suche</a>
                        </li>

                    </ul>

                    <!-- Dropdown-Menü -->
                    <div class="nav-item dropdown">
                        <a class="nav-link btn btn-secondary dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php
                            echo $benutzer_name['benutzername'];
                            ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="profil_bearbeitung.php">Profil bearbeiten</a>
                            <a class="dropdown-item" href="bildupload_bearbeiten.php">Profilbild bearbeiten</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>

                        <!-- Bildeinbindung neben dem Dropdown-Menü -->
                        <?php
                        echo ("<img src= data:".$row_header['format'].";base64,".base64_encode($row_header['datei'])." alt='nutzerprofilbild' class='profilbild-navbar ml-2'>");


                        ?>
                    </div>

                </div>

            </div>
        </div>

    </nav>
</div>

</body>


</html>
