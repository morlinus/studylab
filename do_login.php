<?php
// Startet die Session
session_start();
if(isset($_POST["benutzername"]) AND isset($_POST["passwort"]))
{
    $benutzername=$_POST["benutzername"];
    $passwort=$_POST["passwort"];
}

// Stellt die Verbindung zur Datenbank her
include 'userdata.php';

// Wählt aus der Datenbank den Benutzernamen aus und gleich den Benutzernamen mit eingegebenen Passwort und dem Passwort in der Datenbank ab
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
    header("Location:login.php");;
}
?>


