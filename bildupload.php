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
include "userdata.php";
if (isset($_POST['submit'])){
    $name = $_FILES['myfile']['name'];
    $type = $_FILES ['myfile']['type'];
    $data = file_get_contents($_FILES['myfile']['tmp_name']);
    $statement = $pdo->prepare("INSERT INTO bilduplad VALUES('',?,?,?)");
    $statement->bindParam(1,$name);
    $statement->bindParam(2,$type);
    $statement->bindParam(3,$data);
    $statement->execute();
}
?>

<form enctype="multipart/form-data" method="POST">
    <input type="file" name="myfile"/>
    <button name="submit">Hochladen</button>

</form>
<p></p>
<ol>
    <?php
    $stat = $pdo->prepare("SELECT * FROM bilduplad");
    $stat->execute();
    while($row = $stat->fetch()){
        echo "<li><a target='_blank' href='bild_abrufen.php?".$row['id']."'>".$row['name']."</a><br/>
    <embed src='data:".$row['mime'].";base64,".base64_encode($row['data'])."' width=''/></li>";
    }
    ?>
</ol>
</body>
