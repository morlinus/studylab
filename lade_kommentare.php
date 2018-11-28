<?php

$statement=$pdo->prepare("SELECT kommentar.*, studylab.benutzername FROM kommentare LEFT JOIN studylab ON kommentare.empfaenger_id=studylab.id ORDER BY kommentar.id DESC");
$statement->execute(array('kommentarid'=>1));

while ($content = $statement->fetch()) {
    echo $content['benutzername'];
    echo $content['kommentar'];
}