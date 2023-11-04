<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

include_once 'conexao.php';

$id = $_GET['id'];
$query = "DELETE FROM usuarios WHERE id=$id";

if ($mysqli->query($query) === TRUE) {
    header("Location: index.php");
} else {
    echo "Erro ao excluir registro: " . $mysqli->error;
}
?>
