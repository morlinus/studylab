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
    <script>
        $( function() {
            $( "#datepicker" ).datepicker();
            $( "#format" ).on( "change", function() {
                $( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
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
<body>


<?php

echo "registrieren";

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
            header("Location: bildupload.php");
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

if($showFormular) {
    ?>

    <form action="?register=1" method="post">
        Vorname:<br>
        <input type="name" size="40" maxlength="200" name="name"><br><br>
        Nachname:<br>
        <input type="nachname" size="40" maxlength="200" name="nachname"><br><br>

        Benutzername: <br>
        <input type="benutzername" size="40" maxlength="200" name="benutzername"><br><br>
        E-Mail:<br>
        <input type="email" size="40" maxlength="200" name="email"><br><br>

        Geburtsdatum: <br>
      <input type="geburtsdatum" id="datepicker" value="yy-mm-dd" size = "40" maxlength="200" name="geburtsdatum"><br><br>

        // <option id=fomat value="yy-mm-dd">ISO 8601 - yy-mm-dd</option>

        <!-- Studiengang: <br>
        <input type="studiengang" size="40" maxlength="200" name="studiengang"><br><br>
-->
        Studiengang:
        <div class="ui-widget">
            <input id="tags" size="40" maxlength="200" name="studiengang" type="studiengang">
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
                    <input type="radio" name="geschlecht" value="w" required>Männlich
                    <input type="radio" name="geschlecht" value="m" required>Weiblich
                </td>
            </tr>
        </table>
        <br><br>

        Semester: <br>
        <input type="semester" size = "40" maxlength="200" name="semester"><br><br>

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
                    <input type="radio" name="status" value="s" required>Student
                    <input type="radio" name="status" value="p" required>Professor
                </td>
            </tr>
        </table>
        <br><br>

        Dein Passwort:<br>
        <input type="password" size="40"  maxlength="200" name="passwort"><br>

        Passwort wiederholen:<br>
        <input type="password" size="40" maxlength="200" name="passwort2"><br><br>

        <input type="submit" value="Abschicken">
    </form>

    <?php
} //Ende von if($showFormular)
?>

</body>
</html>