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

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-3">

            </div>

            <div class="col-6">


                <br>
                <br>



                <!-- Dies ist die Form, damit der User einen Post schreiben kann -->
                <form action="formular_abfrage_index.php" method="post">
                    <textarea name="content" class="form-control" rows="3"></textarea><br>
                    <div class="btn-toolbar"  action="formular_abfrage_index.php" method="post" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            <input class="btn btn-secondary" type="submit" value="Posten">
                            <button type="button" class="btn btn-secondary"><img src="https://mars.iuk.hdm-stuttgart.de/~bw038/baseline-collections-24px.svg"></button>
                        </div>
                    </div>
                    <br>
                    <br>
                </form>



                    <?php
                    // Hier wird ausgelsen wem der angemeldete Nutzer folgt
                    $folgt= $pdo -> prepare ("SELECT * FROM folgen WHERE follower_id = $id");
                    $folgt -> execute (array ('follower_id' => 1 ));
                    while ($gefolgtenutzer = $folgt -> fetch ()) {
                        $nutzerids = $gefolgtenutzer ["user_id"];

                    // zeigt die eignen Posts aus der Datenbank an und die von den gefolgten nutzern
                    $statement = $pdo->prepare("SELECT content.*, studylab.* FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE userid= $nutzerids OR userid = $id ORDER BY content.id DESC");
                    $statement->execute(array('beitragsid' => 1));

                    $dbtest = $statement -> rowcount ();
                    echo $dbtest;

                    }

                    if ($dbtest > 0) {
                        while ($content = $statement->fetch()) {

                            //Holt das Bild von dem User, der den betrag gepostet hat, aus der Datenbank
                            $id_index = $content ["userid"];
                            $bild_index = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id=$id_index");
                            $bild_index->execute();
                            while ($row_index = $bild_index->fetch()) {

                                ?>
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
                            //Der Post Inhalt wird ausgegeben
                            echo $content['text'] . "<br /><br />";
                            ?>

                            <form method="post" action="" onsubmit="return post();" id="kommentarform">
                                <textarea id="comment" name="comment" placeholder="Kommentieren" rows="1"
                                          class="form-control"></textarea><br>
                                <input type="hidden" value="<?php echo $content['id']; ?>" name="post_id"
                                       class="form-control">
                                <input type="submit" class="btn btn-primary" value="Kommentieren" name="kommentar"
                                       id="kommentieren"/>
                            </form>
                            <br>

                            <input type="button" name="kommentarezeigen" class="btn btn-primary" onclick="kommentare()"
                                   value="Kommentare zeigen"/>
                            <div id="zeigeKommentare" style="display:none;" class="kommentare ">
                                <?php
                                $post_id = $content['id'];
                                $kommentare = $pdo->prepare("SELECT kommentare.*, studylab.benutzername FROM kommentare LEFT JOIN studylab ON kommentare.sender_id = studylab.id WHERE post_id=$post_id ORDER BY kommentare.id DESC");
                                $kommentare->execute();
                                while ($komm = $kommentare->fetch()) {
                                    ?>
                                    <div class="kommentar">
                                        <?php

                                        echo $komm['Zeit'] . "<br/>";
                                        echo $komm['benutzername'] . ":<br />";
                                        echo $komm['kommentar'];
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                            </div>

                            <?php
                        }
                    }
                    else {
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
        </div>
    </div>

</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

    function kommentare() {
        document.getElementById('zeigeKommentare').style.display = "block";
    }

    function post(){
        var comment = document.getElementById("comment").value;
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
