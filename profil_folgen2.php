<?php
include_once "header.php";

ob_start();

$profile_id=$_GET['studylab'];
$follower=$_SESSION["angemeldet"];
$followerid = $_SESSION["id"];

?>

<!doctype html>
<html lang="de">
<meta charset="utf-8">
<head>
    <title>
        Profil von:<?php session_start();
        echo $_SESSION['angemeldet']; ?>
    </title>

<body>

<div class="container-fluid">
    <div class="row">

        <div class="col-3">

            <div class="profilbildplusfolgen">

                <h4>Profilbild</h4>

            </div>

            <div class="shadow-sm p-3 mb-5 bg-white rounded">

            <?php
                // Fremdes Profil?
                if ($profile_id!=$_SESSION["angemeldet"]) {

                // Folgen wir dem Nutzer schon?
                $checkfollow=$pdo->prepare("SELECT follower_id FROM folgen WHERE user_id=$profile_id");
                $checkfollow->execute();

                $no=$checkfollow->rowCount();
                if(!$no > 0){
                ?>

                <div class="folgenbutton">
                <form class="btn btn-outline-secondary" action="profil_folgen2.php?studilab=<?php echo $profile_id; ?>" method="post">
                    <input class="btn-follow btn-primary-follow" type="submit" name="follow" value="Follow">
                </form>
                </div>


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
                <form class="btn btn-outline-secondary" action="profil_folgen2.php?studilab=<?php echo $profile_id; ?>" method="post">
                    <input class="btn btn-primary" type="submit" name="unfollow" value="Unfollow">
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
                ?>

            <?php
            // Profildaten von dem fremden Nutzer aufrufen
            $nutzersuche = $pdo->prepare("SELECT * FROM studylab WHERE id = $profile_id");
            if ($nutzersuche->execute()) {
                while ($row = $nutzersuche->fetch()) {

                    $benutzername = $row ['benutzername'];
                    $name = $row ['name'];
                    $nachname = $row ['nachname'];
                    $geburtstag = $row ['geburtsdatum'];
                    $studiengang = $row ['studiengang'];
                    ?>

                    <h6>Benutzername:</h6> <?php echo  $benutzername . "<br /><br />"; ?>
                    <h6>Name:</h6> <?php echo $name . "<br /><br />"; ?>
                    <h6>Nachname:</h6><?php echo $nachname . "<br /><br />"; ?>
                    <h6>Geburtstag:</h6> <?php echo $geburtstag . "<br /><br />"; ?>
                    <h6>Studiengang:</h6> <?php echo  $studiengang . "<br /><br />"; ?>
            </div>

                    <?php
                }
            }

            ?>

        </div>


        <div class="col-6">

            <div class="shadow-sm p-3 mb-5 bg-white rounded">

            <?php

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
            ?>

            </div>

        </div>

        <div class="col-3">

        </div>
    </div>
</div>

</body>

<?php
session_start();
include_once 'footer.php';
?>

</html>