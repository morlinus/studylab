<?php
session_start();
// bindet den Datenbankzugriff ein
include 'userdata.php'; //anstatt $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link href="studylab-login.css" rel="stylesheet">
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        } );

        $( function() {
            var availableTags = [
                "Online- Medien- Management",
                "Informationsdesign",
                "Bibliothekswissenschaften",
                "Audiovisuelle Medien",
                "Crossmedia-Redaktion/Public Relations",
                "Deutsch-Chinesischer Studiengang Medien und Technologie",
                "Informationswissenschaften",
                "Integriertes Produktdesign",
                "Mediapublishing",
                "Medieninformatik",
                "Medienwirtschaft",
                "Mobile Medien",
                "Print Media Technologies",
                "Verpackungstechnik",
                "Werbung und Marktkommunikation",
               "Wirtschaftsinformatik und digitale Medien",
                "Wirtschaftsingenieurwesen Medien"
            ];
            $( "#tags" ).autocomplete({
                source: availableTags
            });
        } );
        $( function() {
            $( "#dialog" ).dialog();
        } );

    </script>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        background: url(https://mars.iuk.hdm-stuttgart.de/~lm092/würfel2.jpg);
        background-size: cover;
        height: 100vh;
        width: 100vh;
    }

</style>
<body>


<?php

$showFormular = true; //Variable ob das Registrierungsformular angezeigt werden soll

if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $benutzername = $_POST ['benutzername'];
    $name = $_POST ['name'];
    $nachname = $_POST ['nachname'];
    $geburtsdatum = $_POST ['geburtsdatum'];
    $studiengang = $_POST ['studiengang'];
    $geschlecht = $_POST ['geschlecht'];
    $semester = $_POST ['semester'];
    $status = $_POST ['status'];


    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if(strlen($passwort) == 0) { // Überprüfung, ob eingabe getätigt
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) { // überprüfung, ob passwörter identisch sind
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    //Hier wird überprüft, ob die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM studylab WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if($user !== false) {
            echo '<div id="dialog" title="E-Mail-Adresse">
  <p>Diese E-Mail Adresse ist leider bereits vergeben. Bitte registriere dich erneut</p>
</div>';
            $error = true;
        }
    }

    //Hier wird überprüft, ob der benutzername noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM studylab WHERE benutzername = :benutzername");
        $result = $statement->execute(array('benutzername' => $benutzername));
        $user = $statement->fetch();

        if($user !== false) {
            echo '<div id="dialog" title="Benutzername">
  <p>Dieser Benutzername ist leider bereits vergeben. Bitte registriere dich erneut</p>
</div>';
            $error = true;
        }
    }

    //wenn keine Fehler vorliegen, wird hier der Nutzer registriert
    if(!$error) {
       $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT); //passwort hashen

        $statement = $pdo->prepare("INSERT INTO studylab (email, passwort, benutzername, name, nachname, geburtsdatum, studiengang, geschlecht, semester, status) VALUES (:email, :passwort, :benutzername, :name, :nachname, :geburtsdatum, :studiengang, :geschlecht, :semester, :status)");
        $statement -> bindParam("email",$email);
        $statement -> bindParam("passwort",$passwort_hash);
        $statement -> bindParam("benutzername",$benutzername);
        $statement -> bindParam("name",$name);
        $statement -> bindParam("nachname",$nachname);
        $statement -> bindParam("geburtsdatum",$geburtsdatum);
        $statement -> bindParam("studiengang",$studiengang);
        $statement -> bindParam("geschlecht",$geschlecht);
        $statement -> bindParam("semester",$semester);
        $statement -> bindParam("status",$status);
        $result = $statement -> execute();
        //$result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'benutzername' => $benutzername, 'name' => $name, 'nachname' => $nachname, 'geburtsdatum' => $geburtsdatum, 'studiengang' => $studiengang, 'geschlecht' => $geschlecht, 'semester' => $semester,'status' => $status));
        //$result = $statement->execute(array('email' => $email, 'passwort' => $passwort, 'benutzername' => $benutzername, 'name' => $name, 'nachname' => $nachname, 'geburtsdatum' => $geburtsdatum, 'studiengang' => $studiengang, 'geschlecht' => $geschlecht, 'semester' => $semester,'status' => $status));

        if($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            header("Location: bildupload.php?studylab=$benutzername");
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

if($showFormular) {

    ?>

<div class="container-fluid-main">
    <div class="row height-100 mx-auto align-items-center background-recht">‚

    <div class="col-lg-3 col-md-2 col-sm-0 col-lg-3 col-md-1 col-"></div>


<div class="fensterreg col-lg-6 col-md-8 col-sm-12" >
    <img src="https://mars.iuk.hdm-stuttgart.de/~as325/Studylab.png" alt="" height="100" width="250">
    <h2 style="font-family:'Helvetica Neue'">Registrieren</h2>
    <form action="?register=1" method="post">

        <div class="eingabefeldreg">
        <input type="name" size="40" maxlength="200" name="name" placeholder="Name"> <input type="nachname" size="40" maxlength="200" name="nachname" placeholder="Nachname" required>
        </div>

        <div class="eingabefeldreg">
        <input type="benutzername" size="40" maxlength="200" name="benutzername" placeholder="Benutzername" required>
        </div>

        <div class="eingabefeldreg">
        <input type="email" size="40" maxlength="200" name="email"placeholder="E-Mail" required>
        </div>

        <div class="eingabefeldreg">
        <input type="geburtsdatum" id="datepicker" size = "40" maxlength="200" name="geburtsdatum"placeholder="Geburtsdatum">
        </div>

        <table>
            <tr>
                <td style="font-weight:bold; font-family:'Helvetica Neue';">Geschlecht </td>
                <td style="color:darkgrey; font-family:'Helvetica Neue';">
                    <input type="radio" name="geschlecht" value="Männlich" required> Männlich
                    <input type="radio" name="geschlecht" value="Weiblich" required> Weiblich
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                <td style="font-weight:bold; font-family:'Helvetica Neue';">        Position </td>
                <td style="color:darkgrey; font-family:'Helvetica Neue';">
                    <input type="radio" name="status" value="Student" required> Student
                    <input type="radio" name="status" value="Professor" required> Professor
                </td>
            </tr>
        </table>
        <br>

        <div class="eingabefeldreg">
            <div class="ui-widget">
                <input id="tags" size="40" maxlength="200" name="studiengang" type="studiengang"placeholder="Studiengang">
            </div>
        </div>

        <div class="eingabefeldreg">
        <input type="semester" size = "40" maxlength="200" name="semester" placeholder="Semester"><br><br>
        </div>




        <div class="eingabefeldreg">
        <input type="password" size="40"  maxlength="200" name="passwort" placeholder="Passwort eingeben" required><br>
        </div>

        <div class="eingabefeldreg">
        <input type="password" size="40" maxlength="200" name="passwort2" placeholder="Passwort wiederholen" required><br><br>
        </div>

        <button style="font-family:'Helvetica Neue'" type="submit" value="Abschicken" class="btn btn-primary">Registrieren</button><br><br>
        <a style="font-family:'Helvetica Neue'">Schon Registriert?</a>
        <a class="registrierung" href="login.php" style="font-family:'Helvetica Neue'">Zum Login</a><br><br>
    </form>

</div>


    <div class="col-lg-3 col-md-2 col-sm-0 col-lg-3 col-md-1 col-"></div>

    </div>
</div>

    <?php
} //Ende von if($showFormular)
?>

</body>
</html>