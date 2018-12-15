<?php
//Diese Seite hängt mit der Profil_bearbeitung.php zusammen
// Die Session wird gestartet und es wird übergeben, ob der Nutzer eingeloggt ist, was seine ID und sein Passwort ist
session_start();
$_SESSION["angemeldet"];
$id=$_SESSION["id"];
$passwort=$_SESSION["passwort"];

// Stellt die Verbindung zur Datenbank her
include 'userdata.php';

if(!isset($_POST['submit'])) exit;

// Der Name wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$name= $_POST["name"];
$name2= count($name);
if ($name2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET name = ?  WHERE id=$id");
    $statement->execute(array($_POST["name"]));
}
// Der Nachname wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$nachname= $_POST["nachname"];

$nachname2= count($nachname);
if ($nachname2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET nachname = ?  WHERE id=$id");
    $statement->execute(array($_POST["nachname"]));
}
// Der Benutzerame wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$benutzername= $_POST["benutzername"];

$benutzername2= count($benutzername);
if ($benutzername2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET benutzername = ?  WHERE id=$id");
    $statement->execute(array($_POST["benutzername"]));
}
// Das Geburtsdatum wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$geburtsdatum= $_POST["geburtsdatum"];

$geburtsdatum2= count($geburtsdatum);
if ($geburtsdatum2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET geburtsdatum = ?  WHERE id=$id");
    $statement->execute(array($_POST["geburtsdatum"]));
}
// Der Studiengang wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$studiengang= $_POST["studiengang"];

$studiengang2= count($studiengang);
if ($studiengang2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET studiengang = ?  WHERE id=$id");
    $statement->execute(array($_POST["studiengang"]));
}
// Die E-Mail wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$email= $_POST["email"];

$email2= count($email);
if ($email2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET email = ?  WHERE id=$id");
    $statement->execute(array($_POST["email"]));
}
// Das Semester wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$semester= $_POST["semester"];

$semester2= count($semester);
if ($semester2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET semester = ?  WHERE id=$id");
    $statement->execute(array($_POST["semester"]));
}
// Der Status wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$status= $_POST["status"];

$status2= count($status);
if ($status2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET semester = ?  WHERE id=$id");
    $statement->execute(array($_POST["status"]));
}
//Das alte und das neue Passwort wird durch Post übergeben
$passwort_alt=$_POST["passwort_alt"];
$passwort_neu=$_POST["passwort_neu"];
$passwortneu2= strlen($passwort_neu);
if ($passwortneu2 > 0) {
    $passwort_hash = password_hash($passwort_neu, PASSWORD_DEFAULT); //passwort hashen
// wählt aus der Datenbank den Benutzernamen aus und gleich den Benutzernamen mit eingegebenen Passwort und dem Passwort in der Datenabank ab
    $statement = $pdo->prepare("SELECT * FROM studylab WHERE id = $id");
    $statement->execute();
    $nutzerdaten = $statement->fetch();

// Wenn das Passwort in der Eingabe mit dem Passwort in der Datenbank übereinstimmt, dann kann das Passwort auf das neue Passwort verändert werden
    if (password_verify($passwort_alt, $nutzerdaten['passwort'])) {
        $statement = $pdo->prepare("UPDATE studylab SET passwort = :passwortneu WHERE id=$id");
        $statement->bindParam("passwortneu", $passwort_hash);
//$statement->execute(array($_POST["passwort_neu"]));
        $statement->execute();
    }

    else {
         die (header("Location:profil_bearbeitung.php"));
     }
 }
 else {
    die( header("Location:nutzerprofil.php"));
 }
 header("Location:nutzerprofil.php");

?>

