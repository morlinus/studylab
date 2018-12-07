<?php
// Dies ist die gleiche Formular-Abfrage für die Postings-Funktion nur für die Startseite

session_start();
// stellt die Verbindung zur Datenbank her
include 'userdata.php';

// übergibt die User ID durch die Session
$id = $_SESSION["id"];


if(!isset($_SESSION["angemeldet"]))
{
    echo"nicht angemeldet.";
    die();
}

// übernimmt den Content aus dem Formular der Index.php und fügt die Daten dann in die Datenbank ein
$content= $_POST["content"];


    $statement = $pdo->prepare("INSERT INTO content VALUES ('',:userid,:text)");
    $statement->execute(array(':text' => $content, ':userid' => $id));

    $benachrichtigung=$pdo->prepare("SELECT userid FROM folgen WHERE follower_id=$id");
    $benachrichtigung->execute();

$lastinsert = $pdo->prepare("SELECT max(id) AS id FROM content");
$lastinsert->execute();
while ($letzteid = $lastinsert->fetch()){

    $postid=$letzteid['id'];

            $eintragen = $pdo->prepare("INSERT INTO benachrichtigung (id, userid, post_id) VALUES ('',:userid,:post_id)");
            if (!$eintragen->execute(array(':userid' => $id, ':post_id' =>$postid)))
            {
                echo "Fehler";
            }
}
If ($postid > 0) {

$name = $_FILES['myfile']['name'];
$typ = $_FILES ['myfile']['type'];
$datei = file_get_contents($_FILES['myfile']['tmp_name']);
$statement_bild = $pdo->prepare("INSERT INTO bildupload_content VALUES('',?,?,?,?,?)");
$statement_bild->bindParam(1,$postid);
$statement_bild->bindParam(2,$id);
$statement_bild->bindParam(3,$name);
$statement_bild->bindParam(4,$typ);
$statement_bild->bindParam(5,$datei);
$statement_bild->execute();

echo "Klappt";
echo $name;
echo $typ;
echo $datei;
}
