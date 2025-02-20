<?php
session_start();
require_once "config/database.php";
require_once "repository/questionsRepository.php";

// Récupérer la question courante (Là on a récupéré la première question)
$currentQuestionId = isset($_GET['question_id']) ? $_GET['question_id'] : 1;

// Récupérer la question par son id
$currentQuestion = getQuestionById($currentQuestionId);

// Arreter immediatement l'éxecution s'il n'y pas de questions 
if (!$currentQuestion) {
    die("Question introuvable.");
}

// Initialiser $result à null
$result = null;

// Gérer la réponse de l'utilisateur
if (!empty($_POST)) {
    
    // Vérifier si les réponses existent
    if (isset($_POST['answer']) && !empty($_POST['answer'])) {
        
        $answer = $_POST['answer']; // "Oui" ou "Non"
        
        // Récupérer les réponses
        $answers = getAnswersByQuestionId($currentQuestionId);

        // Trouver la réponse correspondante
        $selectedAnswer = null;
        foreach ($answers as $answerItem) {
            if ($answerItem['contenu'] === $answer) {
                $selectedAnswer = $answerItem;
                break;
            }
        }

        // Vérifier si la question actuelle existe d'abord
        if ($selectedAnswer) {
            
            // Vérifier si la question suivante existe 
            if (isset($selectedAnswer['nextquestion_id']) && $selectedAnswer['nextquestion_id'] !== NULL) {
                
                // Redirection vers la question suivante
                $nextQuestionId = $selectedAnswer['nextquestion_id'];
                header("Location: quizz.php?question_id=" . $nextQuestionId);
                exit;
                
            } 
            // Vérifier si le résultat existe avant d'afficher
            elseif (isset($selectedAnswer['result_id']) && $selectedAnswer['result_id'] !== NULL) {
                
                // Redirection vers la page de résultat avec l'id du resultat trouvé
                header("Location: resultat.php?result_id=" . $selectedAnswer['result_id']);
                
               
                exit;
            } 
            else {
                // Erreur si ni nextquestion_id ni result_id ne sont définis
                echo "Erreur : aucune question suivante ni résultat défini pour cette réponse.";
                exit;
            }
            } 
            else {
            echo "Erreur : réponse non trouvée pour cette question.";
            exit;
        }
    } else {
        echo "Veuillez répondre à la question.";
        exit;
    }
}

// Si la session de l'utilisateur existe déja, le rediriger directement vers son compte
if(isset($_SESSION['user'])){

    $template = "quizz";
    include "layout.phtml";
    
}
// Si non on le redirige vers la page de connexion
else{
    header("Location: index.php");
    exit;
}
