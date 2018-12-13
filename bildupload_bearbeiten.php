<?php
/**
 * Created by PhpStorm.
 * User: linusmorlinghaus
 * Date: 13.12.18
 * Time: 12:37
 */
//include_once 'header.php';
ob_start();
include "userdata.php";
include "header.php";

$benutzer_id = $_SESSION ["id"];
$benutzer_name = $_SESSION ["angemeldet"];

echo $benutzer_name;
?>



<html>
<head>
    <meta charset="utf-8"/>
    <title>Profilbild bearbeiten</title>
    <link href="studylab.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-3 col-md-1 col-sm-1">

        </div>

        <div class="col-lg-6 col-md-10 col-sm-10 col-">

            <h2>Hallo <?php echo $benutzer_name; ?> wähle ein neues Profilbild aus</h2>

            <!-- "enctype" beschreibt wie die Datei encoded werden soll -->
            <?php
            // Stellt die Verbindung zur Datenbank her und fügt die Datei in die Datenbank ein


            echo $regid;
            echo $benutzername_id;


            if (isset($_POST['submit'])){
                $name = $_FILES['myfile']['name'];
                $typ = $_FILES ['myfile']['type'];


                $datei = file_get_contents($_FILES['myfile']['tmp_name']);
                $statement = $pdo->prepare("UPDATE bilduplad SET bildname = :bildname_neu, format = :format_neu, datei = :datei_neu WHERE user_id = $benutzer_id");
                $statement->bindParam("bildname_neu",$name);
                $statement->bindParam("format_neu",$typ);
                $statement->bindParam("datei_neu",$datei);
                $statement->execute();
                //$statement->execute(array('bildname_neu' => $name, 'format_neu' => $typ, 'datei_neu' => $datei)); //codealternative

                header ("location:nutzerprofil.php");
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
ob_end_flush();
session_start();
include_once 'footer.php';
?>

</html>