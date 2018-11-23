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

$statement = $pdo->prepare("UPDATE studylab SET name = ?  WHERE id=$id");
$statement->execute(array($_POST["name"]));

// Der Nachname wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$nachname= $_POST["nachname"];

$statement = $pdo->prepare("UPDATE studylab SET nachname = ?  WHERE id=$id");
$statement->execute(array($_POST["nachname"]));

// Der Benutzerame wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$benutzername= $_POST["benutzername"];

$statement = $pdo->prepare("UPDATE studylab SET benutzername = ?  WHERE id=$id");
$statement->execute(array($_POST["benutzername"]));

// Das Geburtsdatum wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$geburtsdatum= $_POST["geburtsdatum"];

$statement = $pdo->prepare("UPDATE studylab SET geburtsdatum = ?  WHERE id=$id");
$statement->execute(array($_POST["geburtsdatum"]));

// Der Studiengang wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$studiengang= $_POST["studiengang"];

$statement = $pdo->prepare("UPDATE studylab SET studiengang = ?  WHERE id=$id");
$statement->execute(array($_POST["studiengang"]));

// Die E-Mail wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$email= $_POST["email"];

$statement = $pdo->prepare("UPDATE studylab SET email = ?  WHERE id=$id");
$statement->execute(array($_POST["email"]));

// Das Semester wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$semester= $_POST["semester"];

$statement = $pdo->prepare("UPDATE studylab SET semester = ?  WHERE id=$id");
$statement->execute(array($_POST["semester"]));

// Der Status wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$status= $_POST["status"];

$statement = $pdo->prepare("UPDATE studylab SET semester = ?  WHERE id=$id");
$statement->execute(array($_POST["status"]));

// Das alte und das neue Passwort wird durch Post übergeben
$passwort_alt=$_POST["passwort_alt"];
$passwort_neu=$_POST["passwort_neu"];
// Wenn das Passwort in der Eingabe mit dem Passwort in der Datenbank übereinstimmt, dann kann das Passwort auf das neue Passwort verändert werden
if ($passwort == $passwort_alt)
{$statement = $pdo->prepare ("UPDATE studylab SET passwort = ? WHERE id=$id");
$statement->execute(array($_POST["passwort_neu"]));
}
else
{echo "Das Passwort war falsch.
	<br /><a href=\"profil_bearbeitung.php\">Zur&uuml;ck</a>";}


?>

