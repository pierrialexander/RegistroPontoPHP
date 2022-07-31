<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'celke_ponto';
$port = 3306;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);
    echo 'Conexão efetuada com sucesso!';
} catch (PDOException $e) {
    echo 'Erro com a conexão ao banco de dados! ' . $e->getMessage();
}