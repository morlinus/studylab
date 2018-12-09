<?php
ob_start();

include_once "header.php";

$profile_id=$_GET['studylab'];
$follower=$_SESSION["angemeldet"];
$followerid = $_SESSION["id"];
$bild_folgen = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id='$profile_id'");
$bild_folgen->execute();
$row_folgen = $bild_folgen->fetch();

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

        <div class="col-lg-3 col-md-3 col-sm-12 col-">

            <div class="profilbildplusfolgen">

                <?php
                //Benutzerbild wird im Profil angezeigt

                echo("<img src='data:" . $row_folgen['format'] . ";base64," . base64_encode($row_folgen['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-folgen'>");
                ?>
            </div>

            <div class="shadow-sm p-3 mb-5 bg-white rounded">

            <?php
                // Fremdes Profil?
                if ($profile_id!=$_SESSION["angemeldet"]) {

                // Folgen wir dem Nutzer schon?
                $checkfollow=$pdo->prepare("SELECT follower_id FROM folgen WHERE user_id=$profile_id AND follower_id = $followerid");
                $checkfollow->execute();
                $no=$checkfollow->rowCount();
                if(!$no > 0){
                ?>

                <div class="folgenbutton">
                <form class="btn btn-outline-secondary" action="profil_folgen2.php?studylab=<?php echo $profile_id; ?>" method="post">
                    <input class="btn-follow btn-primary-follow" type="submit" name="follow" value="Follow">
                </form>
                </div>


                <?php
                if (isset($_POST['follow'])) {
                    $follow = $pdo->prepare("INSERT INTO folgen (`user_id`, `follower_id`) VALUES ('$profile_id', '$followerid') ");
                    if ($follow->execute()) {
                        echo "followed";
                        $insert_ben = $pdo -> prepare ("ALTER TABLE benachrichtigung ADD $follower VARCHAR(11) NOT NULL");
                        $insert_ben -> execute ();
                        header("location:profil_folgen2.php?studylab=$profile_id");

                    }
                }
                }
                else {
                ?><!-- Wenn schon Abonniert, möglichkeit zu deabonnieren -->
                <div class="entfolgenbutton">
                <form class="btn btn-outline-secondary" action="profil_folgen2.php?studylab=<?php echo $profile_id; ?>" method="post">
                    <input class="btn btn-primary" type="submit" name="unfollow" value="Unfollow">
                </form>
                </div>
                    <?php
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
                    $email = $row ["email"];
                    ?>

                    <h6>Benutzername:</h6> <?php echo  $benutzername . "<br /><br />"; ?>
                    <h6>Name:</h6> <?php echo $name . "<br /><br />"; ?>
                    <h6>Nachname:</h6><?php echo $nachname . "<br /><br />"; ?>
                    <h6>Geburtstag:</h6> <?php echo $geburtstag . "<br /><br />"; ?>
                    <h6>Studiengang:</h6> <?php echo  $studiengang . "<br /><br />"; ?>

                    <a href="<?php echo $email; ?>">Sende <?php echo $benutzername; ?> eine E-Mail</a>


                    <?php
                }
            }

            ?>
            </div>
        </div>


        <div class="col-lg-6 col-md-9 col-sm-12 col-">


            <?php
            // Zeigt die Postings des User an
            // wählt aus der Datenbank die entsprechenden Beiträge aus
            if($no > 0) {
            //wenn dem Benutzer gefolgt wird, werden aus der Datenbank die entsprechenden Beiträge ausgewählt
            $beiträge = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE userid= $profile_id");
            $beiträge->execute(array('beitragsid' => 1));
            while ($content = $beiträge->fetch()) {

            $postid = $content ["id"];
            $beitrags_bild = $pdo->prepare("SELECT * FROM bildupload_content WHERE post_id=$postid");
            $beitrags_bild->execute();
            $bilder = $beitrags_bild->fetch();
            $dbabgleich = $bilder ["post_id"];

            $id_header = $_SESSION ["id"];
            $bild_header = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id=$id_header");
            $bild_header->execute();
            while ($row_header = $bild_header->fetch()){
            ?>

            <div class="shadow-sm p-3 mb-5 bg-white rounded">
                <div class="beitrag">

                    <?php

                    //Benutzerbild wird im Beitrag angezeigt

                    $beitragsersteller = $content['userid'];

                    echo("<img src='data:" . $row_header['format'] . ";base64," . base64_encode($row_header['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                    }
                    ?>
                    <?php
                    //Der Benutzername des Beitrags lässt sich anklicken und leitet auf die Profilseite um
                    echo '<a class="benutzername-post" href="profil_folgen2.php?studylab=' . $beitragsersteller . '">' . $content['benutzername'] . '</a>';
                    echo "<br>";

                    //Es wird überprüft ob es ein Bild zu dem Beitrag gibt und im Falle ausgegeben
                    if ($postid = $dbabgleich) {
                        echo "<br>";
                        echo "<div class='bild-class'>";
                        echo("<img src='data:" . $bilder['format'] . ";base64," . base64_encode($bilder['datei']) . "'width=' alt='Responsive image' class='img-fluid'>");
                        echo "</div>";
                    }
                    echo $content['text'];


                    ?>

                </div>
                <?php
                $post_id = $content['id'];
                $kommentare = $pdo->prepare("SELECT kommentare.*, studylab.benutzername FROM kommentare LEFT JOIN studylab ON kommentare.sender_id = studylab.id WHERE post_id=$post_id ORDER BY kommentare.id DESC");
                $kommentare->execute();
                while ($komm = $kommentare->fetch()) {
                ?>

                <div class="kommentar">

                    <?php
                    $kommid = $komm['id'];

                    $kommbild = $pdo->prepare("SELECT bilduplad.*, kommentare.* FROM bilduplad LEFT JOIN kommentare ON bilduplad.user_id=kommentare.sender_id WHERE post_id=$post_id AND kommentare.id=$kommid");
                    $kommbild->execute();
                    while ($row_kommbild = $kommbild->fetch()) {
                        ?>
                        <div class="miniprofbild">
                            <?php
                            echo("<img src='data:" . $row_kommbild['format'] . ";base64," . base64_encode($row_kommbild['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                            ?>
                        </div>
                        <?php
                    }

                    ?> <h6> <?php echo " " . $komm['benutzername'] . ":<br />"; ?></h6>
                    <?php
                    echo " " . $komm['kommentar'];
                    ?>
                    <?php
                    }
                    ?>

                </div>
                <?php
                }
                }
                    ?>

        </div>
            </div>


    </div>
</div>

</body>

<?php
session_start();
include_once 'footer.php';

ob_end_flush();
?>

</html>