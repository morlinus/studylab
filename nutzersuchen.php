<?php
/**
 * Created by PhpStorm.
 * User: linusmorlinghaus
 * Date: 21.11.18
 * Time: 12:16
 */
include 'userdata.php';
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
    <input type="text" name="nutzersuchen" value="Benutzername">
    <input type="submit" name="suchen" value="Suchen">
</form>

<?php

if (isset($_POST['suchen'])) {

    echo "Suchrgebnisse: <br>";


    $benutzername = $_POST['nutzersuchen'];

// $headline = $_POST['beitragsuchen'];

    $benutzersuche = $pdo->prepare("SELECT * FROM studylab WHERE benutzername LIKE '%$benutzername%'");

    if ($benutzersuche->execute()) {

        while ($row = $benutzersuche->fetch()) {

            echo $row ['benutzername'];

            $userid = $row['userid'];

            echo '<table>';
            echo $userid;
            echo '</table>';


        }
    } else {
        echo "Nutzer nicht gefunden";
    }

}

/*
if (isset($_POST['suchen'])) {
    $suche = explode(" ", $_POST['suchen']);
    if (count($suche) == 1) {
        $suche = str_split($suche[0], 2);
    }
    $whereclause = "";
    $paramsarray = array(':benutzername'=>'%'.$_POST['suchen'].'%');
    for ($i = 0; $i < count($suche); $i++) {
        $whereclause .= " OR benutzername LIKE :u$i ";
        $paramsarray[":u$i"] = $suche[$i];
    }
   // $benutzer = DB::query('SELECT studylab.benutzername FROM studylab WHERE studylab.benutzername LIKE :benutzername '.$whereclause.'', $paramsarray);
    $benutzer = $pdo->prepare('SELECT benutzername FROM studylab WHERE benutzername LIKE :benutzername '.$whereclause.'', $paramsarray);

    print_r($benutzer);
    $whereclause = "";
    $paramsarray = array(':body'=>'%'.$_POST['suchen'].'%');
    for ($i = 0; $i < count($suche); $i++) {
        if ($i % 2) {
            $whereclause .= " OR body LIKE :p$i ";
            $paramsarray[":p$i"] = $suche[$i];
        }
    }
   /* $posts = DB::query('SELECT posts.body FROM posts WHERE posts.body LIKE :body '.$whereclause.'', $paramsarray);
    echo '<pre>';
    print_r($posts);
    echo '</pre>'; */

?>

