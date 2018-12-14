<?php
// bindet den Header in die Seite ein
include "header.php";

// bindet den Datenbankzugriff ein
include "userdata.php";

$hashtag1=$_GET["themen"];

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
        <div class="col-lg-2">

        </div>

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-8 col-md-8 col-sm-8 col-">
            <img src="https://mars.iuk.hdm-stuttgart.de/~lm092/Studylab_Hashtags 2.png" alt="" style="width:300px;">
            <br>
            <h1>#<?php echo $hashtag1;?></h1>
            <br>

            <?php
            // Zeigt die Postings aus, die den hashtag beinhalten des User an
            // wählt aus der Datenbank die entsprechenden Beiträge aus
            $statement = $pdo->prepare("SELECT content.*, studylab.* FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE content.themen='$hashtag1' ORDER BY content.id DESC");
            if (!$statement->execute(array('beitragsid' => 1))) {
                echo "Fehler";
            }
            while ($content = $statement->fetch()) {

            $postid = $content ["id"];
            $beitrags_bild = $pdo -> prepare ("SELECT * FROM bildupload_content WHERE post_id=$postid");
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

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-1 col-md-1 col-sm-1 col-">

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

<!-- Einbindung des Sticky-Footers -->
<?php
include_once 'footer.php';
?>

</html>
