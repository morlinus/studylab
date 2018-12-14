

<title>Profil bearbeiten</title>
<?php
session_start();
include_once 'header.php';
?>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-1 col-sm-1">

            </div>


            <div class="col-lg-6 col-md-10 col-sm-10 col-">

                <script>
                    $( function() {
                                $( "#datepicker" ).datepicker();
                                $( "#format" ).on( "change", function() {
                                    $( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
                                });
                            } );

                    $( function() {
                var availableTags = [
                "Online- Medien- Management",
                "Informationsdesign",
                "Bibliothekswissenschaften",
                "Anni Wissenschaften",
                "C",
                "C++",
                "Clojure",
                "COBOL",
                "ColdFusion",
                "Erlang",
                "Fortran",
                "Groovy",
                "Haskell",
                "Java",
                "JavaScript",
                "Lisp",
                "Perl",
                "PHP",
                "Python",
                "Ruby",
                "Scala",
                "Scheme"
                ];
                $( "#tags" ).autocomplete({
                source: availableTags
                });
                </script>

                <?php
                    session_start();
                    $_SESSION["angemeldet"];
                    $id=$_SESSION["id"];
                    $passwort=$_SESSION["passwort"];
                    include 'userdata.php';

                $statement = $pdo->prepare("SELECT * FROM studylab WHERE id=$id");
                if($statement->execute()) {
                    while($row=$statement->fetch()) {

                        ?>

                        <br>
                        <div class="name-bearbeitung">
                        <form action="aendern.php" method="post">
                                <label for="Inhalt">Name:</label>
                                <br>
                                <input type="text" class="form-control" autocomplete="off" size="40" maxlength="200" name="name" value="<?php echo $row['name'];?>"/>
                        </form>
                        </div>
                        <br>
                        <div class="nachname-bearbeitung">
                                <label for="Inhalt">Nachname:</label>
                                <br>
                                <input type="text" class="form-control" autocomplete="off" size="40" maxlength="200" name="nachname" value="<?php echo $row['nachname'];?>"/>
                        </div>
                        <br>
                        <div class="benutzername-bearbeitung">
                                <label for="Inhalt">Benutzername:</label>
                                <br>
                                <input type="text" class="form-control" autocomplete="off" size="40" maxlength="200" name="benutzername" value="<?php echo $row['benutzername'];?>"/>
                        </div>
                        <br>
                        <div class="geburtsdatum-bearbeitung">
                                <label for="Inhalt">Geburtsdatum:</label>
                                <br>
                                <!-- Der Datepicker funktioniert hier noch nicht -->
                                <input type="geburtsdatum" class="form-control" id="datepicker"  size = "40" maxlength="200" name="geburtsdatum"value="<?php echo $row['geburtsdatum'];?>">
                        </div>
                        <br>
                        <div class="studiengang-bearbeitung">
                                <label for="Inhalt">Studiengang:</label>

                            <!-- Hier bin ich mir nicht sicher wie man die PHP-Datei einbindet -->
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
                        <div class="geschlecht-bearbeitung">
                                <label for="Inhalt">Geschlecht:</label>
                                <br>
                                <input type="text" class="form-control" autocomplete="off" size="40" maxlength="200" name="studiengang" value="<?php echo $row['geschlecht'];?>"/>
                        </div>
                        <br>
                        <div class="email-bearbeitung">
                                <label for="Inhalt">E-Mail Addresse</label>
                                <input type="email" class="form-control" id="Inhalt" value="<?php echo $row['email'];?>">
                        </div>
                        <br>
                        <div class="semester-bearbeitung">
                                <label for="Inhalt">Semester:</label>
                                <br>
                                <input type="text" class="form-control" autocomplete="off" size="40" maxlength="200" name="studiengang" value="<?php echo $row['semester'];?>"/>
                        </div>
                        <br>
                        <div class="status-bearbeitung">
                                <label for="Inhalt">Status:</label>

                            <select class="form-control" id="Inhalt" value="<?php echo $row['semester'];?>">
                                <option>Student</option>
                                <option>Professor</option>
                            </select>
                        </div>
                         <br>
                        <div class="passwort-bearbeitung">
                                <label for="Inhalt">Passwort ändern:</label>
                                <br>
                                altes Passwort:<input  required type="password" class="form-control" name="passwort_alt" />  <br>

                                neues Passwort:<input  required type="password" class="form-control" name="passwort_neu" />  <br><br>
                        </div>

                                <form class="form-inline my-2 my-lg-0" action="aendern.php" method="post">
                                    <button class="btn my-2 my-sm-0" type="submit" name="submit" value="Änderungen speichern">Änderungen speichern</button>
                                </form>




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

            <div class="col-lg-3 col-md-1 col-sm-1">

            </div>

        </div>
    </div>

</body>

<?php
session_start();
include_once 'footer.php';
?>
</html>
