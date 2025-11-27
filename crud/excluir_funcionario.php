<?php
// conexão banco de dados
require_once __DIR__ . '/../includes/conexao.php';

// Verifico se o ID do funcionário veio pela URL
if (!isset($_GET['id'])) {
    // Se não tiver ID, volta pra página de funcionários e aviso o erro
    header('Location: ../funcionarios.php?msg=ID inválido');
    exit;
}

// Guarda o ID que veio da URL
$id = $_GET['id'];

try {
    // SQL pra excluir o funcionário do banco
    $sql = "DELETE FROM funcionario WHERE ID_veterinario = :id";

    // Preparo o comando (usando PDO pra evitar SQL Injection)
    $stmt = $pdo->prepare($sql);

    // Executa o comando passando o ID
    $stmt->execute([':id' => $id]);

    // Se tudo der certo, volta pra página de funcionários com mensagem de sucesso
    header('Location: ../funcionarios.php?msg=Funcionário excluído com sucesso!');
    exit;

} catch (PDOException $e) {
    // Se der algum erro (ex: problema com chave estrangeira), mostra mensagem de erro
    header('Location: ../funcionarios.php?msg=Erro ao excluir funcionário: ' . urlencode($e->getMessage()));
    exit;
}
?>
