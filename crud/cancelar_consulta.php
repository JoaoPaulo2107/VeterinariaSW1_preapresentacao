<?php
// Conecto ao banco de dados
require_once '../includes/conexao.php';

// Inicia a sessão pra identificar o usuário logado
session_start();

// Verifica se o usuário está logado — se não, mando ele pro login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}

// Verifica se vieram os campos necessários do formulário (id da consulta e motivo)
if (isset($_POST['id_consulta'], $_POST['motivo'])) {

    // Guardo os valores enviados
    $id = $_POST['id_consulta'];
    $motivo = $_POST['motivo'];

    try {
        // SQL pra atualizar o status da consulta pra "Cancelada"
        // e salvar o motivo do cancelamento
        $sql = "UPDATE consulta 
                SET Status = 'Cancelada', motivo_cancelamento = :motivo
                WHERE ID_consulta = :id";

        // Prepara a query pra evitar SQL Injection
        $stmt = $pdo->prepare($sql);

        // Executa passando os parâmetros
        $stmt->execute([
            ':motivo' => $motivo,
            ':id' => $id
        ]);

        // Se tudo der certo, volta pra página de consultas com uma mensagem de sucesso
        header('Location: ../consulta.php?msg=Consulta cancelada com sucesso!');
        exit;

    } catch (PDOException $e) {
        // Se der erro no banco ou na execução, mostra o erro na tela
        echo "Erro ao cancelar: " . $e->getMessage();
    }

} else {
    // Se os campos obrigatórios não forem enviados, avisa o usuário
    echo "Campos obrigatórios não informados.";
}
?>
