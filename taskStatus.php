<?php

require_once "config/database.php";
require_once "repository/taskRepository.php";


if (isset($_POST['done'])) {
    
    // Marque la tâche comme terminée
    markTaskAsDone($_POST['task_id']); 
    
    // Redirection après la mise à jour
    header("Location: userAccount.php");  
    exit;
}
