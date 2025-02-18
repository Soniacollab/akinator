<?php

include "repository/classementRepository.php";
include "config/database.php";

// Récupérer le classement
$leaderboard = leaderboard();


// Si le classement est vide, afficher un message d'erreur
if (!$leaderboard) {
    $error = "Aucun utilisateur n'a encore complété de tâches.";
}

// Récupérer les positions
$restLeaderboard = array_slice($leaderboard, 3);  // Afficher tout à partir de la 4ème position

$firstPlace = isset($leaderboard[0]) ? $leaderboard[0] : null;
$secondPlace = isset($leaderboard[1]) ? $leaderboard[1] : null;
$thirdPlace = isset($leaderboard[2]) ? $leaderboard[2] : null;

$template = "classement";
include "layout.phtml";
