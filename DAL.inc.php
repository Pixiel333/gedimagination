<?php

function connexionBase() {
    //$hote='mysql:host=10.0.0.59;port=3306;dbname=gedimanigation';
    //$utilisateur='user'; 
    //$mot_passe='123456789'; 
    $hote='mysql:host=localhost;port=3306;dbname=gedimanigation';
    $utilisateur='root'; 
    $mot_passe='';
    try {
        $connexion = new PDO($hote, $utilisateur, $mot_passe);
        $connexion->exec("set names utf8");
        $connexion->exec("SET CHARACTER SET utf8");
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

function dateConcours()
{
    try {
        $connexion=connexionBase();
        $requete = 'SELECT date_debut_insc, date_fin_insc FROM date'; 
        $prep = $connexion->prepare($requete);
        $prep->execute();
        $result = $prep->fetch();
        return $result;
    }
    catch (Exception $e) {
        echo $e->getMessage();
    } 
}

function participants() 
{
    try {
        $connexion=connexionBase();
        $requete = 'SELECT email FROM photo'; 
        $prep = $connexion->prepare($requete);
        $prep->execute();
        $result = $prep->fetchAll();
        return $result;
    }
    catch (Exception $e) {
        echo $e->getMessage();
    } 
}