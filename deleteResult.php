<?php
include "config/database.php";
include "repository/resultsRepository.php";

session_start();

// Si l'utilisateur n'est pas connectée on le redirige vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}



//Supprimer la tache
if(deleteHistoryByUserId($_SESSION['user_id'])){
    header("Location: userAccount.php");
    exit();
    
}else{
    echo("Erreur lors de la suppression de la tache");
}


