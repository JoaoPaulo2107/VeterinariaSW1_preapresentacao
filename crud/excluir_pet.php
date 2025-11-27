<?php
require '../includes/conexao.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: ../meuspets.php");
    exit;
}

$id = $_GET['id'];

try {

    // 🔥 1) EXCLUI CONSULTAS DO PET
    $sql = "DELETE FROM consulta WHERE ID_Animal = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // 🔥 2) EXCLUI O PET
    $sql = "DELETE FROM animal WHERE ID_Animal = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        header("Location: ../meuspets.php?msg=deleted");
        exit;
    } else {
        header("Location: ../meuspets.php?msg=error");
        exit;
    }

} catch (PDOException $e) {
    echo "Erro ao excluir: " . $e->getMessage();
}
?>
