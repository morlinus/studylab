<?php
session_start();
$_SESSION["angemeldet"];
$id=$_SESSION["id"];
include 'userdata.php';

$name= $_POST["name"];

$statement = $pdo->prepare("UPDATE studylab SET name=:name_neu  WHERE id=$id");
$statement->execute(array(':name_neu' => $name));
?>