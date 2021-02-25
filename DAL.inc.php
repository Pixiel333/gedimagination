<?php

function connexionBase() {
    $hote='mysql:host=10.0.0.59;port=3306;dbname=gedimanigation'; 
    $utilisateur='user'; 
    $mot_passe='123456789'; 
    try {
        $connexion = new PDO($hote, $utilisateur, $mot_passe);
        $connexion->exec("set names utf8");
        return $connexion;
    }
    catch(PDOException $e) {
        echo 'Connexion impossible';
    }
}

function insert_bdd($titre, $date, $description, $chemin_photo, $email)
{ 
    try {
        $connexion=connexionBase();
        $requete = 'INSERT INTO photo(titre, description, date, chemin_photo, email) VALUES(:titre, :description, :date, :chemin_photo, :email)'; 
        $prep = $connexion->prepare($requete);
        $prep->bindValue(':titre', $titre);
        $prep->bindValue(':date', $date);
        $prep->bindValue(':description', $description);
        $prep->bindValue(':chemin_photo', $chemin_photo);
        $prep->bindValue(':email', $email);
        $ok = $prep->execute();
        return $prep->rowCount();
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }  
}