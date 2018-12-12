<?php
session_start();
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
    <link href="studylab-login.css" rel="stylesheet">
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
        } );



        $( function() {
            var availableTags = [
                "Online- Medien- Management",
                "Informationsdesign",
                "Bibliothekswissenschaften",
                "BASIC",
                "C",
                "C++",
                "Clojure",
                "COBOL",
                "ColdFusion",
                "Erlang",
                "Fortran",
                "Groovy",
                "Haskell",
                "Java",
                "JavaScript",
                "Lisp",
                "Perl",
                "PHP",
                "Python",
                "Ruby",
                "Scala",
                "Scheme"
            ];
            $( "#tags" ).autocomplete({
                source: availableTags
            });
        } );

    </script>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        background: url(https://mars.iuk.hdm-stuttgart.de/~lm092/ZH103);
        background-size: cover;
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
    if(strlen($benutzername) == 0) {
        echo 'Bitte einen Benutzernamen angeben<br>';
        $error = true;
    }
    if(strlen($name) == 0) {
        echo 'Bitte einen Vornamen angeben<br>';
        $error = true;
    }
    if(strlen($nachname) == 0) {
        echo 'Bitte einen Nachnamen angeben<br>';
        $error = true;
    }if(strlen($geburtsdatum) == 0) {
        echo 'Bitte ein Geburtsdatum angeben<br>';
        $error = true;
    }
   /* if(strlen($studiengang) == 0) {
        echo 'Bitte einen Studiengang angeben<br>';
        $error = true;
   } */
    if(strlen($geschlecht) == 0) {
        echo 'Bitte Geschlecht angeben<br>';
        $error = true;
    }
   /* if(strlen($semester) == 0) {
      echo 'Bitte Ihr aktuelles Semester angeben<br>';
      $error = true;
    } */
    if(strlen($status) == 0) {
        echo 'Bitte Ihre Position angeben<br>';
        $error = true;
    }


    //Hier wird überprüft, ob die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM studylab WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }

    //wenn keine Fehler vorliegen, wird hier der Nutzer registriert
    if(!$error) {
       $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT); //passwort hashen

        $statement = $pdo->prepare("INSERT INTO studylab (email, passwort, benutzername, name, nachname, geburtsdatum, studiengang, geschlecht, semester, status) VALUES (:email, :passwort, :benutzername, :name, :nachname, :geburtsdatum, :studiengang, :geschlecht, :semester, :status)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'benutzername' => $benutzername, 'name' => $name, 'nachname' => $nachname, 'geburtsdatum' => $geburtsdatum, 'studiengang' => $studiengang, 'geschlecht' => $geschlecht, 'semester' => $semester,'status' => $status));
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
<div class="fenster">
    <h2>Registrieren</h2>
    <form action="?register=1" method="post">

        <div class="eingabefeld">
        <input type="name" size="40" maxlength="200" name="name" placeholder="Name"> <input type="nachname" size="40" maxlength="200" name="nachname" placeholder="Nachname">
        </div>

        <div class="eingabefeld">
        <input type="benutzername" size="40" maxlength="200" name="benutzername" placeholder="Benutzername">
        </div>

        <div class="eingabefeld">
        <input type="email" size="40" maxlength="200" name="email"placeholder="E-Mail">
        </div>

        <div class="eingabefeld">
      <input type="geburtsdatum" id="datepicker" size = "40" maxlength="200" name="geburtsdatum"placeholder="Geburtsdatum">
        </div>

        <!--
        <div class="eingabefeld">
        <option id=fomat value="yy-mm-dd">ISO 8601 - yy-mm-dd</option>
        </div> -->

        <!-- Studiengang: <br>
        <input type="studiengang" size="40" maxlength="200" name="studiengang"><br><br>
-->
        <div class="eingabefeld">
        <div class="ui-widget">
            <input id="tags" size="40" maxlength="200" name="studiengang" type="studiengang"placeholder="Studiengang">
        </div>
            </div>
        <br><br>
        <!--
                Geschlecht: <br>
                <input type="geschlecht" size 40 maxlength="50" name="geschlecht"><br><br>


                 Geschlecht: <br>

                    <label for="männl">Männlich: </label>
                    <input type="radio" name="geschlecht" id="männl" value="männlich">

                    <label for="weibl">Weiblich: </label>
                    <input type="radio" name="geschlecht" id="weibl" value="weiblich">
                    <br><br> -->

        <table>
            <tr>
                <td>Geschlecht :</td>
                <td>
                    <input type="radio" name="geschlecht" value="Männlich" required>Männlich
                    <input type="radio" name="geschlecht" value="Weiblich" required>Weiblich
                </td>
            </tr>
        </table>
        <br><br>

        <div class="eingabefeld">
        <input type="semester" size = "40" maxlength="200" name="semester"><br><br>
        </div>

       <!--  Position: <br>
        <input type="status" size = "40" maxlength="200" name="status"><br><br>

        Position: <br>
        <div class="widget">
            <input type="status" value="Student" name ="status">
            <input type="status" value="Professor" name ="status">

        </div>
        Position:
        <br>
        <select name="status" required>
            <option selected hidden value="">Student</option>
            <option value="Professor">Professor</option>
            <option value="Student">Student</option>
        </select>
        <br><br> -->

        <table>
            <tr>
                <td>Position :</td>
                <td>
                    <input type="radio" name="status" value="Student" required>Student
                    <input type="radio" name="status" value="Professor" required>Professor
                </td>
            </tr>
        </table>
        <br><br>

        <div class="eingabefeld">
        <input type="password" size="40"  maxlength="200" name="passwort" placeholder="Passwort eingeben"><br>
        </div>

        <div class="eingabefeld">
        <input type="password" size="40" maxlength="200" name="passwort2" placeholder="Passwort wiederholen"><br><br>
        </div>

        <input type="submit" value="Abschicken">
    </form>

</div>

    <?php
} //Ende von if($showFormular)
?>

</body>
</html>