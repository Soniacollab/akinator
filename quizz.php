<?php
require_once "config/database.php";
require_once "repository/questionsRepository.php";

// Récupérer la question courante (par exemple, la première question)
$currentQuestionId = isset($_GET['question_id']) ? $_GET['question_id'] : 1;

// Récupérer la question par son ID
$currentQuestion = getQuestionById($currentQuestionId);


// Vérifier si la question existe
if (!$currentQuestion) {
    die("Question introuvable.");
}

// Initialiser $result à null
$result = null;

// Gérer la réponse de l'utilisateur
if (!empty($_POST)) {
    if (isset($_POST['answer']) && !empty($_POST['answer'])) {
        $answer = $_POST['answer']; // "Oui" ou "Non"
        $answers = getAnswersByQuestionId($currentQuestionId);

        // Trouver la réponse correspondante
        $selectedAnswer = null;
        foreach ($answers as $answerItem) {
            if ($answerItem['contenu'] === $answer) {
                $selectedAnswer = $answerItem;
                break;
            }
        }

        if ($selectedAnswer) {
            
            if (isset($selectedAnswer['nextquestion_id']) && $selectedAnswer['nextquestion_id'] !== NULL) {
                // Redirection vers la question suivante
                $nextQuestionId = $selectedAnswer['nextquestion_id'];
                header("Location: quizz.php?question_id=" . $nextQuestionId);
                exit;
            } 
            elseif (isset($selectedAnswer['result_id']) && $selectedAnswer['result_id'] !== NULL) {
                
                // Redirection vers la page de résultat
                header("Location: resultat.php?result_id=" . $selectedAnswer['result_id']);
                
               
                exit;
            } 
            else {
                // Gestion d'erreur si ni nextquestion_id ni result_id ne sont définis
                echo "Erreur : aucune question suivante ni résultat défini pour cette réponse.";
                exit;
            }
            } 
            else {
            // Gestion si aucune réponse ne correspond
            var_dump($answer, $answers); // Pour déboguer
            echo "Erreur : réponse non trouvée pour cette question.";
            exit;
        }
    } else {
        echo "Veuillez répondre à la question.";
        exit;
    }
}


$template="quizz";
include 'layout.phtml';
