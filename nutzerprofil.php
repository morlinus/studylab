<?php
// bindet die header.php ein und damit den Header der Seite
include_once 'header.php';

$id_header=$_SESSION ["id"];
$bild_header = $pdo -> prepare("SELECT * FROM bilduplad WHERE user_id=$id_header");
$bild_header ->execute();
while($row_header = $bild_header->fetch()){
// echo "<li><a target='_blank' href='bild_abrufen.php?".$row['id']."'>".$row['name']."</a><br/>
// <embed src='data:".$row['format'].";base64,".base64_encode($row['datei'])."' width=''/></li>";

if (isset($_SESSION["angemeldet"]))
{

}
else {
    // Falls der Nutzer nicht angemeldet ist, wird er mit header auf die Login-Seite geleitet
    header("Location:login.php");
}

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
<meta charset="utf-8">
<head>
    <title>
        Profil von: <?php session_start();
        echo $_SESSION['angemeldet']; ?>
    </title>

    <style>

        .kommentar{
            padding: 20px;
            margin-bottom: 10px;
            margin-top: 10px;
            position: relative;
            transfrom: translate(-50%, -50%);
            box-sizing: border-box;
            border-radius: 10px;
            box-sizing: border-box;
            background: rgba(0,0,0,0.2);
        }

        #alert_popover{
            display:block;
            position: absolute
            bottom: 50px;
            left: 50px;
        }

        .wrapper{
            display: table-cell;
            vertical-align: bottom;
            height: auto
            width: 200px;
        }

        .alert_default{
            color:#333333;
            background-color: #f2f2f2;
            border-color:#cccccc;
        }

    </style>
</head>


<body>

<div class="container-fluid">
    <div class="row">

        <div class="col-3">
            <h1>Profildaten</h1>
            <div class="profilbild-folgen">
                <?php
                echo ("<img src='data:".$row_header['format'].";base64,".base64_encode($row_header['datei'])."'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                }

                ?>
                <button type="button" class="btn btn-success">Folgen</button>
            </div>
        </div>

        <div class="col-6">

                <?php
                // Zeigt die Postings des User an
                // wählt aus der Datenbank die entsprechenden Beiträge aus
                $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE userid=$id ORDER BY content.id DESC");
                $statement->execute(array('beitragsid' => 1));
                while ($content = $statement->fetch()) {

                $id_header=$_SESSION ["id"];
                $bild_header = $pdo -> prepare("SELECT * FROM bilduplad WHERE user_id=$id_header");
                $bild_header ->execute();
?>
                <div class="inhalt">
                <div class="beitrag">
                    <?php
                while($row_header = $bild_header->fetch()){
                            echo ("<img src='data:".$row_header['format'].";base64,".base64_encode($row_header['datei'])."'width=' alt='Nutzerprofilbild' class='profilbild-navbar'>");
                            }
                    echo "<br />" . $content['benutzername'] . ":<br />";
                    echo $content['text'] . "<br /><br />";
                    ?>

                    <form method="post" action="" onsubmit="return post();" id="kommentarform">
                        <textarea id="comment" name="comment" placeholder="Kommentieren" rows="1" class="form-control"></textarea><br>
                        <input type="hidden" value="<?php echo $content['id'];?>" name="post_id" class="form-control">
                        <input type="submit" class="btn btn-primary" value="Kommentieren" name="kommentar" id="kommentieren"/>
                    </form>
                    <br>

                    <input type="button" name="kommentarezeigen" class="btn btn-primary" onclick="kommentare()" value="Kommentare zeigen"/>
                    <div id="zeigeKommentare" style="display:none;" class="kommentare ">

                    <?php
                    $post_id=$content['id'];
                    $kommentare=$pdo->prepare("SELECT kommentare.*, studylab.benutzername FROM kommentare LEFT JOIN studylab ON kommentare.sender_id = studylab.id WHERE post_id=$post_id ORDER BY kommentare.id DESC");
                    $kommentare->execute();
                    while($komm=$kommentare->fetch()) {
                        ?>
                        <div class="kommentar">
                            <?php

                        echo $komm['Zeit'] . ":<br/>";
                            echo $komm['benutzername'] . ":<br />";
                    echo $komm['kommentar'];
                    ?>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                </div>

                        <?php

                }

                ?>
        </div>
    </div>
</div>
        <div class="col-3">
                <!-- Der User kann hier einen Post schreiben -->
                Schreibe einen Post:
                <form action="formular_abfrage.php" method="post">
                    <textarea name="content" class="form-control" rows="3"></textarea><br>
                    <input class="btn btn-primary" type="submit" value="Posten">

        </div>

<div id="alert_popover">
<div class="wrapper">
    <div class="content">

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
                url: 'nutzerprofil.php',
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

    $(document).ready(function(){
        setInterval(function(){
            load_last_notification();
        }, 10000);
        function load_last_notification()
        {
            $.ajax ({
                url: "fetch.php",
                mehtod:"POST",
                success: function(data)
                {
                    $('.content').html(data);
                }
            })
        }
        $('kommentarform').on('submit', function(event){
            event.preventDefault();
            if ($('#comment').val() != "")
            {
                var form_Data =$(this).serialize();
                $.ajax({
                    url:"nuterprofil.php",
                    method:"POST",
                    data:form_data,
                    sucess:function(data)
                    {
                        $('#kommentarform')[0].reset();
                    }
                })
            }
            else
                {
                alert("Eingabe notwendig")
            }

        });
    });

</script>

<?php
session_start();
include_once 'footer.php';
?>

</html>