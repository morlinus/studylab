<?php
/**
 * Created by PhpStorm.
 * User: linusmorlinghaus
 * Date: 13.12.18
 * Time: 22:51
 */
include "header.php";
include "userdata.php";

$hashtag1=$_GET["themen"];
echo $hashtag1;
$thema = $pdo->prepare("SELECT * FROM content WHERE themen = '$hashtag1'");
$thema -> execute();
    while ($thema2 = $thema->fetch()) {

        echo $thema2 ["id"] . "<br>";
        echo $thema2 ["text"];
        echo "<br>";
    }