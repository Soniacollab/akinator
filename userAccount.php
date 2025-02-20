<?php

// Démarrer la session
session_start();

include_once "config/database.php";
include_once "repository/usersRepository.php";
include_once "repository/questionsRepository.php";
include_once "repository/gameRepository.php";
include_once "repository/resultsRepository.php";

// Récupérer les données de l'utilisateur par son ID
$user = getUserById($_SESSION['user_id']); 


// Récupérer les résultats de l'utilisateur
$gameData = getResultsByUserId($_SESSION['user_id']);




// Vérifier si le formulaire a été soumis
if(!empty($_POST)) {
    
    // Récupérer les données de l'utilisateur
    $user = getUserById($_SESSION['user_id']);
    
    $regex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    
    try{
        
       //si l'utilisateur a saisi les bons identifiants et mots de passe
        if(password_verify($_POST["current_password"],$user["password"])){
           
           if(preg_match($regex, $_POST["new_password"])){
               
               //Hacher le nouveau mot de passe
               $newpassword  = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
               
               // Remplacer le mot de passe par le nouveau saisi par l'utilisateur
               updatePasswordById($newpassword, $_SESSION['user_id']);
            
              // Détruire la session et rediriger vers la page de connexion
              session_destroy();
              header("Location: login.php");
              exit;
            }else {
                throw new Exception("Le nouveau mot de passe ne respecte pas les critères de sécurité.");
            }
        
        } 
    else{
        
         throw new Exception("Identifiant ou mot de passe incorrect");
        }
        
   
    }catch(Throwable $e){
            $error = $e->getMessage();
        }
}





// Supprimer l'utilisateur si le formulaire de suppression est soumis
if (isset($_POST['delete_account'])) {
    $id = $_SESSION['user_id'];
    
    // Appeler la fonction pour supprimer l'utilisateur
    $result = deleteUserById($id);
    
    // Si la suppression a réussi, déconnecter l'utilisateur et rediriger vers la page de connexion
    if ($result) {
        session_destroy(); // Supprimer la session
        header("Location: login.php"); // Rediriger vers la page de connexion
        exit();
    } else {
        echo "Erreur lors de la suppression du compte. Veuillez réessayer.";
    }
}







// Si la session de l'utilisateur existe déja, le rediriger directement vers son compte
if(isset($_SESSION['user'])){

    $template = "userAccount";
    include "layout.phtml";
    
}
// Si non on le redirige vers la page de connexion
else{
    header("Location: login.php");
    exit;
}