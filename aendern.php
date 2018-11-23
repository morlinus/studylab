<?php
session_start();
$_SESSION["angemeldet"];
$id=$_SESSION["id"];
$passwort=$_SESSION["passwort"];

include 'userdata.php';

if(!isset($_POST['submit'])) exit;

$name= $_POST["name"];

$statement = $pdo->prepare("UPDATE studylab SET name = ?  WHERE id=$id");
$statement->execute(array($_POST["name"]));

$nachname= $_POST["nachname"];

$statement = $pdo->prepare("UPDATE studylab SET nachname = ?  WHERE id=$id");
$statement->execute(array($_POST["nachname"]));

$benutzername= $_POST["benutzername"];

$statement = $pdo->prepare("UPDATE studylab SET benutzername = ?  WHERE id=$id");
$statement->execute(array($_POST["benutzername"]));

$geburtsdatum= $_POST["geburtsdatum"];

$statement = $pdo->prepare("UPDATE studylab SET geburtsdatum = ?  WHERE id=$id");
$statement->execute(array($_POST["geburtsdatum"]));

$studiengang= $_POST["studiengang"];

$statement = $pdo->prepare("UPDATE studylab SET studiengang = ?  WHERE id=$id");
$statement->execute(array($_POST["studiengang"]));

$email= $_POST["email"];

$statement = $pdo->prepare("UPDATE studylab SET email = ?  WHERE id=$id");
$statement->execute(array($_POST["email"]));

$semester= $_POST["semester"];
$statement = $pdo->prepare("UPDATE studylab SET semester = ?  WHERE id=$id");
$statement->execute(array($_POST["semester"]));

$status= $_POST["status"];
$statement = $pdo->prepare("UPDATE studylab SET semester = ?  WHERE id=$id");
$statement->execute(array($_POST["status"]));

$passwort_alt=$_POST["passwort_alt"];
$passwort_neu=$_POST["passwort_neu"];

if ($passwort == $passwort_alt)
{$statement = $pdo->prepare ("UPDATE studylab SET passwort = ? WHERE id=$id");
$statement->execute(array($_POST["passwort_neu"]));
}
else
{echo "Das Passwort war falsch.
	<br /><a href=\"profil_bearbeitung.php\">Zur&uuml;ck</a>";}


?>

