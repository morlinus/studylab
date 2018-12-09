<?php
// bindet die header.php ein und damit den Header der Seite
include_once 'header.php';

$id_header=$_SESSION ["id"];
$bild_header = $pdo -> prepare("SELECT * FROM bilduplad WHERE user_id=$id_header");
$bild_header ->execute();
while($row_header = $bild_header->fetch()){

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

    </style>
</head>


<body>

<div class="container-fluid">
    <div class="row">

        <div class="col-3">


            <div class="profilbildplusfolgen">
                <?php

                // Benutzerbild wird im Profil angezeigt

                echo ("<img src='data:".$row_header['format'].";base64,".base64_encode($row_header['datei'])."'width=' alt='Nutzerprofilbild' class='profilbild-folgen'>");
                }
                ?>
            </div>
            <br>
            <div class="shadow-sm p-3 mb-5 bg-white rounded">
                        <?php
                        $id=$_SESSION["id"];
                        $profil=$pdo->prepare("SELECT * FROM studylab WHERE id=$id");
                        $profil->execute();
                        while($daten = $profil->fetch()){

                            ?>
                            <h6>Benutzername:</h6> <?php echo $daten['benutzername'] . "<br /><br />"; ?>
                            <h6>Name:</h6> <?php echo $daten['name'] . " ". $daten['nachname'] . "<br /><br />"; ?>
                            <h6>Geburtstag:</h6> <?php echo $daten['geburtsdatum'] . "<br /><br />"; ?>
                            <h6>Studiengang:</h6> <?php echo $daten['studiengang'] . " ". "(Semester: ".$daten['semester'].")"; ?>


                            <?php
                        }
                        ?>
            </div>
        </div>


        <div class="col-6">

                <?php
                // Zeigt die Postings des User an
                // wählt aus der Datenbank die entsprechenden Beiträge aus
                $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE userid=$id ORDER BY content.id DESC");
                $statement->execute(array('beitragsid' => 1));
                while ($content = $statement->fetch()) {

                    $postid = $content ["id"];
                    $beitrags_bild = $pdo -> prepare ("SELECT * FROM bildupload_content WHERE post_id=$postid");
                    $beitrags_bild -> execute();
                    $bilder = $beitrags_bild -> fetch();
                    $dbabgleich = $bilder ["post_id"];

                $id_header=$_SESSION ["id"];
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
                        if ($postid = $dbabgleich) {
                            echo"<br>";
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

        <div class="col-3">

            <?php
            $gefolgteProfile=$pdo->prepare("SELECT folgen.*, studylab.* FROM folgen LEFT JOIN studylab ON folgen.follower_id=studylab.id WHERE folgen.user_id=$id");
            $gefolgteProfile->execute();
            while($follower=$gefolgteProfile->fetch())
            {
                echo $follower['benutzername'];
                echo $followerbildid=$follower['follower_id'];

                $gefolgteProfilbilder=$pdo->prepare("SELECT bilduplad.*, folgen.* FROM bilduplad LEFT JOIN folgen ON bilduplad.user_id=folgen.follower_id WHERE bilduplad.user_id=$followerbildid");
                $gefolgteProfilbilder->execute();
                while($followerprofbild = $gefolgteProfilbilder->fetch())
                {
                    echo "<br>";
                    echo "<div class='bild-class'>";
                    echo("<img src='data:" . $followerprofbild['format'] . ";base64," . base64_encode($followerprofbild['datei']) . "'width=' alt='Responsive image' class='img-fluid'>");
                    echo "</div>";
                }
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


</script>

<?php
session_start();
include_once 'footer.php';
?>

</html>