<?php
//informações banco de dados
$host = "localhost";     // O servidor do MySQL
$dbname = "veterinaria"; // Nome do banco
$user = "root";          // Usuário padrão do MySQL
$pass = "";              // Senha (vazia)

// Uso o try/catch pra tentar conectar e capturar erros se algo der errado
try {
    // Aqui eu crio a conexão com o banco usando PDO
    // O "charset=utf8" pra aceitar acentos e caracteres especiais
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    //PHP mostrar o erro se der problema no banco
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Se não conectar, mostra mensagem de erro
    die("Erro ao conectar: " . $e->getMessage());
}
?>
