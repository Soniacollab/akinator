<?php

// Fonction pour récupérer un résultat par son ID
function getResultById(int $result_id): array|bool
{
    $pdo = getConnexion();
    
     // La date actuelle
    $date = date('Y-m-d H:i:s'); 
   

    // Préparer la requête pour récupérer un résultat par son ID
    $query = $pdo->prepare("SELECT * FROM results WHERE id = ?");
    
    // Exécuter la requête
    $query->execute([$result_id]);

    // Récupérer les données du résultat
    $result = $query->fetch();

    return $result;
}

// Fonction pour récupérer tous les résultats
function getAllResults(): array|bool
{
    $pdo = getConnexion();
    
     


    // Préparer la requête pour récupérer tous les résultats
    $query = $pdo->prepare("SELECT * FROM results ORDER BY id ASC");
    
    // Exécuter la requête
    $query->execute();

    // Récupérer toutes les données des résultats
    $results = $query->fetchAll();

    return $results;
}

function deleteHistoryByUserId(int $user_id): bool
{
    
    
    $pdo = getConnexion();
    
    $query = $pdo->prepare("DELETE FROM game WHERE user_id = ?");
    
    return $query->execute([$user_id]);
}


