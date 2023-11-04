<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

include_once 'conexão.php';

// Define a quantidade de registros por página
$registrosPorPagina = 10;

// Página atual
if (isset($_GET['pagina'])) {
    $paginaAtual = $_GET['pagina'];
} else {
    $paginaAtual = 1;
}

// Calcula o deslocamento (offset) com base na página atual
$offset = ($paginaAtual - 1) * $registrosPorPagina;

// Consulta SQL para obter registros com paginação
$query = "SELECT * FROM usuarios LIMIT $offset, $registrosPorPagina";
$result = $mysqli->query($query);

// Contagem total de registros
$totalRegistrosQuery = "SELECT COUNT(*) as total FROM usuarios";
$totalRegistrosResultado = $mysqli->query($totalRegistrosQuery);
$totalRegistros = $totalRegistrosResultado->fetch_assoc()['total'];

// Calcula o número total de páginas
$numPaginas = ceil($totalRegistros / $registrosPorPagina);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Lista de Usuários</h1>
        <a href="adicionar.php" class="btn btn-primary mb-3">Adicionar Novo Usuário</a>
        <a href="logout.php" class="btn btn-danger mb-3 float-end">Sair</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="excluir.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Paginação -->
        <nav aria-label="Paginação">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $numPaginas; $i++): ?>
                    <li class="page-item <?php echo ($i == $paginaAtual) ? 'active' : ''; ?>">
                        <a class="page-link" href="listar.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>
</html>
