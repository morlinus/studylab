<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>
<body>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
<style>
 .container{
     background-color: lightgrey;
     margin-top: 30px;
     width: 300px;
 }
    .background {
        background-color: red;
        height: 100vh;
        width: 100vh;
    }
.container-fluid-main {

}
</style>

<?php
/*
session_start();

if(isset($_POST["benutzername"]) AND isset($_POST["passwort"]))
{
    $benutzername=$_POST["benutzername"];
    $passwort=$_POST["passwort"];
}

include 'userdata.php';

$statement =$pdo->prepare("SELECT * FROM studylab WHERE benutzername=:benutzername AND passwort=:passwort");
if($statement->execute(array(':benutzername'=>$benutzername, ':passwort'=>$passwort))) {
    if ($row=$statement->fetch()) {
        //Leitet die Seite nach erfolgreichen Login weiter
        header("Location: index.php");
        $_SESSION["angemeldet"]=$row["benutzername"];
    }
/*
    else
    {
        echo "Melde dich an!";
    }
*/
/*
}
else {
    echo "Datenbank-Fehler:";
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die();
}
*/
?>

<!-- Hier sollte eigentlich das Form mit Bootstrap sein,
funktioniert aber nicht zusammen mit dem Login-Prozess-->
<body>

<div class="container-fluid-main">
<div class="row height-100 mx-auto align-items-center">
<div class = "height-100 background col-lg-6 col-sm-12">
</div>


<div class=" col-lg-6 col-sm-12">
    <div class="container">
    <div class="row">
        <div class="col">
            <br>
        <form method="post" class="navbar-form navbar-left" action="do_login.php">
            <div class="form-group">
                <label for="Benutzer1">Benutzername</label>
                <input type="text" name="benutzername" class="form-control" id="Benutzername1" aria-describedby="BenutzernameHelp" placeholder="Benutzername">
                <small id="emailHelp" class="form-text text-muted"></small>
            </div>
            <div class="form-group">
                <label for="Passwort1">Passwort</label>
                <input type="password" name="passwort" class="form-control" id="Passwort1" placeholder="Passwort">
            </div>
            <button type="submit" class="btn btn-primary">Abschicken</button><br><br>
            Noch nicht angemeldet? Dann <a href="registrierung.php">Registrieren</a><br><br>
    </div>
    </div>
    </div>
</div>
</div>
</div>

<!-- vorheriges Form -->
<!--
<div id="login">
<form action="?login=1" method="post">
    Benutzername:<br><br>
    <input type="benutzername" size="40" maxlength="250" name="benutzername"><br><br>

    Dein Passwort:<br><br>
    <input type="passwort" size="40"  maxlength="250" name="passwort"><br><br>

    <input type="submit" value="Abschicken"><br><br>

    Noch nicht angemeldet? Dann <a href="registrierung.php">Registrieren</a>!
</div>
-->
</body>

</html>
