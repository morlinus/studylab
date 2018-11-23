<?php

session_start();

// stellt die Verbindung zur Datenbank her
include 'userdata.php';

// übernimmt die ID aus dem Login
$id = $_SESSION["id"];

// schaut ob der User angemeldet ist, wenn nicht, dann wird er auf die Login-Seite weitergeleitet
if(!isset($_SESSION["angemeldet"]))
{
    header ("Location:login.php");
}

// übernimmt den Content aus dem Formular des Nutzerprofils
$content= $_POST["content"];

// bereitet die Datenbank vor
$statement = $pdo->prepare("INSERT INTO content VALUES ('',:userid,:text)");
// fügt die Inhalte in die Datenbank ein
$statement->execute(array(':text'=>$content, ':userid'=>$id));
// leitet den Nutzer nach dem Post wieder auf die Nutzerprofil.php zurück
header ("Location:nutzerprofil.php");




