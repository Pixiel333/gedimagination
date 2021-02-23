<?php 
    require_once 'functions.inc.php';
    if (isset($_POST['submit'])) 
    {
        $row = donneeForm();
        unset($_POST);
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
<body>
    <div class="container">
        <form enctype="multipart/form-data" action="" method="POST">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="texte" class="form-control" name="titre" id="titre" aria-describedby="titre" placeholder="Titre de la photo">
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="form-group">
            <label class="custom-file">
                <input type="file" name="image" id="file" class="custom-file-input">
                <span class="custom-file-control"></span>
            </label>
        </div>
        <div class="form-group">
            <label for="exampleTextarea">Déscription de la photo</label>
            <textarea class="form-control" name="description" id="exampleTextarea" rows="3" maxlength="666"></textarea>
        </div>
            <button type="submit" name="submit" class="btn btn-primary mt-2">Participer</button>
        </form>
    </div>
    <?php 
        if ($row === 1)
        {
            
        }
    ?>
</body>
</html>