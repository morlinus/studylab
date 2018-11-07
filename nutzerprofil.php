
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

</head>
<style>
    .container-fluid{
       float: right; !important;
        width: 350px;
    }


</style>
<body>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

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
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col">

            <?php
            session_start();
            if (isset($_SESSION["angemeldet"])) {
                echo "Eingeloggt ist der Benutzer " . $_SESSION['angemeldet'];
?>
            <div class="posting">
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

        <div class="container-fluid">
            <div class="row">
        <div class="col-10">
            Schreibe einen Post:
            <br><br><form action="formular_abfrage.php" method="post">
                <textarea name="content" class="form-control" rows="3"></textarea><br>
                <textarea name="id" class="form-control" rows="3">/textarea>
                <input class="btn btn-primary" type="submit" value="Posten">

        </div>
    </div>

</div>
        <body>
<br>

</body>

</html>