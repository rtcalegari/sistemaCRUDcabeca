<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form action="processar_login.php" method="POST" class="p-3 border rounded" style="max-width: 300px;">
            <h1 class="mb-4">Login</h1>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
            <div>
                <?php
                    session_start();
                    // Verificar se $_SESSION['login_erro'] está definida
                    if (isset($_SESSION['login_erro'])) {
                        echo '<div class="erro">' . $_SESSION['login_erro'] . '</div>';
                        unset($_SESSION['login_erro']); // Limpa a variável de sessão de erro após exibi-la
                    }
                ?>
            </div>
        </form>
    </div>
</body>
</html>

