<?php
    include_once('DAL.inc.php');
    function DAL_getAllPhotos()
	{
        try {
            $connexion = connexionBase();
            $requete = 'SELECT id, titre, description, date, chemin_photo FROM PHOTO';
            $prep = $connexion->prepare($requete);
            $prep->execute();
            $result = $prep->fetchAll();
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
            $requete = 'SELECT * FROM date';
            $prep = $connexion->prepare($requete);
            $prep->execute();
            $result = $prep->fetch();
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
                //(a voir)
				break;
				
			case 'PUT':
				// TODO
				break;
				
			case 'DELETE':
				// TODO
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
