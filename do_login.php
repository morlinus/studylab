<?php
session_start();

if(isset($_POST["benutzername"]) AND isset($_POST["passwort"]))
{
    $benutzername=$_POST["benutzername"];
    $passwort=$_POST["passwort"];
}

include 'userdata.php';
$passwort_hash = password_hash($passwort, PASSWORD_DEFAULT); //passwort wird gehasht

$statement =$pdo->prepare("SELECT * FROM studylab WHERE benutzername=:benutzername AND passwort=:passwort");
if($statement->execute(array(':benutzername'=>$benutzername, ':passwort' => $passwort)))
{
    if ($row=$statement->fetch()) {
        //Leitet die Seite nach erfolgreichen Login weiter
        header("Location: index.php");
        $_SESSION["angemeldet"]=$row['benutzername'];
        $_SESSION["id"]=$row['id'];
        $_SESSION["passwort"]=$row['passwort'];
    }
        else
        {
            header("Location: login.php");
        }

}

else {
    echo "Datenbank-Fehler:";
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die(); }

    ?>


