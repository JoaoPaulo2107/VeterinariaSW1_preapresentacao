<?php
// Inicia a sessão para permitir uso de variáveis de sessão
session_start();

// Inclui o arquivo de conexão com o banco
require_once __DIR__ . '/../includes/conexao.php';

// Verifica se todos os campos obrigatórios foram enviados pelo formulário
if (!isset($_POST['nome'], $_POST['telefone'], $_POST['cpf'], $_POST['email'], $_POST['senha'])) {
    echo "Dados incompletos."; // mensagem de erro caso falte algum campo
    exit; // encerra o script
}

// Recebe os valores enviados pelo formulário
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];

// Criptografa a senha usando algoritmo seguro
$senhaHash = password_hash($_POST['senha'], PASSWORD_DEFAULT);

// SQL para inserir um novo usuário no banco
$sql = "INSERT INTO usuario (Nome, Telefone, CPF, Email, Senha)
        VALUES (:nome, :telefone, :cpf, :email, :senha)";

// Prepara a query para evitar SQL Injection
$stmt = $pdo->prepare($sql);

// Faz a ligação dos parâmetros com os valores recebidos
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':telefone', $telefone);
$stmt->bindParam(':cpf', $cpf);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senhaHash);

// Executa o comando SQL
if ($stmt->execute()) {

    // Pega o ID do usuário recém-inserido (auto increment)
    $idInserido = $pdo->lastInsertId();

    // Gera um novo ID de sessão para evitar sequestro de sessão
    session_regenerate_id(true);

    // Salva dados principais do usuário na sessão
    $_SESSION['usuario_id'] = $idInserido;
    $_SESSION['usuario_nome'] = $nome;
    $_SESSION['usuario_email'] = $email;

    // Redireciona para a página de sucesso
    header("Location: ../cadastro_sucesso.php");
    exit; // garante que o script pare aqui
} else {
    // Caso o INSERT falhe
    echo "Erro ao cadastrar usuário.";
    exit;
}
?>
    
    