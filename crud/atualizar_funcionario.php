<?php
//conexão banco
require_once __DIR__ . '/../includes/conexao.php';

// Verifica se o formulário foi enviado corretamente com o método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // SQL pra atualizar os dados do funcionário no banco
    $sql = "UPDATE Funcionario SET 
                CRMV = :CRMV,
                Nome = :Nome,
                Email = :Email,
                Telefone = :Telefone,
                Especialidade = :Especialidade,
                Sexo = :Sexo,
                Data_Nascimento = :Data_Nascimento,
                CPF = :CPF
            WHERE ID_veterinario = :ID_veterinario";

    // Preparo o comando SQL (usando PDO pra evitar SQL Injection)
    $stmt = $pdo->prepare($sql);

    // Aqui eu passo os dados que vieram do formulário pros parâmetros do SQL
    $stmt->bindParam(':CRMV', $_POST['CRMV']);
    $stmt->bindParam(':Nome', $_POST['Nome']);
    $stmt->bindParam(':Email', $_POST['Email']);
    $stmt->bindParam(':Telefone', $_POST['Telefone']);
    $stmt->bindParam(':Especialidade', $_POST['Especialidade']);
    $stmt->bindParam(':Sexo', $_POST['Sexo']);
    $stmt->bindParam(':Data_Nascimento', $_POST['Data_Nascimento']);
    $stmt->bindParam(':CPF', $_POST['CPF']);
    $stmt->bindParam(':ID_veterinario', $_POST['ID_veterinario']);

    // Executo a atualização no banco
    $stmt->execute();

    // Se tudo der certo, volto pra página de funcionários e mostro uma mensagem de sucesso
    header("Location: ../funcionarios.php?msg=Funcionário atualizado com sucesso!");
    exit;

} else {
    // Caso alguém tente acessar esse arquivo direto (sem mandar o formulário),
    // redireciono de volta com uma mensagem de erro
    header("Location: ../funcionarios.php?msg=Erro: método inválido");
    exit;
}
?>
