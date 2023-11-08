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
        $conexao = (new Conexao())->getPDO();
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":nome", $nome, \PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, \PDO::PARAM_STR);
        $stmt->bindValue(":senha", $senha, \PDO::PARAM_STR);
        $resultado=$stmt->execute();

        if ($resultado) {
            echo json_encode(['status' => true, 'msg' => 'Registro inserido com sucesso']);
        } else {
            //retorna o erro do banco
            //perguntar para o cabeça como retornar o erro pdo
            echo json_encode(['status' => false, 'msg' => 'Erro!']);
        }
    } else
        echo json_encode(['status' => false, 'msg' => $mensagem]);
} else {

    //ver em https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
    header("HTTP/1.1 401 Not Allowed");
}