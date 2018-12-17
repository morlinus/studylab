<?php
// Diese Seite hängt mit der Profil_bearbeitung.php zusammen
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
    $statement = $pdo->prepare("UPDATE studylab SET name = :name  WHERE id=$id");
    $statement -> bindParam ("name",$name);
    $statement->execute();
}
// Der Nachname wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$nachname= $_POST["nachname"];

$nachname2= count($nachname);
if ($nachname2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET nachname = :nachname  WHERE id=$id");
    $statement -> bindParam ("nachname",$nachname);
    $statement->execute();
}
// Der Benutzername wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$benutzername= $_POST["benutzername"];

$benutzername2= count($benutzername);
if ($benutzername2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET benutzername = :benutzername  WHERE id=$id");
    $statement -> bindParam ("benutzername",$benutzername);
    $statement->execute();
    //Benachrichtigungsfunktion wird auf den neuen Benutzernamen aktiviert
    $insert_ben = $pdo -> prepare ("ALTER TABLE benachrichtigung ADD $benutzername VARCHAR(11) NOT NULL");
    $insert_ben -> execute ();
    // Alle Beiträge werden auf read gesetzt, damit man nur die Benachrichtigungen bekommt, ab dem Moment, ab dem man dem Nutzer folgt
    $update=$pdo->prepare("UPDATE benachrichtigung SET $benutzername = ?");
    $update->execute(array('read'));
}
// Das Geburtsdatum wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$geburtsdatum= $_POST["geburtsdatum"];

$geburtsdatum2= count($geburtsdatum);
if ($geburtsdatum2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET geburtsdatum = :geburtsdatum  WHERE id=$id");
    $statement -> bindParam ("geburtsdatum",$geburtsdatum);
    $statement->execute();
}
// Der Studiengang wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$studiengang= $_POST["studiengang"];

$studiengang2= count($studiengang);
if ($studiengang2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET studiengang = studiengang  WHERE id=$id");
    $statement -> bindParam ("studiengang",$studiengang);
    $statement->execute();
}
// Die E-Mail wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$email= $_POST["email"];

$email2= count($email);
if ($email2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET email = :email  WHERE id=$id");
    $statement -> bindParam ("email",$email);
    $statement->execute();
}
// Das Semester wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$semester= $_POST["semester"];

$semester2= count($semester);
if ($semester2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET semester = :semester  WHERE id=$id");
    $statement -> bindParam ("semester",$semester);
    $statement->execute();
}
// Der Status wird durch Post übergeben und wird dann in der Datenbank bei Veränderung überschrieben
$status= $_POST["status"];

$status2= count($status);
if ($status2 > 0) {
    $statement = $pdo->prepare("UPDATE studylab SET semester = ?  WHERE id=$id");
    $statement -> bindParam ("status",$status);
    $statement->execute();
}
// Das alte und das neue Passwort wird durch Post übergeben
$passwort_alt=$_POST["passwort_alt"];
$passwort_neu=$_POST["passwort_neu"];
$passwortneu2= strlen($passwort_neu);
if ($passwortneu2 > 0) {
    $passwort_hash = password_hash($passwort_neu, PASSWORD_DEFAULT); //passwort hashen
// Wählt aus der Datenbank den Benutzernamen aus und gleich den Benutzernamen mit eingegebenen Passwort und dem Passwort in der Datenabank ab
    $statement = $pdo->prepare("SELECT * FROM studylab WHERE id = $id");
    $statement->execute();
    $nutzerdaten = $statement->fetch();

// Wenn das Passwort in der Eingabe mit dem Passwort in der Datenbank übereinstimmt, dann kann das Passwort auf das neue Passwort verändert werden
    if (password_verify($passwort_alt, $nutzerdaten['passwort'])) {
        $statement = $pdo->prepare("UPDATE studylab SET passwort = :passwortneu WHERE id=$id");
        $statement->bindParam("passwortneu", $passwort_hash);
// $statement->execute(array($_POST["passwort_neu"]));
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

