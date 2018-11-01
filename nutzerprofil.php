
<!doctype html>
<html lang="de">
<meta charset="utf-8">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user- scalable=yes">

<style>

</style>

<head>
    <meta charset="utf-8">
    <title>
        Profil von: <?php session_start();
        echo $_SESSION['angemeldet']; ?>
    </title>
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
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <?php
            session_start();
            if (isset($_SESSION["angemeldet"]))
            {
                echo "Eingeloggt ist der Benutzer ".$_SESSION['angemeldet'];
            }
            else {
                echo "nicht angemeldet.";
            }
?>
            </div>
        <div class="col-10">
            Schreibe einen Post:
            <form action="formular_abfrage.php" method="post">
        <textarea name="content" rows="10" cols="80">
        </textarea><br>
                <input type="submit">

        </div>
    </div>
</div>
        <body>
<br>
</body>

</html>