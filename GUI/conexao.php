<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bancoCRUD";

// Crie uma conexão com o banco de dados
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($mysqli->connect_error) {
    die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
}
?>
