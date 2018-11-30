<?php
session_start();
$id=$_SESSION["id"];

$empfaenger_id=$_SESSION['empfaenger_id'];
$post_id=$_SESSION['post_id'];

$comment=$_POST["comment"];

if(isset($_POST['kommentar'])) {

    $statement = $pdo->prepare("INSERT INTO kommentare (id, sender_id, empfaenger_id, post_id, kommentar) VALUES (NULL,:sender_id, :empfaenger_id, :post_id,:kommentar)");
    $statement->execute(array('sender_id' => $id, 'empfaenger_id'=>$empfaenger_id, 'post_id'=>$post_id, 'kommentar' => $comment));


}