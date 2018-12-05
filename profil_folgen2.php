<?php
/**
 * Created by PhpStorm.
 * User: linusmorlinghaus
 * Date: 27.11.18
 * Time: 19:02
 */
ob_start();
include_once "header.php";

$profile_id=$_GET['studylab'];
$follower=$_SESSION["angemeldet"];
$followerid = $_SESSION["id"];

// Profildaten von dem fremden Nutzer aufrufen
$nutzersuche = $pdo->prepare("SELECT * FROM studylab WHERE id = $profile_id");
if ($nutzersuche->execute()) {
    while ($row = $nutzersuche->fetch()) {

        $benutzername = $row ['benutzername'];
        $name = $row ['name'];
        $nachname = $row ['nachname'];
        $studiengang = $row ['studiengang'];
        ?>

        <div class="">
         Hier könnte ihr Foto stehen <br>
        <div> Name: <?php echo $name; ?> </div>
            <div> Nachname: <?php echo $nachname; ?> </div>
            <div> Benutzername: <?php echo  $benutzername; ?> </div>
            <div> Studiengang: <?php echo  $studiengang; ?> </div>

        </div><?php
    }
}

// Fremdes Profil?
if ($profile_id!=$_SESSION["angemeldet"]) {

    // Folgen wir dem Nutzer schon?
    $checkfollow=$pdo->prepare("SELECT follower_id FROM folgen WHERE user_id=$profile_id");
    $checkfollow->execute();

    $no=$checkfollow->rowCount();
    if(!$no > 0){
        ?>
        <form action="profil_folgen2.php?studilab=<?php echo $profile_id; ?>" method="post">
            <input type="submit" name="follow" value="Follow">
        </form>
        <?php
        if (isset($_POST['follow'])) {
            $follow = $pdo->prepare("INSERT INTO folgen (`user_id`, `follower_id`) VALUES ('$profile_id', '$followerid') ");
            if ($follow->execute()) {
                echo "followed";
                header("location:profil_folgen2.php?studylab=$profile_id");

            }
        }
    }
    else {
        ?><!-- Wenn schon Abonniert, möglichkeit zu deabonnieren -->
        <form action="profil_folgen2.php?studilab=<?php echo $profile_id; ?>" method="post">
            <input type="submit" name="unfollow" value="Unfollow">
        </form><?php
         // entfolgen Befehl
        if (isset($_POST['unfollow'])) {
            $unfollow = $pdo->prepare("DELETE FROM folgen WHERE user_id='$profile_id' AND follower_id='$followerid'");
            if ($unfollow->execute()) {
                echo "unfollowed";
                header("location:profil_folgen2.php?studylab=$profile_id");

            }
        }


    }

}


if($no > 0) {
//wenn dem Benutzer gefolgt wird, werden aus der Datenbank die entsprechenden Beiträge ausgewählt
    $beiträge = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE userid= $profile_id");
    $beiträge->execute(array('beitragsid' => 1));
    while ($content = $beiträge->fetch()) {
        echo "<br />" . $content['benutzername'] . " schrieb:<br />";
        echo $content['text'] . "<br /><br />";
    }
}
ob_end_flush();