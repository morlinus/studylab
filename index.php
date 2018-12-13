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

        <div class="col-lg-3 col-md-1 col-sm-1">

        </div>


                <div class="col-lg-6 col-md-8 col-sm-8 col-">
                <br>
                <br>


                <div class="shadow-sm p-3 mb-5 bg-white rounded">
                <!-- Dies ist die Form, damit der User einen Post schreiben - und ein Bild auswählen kann -->
                <form action="formular_abfrage_index.php" enctype="multipart/form-data" method="POST">
                    <textarea name="content" class="form-control" rows="3" placeholder="Schreibe einen Beitrag oder poste ein Foto"></textarea><br>
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div role="group" aria-label="First group">
                            <input class="btn btn-secondary" type="submit" value="Posten">
                            <input type="file" name="myfile"/>
                        </div>
                    </div>
                </div>
                </form>


                <br>
                <br>


                    <?php
                    /* Hier wird ausgelsen wem der angemeldete Nutzer folgt
                    $folgt= $pdo -> prepare ("SELECT * FROM folgen WHERE follower_id = $id");
                    $folgt -> execute ();
                    while ($gefolgtenutzer = $folgt -> fetch ()) {
                        $nutzerids = $gefolgtenutzer ["user_id"];


                        // zeigt die eignen Posts aus der Datenbank an und die von den gefolgten nutzern
                        $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE content.userid= $nutzerids ORDER BY content.id DESC");
                        $statement->execute(array('beitragsid' => 1)); */

                        $statement = $pdo->prepare("SELECT DISTINCT content.*, studylab.benutzername, folgen.follower_id FROM content LEFT JOIN studylab ON content.userid = studylab.id LEFT JOIN folgen ON studylab.id = folgen.user_id WHERE folgen.follower_id = $id ORDER BY content.id DESC");
                        $statement->execute(array('beitragsid' => 1));

                        $dbtest = $statement->rowcount();
                        //echo $nutzerids;

                       // if ($dbtest > 0) {
                            while ($content = $statement->fetch()) {
                                $postid = $content ["id"];



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
                                        echo("<img src='data:" . $row_index['format'] . ";base64," . base64_encode($row_index['datei']) . "'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
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
                                        ?>
                                        <div class="img-fluid"><?php
                                        echo("<img src='data:" . $bilder['format'] . ";base64," . base64_encode($bilder['datei']) . "'width=' alt='Responsive image' class='img-fluid'>"); ?></div><?php
                                        echo "</div>";
                                    }
                                    echo "<br>";


                                    //Der Post Inhalt wird ausgegeben
                                    echo htmlspecialchars($content['text'], ENT_HTML401);
                                    ?>
                                    </div>

                                    <form method="post" action="" onsubmit="return post();" id="kommentarform">
                                <textarea id="<?php echo $content['id']; ?>" name="comment" placeholder="Kommentieren"
                                          rows="1"
                                          class="form-control"></textarea><br>
                                        <input type="hidden" value="<?php echo $content['id']; ?>" name="post_id"
                                               class="form-control">
                                        <input type="submit" class="btn btn-primary" value="Kommentieren"
                                               name="kommentar"
                                               id="kommentarbtn"/>
                                    </form>
                                    <br>


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

                                            ?> <h6> <?php echo $komm['benutzername'] . ":<br />"; ?> </h6><?php
                                            echo htmlspecialchars($komm['kommentar'], ENT_HTML401);
                                            ?>
                                        </div>

                                        <?php
                                    }
                                    ?>


                                    </div>

                                    <?php
                               // }


                        }

                        if (!$dbtest > 0) {
                            ?>
                            <div class="beitrag">
                                <?php
                                echo "Herzlich Willkommen $angmeldet_index, du kannst Nutzer über die Suchenfunktion finden, um deren Beiträge zu sehen oder selber Beiträge verfassen.";
                                ?>
                            </div>
                            <?php
                        }
                    ?>

            </div>

            <div class="col-lg-3 col-md-3 col-sm-3">
                <?php

                //Schaut nach ob ein Nutzer, dem man folgt, etwas neues gepostet hat
                $benachrichtigung=$pdo->prepare("SELECT benachrichtigung.$angmeldet_index, studylab.* FROM benachrichtigung LEFT JOIN studylab ON benachrichtigung.userid = studylab.id WHERE benachrichtigung.$angmeldet_index = ' ' AND benachrichtigung.userid<>$id");
                $benachrichtigung->execute();

                //Führt die Benachrichtigung aus
                while($nachricht=$benachrichtigung->fetch()) {

                    $nachrichtid=$nachricht['id'];
                    ?>


                    <div class="alert alert-success alert-dismissible" >
                        <button class="close" data-dismiss="alert" id="update" aria-label="close">&times;</button>
                        <strong><a href="profil_folgen2.php?studylab=<?php echo $nachrichtid; ?>"><?php echo $nachricht['benutzername'];?></a></strong> Hat einen neuen Beitrag gepostet.
                    </div>

                    <?php
                    //Wenn die benachrichtigung gesehen wurde, wird sie in der Datenbank auf read gesetzt
                    $update=$pdo->prepare("UPDATE benachrichtigung SET $angmeldet_index = ?");
                    $update->execute(array('read'));
                    ?>

                    <?php
                }
                ?>
            </div>

    </div>
    </div>




</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">


    function post(){
        var comment = document.getElementById("comment").value;

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
                    document.getElementById("comment").value="";
                }
            });
        }
        return false;

    }
</script>

<?php
session_start();
include_once 'footer.php';
?>

</html>
