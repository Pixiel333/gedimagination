<?php
require_once 'DAL.inc.php';
function donneeForm() 
{
    if (isset($_POST['titre']) && isset($_POST['date']) && isset($_FILES['image']) && isset($_POST['description']))
    {
        if (!empty($_POST['titre']) && !empty($_POST['date']) && !empty($_FILES['image']['name']) && !empty($_POST['description']))
        {
            $titre = htmlspecialchars($_POST['titre']);
            $date = htmlspecialchars($_POST['date']);
            $description = htmlspecialchars($_POST['description']);
            $chemin_photo = uploadImage();
            $row =insert_bdd($titre, $date, $description, $chemin_photo, "polivier@exemple.com");
            return $row;
        }
        else
        {

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
    if (is_uploaded_file($_FILES["image"]["tmp_name"])) 
    {
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

function formValide($nomInput)
{
    if ($nomInput === "image") 
    {
        if (isset($_FILES[$nomInput]))
        {
            if (empty($_FILES[$nomInput]['name']))
            {
                return "is-invalid";
            }
            else 
            {
                return "is-valid";
            }
        }
    }
    else 
    {
        if (isset($_POST[$nomInput]))
        {
            if (empty($_POST[$nomInput]))
            {
                return "is-invalid";
            }
            else 
            {
                return "is-valid";
            }
        }
    }
}

function invalidMessage($nomInput)
{
    $message = "";
    switch ($nomInput)
    {
        case "titre":
            $message .= "Veuillez saisir un titre pour cette photo.";
        break;

        case "date":
            $message .= "Veuillez saisir la date de la photo.";
        break;
        
        case "image":
            $message .= "Veuillez choisir une photo.";
        break;

        case "description":
            $message .= "Veuillez remplir la déscription de la photo.";
        break;

        default:
            $message .= "Veuillez saisir le champs.";
        break;
    }
    if (formValide($nomInput) === "is-invalid")
    {
        return "<div class=\"invalid-feedback\">". $message ."</div>";
    }
}