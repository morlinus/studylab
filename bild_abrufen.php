<?php

include "userdata.php";
$id = isset($_GET['id'])? $_GET['id'] : "";
$stat = $pdo->prepare("SELECT * FROM bilduplad WHERE id=?");
$stat-> bindParam(1, $id);
$stat->execute();
$row = $stat->fetch();
header('Content-Type: '.$row['mime']);
echo $row['data'];

