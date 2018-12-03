<?php
session_start();
//include_once 'header.php';
?>



<html>
<head>
    <meta charset="utf-8"/>
    <title>Bild Upload</title>
</head>
<body>

    <div class="container-fluid">
        <div class="row">

            <div class="col-3">

            </div>

            <div class="col-6">

                <h1>Du wurdest erfolgreich Registriert</h1>
                <h2>Nun wähle ein Profilbild aus</h2>

                <!-- "enctype" beschreibt wie die Datei encoded werden soll -->
                <?php
                // Stellt die Verbindung zur Datenbank her und fügt die Datei in die Datenbank ein


                include "userdata.php";
                if (isset($_POST['submit'])){
                    $name = $_FILES['myfile']['name'];
                    $typ = $_FILES ['myfile']['type'];
                    $id = $_SESSION ["id"];
                    $datei = file_get_contents($_FILES['myfile']['tmp_name']);
                    $statement = $pdo->prepare("INSERT INTO bilduplad VALUES('',?,?,?,?)");
                    $statement->bindParam(1,$name);
                    $statement->bindParam(2,$typ);
                    $statement->bindParam(3,$datei);
                    $statement->bindParam(4,$id);
                    $statement->execute();
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

            <div class="col-3">

            </div>

        </div>
    </div>




</body>

<?php
session_start();
include_once 'footer.php';
?>

</html>