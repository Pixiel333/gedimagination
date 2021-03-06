<?php
require_once 'DAL.inc.php';
function donneeForm() 
{
    if (isset($_POST['titre']) && isset($_POST['date']) && isset($_FILES['image']) && isset($_POST['description']) && isset($_SESSION['email']))
    {
        if (!empty($_POST['titre']) && !empty($_POST['date']) && !empty($_FILES['image']['name']) && !empty($_POST['description']) && tailleImage() && verifImage())
        {
            $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES);
            $date = htmlspecialchars($_POST['date'], ENT_QUOTES);
            $description = htmlspecialchars($_POST['description'], ENT_QUOTES);
            $chemin_photo = uploadImage();
            $email = $_SESSION['email'];

            if (strlen($titre) > 80 || strlen($description) > 666 || validationDate() === false)
            {
                return 0;
            }
            else 
            {
                $row =insert_bdd($titre, $date, $description, $chemin_photo, $email);
                return $row;    
            }
        }
        else
        {

        }
    }
}

function validationDate()
{
    $date = "";
    if (isset($_POST["date"]) && !empty($_POST["date"]))
    {
        $date = htmlspecialchars($_POST['date'], ENT_QUOTES);
    }
    if (strtotime($date))
    {
        if (strpos($date,'-')!== false)
        {
            list($day, $month, $year) = explode('-',$date);
            return checkdate($month, $day, $year);
            echo checkdate($month, $day, $year);
        }
        else
        {
            return false;    
        }
    }
    else
    {
        return false;    
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
            else if (tailleImage() === false || verifImage() === false)
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
            elseif ($nomInput === "date" && validationDate() === false) {
                return "is-invalid" ;
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
    if ($nomInput === "image")
    {
        if (verifImage() === false)
        {
            $message = "Le format de l'image n'est pas la bonne !";
        }
        else if (tailleImage() === false)
        {
            $message = "La taille de l'image est trop volimineuse (10Mo max)";
        }
    }
    elseif ($nomInput === "date")
    {
        if (validationDate() === false )
        {
            $message = "Le format de la date n'est pas valide !";
        }
    }

    if (formValide($nomInput) === "is-invalid")
    {
        return "<div class=\"invalid-feedback\">". $message ."</div>";
    }
}

function verifDate()
{
    $dateConcours = dateConcours();
    $today = date('Y-m-d');
    if ($today >= $dateConcours['date_debut_insc'] && $today <= $dateConcours['date_fin_insc'])
    {
        return true;
    }
    else
    {
        return false;
    }
}

function dejaParticipe()
{
    $email = $_SESSION['email'];
    $emailParticipants = participants();
    $bool = false;
    foreach ($emailParticipants as $key => $value)
    {
        if ($email === $value['email'])
        {
            $bool = true;
        }
    }
    if ($bool)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function tailleImage()
{
    if (isset($_FILES['image']))
    {
        if ($_FILES['image']['size'] > 10000000)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}

function verifImage()
{
    if (isset($_FILES['image']) && !empty($_FILES['image']['name']))
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($_FILES['image']['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'jpeg' => 'image/jpg',
            ),
            true
        ))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
}

function gardeValeur($valeur)
{
    $texte = "";
    if(isset($_POST[$valeur]) && !empty($_POST[$valeur]))
    {
        if ($valeur === "date" && validationDate() === false) 
        {
            $texte = date('Y-m-d');
        }
        else
        {
            $texte = htmlspecialchars($_POST[$valeur], ENT_QUOTES);
        }
    }
    elseif ($valeur === "date")
    {
        $texte = date('Y-m-d');
    }
    return $texte;
}