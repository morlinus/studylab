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

session_start();

// bindet die header.php ein und damit den Header der Seite
include_once 'header.php';


?>


<!doctype html>
<html lang="de">
<meta charset="utf-8">
<head>
    <title>Profil bearbeiten</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Einteilung in das Grid-System -->
            <div class="col-lg-3 col-md-1 col-sm-1">

            </div>

            <!-- Einteilung in das Grid-System -->
            <div class="col-lg-6 col-md-10 col-sm-10 col-">

                <br>
                <br>

                <div class="shadow-sm p-3 mb-5 bg-white rounded">

                <?php
                    session_start();
                    $_SESSION["angemeldet"];
                    $id=$_SESSION["id"];
                    $passwort=$_SESSION["passwort"];
                    include 'userdata.php';

                // Die Daten des angemeldeten User werden ausgegeben
                $statement = $pdo->prepare("SELECT * FROM studylab WHERE id=$id");
                if($statement->execute()) {
                    while($row=$statement->fetch()) {

                        ?>

                        <!-- Style der Profilbearbeitung -->
                        <div class="profilbearbeitung">
                        <form action="aendern.php" method="post">
                                <label for="Inhalt">Name:</label>
                                <br>
                                <input type="text" class="form-control" autocomplete="off" size="40" maxlength="200" name="name" value="<?php echo $row['name'];?>"/>
                        </form>
                        </div>
                        <br>
                        <div class="profilbearbeitung">
                                <label for="Inhalt">Nachname:</label>
                                <br>
                                <input type="text" class="form-control" autocomplete="off" size="40" maxlength="200" name="nachname" value="<?php echo $row['nachname'];?>"/>
                        </div>
                        <br>
                        <div class="profilbearbeitung">
                                <label for="Inhalt">Benutzername:</label>
                                <br>
                                <input type="text" class="form-control" autocomplete="off" size="40" maxlength="200" name="benutzername" value="<?php echo $row['benutzername'];?>"/>
                        </div>
                        <br>
                        <div class="profilbearbeitung">
                                <label for="Inhalt">Geburtsdatum:</label>
                                <br>
                                <!-- Der Datepicker funktioniert hier noch nicht -->
                                <input type="geburtsdatum" class="form-control" id="datepicker"  size = "40" maxlength="200" name="geburtsdatum"value="<?php echo $row['geburtsdatum'];?>">
                        </div>
                        <br>
                        <div class="profilbearbeitung">
                            <label for="Inhalt">Geschlecht:</label>
                            <br>
                            <input type="text" class="form-control" autocomplete="off" size="40" maxlength="200" name="studiengang" value="<?php echo $row['geschlecht'];?>"/>
                        </div>
                        <br>
                        <div class="profilbearbeitung">
                            <label for="Inhalt">E-Mail Addresse</label>
                            <input type="email" class="form-control" name="email" id="Inhalt" value="<?php echo $row['email'];?>">
                        </div>
                        <br>
                        <div class="profilbearbeitung">
                                <label for="Inhalt">Studiengang:</label>

                            <select class="form-control" id="Inhalt" value="<?php echo $row['semester'];?>">
                                <option>Audiovisuelle Medien</option>
                                <option>Crossmedia-Redaktion/Public Relations</option>
                                <option>Deutsch-Chinesischer Studiengang Medien und Technologie</option>
                                <option>Informationsdesign</option>
                                <option>Informationswissenschaften</option>
                                <option>Integriertes Produktdesign</option>
                                <option>Mediapublishing</option>
                                <option>Medieninformatik</option>
                                <option>Medienwirtschaft</option>
                                <option>Mobile Medien</option>
                                <option>Online-Medien-Management</option>
                                <option>Print Media Technologies</option>
                                <option>Verpackungstechnik</option>
                                <option>Werbung und Marktkommunikation</option>
                                <option>Wirtschaftsinformatik und digitale Medien</option>
                                <option>Wirtschaftsingenieurwesen Medien</option>
                            </select>
                        </div>
                        <br>
                        <div class="profilbearbeitung">
                                <label for="Inhalt">Semester:</label>
                                <br>
                                <input type="text" class="form-control" autocomplete="off" size="40" maxlength="200" name="studiengang" value="<?php echo $row['semester'];?>"/>
                        </div>
                        <br>
                        <div class="profilbearbeitung">
                                <label for="Inhalt">Status:</label>

                            <select class="form-control" id="Inhalt" value="<?php echo $row['semester'];?>">
                                <option>Student</option>
                                <option>Professor</option>
                            </select>
                        </div>
                         <br>
                        <div class="profilbearbeitung">
                                <label for="Inhalt">Passwort ändern:</label>
                                <br>
                                altes Passwort:<input  required type="password" class="form-control" name="passwort_alt" />  <br>

                                neues Passwort:<input  required type="password" class="form-control" name="passwort_neu" />  <br><br>
                        </div>

                        <div class="profilbearbeitung">
                                <form class="form-inline my-2 my-lg-0" action="aendern.php" method="post">
                                    <button class="btn my-2 my-sm-0" type="submit" name="submit" value="Änderungen speichern">Änderungen speichern</button>
                                </form>
                        </div>



                <?php

                    }
                } else {
                    echo 'Datenbank-Fehler:';
                    echo $statement->errorInfo()[2];
                    echo $statement->queryString;
                    die();
                }
                ?>

                </div>
            </div>

            <!-- Einteilung in das Grid-System -->
            <div class="col-lg-3 col-md-1 col-sm-1">

            </div>

        </div>
    </div>

</body>

<!-- Einbindung des Sticky-Footers -->
<?php
session_start();
include_once 'footer.php';
?>
