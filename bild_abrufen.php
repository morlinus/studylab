<?php
session_start ();
$id = isset($_GET['id'])? $_GET['id'] : "";
$stat = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id=$id");
$stat-> bindParam(1, $id);
$stat->execute();
$row = $stat->fetch();
header('Content-Type: '.$row['mime']);
echo $row['data'];

