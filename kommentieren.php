<?php
session_start();
$id=$_SESSION["id"];

$statement=$pdo->prepare("SELECT kommentare.kommentar, studylab.bentuzername FROM kommentare LEFT JOIN studylab ON kommentare.sender_id=studylab.id");
$statement->execute();
while($komm=$statement->fetch()) {
    echo $komm['benutzername'];
    echo $komm['kommentar'];

}
