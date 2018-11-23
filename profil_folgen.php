<?php
/**
 * Created by PhpStorm.
 * User: linusmorlinghaus
 * Date: 23.11.18
 * Time: 09:19
 */

include_once 'header.php';

$benutzername = "";

if (isset($_GET['username'])) {
    if ($pdo -> prepare('SELECT benutzername FROM studylab WHERE benutzername=:benutzername', array(':username'=>$_GET['username']))) {
        $username = $pdo -> prepare('SELECT benutzermname FROM studylab WHERE benutzername=:benutzername', array(':username'=>$_GET['username']))[0]['username'];
