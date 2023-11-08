<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">

        <h1 class="mb-4">Login</h1>
        <p>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>
        <button type="button" class="btn btn-primary" onclick=logar()>Entrar</button>

    </div>

    <!-- Toast (Notificação Flutuante): O toast é invisível por padrão e é ativado com JavaScript 
    quando necessário.
        -->
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
            //tempo de duração do toast
            delay: 5000
        });



        function limparCampos() {
            document.getElementById('email').value = "";
            document.getElementById('senha').value = "";
        }


        /*async: A palavra-chave async é usada para criar funções assíncronas em JavaScript. 
        Funções assíncronas permitem que você escreva código que lida com operações assíncronas, 
        como solicitações de rede, de uma maneira mais conveniente e legível. O código dentro de 
        uma função assíncrona é executado de forma assíncrona, o que significa que ele pode esperar
         por tarefas assíncronas sem bloquear a execução do programa. */
        
         async function logar() {

            //quando utlizo o # pego o id do elemento
            //quando utlizo o [name="nome"] pego o name do elemento
            //quando utlizo o . pego o elemento pela classe

            //cria uma instância de um objeto FormData em JavaScript.
            // O FormData é um objeto que é usado principalmente para coletar dados de um formulário HTML 
            //de maneira programática e prepará-los para serem enviados por meio de uma solicitação HTTP, como uma solicitação POST.
            let formData = new FormData();

            //append é um método de FormData que é usado para adicionar pares chave-valor aos dados a serem enviados.
            formData.append('email', document.querySelector(`#email`).value);
            formData.append('senha', document.querySelector(`#senha`).value);

            //os dados do formulário (email e senha) serão enviados para o URL http://localhost/sistemaCRUDCabeca/API/api-login.php 
            //como parte da solicitação POST. O servidor pode, então, processar esses dados e responder de acordo.
            let resposta = await fetch('http://localhost/sistemaCRUDCabeca/API/api-login.php', {
                method: "POST",
                body: formData
            });

            //A linha de código resposta = await resposta.json();
            // é usada para converter a resposta de uma solicitação HTTP (geralmente no formato JSON) em um objeto JavaScript 
            // que pode ser facilmente manipulado no seu código.
            //await: A palavra-chave await é usada em uma função assíncrona
            // (geralmente marcada com async) para pausar a execução até que a promessa seja resolvida. 
            //Isso é comum quando se faz uma solicitação assíncrona, como com o fetch, onde você está aguardando a resposta da solicitação.

            //resposta.json(): Isso é um método do objeto Response retornado pelo fetch. Ele é usado para extrair os dados do corpo da resposta (que geralmente estão no formato JSON) e convertê-los em um objeto JavaScript.
            //resposta é a variável que armazena a resposta da solicitação fetch.
            //.json() é um método que converte o conteúdo da resposta em um objeto JavaScript. O conteúdo da resposta deve estar no formato JSON válido para que esse método funcione corretamente.

            resposta = await resposta.json();

            //resposta = ...: Após a execução bem-sucedida de await resposta.json(), 
            //a variável resposta é atualizada com o objeto JavaScript resultante da conversão.
            //Agora, você pode acessar e manipular os dados da resposta em formato de objeto JavaScript.

            //Por exemplo, se a resposta da solicitação HTTP for um objeto JSON com campos como status e msg, você pode acessá-los da seguinte forma:
            /*
            if (resposta.status) {
                // Acessa o campo 'status' da resposta
                // Faça algo se 'status' for verdadeiro
            } else {
                // Acessa o campo 'status' da resposta
                // Faça algo se 'status' for falso
            }

            // Acessa o campo 'msg' da resposta
            const mensagem = resposta.msg;
            */

            if (resposta.status) { //deu certo // se resposta.status==true

                /*
                document.querySelector() para selecionar o primeiro elemento no documento HTML que tem 
                a classe CSS .tipo-msg. Isso significa que ele está selecionando um elemento HTML com 
                essa classe.

                .classList: A propriedade classList permite acessar e manipular as classes CSS de um
                 elemento HTML. Ela fornece vários métodos, como add, remove, toggle, entre outros,
                  para adicionar ou remover classes.

                .remove('msg-error'): Neste caso, o método remove é chamado na lista de classes do 
                elemento selecionado. Ele remove a classe msg-error do elemento.

                */

                document.querySelector('.tipo-msg').classList.remove('msg-error');
                limparCampos();

                formData = new FormData();
                //A parte resposta.resposta.idusuario está acessando o campo "idusuario" no objeto resposta.resposta, 
                //que é uma estrutura de dados retornada de uma solicitação anterior. 
                formData.append('idusuario', resposta.resposta.idusuario);
                formData.append('nome', resposta.resposta.nome);
                
                //aqui enviamos o id do usuario e o nome para criar uma função
                //como o arquivo cria-sessao.php apenas cria a sessão, não precisamos da resposta 
                respostaSession = await fetch('http://localhost/sistemaCRUDCabeca/GUI/cria-sessao.php', {
                    method: "POST",
                    body: formData
                });

                // não precisamos da linha: respostaSession = await respostaSession.json();
                
                //A linha de código window.open("index.php"); é usada para abrir uma nova
                // janela ou guia do navegador e carregar o arquivo "index.php" nessa nova janela ou guia.
                window.open("index.php");

            } else { //deu errado
                document.querySelector('.tipo-msg').classList.add('msg-error');
            }

            document.querySelector('#msgRetorno').innerHTML = resposta.msg;
            document.querySelector('.toast-body').innerHTML = resposta.msg;
            document.querySelector('#hora').innerHTML = (new Date()).toLocaleTimeString();


            toastBootstrap.show();
        }
    </script>
</body>

</html>