<?php
$senha = '123'; // Sua senha aqui
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo $hash;
?>