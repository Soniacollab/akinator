<?php

require_once "config/database.php";
require_once "repository/usersRepository.php";



if(!empty($_POST)){
    $regex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    $mail ="/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/
";
    try{
        
         if(preg_match($regex, $_POST["password"]) && preg_match($mail, $_POST["email"])){
        $password  = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $email = $_POST["email"];
        $username = $_POST["username"];
        
        insertData($username,$email,$password);
         header("Location: login.php");
        exit();
        
    }else{
        
         throw new Exception("Format incorrecte");
        }
    }catch(Throwable $e){
            $error = $e->getMessage();
        }
   
        
}


$template = "register";
include "layout.phtml";