<?php
require_once "config/database.php";
require_once "repository/resultsRepository.php";
require_once "repository/gameRepository.php";

session_start();

// Vérifier si l'ID du résultat via l'URL
if (isset($_GET['result_id'])) {
    $resultId = $_GET['result_id'];
    
    // Appel à la fonction pour récupérer le résultat
    $result = getResultById($resultId);
    
    // Récupérer les résultats de l'utilisateur
 $gameData = createGame($_SESSION['user_id'],$resultId);
 
 
    
    if (!$result) {
        
        // Si le résultat n'existe pas, on affiche un message d'erreur
        $error = "Résultat non trouvé.";
    }
    
} else {
    // Si aucun ID de résultat n'est passé
    $error = "Aucun résultat trouvé.";
}


$template = "resultat";
include 'layout.phtml';

