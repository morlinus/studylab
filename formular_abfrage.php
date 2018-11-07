<?php

session_start();
include 'userdata.php';


$id = $_SESSION["id"];


if(!isset($_SESSION["angemeldet"]))
{
    echo"nicht angemeldet.";
    die();
}

$content= $_POST["content"];

$statement = $pdo->prepare("INSERT INTO content VALUES ('',:userid,:text)");
$statement->execute(array(':text'=>$content, ':userid'=>$id));
echo "id in der Datenbank: ".$neueid=$pdo->lastInsertId();




