<?php
session_start();
include_once 'header.php';
?>
<html>
<head>
<title> Profil bearbeiten</title>
</head>

<body>

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
        <html>
        <br>
        <form action="aendern.php" method="post">
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input type="text" autocomplete="off" size="40" maxlength="200" name="name" value="<?php echo $row['name'];?>"/>
                </td><br><br>
                <td>
                    Nachname:
                </td>
                <td>
                    <input type="text" autocomplete="off" size="40" maxlength="200" name="nachname" value="<?php echo $row['nachname'];?>"/>
                </td><br><br>
                <td>
                    Benutzername:
                </td>
                <td>
                     <input type="text" autocomplete="off" size="40" maxlength="200" name="benutzername" value="<?php echo $row['benutzername'];?>"/>
                </td> <br><br>
                <td>
                    Geburtsdatum:
                </td>
                <td>
                    <!-- Der Datepicker funktioniert hier noch nicht -->
                    <input type="geburtsdatum" id="datepicker" value="<?php echo $row['geburtsdatum'];?>" size = "40" maxlength="200" name="geburtsdatum">
                </td>    <br><br>
                <td>
                    Studiengang:
                </td>
                <td>
                    <input type="text" autocomplete="off" size="40" maxlength="200" name="studiengang" value="<?php echo $row['studiengang'];?>"/>
                </td>    <br><br>
                <td>
                    Geschlecht: <?php echo $row['geschlecht'];?>
                </td>  <br><br> 
                <td>
                    E-Mail:
                </td>
                    <input type="text" autocomplete="off" size="40" maxlength="200" name="email" value="<?php echo $row['email'];?>"/>
                <td>  <br><br>
                <td>
                    Semester:
                </td>
                <td>
                    <input type="text" autocomplete="off" size="40" maxlength="200" name="semester" value="<?php echo $row['semester'];?>"/>
                </td>  <br><br>
                <td>
                    Status:
                </td>
                <td>
                    <input type="text" autocomplete="off" size="40" maxlength="200" name="status" value="<?php echo $row['status'];?>"/>
                </td> <br><br>
                <td>
                <td> Passwort ändern: </td>        <br><br>


                    altes Passwort:<input type="password" name="passwort_alt" />  <br><br>

                    neues Passwort:<input type="password" name="passwort_neu" />    <br><br> 
                </td>
                <td>
                    <input type="submit" value="Änderungen speichern" name="submit">
                </td>
            </tr>
        </form>
    </html>
                                                       
<?php

    }
} else {
    echo 'Datenbank-Fehler:';
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die();
}
?>
</body>
</html>
