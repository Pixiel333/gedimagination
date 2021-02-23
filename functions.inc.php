<?php

function connexionBase() {
    $hote='mysql:host=localhost;port=3306;dbname=gedimanigation'; 
    $utilisateur='root'; 
    $mot_passe=''; 
    try {
        $connexion = new PDO($hote, $utilisateur, $mot_passe);
        $connexion->exec("set names utf8");
        return $connexion;
    }
    catch(PDOException $e) {
        throw new Exception('Connexion impossible');
    }
}

function insert_bdd()
{
    if (isset($_POST['titre']) && isset($_POST['date']) && isset($_POST['image']) && isset($_POST['description']))
    {
        $titre = htmlspecialchars($_POST['titre']);
        
        try {
			$connexion=connexionBase();
			$requete = 'INSERT INTO photo(titre, date, description, chemin_photo) VALUES(:titre, :date,:description,:chemin_photo)'; 
			$prep = $connexion->prepare($requete);
			$prep->bindValue(':titre', $isbn);
			$prep->bindValue(':date', $titre);
			$prep->bindValue(':descrption', $annee);
			$prep->bindValue(':chemin_photo', $auteur);
			$ok =$prep->execute();
			return $prep->rowCount();
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
    }
}