<?php
include "config/database.php";
include "repository/taskRepository.php";

session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Vérifier si l'ID est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID manquant !");
}

$id = intval($_GET['id']); // Sécurisation de l'ID
$user_id = $_SESSION['user_id'];

// Récupérer les infos de la tâche

$task = getTasksById($id,$user_id);

if (!$task) {
    die("Tâche introuvable !");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $urgent = isset($_POST["urgent"]) ? 1 : 0;
    $important = isset($_POST["important"]) ? 1 : 0;

    updateTask($name, $description, $urgent, $important, $id, $user_id);
    // $result = updateTask($name, $description, $urgent, $important, $id);
    // var_dump($result);
    // Redirection vers userAccount après mise à jour
    header("Location: userAccount.php");
    exit();
}


$template = "edit";
include "layout.phtml";
