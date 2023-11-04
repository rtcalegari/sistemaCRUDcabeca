<?php
include_once __DIR__ . '/conexao.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha

    $mensagem="";

	if (empty($nome)){
        $mensagem='O campo nome é obrigatório!';
    }
    if (empty($email)){
        $mensagem='O campo email é obrigatório!';
    }
    if (empty($_POST['senha'])){
        $mensagem='O campo senha é obrigatório!';
    }
    if (empty($_POST['confirmarSenha'])){
        $mensagem='O campo confirmar senha é obrigatório!';
    }
    if (($_POST['senha']!=$_POST['confirmarSenha'])){
        $mensagem='O campo senha difere do campo confirmar senha!';
    }

    if (empty($mensagem)){
        $query = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

        if ($mysqli->query($query) === TRUE) {
            echo json_encode(['status' => true, 'msg' => 'Registro inserido com sucesso']);
        } else {
            //retorna o erro do banco
            echo json_encode(['status' => false, 'msg' => $mysqli->error]);
        }
    } else
        echo json_encode(['status' => false, 'msg' => $mensagem]);
} else {

    //ver em https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
    header("HTTP/1.1 401 Not Allowed");
}