<?php

include_once "config/database.php";
include_once "repository/usersRepository.php";
include_once "repository/questionsRepository.php";
include_once "repository/gameRepository.php";
include_once "repository/resultsRepository.php";


session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
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


// Récupérer les données de l'utilisateur
$user = getUserById($_SESSION['user_id']);  // Cette fonction doit être définie pour récupérer l'utilisateur par son ID

// Si l'utilisateur n'existe pas
if (!$user) {
    header("Location: login.php");
    exit();
}

$gameData = getResultsByUserId($_SESSION['user_id']);




date_default_timezone_set('Europe/Paris');

// Récupérer la date d'inscription de l'utilisateur
// Créer un objet DateTime à partir de l'heure UTC stockée
$date = new DateTime($user['registration_date'], new DateTimeZone('UTC'));

// Convertir l'heure à Paris (Europe/Paris)
$date->setTimezone(new DateTimeZone('Europe/Paris'));

// Afficher la date ajustée
$date = $date->format('d/m/Y à H:i');






// Vérifier si le formulaire a été soumis
if(!empty($_POST)) {
    
    $user = getUserById($_SESSION['user_id']);
    $regex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    
    try{
       
         //si l'utilisateur a saisi les bons identifiants et mots de passe
    if(password_verify($_POST["current_password"],$user["password"])){
        
        if(preg_match($regex, $_POST["new_password"])){
         
        
        //Hacher le nouveau mot de passe
        $newpassword  = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
        
         updatePasswordById($newpassword, $_SESSION['user_id']);
        
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




if(isset($_SESSION['user'])){

    $template = "userAccount";
    include "layout.phtml";
    
}
else{
    header("Location: login.php");
    exit;
}