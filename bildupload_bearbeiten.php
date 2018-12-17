<?php
// schaut durch die Session, ob der Nutzer angemeldet ist
session_start();
if (isset($_SESSION["angemeldet"]))
{

}
else {
    // Falls der Nutzer nicht angemeldet ist, wird er mit header auf die Login-Seite geleitet
    header("Location:login.php");
}

ob_start();
// stellt die Verbindung zur Datenbank her
include "userdata.php";
// bindet die header.php ein und damit den Header der Seite
include_once "header.php";

$benutzer_id = $_SESSION ["id"];
$benutzer_name = $_SESSION ["angemeldet"];


$bild_header = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id=$id_header");
$bild_header->execute();
while($row_header = $bild_header->fetch()){


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

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-3 col-md-1 col-sm-1">

        </div>

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-6 col-md-10 col-sm-10 col- mt-5">

            <br>
            <br>
            
            <div class="shadow-sm p-3 mb-5 bg-white rounded">

                <div class="profilbild-bearbeitung">

                    <h4>Profilbild ändern</h4>

                    <br>

                        <h6>Akutelles Profilbild</h6><br>
                        <div class="kommentar">
                            <?php

                            // Benutzerbild wird im Profil angezeigt
                            echo ("<img src='data:".$row_header['format'].";base64,".base64_encode($row_header['datei'])."'width=' alt='Responsive image' class='profilbild-profil'>");
                            }
                            ?>
                        </div>
                        <br>



                    <h6>Wähle ein neues Profilbild aus</h6>
                    <!-- "enctype" beschreibt wie die Datei encoded werden soll -->
                    <?php
                    // Stellt die Verbindung zur Datenbank her und fügt die Datei in die Datenbank ein

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

                    <br>

                    <!-- Das Form zum hochladen der Dateien -->
                    <form class="form-inline my-2 my-lg-0" enctype="multipart/form-data" method="POST">
                        <input type="file" name="myfile"/>
                        <button class="btn my-2 my-sm-0" type="submit" name="submit" value="Hochladen">Hochladen</button>
                    </form>

                    <p></p>

                </div>
            </div>
        </div>

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-3 col-md-1 col-sm-1">

        </div>


    </div>

</div>
</body>


<?php
ob_end_flush();
session_start();

// Einbindung des Sticky-Footers
include_once 'footer.php';
?>

</html>