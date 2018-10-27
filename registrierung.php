<?php
session_start();
include 'userdata.php'; //anstatt $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
</head>
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
        echo 'Bitte einen Benutzernamen angeben<br>';
        $error = true;
    }
    if(strlen($nachname) == 0) {
        echo 'Bitte einen Benutzernamen angeben<br>';
        $error = true;
    }if(strlen($geburtsdatum) == 0) {
        echo 'Bitte einen Benutzernamen angeben<br>';
        $error = true;
    }
    if(strlen($studiengang) == 0) {
        echo 'Bitte einen Benutzernamen angeben<br>';
        $error = true;
    }
    if(strlen($geschlecht) == 0) {
        echo 'Bitte einen Benutzernamen angeben<br>';
        $error = true;
    }
    if(strlen($semester) == 0) {
        echo 'Bitte einen Benutzernamen angeben<br>';
        $error = true;
    }
    if(strlen($status) == 0) {
        echo 'Bitte einen Benutzernamen angeben<br>';
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
       // $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT); //passwort hashen

        $statement = $pdo->prepare("INSERT INTO studylab (email, passwort,benutzername, name, nachname, geburtsdatum, studiengang, geschlecht, semester, status) VALUES (:email, :passwort, :benutzername, :name, :nachname, :geburtsdatum, :studiengang, :geschlecht, :semester, :status)");
        //$result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'benutzername' => $benutzername, 'name' => $name, 'nachname' => $nachname, 'geburtsdatum' => $geburtsdatum, 'studiengang' => $studiengang, 'geschlecht' => $geschlecht, 'semester' => $semester,'status' => $status));
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort, 'benutzername' => $benutzername, 'name' => $name, 'nachname' => $nachname, 'geburtsdatum' => $geburtsdatum, 'studiengang' => $studiengang, 'geschlecht' => $geschlecht, 'semester' => $semester,'status' => $status));

        if($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
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
        <input type="name" size="40" maxlength="250" name="name"><br><br>
        Nachname:<br>
        <input type="nachname" size="40" maxlength="250" name="nachname"><br><br>

        Benutzername: <br>
        <input type="benutzername" size 40 maxlength="50" name="benutzername"><br><br>
        E-Mail:<br>
        <input type="email" size="40" maxlength="250" name="email"><br><br>

        Geburtsdatum: <br>
        <input type="geburtsdatum" size 40 maxlength="50" name="geburtsdatum"><br><br>

        Studiengang: <br>
        <input type="studiengang" size 40 maxlength="50" name="studiengang"><br><br>

        Geschlecht: <br>
        <input type="geschlecht" size 40 maxlength="50" name="geschlecht"><br><br>

        Semester: <br>
        <input type="semester" size 40 maxlength="50" name="semester"><br><br>

        Position: <br>
        <input type="status" size 40 maxlength="50" name="status"><br><br>

        Dein Passwort:<br>
        <input type="password" size="40"  maxlength="250" name="passwort"><br>

        Passwort wiederholen:<br>
        <input type="password" size="40" maxlength="250" name="passwort2"><br><br>

        <input type="submit" value="Abschicken">
    </form>

    <?php
} //Ende von if($showFormular)
?>

</body>
</html>