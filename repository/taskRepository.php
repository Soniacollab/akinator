<?php

function getTasks(int $user_id): array
{
    
    $pdo = getConnexion();
    
    $query = $pdo->prepare('SELECT * FROM task WHERE user_id = ?');
    
    $query->execute([$user_id]);
    
    return $query->fetchAll();
}

function insertTask(string $name, string $description, int $urgent, int $important, int $user_id): bool
{
    
    $pdo = getConnexion();
    
    $query = $pdo->prepare("INSERT INTO task (name, description, urgent, important, user_id) VALUES (?, ?, ?, ?, ?)");
    
    
    return $query->execute([$name, $description, $urgent, $important, $user_id]);
}

function updateTask(string $name, string $description, int $urgent, int $important, int $id, int $user_id): bool
{
    
    $pdo = getConnexion();
    
    $query = $pdo->prepare("UPDATE task SET name = ?, description = ?, urgent = ?, important = ? WHERE id = ? AND user_id = ?");
    
    return $query->execute([$name, $description, $urgent, $important, $id,$user_id]);
}

function deleteTaskById(int $id, int $user_id): bool
{
    
    
    $pdo = getConnexion();
    
    $query = $pdo->prepare("DELETE FROM task WHERE id = ? AND user_id = ?");
    
    return $query->execute([$id, $user_id]);
}

function getTasksById(int $id,  int $user_id)
{
    $pdo = getConnexion();
    
    $query = $pdo->prepare("SELECT * FROM task WHERE id = ? AND user_id = ?");
    
    $query->execute([$id,$user_id]);
    
    return $query->fetch();
}


function markTaskAsDone(int $id): bool
{
    
    $pdo = getConnexion();
    
    $query = $pdo->prepare("UPDATE task SET DONE = 1 WHERE id = ?");
    
    return $query->execute([$id]);
}