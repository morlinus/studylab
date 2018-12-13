<!DOCTYPE html>
<html lang="de">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link href="studylab-login.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: url(https://mars.iuk.hdm-stuttgart.de/~lm092/23598316373_de98f70881_b.jpg);
            background-size: cover;
        }
    </style>
</head>

<!-- Hier sollte eigentlich das Form mit Bootstrap sein,
funktioniert aber nicht zusammen mit dem Login-Prozess-->
<body>

<div class="container-fluid-main">
    <div class="row height-100 mx-auto align-items-center background-recht">‚
        <!--
    <div class = "height-100 background-startseite col-lg-6 col-sm-12">

        <h3>Hier steht dann eine interessante Beschreibung der Website</h3>
    </div>
    -->
        <!-- Login-Form -->
        <div class="fenster col-sm-12 align-items-center">
            <img src="https://mars.iuk.hdm-stuttgart.de/~as325/Studylab.png" alt="" height="100" width="250">
            <br>

            <form method="post" action="do_login.php">

                <div class="eingabefeld">
                    <input type="text" name="benutzername"  id="Benutzername1" placeholder="Benutzername" required>
                    <!--  <label for="Benutzer1">Benutzername</label> -->

                    <small id="emailHelp" class="form-text text-muted"></small>
                </div>

                <div class="eingabefeld">
                    <input type="password" name="passwort"  id="Passwort1" placeholder="Passwort" required>
                    <!--  <label for="Passwort1">Passwort</label> -->
                </div>

                <button type="submit" class="btn btn-primary">Einloggen</button><br><br>
                Noch nicht angemeldet? <a href="registrierung.php">Registrieren</a><br><br>
            </form>
        </div>
    </div>
</div>

</body>

</html>
