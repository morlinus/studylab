<?php
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
    }*/
}
else {
    echo "Datenbank-Fehler:";
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<form action="?login=1" method="post">
    Benutzername:<br>
    <input type="benutzername" size="40" maxlength="250" name="benutzername"><br><br>

    Dein Passwort:<br>
    <input type="passwort" size="40"  maxlength="250" name="passwort"><br>

    <input type="submit" value="Abschicken"><br><br>

    Noch nicht angemeldet? Dann <a href="registrierung.php">Registrieren</a>!
</form>
</body>
</html>
