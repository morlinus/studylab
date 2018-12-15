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

// bindet die header.php ein und damit den Header der Seite
include_once 'header.php';

// übernimmt aus der Session die ID
$id_header=$_SESSION ["id"];
$id=$_SESSION["id"];

// es wird geschaut, ob der Nutzer schon jemandem folgt
$abonennten = $pdo ->prepare ("SELECT * FROM folgen WHERE user_id = $id_header");
$abonennten ->execute();
$abos = $abonennten ->rowCount();

if (!$abos > 0 ) {
    $abos = "Du hast noch keine Abonennten. Folge Nutzern, damit sie auf dich aufmerksam werden";
}

// das Bild für den Header wird aus der Datenbank ausgegeben
$bild_header = $pdo->prepare("SELECT * FROM bilduplad WHERE user_id=$id_header");
$bild_header->execute();
while($row_header = $bild_header->fetch()){

// Die Kommentare werden in die Datenbank eingetragen
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

</head>


<body>

<div class="container-fluid">
    <div class="row">

        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-3 col-md-3 col-sm-3 col-">

            <br>
            <br>

            <!-- Style des Profilbilds im Profil -->
            <div class="profilbildplusfolgen">
                <?php

                // Benutzerbild wird im Profil angezeigt

                echo ("<img src='data:".$row_header['format'].";base64,".base64_encode($row_header['datei'])."'width=' alt='Responsive image' class='profilbild-profil'>");
                }
                ?>
            </div>
            <br>

            <!-- Umrandung und Schatten der Profilinfo -->
            <div class="shadow-sm p-3 mb-5 bg-white rounded">

                        <!-- Die Daten des angemeldeten Nutzers werden aus der Datenbank geholt und ausgegeben -->
                        <?php
                        $id=$_SESSION["id"];
                        $profil=$pdo->prepare("SELECT * FROM studylab WHERE id=$id");
                        $profil->execute();
                        while($daten = $profil->fetch()){

                            ?>
                            <h6>Benutzername</h6> <?php echo $daten['benutzername'] . "<br /><br />"; ?>
                            <h6>Name</h6> <?php echo $daten['name'] . " ". $daten['nachname'] . "<br /><br />"; ?>
                            <h6>Geburtstag</h6> <?php echo $daten['geburtsdatum'] . "<br /><br />"; ?>
                            <h6>Studiengang</h6> <?php echo $daten['studiengang'] . " ". "(Semester: ".$daten['semester'].")"."<br /><br />"; ?>
                            <h6> Abonennten</h6> <?php echo $abos; ?>



                            <?php
                        }
                        ?>
            </div>
        </div>


        <!-- Einteilung in das Grid-System -->
        <div class="col-lg-8 col-md-8 col-sm-8 col-">

            <br>
            <br>

                <?php
                // Zeigt die Postings des User an
                // wählt aus der Datenbank die entsprechenden Beiträge aus
                $statement = $pdo->prepare("SELECT content.*, studylab.benutzername FROM content LEFT JOIN studylab ON content.userid = studylab.id WHERE userid=$id ORDER BY content.id DESC");
                $statement->execute(array('beitragsid' => 1));
                while ($content = $statement->fetch()) {
                    // wählt zu den entsprechenden Beiträgen die Bilder aus
                    $postid = $content ["id"];
                    $beitrags_bild = $pdo -> prepare ("SELECT * FROM bildupload_content WHERE post_id=$postid");
                    $beitrags_bild -> execute();
                    $bilder = $beitrags_bild -> fetch();
                    $dbabgleich = $bilder ["post_id"];

                // Das Profilbild des jeweiligen Beitragserstellers wird ausgegeben
                $bild_header = $pdo -> prepare("SELECT * FROM bilduplad WHERE user_id=$id_header");
                $bild_header ->execute();
                while($row_header = $bild_header->fetch()){

                ?>

                <!-- Umrandung und Schatten der Postingbox und der Beiträge -->
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
                            echo"<br>";
                        }
                    echo $content['text'];
                    ?>
                    </div>

                        <?php
                        // Die zu dem Beitrag zugehörigen Kommentare werden ausgegeben
                        $post_id = $content['id'];
                        $kommentare = $pdo->prepare("SELECT kommentare.*, studylab.benutzername FROM kommentare LEFT JOIN studylab ON kommentare.sender_id = studylab.id WHERE post_id=$post_id ORDER BY kommentare.id DESC");
                        $kommentare->execute();
                        while ($komm = $kommentare->fetch()) {
                            ?>


                            <!-- Style des Kommentars -->
                            <div class="kommentar2">

                                <?php
                                // Die zu den Kommentaren zugehörigen Profilbilder werden ausgegeben
                                $kommid=$komm['id'];

                                $kommbild =$pdo->prepare("SELECT bilduplad.*, kommentare.* FROM bilduplad LEFT JOIN kommentare ON bilduplad.user_id=kommentare.sender_id WHERE post_id=$post_id AND kommentare.id=$kommid");
                                $kommbild->execute();
                                while ($row_kommbild = $kommbild->fetch()){
                                    ?>

                                    <!-- Style des Profilbilds im Beitrag -->
                                    <div class="miniprofbild">
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
<!-- Hier wird das Script für die Kommentare und den Post implementiert -->
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
session_start();
include_once 'footer.php';
?>

</html>