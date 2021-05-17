<?php
    include_once('DAL.inc.php');
    function DAL_getAllPhotos()
	{
        try {
            $connexion = connexionBase();
            $requete = 'SELECT id, titre, description, date, chemin_photo FROM PHOTO';
            $prep = $connexion->prepare($requete);
            $prep->execute();
            $result = $prep->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

	function DAL_getAllDates()
	{
        try {
            $connexion = connexionBase();
            $requete = 'SELECT * FROM DATE';
            $prep = $connexion->prepare($requete);
            $prep->execute();
            $result = $prep->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

	try {
		$request_method = $_SERVER["REQUEST_METHOD"];
		switch($request_method)
		{
			case 'GET':
				if(isset($_GET["concours"]) && !empty($_GET["concours"]))
				{
					if ($_GET["concours"] === "photos") {
						getPhotos();
					}
					elseif ($_GET["concours"] === "dates") {
						getDates();
					}
				}
				break;
			
			case 'POST':
                postPhoto();
				break;
				
			case 'PUT':
				break;
				
			case 'DELETE':
				break;

			default:
				http_response_code(405);
				break;
		}
	} 
	catch (Exception $e) {
		echo $e->getMessage();
		http_response_code(500);
	}
	
	// requête GET localhost/gedimagination/WebService
	function getPhotos()
	{
		header('Content-type: application/json');
		$lesPhotos = DAL_getAllPhotos();
		echo json_encode($lesPhotos);
	}

	function getDates()
	{
		header('Content-type: application/json');
		$lesDates = DAL_getAllDates();
		echo json_encode($lesDates);
	}

	// requête POST localhost/gedimagination/WebService
	function postPhoto()
	{
		$json = file_get_contents('php://input');
		if (!empty($json)) { 
			$obj = json_decode($json);
			foreach ($obj as $photo)
			{
				if (array_key_exists("idTicket", $photo)
					&& array_key_exists("idPhoto", $photo)
					&& array_key_exists("rating", $photo)
					&& array_key_exists("dateVote", $photo))
				{
					$idTicket = $photo->idTicket;
					$idPhoto = $photo->idPhoto;
					$rating = $photo->rating;
					$dateVote = $photo->dateVote;
					$resultat = DAL_insertVotePhoto($idTicket, $idPhoto, $rating, $dateVote);
					if($resultat == 1)
					{
						header('Content-Type: application/json');
						echo json_encode("Vote ajouté avec succés");
						http_response_code(201);
					}
					else
					{
						header('Content-Type: application/json');
						echo json_encode("Erreur");
						http_response_code(500);
					}
				}
				else
				{
					header('Content-Type: application/json');
					echo json_encode("Missing_field or bad_field");
					http_response_code(422);
				}
			}
		}
		else {
			header('Content-Type: application/json');
			echo json_encode("Body should be a JSON object");
			http_response_code(400);
		}
	}
