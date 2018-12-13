<?php
// startet die Session
session_start();
if(isset($_POST["benutzername"]) AND isset($_POST["passwort"]))
{
    $benutzername=$_POST["benutzername"];
    $passwort=$_POST["passwort"];
}

// stellt die Verbindung zur Datenbank her
include 'userdata.php';

$statement = $pdo->prepare("SELECT * FROM studylab WHERE benutzername = '$benutzername'");
$statement -> execute ();
$nutzerdaten = $statement->fetch();

    if (password_verify($passwort, $nutzerdaten['passwort'])) {

        echo "Login erfolgreich";
        header("Location: index.php");
        // übergibt in der Session den Benutzernamen und die ID des Users
        $_SESSION["angemeldet"]=$nutzerdaten['benutzername'];
        $_SESSION["id"]=$nutzerdaten['id'];
    }

else {
    echo "Etwas ist schief gelaufen";
}


// Passwort wird gehast
// $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

/* kontrolliert, ob der Benutzer und das Passwort mit den Daten aus der Datenbank übereinstimmen
$statement =$pdo->prepare("SELECT * FROM studylab WHERE benutzername=:benutzername AND passwort=:passwort");
if($statement->execute(array(':benutzername'=>$benutzername, ':passwort' => $passwort_hash)))
{
    if ($row=$statement->fetch()) {
        //Leitet die Seite nach erfolgreichen Login weiter
        header("Location: index.php");
        // übergibt in der Session den Benutzernamen und die ID des Users
        $_SESSION["angemeldet"]=$row['benutzername'];
        $_SESSION["id"]=$row['id'];
    }
        else
        {
            // wenn der Login nicht funktioniert, dann wir er wieder auf die Login-Seite weitergeleitet
           // header("Location: login.php");
            echo $benutzername;
            echo $passwort;
            echo $passwort_hash;
        }

}

else {
    echo "Datenbank-Fehler:";
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die(); }
*/



