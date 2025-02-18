<?php

function leaderboard(): array|bool
{
    $pdo = getConnexion();
    
    // Préparer la requête pour récupérer les utilisateurs et leurs tâches complétées
    $query = $pdo->prepare("
        SELECT username, COUNT(task.id) AS nb 
        FROM users
        LEFT JOIN task ON users.id = task.user_id
        GROUP BY users.id
        ORDER BY nb DESC
    ");
    
    // Exécuter la requête
    $query->execute();
    
    // Récupérer les résultats
    $leaderboard = $query->fetchAll();
    
    return $leaderboard;
}
