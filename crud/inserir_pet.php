<?php
session_start();
require '../includes/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Erro: usuário não está logado.");
}

// Pegando dados do formulário
$nome = $_POST['Nome'];
$especie = $_POST['Especie'];
$raca = $_POST['Raca'];
$idade = $_POST['Idade'];
$peso = $_POST['Peso'];
$sexo = $_POST['Sexo'];
$obs = $_POST['Observacao'];

// Pegando o ID do dono corretamente
$id_dono = $_SESSION['usuario_id'];

// Inserção no banco
$sql = "INSERT INTO Animal 
        (Nome, Especie, Raca, Idade, Sexo, Peso, Observacao, idDono_animal)
        VALUES 
        (:nome, :especie, :raca, :idade, :sexo, :peso, :obs, :id_dono)";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':especie', $especie);
$stmt->bindParam(':raca', $raca);
$stmt->bindParam(':idade', $idade);
$stmt->bindParam(':sexo', $sexo);
$stmt->bindParam(':peso', $peso);
$stmt->bindParam(':obs', $obs);
$stmt->bindParam(':id_dono', $id_dono);

// Se deu certo, redireciona pra tela de sucesso
if ($stmt->execute()) {
    header("Location: ../cadastro_pet_sucesso.php");
    exit;
} else {
    header("Location: ../cadastro_pet_falha.php");
    exit;
}
?>
