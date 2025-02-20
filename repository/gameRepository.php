<?php 

require_once "config/database.php";

// Fonction pour créer une nouvelle partie
function createGame(int $user_id, int $result_id): array|bool
{
    
    
    $pdo = getConnexion();
    
    // Préparer la requête pour créer une nouvelle partie
    
    $date = date('Y-m-d H:i:s');  // La date actuelle en UTC (ou Europe/Paris selon la configuration)
    
    $query = $pdo->prepare("INSERT INTO game (user_id, result_id) VALUES (?, ?)");
    
    // Exécuter la requête
    return $query->execute([$user_id, $result_id]);
    
}

function getResultsByUserId(int $user_id): array|bool {
    $pdo = getConnexion();
    
    // Requête pour récupérer les jeux et leurs résultats associés
    $query = $pdo->prepare("
        SELECT game.id, game.name AS game_name, game.date, results.name AS result_name, results.description, results.visuel
        FROM game
        INNER JOIN results ON game.result_id = results.id
        WHERE game.user_id = ?
        ORDER BY game.date DESC
    ");
    
    $query->execute([$user_id]);
    
    return $query->fetchAll();
}

function deleteGameLogById(int $id, int $user_id): bool
{
    
    
    $pdo = getConnexion();
    
    $query = $pdo->prepare("DELETE FROM game WHERE id = ? AND user_id = ?");
    
    return $query->execute([$id, $user_id]);
}


