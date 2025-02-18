<?php

function getConnexion():object
{
    $pdo = new PDO('mysql:host=db.3wa.io;port=3306;dbname=sokhnandione_akinator;charset=utf8', 'sokhnandione', '70c3e4957990314c0d1f5b8bca4512e1');
    
    return $pdo;
}
