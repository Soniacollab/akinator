<?php

require_once "config/database.php";
require_once "repository/usersRepository.php";


//démarrage du système de session
session_start();
 
//si le form a été soumis ($_POST n'est pas vide)
if(!empty($_POST)){
    
    
    $user = getUserByEmail($_POST["email"]);
    
    try{
       
         //si l'utilisateur a saisi les bons identifiants et mots de passe
    if($user && password_verify($_POST["password"],$user["password"])){
         var_dump($user);
        
        // // //création d'une session
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user"] = $user["email"];
        $_SESSION["username"] = $user["username"];
    
         
        //redirection vers la page top secrète
        header("Location: userAccount.php");
        exit;
    
    }else{
        
         throw new Exception("Identifiant ou mot de passe incorrect");
        }
        
   
    }catch(Throwable $e){
            $error = $e->getMessage();
        }
 
}
   

if(isset($_SESSION['user'])){
    header("Location: userAccount.php");
    exit;
}


$template = "login";
include "layout.phtml";