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

// bindet den Header in die Seite ein
include "header.php";

// bindet den Datenbankzugriff ein
include "userdata.php";

$hashtag1=$_GET["themen"];
$id=$_SESSION['id'];

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


// trägt die Kommentare auf dem Kommentar-Form in die Datenbank ein
if(isset($_POST['kommentar'])) {

    $comment=$_POST['comment'];
    $postid=$_POST['post_id'];

    $statement = $pdo->prepare("INSERT INTO kommentare (id, sender_id, post_id, kommentar) VALUES (' ',:sender_id, :post_id,:kommentar)");
    if (!$statement->execute(array('sender_id'=>$id, 'post_id'=>$postid, 'kommentar'=>$comment)))
    {
        echo "Fehler";
    }

}
    ?>

<!doctype html>
<html lang="de">
<meta charset="utf-8">
<head>
    <title>
        Thema <?php echo $hashtag1; ?>
    </title>

</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-3 col-md-1 col-sm-1">

        </div>

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-6 col-md-10 col-sm-10 col-">


            <div class="row justify-content-lg-center justify-content-md-center justify-content-sm-center">
                <div class="" style="">
                    <img src="https://mars.iuk.hdm-stuttgart.de/~lm092/Studylab_Hashtags 2.png" alt="" style="width: 350px;">
                </div>
            </div>

            <div class="row justify-content-lg-center justify-content-md-center justify-content-sm-center">
                <div class="" style="">
                    <h1>#<?php echo $hashtag1;?></h1>
                </div>
            </div>

            <?php
            // Zeigt die Postings aus, die den hashtag beinhalten des User an
            // wählt aus der Datenbank die entsprechenden Beiträge aus
            $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE content.themen='$hashtag1' ORDER BY content.id DESC");
            if (!$statement->execute(array('beitragsid' => 1))) {
                echo "Fehler";
            }
            while ($content = $statement->fetch()) {

            $post_id = $content["id"];
            $beitrags_bild = $pdo -> prepare ("SELECT * FROM bildupload_content WHERE post_id=$post_id");
            $beitrags_bild -> execute();
            $bilder = $beitrags_bild -> fetch();
            $dbabgleich = $bilder ["post_id"];

            $id_header=$content ["userid"];
            $bild_header = $pdo -> prepare("SELECT * FROM bilduplad WHERE user_id=$id_header");
            $bild_header ->execute();
            while($row_header = $bild_header->fetch()){

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
                    if ($post_id = $dbabgleich) {
                    echo"<br>";
                    echo "<div class='bild-class'>";
                    echo("<img src='data:" . $bilder['format'] . ";base64," . base64_encode($bilder['datei']) . "'width=' alt='Responsive image' class='img-fluid'>");
                    echo "</div>";
                    }
                    echo("<br>");
                    $inhalte= $content['text'];
                    echo hashtag($inhalte);

                    ?>
                </div>

                <!-- Hier steht das Kommentar-Form, in dem der User einen Kommentar eintragen kann -->
                <form method="post" action="" onsubmit="return post();" id="kommentarform">
                                     <textarea required id="<?php echo htmlspecialchars($content['id'], ENT_HTML401); ?>" name="comment" placeholder="Kommentieren"
                                               rows="1"
                                               class="form-control"></textarea><br>
                    <input type="hidden" value="<?php echo htmlspecialchars($content['id'], ENT_HTML401); ?>" name="post_id"
                           class="form-control">
                    <input type="submit" class="btn btn-primary" value="Kommentieren"
                           name="kommentar"
                           id="kommentarbtn"/>
                </form>
                <br>

                <?php
                $post_id=$content['id'];
                $kommentare = $pdo->prepare("SELECT kommentare.*, studylab.benutzername FROM kommentare LEFT JOIN studylab ON kommentare.sender_id = studylab.id WHERE post_id=$post_id");
                if (! $kommentare->execute()) {
                    echo "Fehler";
                }
                while ($komm = $kommentare->fetch()) {
                ?>

                <div class="kommentar">

                    <?php
                    $kommid=$komm['id'];
                    $kommbild =$pdo->prepare("SELECT bilduplad.*, kommentare.* FROM bilduplad LEFT JOIN kommentare ON bilduplad.user_id=kommentare.sender_id WHERE post_id=$post_id AND kommentare.id=$kommid");
                    $kommbild->execute();
                    while ($row_kommbild = $kommbild->fetch()){
                    ?> <div class="miniprofbild">
                        <?php
                        echo ("<img src='data:".$row_kommbild['format'].";base64,".base64_encode($row_kommbild['datei'])."'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                        ?>
                    </div>
                    <?php
                    }

                    ?> <h6> <?php echo " ".  $komm['benutzername'] . ":<br />"; ?></h6>
                    <?php
                    echo " ".  $komm['kommentar'];
                    ?>

                </div>
                <?php
                }
                ?>
            </div>


            <?php
            }
            ?>

        </div>

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-3 col-md-1 col-sm-1">

        </div>

    </div>

</div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">


    function post(){
        var comment = document.getElementByName("comment").value;
        if(comment)
        {
            $.ajax
            ({
                type: 'post',
                url: 'index.php',
                data:
                    {
                        comment:comment,
                    },
                success: function (response)
                {
                    document.getElementByName("comment").value="";
                }
            });
        }
        return false;
    }


</script>

<!-- Einbindung des Sticky-Footers -->
<?php
include_once 'footer.php';
?>

</html>
