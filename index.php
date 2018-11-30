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
                    if ($row = $statement->fetch()){

                        $empfaenger_id=$row['userid'];
                        $post_id=$row['id'];
                        /*
                        $_SESSION['empfaenger_id']=$row['userid'];
                        $_SESSION['post_id']=$row['id'];
                        */

                    }
                    while ($content = $statement->fetch()) {
                        ?>
                        <div class="content">
                            <div class="post">
                                <?php

                        echo "<br />" . $content['benutzername'] . " schrieb:<br />";
                        echo $content['text'] . "<br /><br />";
                    ?>
                <form action="socialfuntktionen.php" method="post">
                    <input class="btn btn-primary" type="button" name="like" value="Gefällt mir!">
                </form>

                <br>

                <form method="post" id="kommentar_form">
                    <textarea name="comment" class="form-control" placeholder="Kommentieren" rows="1"></textarea><br>
                    <input type="hidden" name="kommentar_id" id="kommentar_id" value="0"/>
                    <input class="btn btn-primary" type="submit" name="kommentar" value="Kommentieren" id="submit"/>
                </form>

                                    <span id="kommentar_nachricht"></span>
                                </br>
                                    <div id="zeigen_kommentar"></div>





                                <?php

                                session_start();
                                $id=$_SESSION["id"];

                                $comment=$_POST["comment"];

                                if(isset($_POST['kommentar'])) {

                                    $statement = $pdo->prepare("INSERT INTO kommentare (id, sender_id, empfaenger_id, post_id, kommentar) VALUES (NULL,:sender_id, :empfaenger_id, :post_id,:kommentar)");
                                    $statement->execute(array('sender_id' => $id, 'empfaenger_id'=>$empfaenger_id, 'post_id'=>$post_id, ':kommentar' => $comment));


                                }

                                ?>



                <br>
            </div>
        </div>
<?php
                    }
                    ?>


            </div>

        </div>
    </div>

</body>

<script>
    $(document).ready(function(){

        $('#kommentar_form').on('kommentar',function(event){
            event.preventDefault();
            var form_data = $(this).serialize();
            $ajax({
                url: "index.php",
                method: "POST",
                data:form_data,
                dataType:JSON
                success:function(data)
                {
                    if(data.error != ' ')
                    {
                        $('#kommentar_form')[0].reset();
                        $('#kommentar_form').html(data.error);
                    }
                }
            })
        });
        lade_kommentar();

        function lade_kommentar()
        {
            $ajax({
                url:"lade_kommentare.php",
                method:"POST",
                success: function(data)
                {
                    $('zeigen_kommentar').hmtl(data);
                }
            })
        }
        $(document).on('click', '.reply', function(){
            var kommentar_id =$(this).attr("id");
            $('#kommentar_id').val(kommentar_id);
            $('kommentar_name').focus();
        })
    });

</script>
<?php
session_start();
include_once 'footer.php';
?>

</html>