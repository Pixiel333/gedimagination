<?php 
    require_once 'functions.inc.php';
    include_once 'header.php';

    if (verifDate() == false)
    {
        header('Location: finConcours.php');
        exit();
    }
    elseif (dejaParticipe())
    {
        header('Location: finConcours.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Participation concours photo</title>
</head>

<header>
    <div class="container">
        <div class="bg-light">
            <img src="./img/gedimat.png" class="float-none rounded">
            <a href="inscription.html">Inscription</a>
        </div>
    </div>
</header>

<body>
    <div class="container">
        <br>
        <p class="text-start fs-5">En appuyant sur le bouton, vous participerez au concours de photo (sans possibilité de changements)</p>
        <form enctype="multipart/form-data" action="" method="POST">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="texte" class="form-control <?= formValide("titre");?>" name="titre" id="titre" aria-describedby="titre" placeholder="Titre de la photo" value="<?php echo gardeValeur("titre"); ?>" maxlength="80">
            <?= invalidMessage("titre");?>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control <?= formValide("date")?>" name="date" id="date" value="<?php echo gardeValeur("date"); ?>" >
            <?= invalidMessage("date");?>
        </div>
        <div class="form-group">
            <input type="file" name="image" id="file" class="custom-file-input <?= formValide("image")?>" accept="image/*" >
            <?= invalidMessage("image");?>
        </div>
        <div class="form-group">
            <label for="exampleTextarea">Déscription de la photo</label>
            <textarea class="form-control <?= formValide("description")?>" name="description" id="exampleTextarea" rows="5" maxlength="666"><?php echo gardeValeur("description"); ?></textarea>
            <?= invalidMessage("description");?>
        </div>
            <button type="submit" name="submit" class="btn btn-primary mt-2">Participer</button>
        </form>
    </div>
    <?php 
        if (isset($_POST['submit'])) 
        {
            $row = donneeForm();
            print_r(verifDate());
            unset($_POST);
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

<footer>
    <div class="float">

    </div>
</footer>
</html>