<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bancoCRUD";

// Crie uma conex�o com o banco de dados
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Verifique a conex�o
if ($mysqli->connect_error) {
    die("Erro na conex�o com o banco de dados: " . $mysqli->connect_error);
}
?>
