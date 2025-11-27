<?php
session_start();
require_once "includes/conexao.php";

// Verifica se veio tudo do formulário
if (!isset($_POST['id_consulta'], $_POST['nova_data'], $_POST['novo_horario'])) {
    die("Erro: Dados incompletos.");
}

$id = $_POST['id_consulta'];
$nova_data = $_POST['nova_data'];
$novo_horario = $_POST['novo_horario'];

try {
    // Atualiza a consulta no banco
    $sql = "UPDATE Consulta
            SET Data_consulta = :nova_data,
                Horario = :novo_horario,
                status = 'Reagendado pelo Cliente'
            WHERE ID_consulta = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nova_data', $nova_data);
    $stmt->bindParam(':novo_horario', $novo_horario);
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    header("Location: dashboard_cliente.php?msg=reagendado");
    exit;

} catch (PDOException $e) {
    die("Erro ao reagendar: " . $e->getMessage());
}
?>
