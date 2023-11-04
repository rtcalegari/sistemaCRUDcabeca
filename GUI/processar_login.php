<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    include_once 'conexao.php';

    // Consulta SQL para verificar as credenciais do usuário
    $query = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $nome, $hashedSenha);
            $stmt->fetch();
            
            // Verifique se a senha inserida corresponde ao hash no banco de dados
            if (password_verify($senha, $hashedSenha)) {
                // Login bem-sucedido, armazene informações na sessão
                $_SESSION['id'] = $id;
                $_SESSION['nome'] = $nome;
                
                header("Location: index.php"); // Redireciona para a página principal após o login
                exit;
            } else {
                $_SESSION['login_erro'] = "Senha incorreta.";
                header("Location: login.php"); // Redireciona de volta para a página de login com uma mensagem de erro
                exit;
            }
        } else {
            $_SESSION['login_erro'] = "Usuário não encontrado.";
            header("Location: login.php"); // Redireciona de volta para a página de login com uma mensagem de erro
            exit;
        }
        
        $stmt->close();
    } else {
        $_SESSION['login_erro'] = "Erro na consulta ao banco de dados.";
        header("Location: login.php"); // Redireciona de volta para a página de login com uma mensagem de erro
        exit;
    }
} else {
    header("Location: login.php"); // Redireciona de volta para a página de login se não for uma solicitação POST
    exit;
}
?>
