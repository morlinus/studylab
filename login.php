<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>
<body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link href="studylab-login.css" rel="stylesheet">
</body>


<!-- Hier sollte eigentlich das Form mit Bootstrap sein,
funktioniert aber nicht zusammen mit dem Login-Prozess-->
<body>

<div class="container-fluid-main">
<div class="row height-100 mx-auto align-items-center">
<div class = "height-100 background-startseite col-lg-6 col-sm-12">

    <h3>Hier steht dann eine interessante Beschreibung der Website</h3>
</div>

<!-- Login-Form -->
<div class="background-recht col-lg-6 col-sm-12">
    <div class="fenster">
        <h2>StudiLAB</h2>
        <br>

        <form method="post" action="do_login.php">

            <div class="eingabefeld">
                <input type="text" name="benutzername"  id="Benutzername1" aria-describedby="BenutzernameHelp" placeholder="Benutzername">
                <!--  <label for="Benutzer1">Benutzername</label> -->

                 <small id="emailHelp" class="form-text text-muted"></small>
             </div>

             <div class="eingabefeld">
                 <input type="password" name="passwort"  id="Passwort1" placeholder="Passwort">
               <!--  <label for="Passwort1">Passwort</label> -->
            </div>

            <button type="submit" class="btn btn-primary">Einloggen</button><br><br>
            Noch nicht angemeldet? <a href="registrierung.php">Registrieren</a><br><br>
    </div>
</div>
</div>
</div>

</body>

</html>
