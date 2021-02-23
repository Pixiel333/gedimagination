<?php
require_once 'DAL.inc.php';
function donneeForm() 
{
    echo "donneform";
    if (isset($_POST['titre']) && isset($_POST['date']) && isset($_FILES['image']) && isset($_POST['description']))
    {
        echo "premierif";
        if (!empty($_POST['titre']) && !empty($_POST['date']) && !empty($_FILES['image']) && !empty($_POST['description']))
        {
            echo "deuxiemeif";
            $titre = htmlspecialchars($_POST['titre']);
            $date = htmlspecialchars($_POST['date']);
            $description = htmlspecialchars($_POST['description']);
            $chemin_photo = uploadImage();
            $row =insert_bdd($titre, $date, $description, $chemin_photo, "polivier@exemple.com");
            return $row;
        }
    }
}

function uploadImage() 
{
    // Copie dans le repertoire du script avec un nom
    // incluant l'heure a la seconde pres 
    $repertoireDestination = dirname(dirname(dirname(__FILE__)))."\\data\\images\\";
    $infoExt = new SplFileInfo($_FILES["image"]["name"]);
    $nomDestination        = "image".date("YmdHis"). '.'.$infoExt->getExtension();
    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
        if (rename($_FILES["image"]["tmp_name"], $repertoireDestination.$nomDestination)) 
        {
            return $repertoireDestination.$nomDestination;
        } 
        else 
        {
            echo "Le déplacement du fichier temporaire a échoué";
        }          
    } 
    else 
    {
        echo "Le fichier n'a pas été uploadé (trop gros ?)";
    }
}