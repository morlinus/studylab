<?php
session_start();

include 'userdata.php';

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
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link href="studylab.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

<div id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container-fluid">
                <div class="col-6">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <a class="navbar-brand" href="https://mars.iuk.hdm-stuttgart.de/~as325/index.php">StudiLAB</a>
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/index.php">Startseite</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/nutzerprofil.php">Profil</a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="col-6">
                <div class="dropdown">
                    <a class="btn btn-outline-secondary" href="https://mars.iuk.hdm-stuttgart.de/~as325/nutzersuchen.php">Suche</a>
                    <a class="btn btn-outline-secondary" href="https://mars.iuk.hdm-stuttgart.de/~as325/benachrichtigung.php">Benachrichtigung</a>
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Nutzer
                    </a>


                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="https://mars.iuk.hdm-stuttgart.de/~as325/profil_bearbeitung.php">Profil bearbeiten</a><br/>
                        <a class="dropdown-item" href="https://mars.iuk.hdm-stuttgart.de/~as325/bildupload.php">Profilbild bearbeiten</a><br/>
                        <a class="dropdown-item" href="https://mars.iuk.hdm-stuttgart.de/~as325/logout.php">Logout</a><br/>
                    </div>

                    <?php
                    echo ("<img src='data:".$row_header['format'].";base64,".base64_encode($row_header['datei'])."'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                    }

                    ?>

                </div>
                </div>

        </div>
    </nav>

</div>

</body>

</html>