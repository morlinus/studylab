<?php

session_start();
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user- scalable=yes">

    <style>
        /* stylesheet*/
    </style>

</head>
<div id="header"></div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">StudiLAB</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
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

<div id="main">
    <?php

    if (isset($_SESSION["angemeldet"]))
    {
        echo "angemeldet.";
    }
    else {
        echo "nicht angemeldet.";
    }

    ?>
</div>
</html>