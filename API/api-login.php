<?php

//O include_once é semelhante ao include, mas ele verifica se o arquivo já foi incluído antes no script.
// Se o arquivo já foi incluído, o PHP não o incluirá novamente.
// Evitar a inclusão repetida de arquivos pode melhorar o desempenho do seu aplicativo. 
//Incluir o mesmo arquivo várias vezes pode resultar em uma sobrecarga desnecessária de memória e tempo de execução.


//_DIR__ é uma constante mágica no PHP que representa o diretório do arquivo atual (o arquivo que contém essa linha de código).
// Ela retorna o caminho absoluto do diretório onde o arquivo está localizado.

//o uso de __DIR__ é uma prática recomendada, pois garante que o caminho seja sempre resolvido com base no diretório do script atual,
// independentemente de onde o script seja executado. Isso torna o código mais portátil e menos suscetível a erros de caminho, 
// especialmente quando você move ou compartilha seu código em diferentes ambientes.

/*Qual a difereça entre include_once e require_once?
As principais diferenças entre include_once e require_once em PHP estão relacionadas ao comportamento 
em caso de falha na inclusão do arquivo e ao tratamento de erros. Ambas são construções que permitem 
incluir arquivos em um script PHP, mas diferem nas seguintes maneiras:


include_once: Se o arquivo não puder ser incluído (por exemplo, se o arquivo não existir), 
o PHP emitirá um aviso (warning) e continuará a execução do script. Isso significa que o script não 
será interrompido e continuará a ser executado.

require_once: Se o arquivo não puder ser incluído, o PHP emitirá um erro fatal (fatal error) e 
interromperá a execução do script imediatamente. Isso torna o require_once mais rígido em relação 
à inclusão de arquivos e é geralmente usado quando a inclusão do arquivo é crítica para o
 funcionamento do script.

*/
include_once __DIR__ . '/conexao.php';

// verifica o método HTTP usado para acessar a página atual. 
//Essa condição é comumente usada para lidar com dados enviados por meio de um 
//formulário HTML usando o método HTTP POST.

/*
    $_SERVER: É uma superglobal em PHP que contém informações do servidor web, incluindo detalhes sobre
     a solicitação HTTP, como método, cabeçalhos e outras informações relacionadas à requisição.

    ["REQUEST_METHOD"]: Isso acessa a chave "REQUEST_METHOD" no array $_SERVER, que contém o método 
    HTTP usado na solicitação atual.

    == "POST": Isso verifica se o método HTTP usado na solicitação é igual a "POST". O método "POST" 
    é usado para enviar dados de um formulário HTML para o servidor.
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $mensagem = "";

    if (empty($email)) {
        $mensagem = 'O campo email é obrigatório!';
    }
    if (empty($senha)) {
        $mensagem = 'O campo senha é obrigatório!';
    }

    if (empty($mensagem)) {
        // Consulta SQL para verificar as credenciais do usuário
        $conexao = (new Conexao())->getPDO();
        $query = "SELECT id, nome, senha FROM usuarios WHERE email = :email";
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(":email", $email, \PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch();
        //  var_dump($resultado);
        //  exit;

        if (!empty($resultado)) {

            /*
             password_verify: password_verify é uma função integrada do PHP que é usada em conjunto com
              funções de hashing seguras, como password_hash. Essa função foi projetada especificamente
              para verificar senhas em um formato seguro e resistente a ataques. Ela compara uma senha 
              fornecida pelo usuário com um hash de senha previamente armazenado.
            
            Exemplo de uso do password_verify com password_hash:

                Para armazenar a senha:  
                    $senha = 'minha_senha';
                    $hash = password_hash($senha, PASSWORD_BCRYPT);
                    // Armazene o $hash no banco de dados

                Para verificar a senha:
                    $senhaInserida = 'senha_inserida_pelo_usuario';
                    $hashArmazenado = 'hash_previamente_armazenado';
                    if (password_verify($senhaInserida, $hashArmazenado)) {
                        // A senha está correta
                    } else {
                        // A senha está incorreta
                    }
                O password_hash gera hashes seguros usando algoritmos de hash de senha, como o Bcrypt,
                que são projetados para serem resistentes a ataques. O password_verify verifica se a senha
                inserida pelo usuário corresponde ao hash armazenado.    

                Em resumo, MD5 e password_verify são conceitos muito diferentes. Use password_hash e 
                password_verify para armazenar e verificar senhas de forma segura, evitando o uso de 
                MD5 ou outros algoritmos de hash inseguros.
            
              */

            // Verifique se a senha inserida corresponde ao hash no banco de dados
            if (password_verify($senha, $resultado->senha)) {

                //json_encode é uma função em PHP que converte dados de PHP em uma 
                //representação JSON (JavaScript Object Notation). JSON é um formato de intercâmbio 
                //de dados leve e legível por humanos que é amplamente utilizado em aplicativos web 
                //e em muitos outros contextos para transmitir dados estruturados.

                //A função json_encode é usada para converter arrays e objetos do PHP em uma string JSON. 
                //Aqui está um exemplo de uso típico:

                /*
                    $dados = array(
                        'nome' => 'João',
                        'idade' => 30,
                        'cidade' => 'São Paulo'
                    );
                
                $json = json_encode($dados);

                echo $json;


                Neste exemplo, a variável $dados contém um array associativo com informações, 
                e json_encode é usado para convertê-lo em uma string JSON. O resultado será algo como:    

                {"nome":"João","idade":30,"cidade":"São Paulo"}
                

                A função json_encode permite que você converta dados complexos, como arrays multidimensionais
                 ou objetos, em representações JSON. Isso é útil ao transmitir dados de um servidor para um 
                 cliente ou ao trabalhar com APIs que esperam dados no formato JSON.

                Além disso, o PHP também fornece a função json_decode, que faz o oposto de json_encode: 
                    ela converte uma string JSON em uma estrutura de dados do PHP (array ou objeto), 
                    permitindo que você processe e trabalhe com os dados JSON em seu código PHP.

                */    

                echo json_encode(
                    [
                        'status' => true,
                        'resposta' => [
                            'mensagem' => 'Login efetuado com sucesso',
                            'idusuario' => $resultado->id,
                            'nome' => $resultado->nome
                        ]
                    ]
                );
            } else {
                echo json_encode(['status' => false, 'msg' => "Senha incorreta."]);
            }
        } else {

            echo json_encode(['status' => false, 'msg' => "Usuário não encontrado."]);
        }
    }
}
