<?php
session_start();
include 'userdata.php';
?>
<html>
<head>
<title> Profil bearbeiten</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
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
</script>

<div id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">StudiLAB</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/index.php">Startseite</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/logout.php">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/nutzerprofil.php">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://mars.iuk.hdm-stuttgart.de/~as325/impressum.html">Impressum</a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<?php
    session_start();
    $_SESSION["angemeldet"];
    $id=$_SESSION["id"];
    include 'userdata.php';

$statement = $pdo->prepare("SELECT * FROM studylab WHERE id=$id");
if($statement->execute()) {
    while($row=$statement->fetch()) {

        ?><html><br><?php echo "Benutzername:".' '.$row['benutzername']; ?><form action="aendern.php" method="post">
        <?php echo "Name:".' '.$row['name']; ?><br><input type="name" size="40" maxlength="200" name="name"><br><br>
        <?php echo "Nachname:".' '.$row['nachname']; ?><br><input type="nachname" size="40" maxlength="200" name="name"><br><br>
        <?php echo "Geburtstdatum:".' '.$row['geburtsdatum']; ?><br><br>
        <?php echo "Studiengang:".' '.$row['studiengang']; ?><br><input id="tags" size="40" maxlength="200" name="studiengang" type="studiengang"><br><br>
        <?php echo "Geschlecht:".' '.$row['geschlecht']; ?><br><br>
        <?php echo "E-Mail:".' '.$row['email']; ?><br><input type="email" size="40" maxlength="200" name="name"><br><br>
        <?php echo "Semester:".' '.$row['semester']; ?><br><input type="semester" size="40" maxlength="200" name="name"><br><br>
        <?php echo "Status:".' '.$row['status']; ?><br><input type="status" size="40" maxlength="200" name="name"><br><br>
            <input type="submit" value="Änderungen speichern"></form></html>
<?php

    }
} else {
    echo 'Datenbank-Fehler:';
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die();
}
?>
</body>
</html>
