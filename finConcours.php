<?php
    require_once 'functions.inc.php';
    include_once 'header.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Fin du concours</title>
</head>
<body>
    <header>
        <div class="container">
            <div class="bg-light">
                <img src="./img/gedimat.png" class="float-none rounded">
                <a href="index.php">Accueil</a>
            </div>
        </div>
    </header>
    <div class="container mt-3">
        <?php
            if (dejaParticipe())
            {
                echo "<div class=\"alert alert-success\" role=\"alert\"> Merci d'avoir particpé au concours </div>";
            }
            if (dateConcours() === false)
            {
                echo "<div class=\"alert alert-danger\" role=\"alert\"> Le concours est terminé !! </div>";
            }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

<footer>
    <div class="float">

    </div>
</footer>
</html>