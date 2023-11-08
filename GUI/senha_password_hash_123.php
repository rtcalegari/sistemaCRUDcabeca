PARA INSERIR UM REGISTRO NO BANCO UTILIZE ESSE
PROGRAMINHA EM PHP PARA GERAR A SENHA, DEPOIS
COPIE A SENHA GERADA E COLE NO CAMPO SENHA 
QUANDO FOR INSERIR UM REGISTRO NA TABELA USUÁRIO

<?php
$senha = '123'; // Sua senha aqui
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo $hash;
?>

Então nesse caso, seria assim:
INSERT INTO usuarios (nome, email, senha) VALUES ('Reginaldo', 'rtcalegari@hotmail.com', '$2y$10$odgRUWPF8salpnWRgBt7geCKsMO8hUFHfKDp7ojuWuHP0gENZonOi');
