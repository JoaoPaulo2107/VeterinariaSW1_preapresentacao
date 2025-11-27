<?php
// conexão banco 
require_once __DIR__ . '/../includes/conexao.php';

// Verifica se vieram os parâmetros necessários pela URL
if (!isset($_GET['id']) || !isset($_GET['acao'])) {
    // Se faltar algo, volta pro dashboard e aviso o erro
    header('Location: ../dashboard_adm.php?msg=Erro: parâmetros inválidos.');
    exit;
}

// Pego o ID da consulta e a ação (aceitar ou recusar)
$id = $_GET['id'];
$acao = $_GET['acao'];

// Variável pra guardar o novo status da consulta
$status = '';

// Verifico qual ação o admin escolheu e defino o status correspondente
if ($acao === 'aceitar') {
    $status = 'Aceita';
} elseif ($acao === 'recusar') {
    $status = 'Recusada';
} else {
    // Se for uma ação desconhecida, redireciona de volta com mensagem de erro
    header('Location: ../dashboard_adm.php?msg=Ação inválida.');
    exit;
}

try {
    // SQL pra atualizar o status da consulta no banco
    $sql = "UPDATE consulta SET Status = :status WHERE ID_consulta = :id";

    // Prepara o comando SQL pra evitar SQL Injection
    $stmt = $pdo->prepare($sql);

    // Executa a query passando os valores
    $stmt->execute([':status' => $status, ':id' => $id]);

    // Se der tudo certo, volta pro dashboard com uma mensagem de sucesso
    header('Location: ../dashboard_adm.php?msg=Consulta ' . strtolower($status) . ' com sucesso!');
    exit;

} catch (PDOException $e) {
    // Se der erro na execução, redireciona com a mensagem do erro
    header('Location: ../dashboard_adm.php?msg=Erro: ' . urlencode($e->getMessage()));
    exit;
}
?>
