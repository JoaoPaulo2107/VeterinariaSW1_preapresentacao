<?php
require_once '../includes/conexao.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['ID_Animal'], $_POST['procedimento'], $_POST['data'], $_POST['horario'])) {
    $idAnimal = $_POST['ID_Animal'];
    $procedimento = $_POST['procedimento'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $observacao = $_POST['observacao'] ?? '';

    try {
        // ✅ INSERE A CONSULTA COMO "Pendente"
        $sql = "INSERT INTO Consulta (ID_Animal, Procedimento, Data_consulta, Horario, Observacao, Status)
                VALUES (:animal, :proc, :data, :hora, :obs, 'Pendente')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':animal' => $idAnimal,
            ':proc'   => $procedimento,
            ':data'   => $data,
            ':hora'   => $horario,
            ':obs'    => $observacao
        ]);

        header('Location: ../consulta.php?msg=Consulta marcada com sucesso!');
        exit;
    } catch (PDOException $e) {
        echo "<p style='color:red; text-align:center;'>Erro: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p style='color:red; text-align:center;'>Campos obrigatórios não preenchidos.</p>";
}
?>
