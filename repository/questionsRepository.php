<?php


function getQuestions(): array
{
    
    $pdo = getConnexion();
    
    $query = $pdo->prepare('SELECT * FROM questions ORDER BY question_order ASC');
    
    $query->execute();
    
    $questions = $query->fetchAll();
    
    return $questions;
}

// Fonction pour récupérer une question par son ID
function getQuestionById(int $id)
{
    $pdo = getConnexion();
    
    $query = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
    
    $query->execute([$id]);
    
    $question = $query->fetch();
    
    return $question;
}


// Fonction pour récupérer les réponses d'une question donnée
function getAnswersByQuestionId(int $question_id): array|bool
{
    $pdo = getConnexion();

    // Préparer la requête pour récupérer toutes les réponses pour une question donnée
    $query = $pdo->prepare("SELECT * FROM answers WHERE question_id = ?");
    
    // Exécuter la requête
    $query->execute([$question_id]);

    // Récupérer toutes les réponses associées
    $answers = $query->fetchAll();

    return $answers;
}

