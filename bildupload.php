<?php
//include_once 'header.php';
include "userdata.php";

$benutzername_id=$_GET['studylab'];

$suchnutzer = $pdo->prepare("SELECT * FROM studylab WHERE benutzername = '$benutzername_id'");
$suchnutzer->execute();
$row_get = $suchnutzer->fetch();

        $regid = $row_get ['id'];

echo $regid;
echo $benutzername_id
?>



<html>
<head>
    <meta charset="utf-8"/>
    <title>Profilbild auswählen</title>
    <link href="studylab.css" rel="stylesheet">
</head>
<body>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-md-1 col-sm-1">

            </div>

            <div class="col-lg-6 col-md-10 col-sm-10 col-">

                <h1>Du wurdest erfolgreich Registriert</h1>
                <h2>Nun wähle ein Profilbild aus</h2>

                <!-- "enctype" beschreibt wie die Datei encoded werden soll -->
                <?php
                // Stellt die Verbindung zur Datenbank her und fügt die Datei in die Datenbank ein


                echo $regid;
                echo $benutzername_id;


                if (isset($_POST['submit'])){
                    $name = $_FILES['myfile']['name'];
                    $typ = $_FILES ['myfile']['type'];
                   // $id = $_SESSION ["id"];


                    $datei = file_get_contents($_FILES['myfile']['tmp_name']);
                    $statement = $pdo->prepare("INSERT INTO bilduplad VALUES('',?,?,?,?)");
                    $statement->bindParam(1,$name);
                    $statement->bindParam(2,$typ);
                    $statement->bindParam(3,$datei);
                    $statement->bindParam(4,$regid);
                    $statement->execute();

                    $folgen = $pdo->prepare("INSERT INTO folgen (`user_id`, `follower_id`) VALUES ('$benutzername_id', '$benutzername_id') ");
                    $folgen -> execute();

                    header ("location:login.php");
                }
                ?>

                <!-- Das Form zum hochladen der Dateien -->
                <form class="form-inline my-2 my-lg-0" enctype="multipart/form-data" method="POST">
                    <input type="file" name="myfile"/>
                    <button class="btn my-2 my-sm-0" type="submit" name="submit" value="Hochladen">Hochladen</button>
                </form>

                <p></p>

                <div class="bilder">
                    <?php
                    /*
                    // zeigt die Bilder aus der Datenbank an
                    $stat = $pdo->prepare("SELECT * FROM bilduplad");
                    $stat->execute();
                    while($row = $stat->fetch()){
                        echo "<a target='_blank' href='bild_abrufen.php?".$row['user_id']."'>"."</a><br/>
                    <embed src='data:".$row['format'].";base64,".base64_encode($row['datei'])."' width=''/>";
                    }
                    */
                    ?>

            </div>

            <div class="col-lg-3 col-md-1 col-sm-1">

            </div>

        </div>
    </div>
</body>

<?php
session_start();
include_once 'footer.php';
?>

</html>