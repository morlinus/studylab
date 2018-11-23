<html>
<body>
<head>
    <meta charset="utf-8"/>
    <title>Bild Upload</title>
</head>
<body>
<h1>Du wurdest erfolfgreich Registriert</font></h1>
<h2>Nun wähle ein Profilbild aus</h2>

<!-- "enctype" beschreibt wie die Datei encoded werden soll -->
<?php
// Stellt die Verbindung zur Datenbank her und fügt die Datei in die Datenbank ein
include "userdata.php";
if (isset($_POST['submit'])){
    $name = $_FILES['myfile']['name'];
    $typ = $_FILES ['myfile']['type'];
    $datei = file_get_contents($_FILES['myfile']['tmp_name']);
    $statement = $pdo->prepare("INSERT INTO bilduplad VALUES('',?,?,?)");
    $statement->bindParam(1,$name);
    $statement->bindParam(2,$typ);
    $statement->bindParam(3,$datei);
    $statement->execute();
}
?>
<!-- Das Form zum hochladen der Dateien -->
<form enctype="multipart/form-data" method="POST">
    <input type="file" name="myfile"/>
    <button name="submit">Hochladen</button>

</form>
<p></p>
<ol>
    <?php
    // zeigt die Bilder aus der Datenbank an
    $stat = $pdo->prepare("SELECT * FROM bilduplad");
    $stat->execute();
    while($row = $stat->fetch()){
        echo "<li><a target='_blank' href='bild_abrufen.php?".$row['id']."'>".$row['name']."</a><br/>
    <embed src='data:".$row['format'].";base64,".base64_encode($row['datei'])."' width=''/></li>";
    }
    ?>
</ol>
</body>
