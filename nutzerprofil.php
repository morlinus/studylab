<?php
session_start();
echo "Eingeloggt ist der Benutzer ".$_SESSION['angemeldet'];
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>
        Profil von: <?php echo $_SESSION['angemeldet']; ?>
    </title>
</head>
<body>
<br>
Schreibe einen Post:
<form action="formular_abfrage.php" method="post">
        <textarea name="content" rows="10" cols="30">
        </textarea>
    <input type="submit">
</form>

</body>

</html>