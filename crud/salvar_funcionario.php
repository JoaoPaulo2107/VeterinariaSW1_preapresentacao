<?php
//conexão banco de dados
require_once __DIR__ . '/../includes/conexao.php';

// Verifico se o formulário foi enviado pelo método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // SQL pra inserir um novo funcionário no banco
    $sql = "INSERT INTO Funcionario (CRMV, Nome, Email, Telefone, Especialidade, Sexo, Data_Nascimento, CPF)
            VALUES (:CRMV, :Nome, :Email, :Telefone, :Especialidade, :Sexo, :Data_Nascimento, :CPF)";

    // Preparo a query (usando PDO pra evitar SQL Injection)
    $stmt = $pdo->prepare($sql);

    // Ligo cada campo do formulário com o respectivo parâmetro do SQL
    $stmt->bindParam(':CRMV', $_POST['CRMV']);
    $stmt->bindParam(':Nome', $_POST['Nome']);
    $stmt->bindParam(':Email', $_POST['Email']);
    $stmt->bindParam(':Telefone', $_POST['Telefone']);
    $stmt->bindParam(':Especialidade', $_POST['Especialidade']);
    $stmt->bindParam(':Sexo', $_POST['Sexo']);
    $stmt->bindParam(':Data_Nascimento', $_POST['Data_Nascimento']);
    $stmt->bindParam(':CPF', $_POST['CPF']);

    // Executo o comando, insere o novo funcionário no banco
    $stmt->execute();

    // Depois de cadastrar, volto pra página de funcionários e mostra uma mensagem de sucesso
    header("Location: ../funcionarios.php?msg=Funcionário cadastrado com sucesso!");
    exit;

} else {
    // Se alguém tentar acessar esse arquivo direto (sem mandar o formulário),
    // redireciona pra página de funcionários e mostro uma mensagem de erro
    header("Location: ../funcionarios.php?msg=Erro: método inválido!");
    exit;
}
?>
