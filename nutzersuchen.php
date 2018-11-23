<?php
/**
 * Created by PhpStorm.
 * User: linusmorlinghaus
 * Date: 21.11.18
 * Time: 12:16
 */
include 'header.php';
    session_start();
    if (isset($_SESSION["angemeldet"]))
    {
        echo "Hallo"." " .$_SESSION["angemeldet"].", nach welchem Nutzer möchtest du suchen?";
    }
    else {

        header("Location:login.php");
    }
?>

<form action="nutzersuchen.php" method="post">
    <input type="text" name="nutzersuchen" value="">
    <input type="submit" name="suchen" value="Suchen">
</form>

<?php

if (isset($_POST['suchen'])) {

    echo "Suchergebnisse: <br>";


    $benutzername = $_POST['nutzersuchen'];

// $headline = $_POST['beitragsuchen'];

    $benutzersuche = $pdo->prepare("SELECT * FROM studylab WHERE benutzername LIKE '%$benutzername%'");

    if ($benutzersuche->execute()) {

        while ($row = $benutzersuche->fetch()) {

            // echo $row ['benutzername'];

            $nutzerid = $row['nutzerid'];



            echo '<table>';
            echo '<a href="nutzerprofil.php?nutzerid='.$nutzerid.'">' . $row['benutzername'];
            echo '<table>';

        }
    }


else {
        echo "Nutzer nicht gefunden";
    }

}

?>

