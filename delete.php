<?php
include "config/database.php";
include "repository/taskRepository.php";
include('session_start.php'); 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo ("ID manquant !");
}

// Sécuriser l'id
$id = intval($_GET["id"]);
$user_id = $_SESSION['user_id'];

//Supprimer la tache
if(deleteTaskById($id,$user_id)){
    var_dump("Suppression réussie");
    header("Location: userAccount.php");
    exit();
    
}else{
    echo("Erreur lors de la suppression de la tache");
}


