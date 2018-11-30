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
    <style type="text/css">
        .Inhalt{
            width: 80%;
            margin:100px auto;
            border: 1px solid #cbcbcb;
            border-radius: 20px;
        }
        .Beitrag{
            width: 95%;
            margin: 10px auto;
            border: 1px solid #cbcbcb;
            padding: 10px;
            border-radius: 20px;
        }


    </style>

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
                    <input class="btn btn-primary" type="submit" value="Posten">
                    <br>
                    <br>
                </form>


                    <?php
                    // stellt die Verbindung zur Datenbank her
                    include "userdata.php";
                    // zeigt die Post aus der Datenbank an - muss noch so erweitert werde, dass nur die Post von sich selbst und den Leuten, denen man folgt angezeigt wird
                    $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id ORDER BY content.id DESC");
                    $statement->execute(array('beitragsid' => 1));
                    while ($content = $statement->fetch()) {
                        ?>
                        <div class="Inhalt">
                            <div class="Beitrag">
                                <?php

                        echo "<br />" . $content['benutzername'] . " schrieb:<br />";
                        echo $content['text'] . "<br /><br />";
?>
                                <form method="post" action="" onsubmit="return post();">
                    <textarea id="comment" name="comment" placeholder="Kommentieren" rows="1" class="form-control"></textarea><br>
                    <input type="hidden" value="<?php echo $content['id'];?>" name="post_id" class="form-control">

                    <input type="submit" class="btn btn-primary" value="Kommentieren"/>


                </form>
                               <?php
                                /*
                               $statement=$pdo->prepare("SELECT kommentare.*, studylab.bentuzername FROM kommentare LEFT JOIN studylab ON kommentare.senderid=studylab.id ORDER BY kommentare.id DESC");
                               $statement->execute(array('beitragsid'=>1));
                               while($komm=$statement->fetch()) {
                                   echo $komm['benutzername'];
                                   echo $komm['kommentar'];

                               } */?>

                            </div>
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