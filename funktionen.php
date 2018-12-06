<?php
include 'userdata.php';

function fetchAll($benachrichtigung){
    include 'userdata.php';
    $stmt=$pdo->query($benachrichtigung);
    return $stmt->fetchAll();
}
function performQuery($nachricht){
    include 'userdata.php';
    $stmt=$pdo->prepare($nachricht);
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}