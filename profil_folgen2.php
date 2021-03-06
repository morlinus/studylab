<?php
// Schaut durch die Session, ob der Nutzer angemeldet ist
session_start();
if (isset($_SESSION["angemeldet"]))
{

}
else {
    // Falls der Nutzer nicht angemeldet ist, wird er mit header auf die Login-Seite geleitet
    header("Location:login.php");
}

ob_start();
// Bindet die header.php ein und damit den Header der Seite
include_once "header.php";
$id=$_SESSION['id'];
$profil_id=$_GET['studylab'];
$follower=$_SESSION["angemeldet"];
$followerid = $_SESSION["id"];
$bild_folgen = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id='$profil_id'");
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
            $arr[$i]= "<a class='e-mail' href='themen.php?themen=".$tag3."'>".$arr[$i]."</a>";
        }
        $i++;
    }
    $htags = implode(" ", $arr);
    //$htags = substr($htags2,1)
    return $htags;
}

if(isset($_POST['kommentar'])) {

    $comment=$_POST['comment'];
    $post_id=$_POST['post_id'];

    $statement = $pdo->prepare("INSERT INTO kommentare (id, sender_id, post_id, kommentar) VALUES (' ',:sender_id, :post_id,:kommentar)");
    if (!$statement->execute(array('sender_id'=>$id, 'post_id'=>$post_id, 'kommentar'=>$comment)))
    {
        echo "Fehler";
    }

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
        <div class="col-lg-1">

        </div>

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-3 col-md-4 col-sm-4 col- mt-5">

            <br>
            <br>

            <div class="profilbildplusfolgen">

                <?php
                // Benutzerbild wird im Profil angezeigt

                echo("<img src='data:" . $row_folgen['format'] . ";base64," . base64_encode($row_folgen['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-profil'>");
                ?>
            </div>

            <br>

            <!-- Umrandung und Schatten der Profilinfo -->
            <div class="shadow-sm p-3 mb-5 bg-white rounded">


            <div class="rand">
            <?php
                // Fremdes Profil?
                if ($profil_id!=$_SESSION["angemeldet"]) {

                // Folgen wir dem Nutzer schon?
                $checkabo=$pdo->prepare("SELECT follower_id FROM folgen WHERE user_id=$profil_id AND follower_id = $followerid");
                $checkabo->execute();
                $check=$checkabo->rowCount();
                if(!$check > 0){
                ?>

                <div class="folgenbutton">
                <form class="btn btn-outline-secondary" action="profil_folgen2.php?studylab=<?php echo htmlspecialchars($profil_id, ENT_HTML401); ?>" method="post">
                    <input class="btn-follow btn-primary-follow" type="submit" name="follow" value="Folgen">
                </form>
                </div>


                <?php
                if (isset($_POST['follow'])) {
                    $follow = $pdo->prepare("INSERT INTO folgen (`user_id`, `follower_id`) VALUES ('$profil_id', '$followerid') ");
                    if ($follow->execute()) {
                        echo "followed";
                        $insert_ben = $pdo -> prepare ("ALTER TABLE benachrichtigung ADD $follower VARCHAR(11) NOT NULL");
                        $insert_ben -> execute ();
                        // Alle Beiträge werden auf read gesetzt, damit man nur die Benachrichtigungen bekommt, ab dem Moment, ab dem man dem Nutzer folgt
                        $update=$pdo->prepare("UPDATE benachrichtigung SET $follower = ?");
                        $update->execute(array('read'));
                        header("location:profil_folgen2.php?studylab=$profil_id");

                    }
                }
                }
                else {
                ?><!-- Wenn schon Abonniert, möglichkeit zu deabonnieren -->
                <div class="entfolgenbutton">
                <form class="btn btn-outline-secondary" action="profil_folgen2.php?studylab=<?php echo $profil_id; ?>" method="post">
                    <input class="btn-follow btn-primary-follow" type="submit" name="unfollow" value="Entfolgen">
                </form>
                </div>
                    <?php
                // Entfolgen Befehl
                if (isset($_POST['unfollow'])) {
                    $unfollow = $pdo->prepare("DELETE FROM folgen WHERE user_id='$profil_id' AND follower_id='$followerid'");
                    if ($unfollow->execute()) {
                        echo "unfollowed";
                        header("location:profil_folgen2.php?studylab=$profil_id");

                    }
                }


                }

                }
                ?>

            <?php
            // Profildaten des fremden Nutzers aufrufen
            $nutzersuche = $pdo->prepare("SELECT * FROM studylab WHERE id = $profil_id");
            if ($nutzersuche->execute()) {
                while ($row = $nutzersuche->fetch()) {

                    $benutzername = $row ['benutzername'];
                    $name = $row ['name'];
                    $nachname = $row ['nachname'];
                    $geburtstag = $row ['geburtsdatum'];
                    $studiengang = $row ['studiengang'];
                    $email = $row ["email"];

                    // Es wird geschaut, ob der Nutzer schon jemandem folgt
                    $abonennten = $pdo ->prepare ("SELECT * FROM folgen WHERE user_id = $profil_id");
                    $abonennten ->execute();
                    $abos = $abonennten ->rowCount();

                    if (!$abos > 0 ) {
                        $abos = "'$benutzername' hat noch keine Abonennten";
                    }

                    ?>

                    <h6>Benutzername</h6> <?php echo  htmlspecialchars($benutzername, ENT_HTML401) . "<br /><br />"; ?>
                    <h6>Name</h6> <?php echo htmlspecialchars($name, ENT_HTML401) . "<br /><br />"; ?>
                    <h6>Nachname</h6><?php echo htmlspecialchars($nachname, ENT_HTML401) . "<br /><br />"; ?>
                    <h6>Geburtstag</h6> <?php echo htmlspecialchars($geburtstag, ENT_HTML401) . "<br /><br />"; ?>
                    <h6>Studiengang</h6> <?php echo  htmlspecialchars($studiengang, ENT_HTML401) . "<br /><br />"; ?>
                    <h6>Abonennten</h6> <?php echo  htmlspecialchars($abos, ENT_HTML401) . "<br /><br />"; ?>

                    <a class="e-mail" href="mailto:<?php echo htmlspecialchars( $email, ENT_HTML401); ?>">Sende <?php echo htmlspecialchars($benutzername, ENT_HTML401); ?> eine E-Mail</a>


                    <?php
                }
            }

            ?>
            </div>
            </div>
        </div>

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-7 col-md-8 col-sm-8 col- mt-5">

            <br>
            <br>

            <?php
            // Zeigt die Postings des User an
            // Wählt aus der Datenbank die entsprechenden Beiträge aus
            if($check > 0) {
            //Wenn dem Benutzer gefolgt wird, werden aus der Datenbank die entsprechenden Beiträge ausgewählt
            $beiträge = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE userid= $profil_id ORDER BY content.id DESC ");
            $beiträge->execute(array('beitragsid' => 1));
            while ($content = $beiträge->fetch()) {

            $postid = $content ["id"];
            $beitrags_bild = $pdo->prepare("SELECT * FROM bildupload_content WHERE post_id=$postid");
            $beitrags_bild->execute();
            $bilder = $beitrags_bild->fetch();
            $dbabgleich = $bilder ["post_id"];


            $bild_folgen2 = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id=$profil_id");
            $bild_folgen2->execute();
            while ($row_folgen2 = $bild_folgen2->fetch()){
            ?>

            <!-- Umrandung und Schatten der Profilinfo und der Beiträge -->
            <div class="shadow-sm p-3 mb-5 bg-white rounded">
                <div class="beitrag">

                    <?php

                    // Benutzerbild wird im Beitrag angezeigt

                    $beitragsersteller = $content['userid'];

                    echo("<img src='data:" . $row_folgen2['format'] . ";base64," . base64_encode($row_folgen2['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                    }
                    ?>
                    <?php
                    // Der Benutzername des Beitrags lässt sich anklicken und leitet auf die Profilseite um
                    echo '<a class="benutzername-post" href="profil_folgen2.php?studylab=' . htmlspecialchars($beitragsersteller, ENT_HTML401) . '">' . $content['benutzername'] . '</a>';
                    echo "<br>";

                    // Es wird überprüft ob es ein Bild zu dem Beitrag gibt und im Falle ausgegeben
                    if ($postid == $dbabgleich) {
                        echo "<br>";
                        echo "<div class='bild-class'>";
                        echo("<img src='data:" . $bilder['format'] . ";base64," . base64_encode($bilder['datei']) . "'width=' alt='Responsive image' class='img-fluid'>");
                        echo "</div>";
                    }
                    echo "<br>";

                    $inhaltp = htmlspecialchars($content['text'], ENT_HTML401);
                    echo hashtag($inhaltp);


                    ?>
                </div>
                <br>
                <!-- Hier steht das Kommentar-Form, in dem der User einen Kommentar eintragen kann -->
                <form method="post" action="" onsubmit="return post();" id="kommentarform">
                                     <textarea required id="<?php echo $content['id'] ?>" name="comment" placeholder="Kommentieren"
                                               rows="1"
                                               class="form-control"></textarea><br>
                    <input type="hidden" value="<?php echo $content['id']?>" name="post_id"
                           class="form-control">
                    <input type="submit" class="btn btn-primary" value="Kommentieren"
                           name="kommentar"
                           id="kommentarbtn"/>
                </form>
                <br>

                <?php
                $post_id = $content['id'];
                $kommentare = $pdo->prepare("SELECT kommentare.*, studylab.benutzername FROM kommentare LEFT JOIN studylab ON kommentare.sender_id = studylab.id WHERE post_id=$post_id");
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
                    $kommersteller=$komm['sender_id'];
                    ?> <h6> <?php echo '<a style="font-size:98%;" class="benutzername-post" href="profil_folgen2.php?studylab=' . $kommersteller . '">' .  $komm['benutzername'] . '</a>'.":<br />"; ?></h6>
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

<!-- Hier wird das Script für die Kommentare und den Post implementiert -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

    function post(){
        var comment = document.getElementByName("comment").value;

        if(comment)
        {
            var postid = sessionStorage.getItem('post_id');

            $.ajax
            ({
                type: 'post',
                url: 'profil_folgen2.php',
                data:
                    {
                        comment:comment,
                    },
                success: function (response)
                {
                    document.getElementsByName("comment").value="";
                }
            });
        }
        return false;

    }
</script>

<!-- Einbindung des Sticky-Footers -->
<?php
ob_end_flush();

session_start();
include_once 'footer.php';
?>

</html>