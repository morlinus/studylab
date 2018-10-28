<?php

session_start();
include 'userdata.php';

if(!isset($_SESSION["angemeldet"]))
{
    echo"nicht angemeldet.";
    die();
}

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>
        Profil von: <?php echo "$benutzername"; ?>
    </title>
</head>
<body>
Schreibe einen Post:
<form action="formular_abfrage.php" method="post">
        <textarea name="content" rows="10" cols="30">
        </textarea>
    <input type="submit">
</form>

</body>

</html>
