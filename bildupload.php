<?php
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
    <link href="studylab-login.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: url(https://mars.iuk.hdm-stuttgart.de/~lm092/bib2.jpg);
            background-size: cover;
        }
    </style>
</head>
<body>

    <div class="container-fluid-main">
        <div class="row">

            <!-- Einteilung in das Grid-System -->
            <div class="row height-100 mx-auto align-items-center background-recht">

            </div>

            <!-- Einteilung in das Grid-System -->
            <div class="fenster col-sm-12 align-items-center">
                <img src="https://mars.iuk.hdm-stuttgart.de/~as325/Studylab.png" alt="" height="100" width="250">
                <br>
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

                   // $folgen = $pdo->prepare("INSERT INTO folgen (`user_id`, `follower_id`) VALUES ('$benutzername_id', '$benutzername_id') ");
                   // $folgen -> execute();
                    $folgen = $pdo->prepare("INSERT INTO folgen (id,user_id,follower_id) VALUES ('',:user_id,:follower_id)");
                    $folgen -> execute(array(':user_id' =>$regid,':follower_id' => $regid));

                    header ("location:login.php");
                }
                ?>

                <!-- Das Form zum hochladen der Dateien -->
                <form class="form-inline my-2 my-lg-0" enctype="multipart/form-data" method="POST">
                    <input type="file" name="myfile"/>
                    <button class="btn my-2 my-sm-0" type="submit" name="submit" value="Hochladen">Hochladen</button>
                </form>

                <p></p>

        </div>
    </div>
</body>

</html>