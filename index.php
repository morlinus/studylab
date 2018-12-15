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
include_once 'header.php';

$id=$_SESSION["id"];
$angmeldet_index = $_SESSION ["angemeldet"];

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

// trägt die Kommentare auf dem Kommentar-Form in die Datenbank ein
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
<title>Startseite</title>
    <meta charset="utf-8">
</head>

<body>

    <div class="container-fluid">

        <div class="row">


                <!-- Einteilung in das Grid-System -->
                <div class="col-lg-3 col-md-3 col-sm-3">

                        <br>
                        <br>

                        <?php

                        //Schaut nach ob ein Nutzer, dem man folgt, etwas neues gepostet hat
                        $benachrichtigung=$pdo->prepare("SELECT benachrichtigung.$angmeldet_index, studylab.*, folgen.* FROM benachrichtigung LEFT JOIN studylab ON benachrichtigung.userid = studylab.id LEFT JOIN folgen ON benachrichtigung.userid=folgen.user_id WHERE benachrichtigung.$angmeldet_index = ' ' AND benachrichtigung.userid<>$id AND folgen.follower_id=$id");
                        $benachrichtigung->execute();

                        //Führt die Benachrichtigung aus
                        while($nachricht=$benachrichtigung->fetch()) {

                        $nachrichtid=$nachricht['id'];
                        ?>

                        <!-- Pop-Up Benachrichtigung -->
                        <div class="alert alert-success alert-dismissible" >
                            <button class="close" data-dismiss="alert" id="update" aria-label="close">&times;</button>
                            <strong><a href="profil_folgen2.php?studylab=<?php echo $nachrichtid; ?>"><?php echo $nachricht['benutzername'];?></a></strong> Hat einen neuen Beitrag gepostet.
                        </div>

                        <?php
                        //Wenn die Benachrichtigung gesehen wurde, wird sie in der Datenbank auf read gesetzt
                        $update=$pdo->prepare("UPDATE benachrichtigung SET $angmeldet_index = ?");
                        $update->execute(array('read'));
                        ?>

                        <?php
                        }
                        ?>

                </div>

                <!-- Einteilung in das Grid-System -->
                <div class="col-lg-6 col-md-8 col-sm-8 col-">
                        <br>
                        <br>

                        <!-- Umrandung und Schatten der Postingbox und der Beiträge -->
                        <div class="shadow-sm p-3 mb-5 bg-white rounded">
                        <!-- Dies ist die Form, damit der User einen Post schreiben - und ein Bild auswählen kann -->
                        <form action="formular_abfrage_index.php" enctype="multipart/form-data" method="POST">
                            <textarea required name="content" class="form-control" rows="3" placeholder="Schreibe einen Beitrag oder poste ein Foto"></textarea><br>
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div role="group" aria-label="First group">
                                    <input class="btn btn-secondary" type="submit" value="Posten">
                                    <input type="file" name="myfile"/>
                                </div>
                            </div>
                        </form>
                        </div>



                        <br>
                        <br>


                    <?php
                        // wählt aus der Datenbank alle Beiträge aus, der Personen, die der angemeldete Benutzer folgt
                        $statement = $pdo->prepare("SELECT DISTINCT content.*, studylab.benutzername, folgen.follower_id FROM content LEFT JOIN studylab ON content.userid = studylab.id LEFT JOIN folgen ON studylab.id = folgen.user_id WHERE folgen.follower_id = $id ORDER BY content.id DESC");
                        $statement->execute(array('beitragsid' => 1));

                        $dbtest = $statement->rowcount();
                            while ($content = $statement->fetch()) {
                                $postid = $content ["id"];
                                    // wählt das Bild aus, welches zum jeweiligen Beitrag gehört
                                    $beitrags_bild = $pdo->prepare("SELECT * FROM bildupload_content WHERE post_id=$postid");
                                    $beitrags_bild->execute();
                                    $bilder = $beitrags_bild->fetch();
                                    $dbabgleich = $bilder ["post_id"];


                                    //Holt das Bild von dem User, der den betrag gepostet hat, aus der Datenbank
                                    $id_index = $content ["userid"];
                                    $bild_index = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id=$id_index");
                                    $bild_index->execute();
                                    while ($row_index = $bild_index->fetch()) {

                                        ?>
                                    <div class="shadow-sm p-3 mb-5 bg-white rounded">
                                        <div class="beitrag">

                                        <?php
                                        //Benutzerbild wird im Beitrag angezeigt
                                        $beitragsersteller = $content['userid'];
                                        echo("<img src='data:" . $row_index['format'] . ";base64," . base64_encode($row_index['datei']) . "'width=' alt='nutzerprofilbild' class='profilbild-navbar'>");
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
                                            ?>
                                            <div class="img-fluid"><?php
                                            echo("<img src='data:" . $bilder['format'] . ";base64," . base64_encode($bilder['datei']) . "'width=' alt='Responsive image' class='img-fluid'>"); ?></div><?php
                                            echo "</div>";
                                        }
                                        echo "<br>";


                                    //Der Post Inhalt wird ausgegeben
                                    $inhalt = htmlspecialchars($content['text'], ENT_HTML401);
                                    echo hashtag($inhalt);
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
                                    // Hier werden die Kommentare für den jeweiligen Post ausgegeben
                                    $kommentare = $pdo->prepare("SELECT kommentare.*, studylab.benutzername FROM kommentare LEFT JOIN studylab ON kommentare.sender_id = studylab.id WHERE post_id=$post_id ORDER BY kommentare.id DESC");
                                    $kommentare->execute();
                                    while ($komm = $kommentare->fetch()) {
                                        ?>


                                        <!-- Style des Kommentars -->
                                        <div class="kommentar">

                                            <?php

                                            $kommid = $komm['id'];
                                            // zu dem zugehörigen Kommentar, wird auch das dazugehörige Profilbild ausgegeben
                                            $kommbild = $pdo->prepare("SELECT bilduplad.*, kommentare.* FROM bilduplad LEFT JOIN kommentare ON bilduplad.user_id=kommentare.sender_id WHERE post_id=$post_id AND kommentare.id=$kommid");
                                            $kommbild->execute();
                                            while ($row_kommbild = $kommbild->fetch()) {
                                                ?>

                                                <!-- Style des Profilbilds im Beitrag -->
                                                <div class="miniprofbild">
                                                    <?php
                                                    echo("<img src='data:" . $row_kommbild['format'] . ";base64," . base64_encode($row_kommbild['datei']) . "'width=' alt='nutzerprofilbild' class='profilbild-navbar'>");
                                                    ?>
                                                </div>
                                                <?php
                                            }

                                            ?> <h6> <?php echo htmlspecialchars($komm['benutzername'], ENT_HTML401) . ":<br />"; ?> </h6><?php
                                            echo htmlspecialchars($komm['kommentar'], ENT_HTML401);
                                            ?>
                                        </div>

                                        <?php
                                        }
                                        ?>


                                    </div>

                                    <?php
                                    }
                                    // Wenn der Nutzer noch niemandem folgt, wird ihm empfohlen, in der Suchfunktion Nutzern zu folgen
                                    if (!$dbtest > 0) {
                                        ?>
                                        <div class="beitrag">
                                            Herzlich Willkommen <?php echo htmlspecialchars($angmeldet_index,ENT_HTML401); ?>! Schreibe einen Beitrag oder finde Nutzer über die <a class="e-mail" href="nutzersuchen.php">Suchfunktion</a>, um deren Beiträge zu sehen.
                                        </div>
                                        <?php
                                    }
                                ?>

                </div>

                <!-- Einteilung in das Grid-System -->
                <div class="col-lg-3 col-md-1 col-sm-1 c">

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
                url: 'index.php',
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
session_start();
include_once 'footer.php';
?>

</html>
