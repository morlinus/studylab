<?php

session_start();
$_SESSION["angemeldet"];
$id=$_SESSION["id"];
include ("userdata.php");

$empfaengerid = $_SESSION["benutzerid"];
$beitragsid = $_SESSION["beitragsid"];

$like= $_POST["like"];
$kommentar=$_POST["kommentar"];

if(isset($_POST["like"])) {

    $statement = $pdo->prepare("INSERT INTO likes (userid, postid) VALUES (:sender_id, :empfaenger_id, :beitrags_id)");
    $statement ->execute(array(':sender_id'=>$id, ':empfaenger_id'=>$empfaengerid, ':beitrags_id'=>$beitragsid));

    $statement = $pdo->prepare("UPDATE likes SET gefeaelltmir = +1 ");
    $statement -> execute (array($_POST['like']));

}


if(isset($_POST['kommentar'])) {


}