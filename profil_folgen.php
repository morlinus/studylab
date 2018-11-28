<?php
/**
 * Created by PhpStorm.
 * User: linusmorlinghaus
 * Date: 23.11.18
 * Time: 09:19
 */

include_once 'header.php';

if (isset($_GET["nutzerid"])) {

    $_SESSION ["angemeldet"];

    $benutzername = $_GET["nutzerid"];
    $followerid = $_SESSION ["angemeldet"];
    echo $followerid;

    $nutzersuche = $pdo->prepare("SELECT * FROM studylab WHERE benutzername = $benutzername");
    if ($nutzersuche->execute()) {
        while ($row = $nutzersuche->fetch()) {

            // echo $benutzername;
            $benutzername = $row ['benutzername'];
            $name = $row ['name'];
            $nachname = $row ['nachname'];

        }
    }

        if (isset($_POST['folgen'])) {
                $folgen = $pdo->prepare("INSERT INTO folgen (user_id,follower_id) VALUES ($benutzername, $followerid)");
                if ($folgen -> execute()) {
                    echo "Abboniert";
                    //header ("location:profil_folgen.php?nutzerid= $benutzername");

            }
        }

            else {
                    ?>
                    <!-- Folgen schon gegenseitig unfollow -->
                    <form action="profil_folgen.php?nutzerid=<?php echo $benutzername; ?>" method="post">
                        <input type="submit" name="entfolgen" value="entfolgen">
                    </form>
                    <?php

                    if (isset($_POST['entfolgen'])) {
                        $entfolgen = $pdo->prepare("DELETE FROM folgen WHERE user_id='$benutzername' AND follower_id='$followerid'");
                        if ($entfolgen->execute()) {
                            echo "unfollowed";
                            header("location:profile.php?userid=$benutzername");
                        }
                    }
                }


}
else {
            die ('ERROR 404 - Benutzer nicht gefunden');
        }


?>

<h2><?php echo $benutzername; ?>'s Profil</h2>
<form action="profil_folgen.php?nutzerid=<?php echo $benutzername; ?>" method="post">
    Name: <?php echo $benutzername; ?> <br>
    Nachname: <?php echo $followerid; ?> <br>
    <input type="submit" name="folgen" value="Folgen">
</form>
