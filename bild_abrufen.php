<?php

include "userdata.php";
$id = isset($_GET['id'])? $_GET['id'] : "";
$stat = $pdo->prepare("SELECT * FROM bilduplad WHERE id=?");
$stat-> bindParam(1, $id);
$stat->execute();
$row = $stat->fetch();
header('Content-Type: '.$row['mime']);
echo $row['data'];

/*
<?php

// bild_abrufen.php: Bild abrufen

require_once ("userdata.php");

$id = intval($_GET['id']); //Konvertierung von String in integer

$strQuery= "select profilbild from Test Bild Upload where id=$id";

$result = mysqli_query($strQuery);

$row = mysqli_fetch_assoc($result);

header("Content-type: {$row['imgtype']}");

echo $row['profilbild'];

?>
*/