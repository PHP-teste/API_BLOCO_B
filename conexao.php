<?php
$host = 'localhost';
$dbname = 'api_bloco_b';
$username = 'root'; 
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
?>