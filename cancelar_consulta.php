<?php
// Inicia a sessão pra garantir que o cliente logado seja identificado
session_start();

// Puxa a conexão com o banco de dados
require_once "includes/conexao.php";

//verifica se vieram todos os dados do formulário
// (id da consulta e o motivo do cancelamento)
if (!isset($_POST['id_consulta'], $_POST['motivo'])) {
    // Se estiver faltando algo, para e mostra uma mensagem de erro
    die("Erro: Dados incompletos.");
}

// Pega os valores enviados pelo formulário
$id = $_POST['id_consulta'];
$motivo = $_POST['motivo'];

try {
    // SQL pra atualizar o status da consulta e registrar o motivo do cancelamento
    $sql = "UPDATE consulta
            SET status = 'Cancelado pelo Cliente',
                motivo_cancelamento = :motivo
            WHERE id_consulta = :id"; // <-- Atualiza só a consulta que o cliente escolheu (ALTERADO AQUI)

    // Prepara o comando pra evitar SQL Injection
    $stmt = $pdo->prepare($sql);

    // Executa a query passando os valores
    $stmt->execute([
        ':motivo' => $motivo,
        ':id' => $id
    ]);

    // Se deu tudo certo, volta pra dashboard do cliente com uma mensagem
    header("Location: dashboard_cliente.php?msg=cancelado");
    exit;

} catch (PDOException $e) {
    // Se der algum erro na execução ou no banco, mostra o erro na tela
    die("Erro: " . $e->getMessage());
}
?>
