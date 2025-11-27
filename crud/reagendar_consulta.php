<?php
// Conecto banco de dados
require_once '../includes/conexao.php';

// Inicia a sessão pra saber qual cliente está logado
session_start();

// Verifico se o usuário está logado; se não estiver, manda pro login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}

// Verifica se todos os campos do formulário foram enviados corretamente
if (isset($_POST['id_consulta'], $_POST['nova_data'], $_POST['novo_horario'])) {

    // Pega os dados enviados pelo formulário
    $id = $_POST['id_consulta'];
    $data = $_POST['nova_data'];
    $horario = $_POST['novo_horario'];

    try {
        // SQL pra atualizar a consulta no banco
        // Aqui muda a data, o horário e deixa o status como "Pendente" de novo
        $sql = "UPDATE Consulta 
                SET Data_consulta = :data, Horario = :horario, Status = 'Pendente'
                WHERE ID_consulta = :id";

        // Prepara a query (usando PDO pra evitar SQL Injection)
        $stmt = $pdo->prepare($sql);

        // Executa a atualização passando os valores corretos
        $stmt->execute([
            ':data' => $data,
            ':horario' => $horario,
            ':id' => $id
        ]);

        // Se tudo der certo, volta pra página de consultas com mensagem de sucesso
        header('Location: ../consulta.php?msg=Consulta reagendada com sucesso!');
        exit;

    } catch (PDOException $e) {
        // Caso dê algum erro (problema na conexão ou SQL), mostra o erro
        echo "Erro ao reagendar: " . $e->getMessage();
    }

} else {
    // Se algum campo obrigatório não for enviado, avisa o usuário
    echo "Campos obrigatórios não informados.";
}
?>
