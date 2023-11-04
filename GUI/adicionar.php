<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/sistemaCRUDCabeca/GUI/css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Adicionar Usuário</h1>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>
        <div class="mb-3">
            <label for="confirmarSenha" class="form-label">Confirmar Senha</label>
            <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" required>
        </div>
        <button type="button" class="btn btn-primary" onclick="gravar()">Adicionar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </div>


    <div class="modal" id='modal' tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sistema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="msgRetorno"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <div class="tipo-msg me-1"></div>
                <strong class="me-auto">Bootstrap</strong>
                <small id='hora'></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
       
        const toastLiveExample = document.getElementById('liveToast');
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample, {
            delay: 5000
        });
        
        
        const myModal = new bootstrap.Modal('#modal');

        function limparCampos(){
            document.getElementById('nome').value="";
            document.getElementById('email').value="";
            document.getElementById('senha').value="";
            document.getElementById('confirmarSenha').value="";
        }

        async function gravar() {
            //quando utlizo o # pego o id do elemento
            //quando utlizo o [name="nome"] pego o name do elemento
            //quando utlizo o . pego o elemento pela classe

            let formData = new FormData();
            formData.append('nome', document.querySelector(`#nome`).value);
            formData.append('email', document.querySelector(`#email`).value);
            formData.append('senha', document.querySelector(`#senha`).value);
            formData.append('confirmarSenha', document.querySelector(`#confirmarSenha`).value);

            let resposta = await fetch('http://localhost/sistemaCRUDCabeca/API/api-adicionar.php', {
                method: "POST",
                body: formData
            });

            resposta = await resposta.json();

            if (resposta.status) {    //deu certo // se resposta.status==true
                document.querySelector('.tipo-msg').classList.remove('msg-error');
                limparCampos();
            } else {  //deu errado
                document.querySelector('.tipo-msg').classList.add('msg-error');
            }

            document.querySelector('#msgRetorno').innerHTML = resposta.msg;
            document.querySelector('.toast-body').innerHTML = resposta.msg;
            document.querySelector('#hora').innerHTML = (new Date()).toLocaleTimeString();
            
            // myModal.show();
            toastBootstrap.show();
        }
    </script>
</body>

</html>