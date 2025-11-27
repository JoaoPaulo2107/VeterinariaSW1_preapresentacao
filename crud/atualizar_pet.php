<?php
require '../includes/conexao.php';
session_start();

if (!isset($_POST['ID_Animal'])) {
    die("ID do animal não enviado!");
}

$id = $_POST['ID_Animal'];
$nome = $_POST['Nome'];
$especie = $_POST['Especie'];
$raca = $_POST['Raca'];
$sexo = $_POST['Sexo'];
$idade = $_POST['Idade'];
$peso = $_POST['Peso'];
$observacao = $_POST['Observacao'];

try {

    $sql = "UPDATE animal
            SET Nome = :nome,
                Especie = :especie,
                Raca = :raca,
                Sexo = :sexo,
                Idade = :idade,
                Peso = :peso,
                Observacao = :observacao
            WHERE ID_Animal = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':especie', $especie);
    $stmt->bindParam(':raca', $raca);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':idade', $idade);
    $stmt->bindParam(':peso', $peso);
    $stmt->bindParam(':observacao', $observacao);

    if ($stmt->execute()) {
        header("Location: ../meuspets.php?msg=updated");
        exit;
    } else {
        echo "Erro ao atualizar!";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
