<?php
session_start();
$id=$_SESSION["id"];


if(isset($_POST['kommentar'])) {

    $comment=$_POST['comment'];
    $post_id=$_POST['post_id'];

    $statement = $pdo->prepare("INSERT INTO kommentare (id, sender_id, post_id, kommentar) VALUES (' ',:sender_id, :post_id,:kommentar)");
    if (!$statement->execute(array(':sender_id' => $id, ':post_id'=>$post_id, ':kommentar' => $comment)))
    {
        echo "Fehler";
    }

}
