<?php
// schaut durch die Session, ob der Nutzer angemeldet ist
session_start();
if (isset($_SESSION["angemeldet"]))
{

}
else {
    // Falls der Nutzer nicht angemeldet ist, wird er mit header auf die Login-Seite geleitet
    header("Location:login.php");
}

ob_start();
// bindet die header.php ein und damit den Header der Seite
include_once "header.php";

$profile_id=$_GET['studylab'];
$follower=$_SESSION["angemeldet"];
$followerid = $_SESSION["id"];
$bild_folgen = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id='$profile_id'");
$bild_folgen->execute();
$row_folgen = $bild_folgen->fetch();
$lesen = "read";


//Inhalt wird in wörter unterteilt, noch hashtags untersucht und alle wörter mit hahstag werden als link wieder ausgegeben
function hashtag($htags) {
    $tagzeichen = "#";
    $arr = explode(" ", $htags);
    $arrcnt = count($arr);
    $i =0;

    while($i < $arrcnt) {
        if (substr($arr[$i],0,1) === $tagzeichen) {
            $tag2 =$arr[$i];
            $tag3=substr($tag2,1);
            $arr[$i]= "<a href='themen.php?themen=".$tag3."'>".$arr[$i]."</a>";
        }
        $i++;
    }
    $htags = implode(" ", $arr);
    //$htags = substr($htags2,1)
    return $htags;
}

?>

<!doctype html>
<html lang="de">
<head>
    <title>
        Nutzerprofil
    </title>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-4 col-md-4 col-sm-4 col-">

            <br>
            <br>

            <div class="profilbildplusfolgen">

                <?php
                //Benutzerbild wird im Profil angezeigt

                echo("<img src='data:" . $row_folgen['format'] . ";base64," . base64_encode($row_folgen['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-profil'>");
                ?>
            </div>

            <br>

            <!-- Umrandung und Schatten der Profilinfo -->
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
                <form class="btn btn-outline-secondary" action="profil_folgen2.php?studylab=<?php echo htmlspecialchars($profile_id, ENT_HTML401); ?>" method="post">
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
                        //$statementupdate = $pdo->prepare("UPDATE benachrichtigung SET '$follower'= :gelesen WHERE id > 0");
                        //$statementupdate -> bindParam("gelesen",$lesen);
                        //$statementupdate -> execute ();
                        $update=$pdo->prepare("UPDATE benachrichtigung SET $follower = ?");
                        $update->execute(array('read'));
                        header("location:profil_folgen2.php?studylab=$profile_id");

                    }
                }
                }
                else {
                ?><!-- Wenn schon Abonniert, möglichkeit zu deabonnieren -->
                <div class="entfolgenbutton">
                <form class="btn btn-outline-secondary" action="profil_folgen2.php?studylab=<?php echo $profile_id; ?>" method="post">
                    <input class="btn-follow btn-primary-follow" type="submit" name="unfollow" value="Unfollow">
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

                    <h6>Benutzername</h6> <?php echo  htmlspecialchars($benutzername, ENT_HTML401) . "<br /><br />"; ?>
                    <h6>Name</h6> <?php echo htmlspecialchars($name, ENT_HTML401) . "<br /><br />"; ?>
                    <h6>Nachname</h6><?php echo htmlspecialchars($nachname, ENT_HTML401) . "<br /><br />"; ?>
                    <h6>Geburtstag</h6> <?php echo htmlspecialchars($geburtstag, ENT_HTML401) . "<br /><br />"; ?>
                    <h6>Studiengang</h6> <?php echo  htmlspecialchars($studiengang, ENT_HTML401) . "<br /><br />"; ?>

                    <a class="e-mail" href="mailto:<?php echo htmlspecialchars( $email, ENT_HTML401); ?>">Sende <?php echo htmlspecialchars($benutzername, ENT_HTML401); ?> eine E-Mail</a>


                    <?php
                }
            }

            ?>
            </div>
        </div>

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-8 col-md-8 col-sm-8 col-">

            <br>
            <br>


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


            $bild_folgen2 = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id=$profile_id");
            $bild_folgen2->execute();
            while ($row_folgen2 = $bild_folgen2->fetch()){
            ?>

            <!-- Umrandung und Schatten der Profilinfo und der Beiträge -->
            <div class="shadow-sm p-3 mb-5 bg-white rounded">
                <div class="beitrag">

                    <?php

                    //Benutzerbild wird im Beitrag angezeigt

                    $beitragsersteller = $content['userid'];

                    echo("<img src='data:" . $row_folgen2['format'] . ";base64," . base64_encode($row_folgen2['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                    }
                    ?>
                    <?php
                    //Der Benutzername des Beitrags lässt sich anklicken und leitet auf die Profilseite um
                    echo '<a class="benutzername-post" href="profil_folgen2.php?studylab=' . htmlspecialchars($beitragsersteller, ENT_HTML401) . '">' . $content['benutzername'] . '</a>';
                    echo "<br>";

                    //Es wird überprüft ob es ein Bild zu dem Beitrag gibt und im Falle ausgegeben
                    if ($postid == $dbabgleich) {
                        echo "<br>";
                        echo "<div class='bild-class'>";
                        echo("<img src='data:" . $bilder['format'] . ";base64," . base64_encode($bilder['datei']) . "'width=' alt='Responsive image' class='img-fluid'>");
                        echo "</div>";
                    }

                    $inhaltp = htmlspecialchars($content['text'], ENT_HTML401);
                    echo hashtag($inhaltp);


                    ?>
                </div>
                <?php
                $post_id = $content['id'];
                $kommentare = $pdo->prepare("SELECT kommentare.*, studylab.benutzername FROM kommentare LEFT JOIN studylab ON kommentare.sender_id = studylab.id WHERE post_id=$post_id ORDER BY kommentare.id DESC");
                $kommentare->execute();
                while ($komm = $kommentare->fetch()) {
                ?>

                <!-- Style der Kommentare -->
                <div class="kommentar">

                    <?php
                    $kommid = $komm['id'];

                    $kommbild = $pdo->prepare("SELECT bilduplad.*, kommentare.* FROM bilduplad LEFT JOIN kommentare ON bilduplad.user_id=kommentare.sender_id WHERE post_id=$post_id AND kommentare.id=$kommid");
                    $kommbild->execute();
                    while ($row_kommbild = $kommbild->fetch()) {
                        ?>

                        <!-- Style des Profilbilds im Beitrag -->
                        <div class="miniprofbild">
                            <?php
                            echo("<img src='data:" . $row_kommbild['format'] . ";base64," . base64_encode($row_kommbild['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                            ?>
                        </div>
                        <?php
                    }

                    ?> <h6> <?php echo " " . htmlspecialchars($komm['benutzername'], ENT_HTML401) . ":<br />"; ?></h6>
                    <?php
                    echo " " . htmlspecialchars($komm['kommentar'], ENT_HTML401);
                    ?>
                </div>
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

</body>

<!-- Einbindung des Sticky-Footers -->
<?php
ob_end_flush();

session_start();
include_once 'footer.php';
?>

</html>