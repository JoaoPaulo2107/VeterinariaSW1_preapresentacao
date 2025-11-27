<?php
// Inicia a sessão — precisa estar na primeira linha
session_start();

// Conexão com o banco de dados
require_once __DIR__ . '/../includes/conexao.php';

// Verifica se o formulário enviou os campos necessários
if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: ../login_falha.php');
    exit;
}

$email = trim($_POST['email']);
$senhaDigitada = $_POST['senha'];

// Prepara a consulta protegida contra SQL Injection
$sql = "SELECT 
            ID_usuario AS id, 
            Nome AS nome, 
            Email AS email, 
            Senha AS senha
        FROM usuario
        WHERE Email = :email
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o usuário existe e se a senha está correta
if ($usuario && password_verify($senhaDigitada, $usuario['senha'])) {

    // Regenera o ID da sessão para segurança
    session_regenerate_id(true);

    // Guarda dados do usuário na sessão
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['usuario_email'] = $usuario['email'];

    // Se for o admin, manda pra dashboard do admin
    if (strtolower($usuario['email']) === 'admin@vet.com') {
        header('Location: ../dashboard_adm.php');
        exit;
    }

    // Se for usuário comum, manda pra dashboard padrão
    header('Location: ../dashboard_cliente.php');
    exit;
}

// Se chegar aqui, login falhou
header('Location: ../login_falha.php');
exit;
?>
