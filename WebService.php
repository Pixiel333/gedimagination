<?php
    include_once('DAL.inc.php');
    function DAL_getAllPhotos() {
        try {
            $connexion = connexionBase();
            $requete = 'SELECT * FROM PHOTO';
            $prep = $connexion->prepare($requete);
            $prep->execute();
            $result = $prep->fetchAll();
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
                getPhotos();
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
	
	// requête GET localhost/APIBiblio/livres
	function getPhotos()
	{
		header('Content-type: application/json');
		$lesPhotos = DAL_getAllPhotos();
		echo json_encode($lesPhotos);
	}