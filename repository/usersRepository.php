<?php 
function getUsers(): array|bool
{
        $pdo = getConnexion();
        
        //préparation de la requête
        $query = $pdo->prepare('SELECT * FROM users');
        
        //exécution de la requête
        $query->execute();
        
        //récupération des données
        $users = $query->fetchAll();
        
        return $users;
}
function getUserByEmail(string $email): array|bool
{
        $pdo = getConnexion();
        
        //préparation de la requête
        $query = $pdo->prepare('SELECT * FROM users WHERE email=?');
        
        //exécution de la requête
        $query->execute([$email]);
        
        //récupération des données
        $user = $query->fetch();
        
        return $user;
}

function insertData(string $username, string $email, string $password): array|bool
{
    $user = getUserByEmail($email);
    if ($user) {
        throw new Exception("Cet email est déjà utilisé.");
    }

    $pdo = getConnexion();
    
    
    $query = $pdo->prepare("INSERT INTO users (username, email, password, registration_date) VALUES (?, ?, ?, ?)");
    
    // Exécuter la requête
    $query->execute([$username, $email, $password, $date]);
    
    // Récupérer les données de l'utilisateur
    $newData = $query->fetch();
    
    return $newData;
}

function getUserById(int $id): array|bool
{
    $pdo = getConnexion();
    
    // Préparer la requête pour récupérer l'utilisateur par son ID
    $query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    
    // Exécuter la requête
    $query->execute([$id]);
    
    // Récupérer les données de l'utilisateur
    $user = $query->fetch();
    
    return $user;
}

function deleteUserById(int $id): bool
{
    $pdo = getConnexion();
    
    // Préparer la requête de suppression
    $query = $pdo->prepare("DELETE FROM users WHERE id = ?");
    
    // Exécuter la requête
   return  $query->execute([$id]);
    
    
}

function updatePasswordById(string $password, int $id) : bool{
    $pdo = getConnexion();
    
    $query = $pdo->prepare("UPDATE users SET password = ? WHERE id = ? ");
    
    return $query->execute([$password, $id]);
    
}
