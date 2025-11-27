<?php
session_start();
include 'includes/header_cliente.php';
?>

<link rel="stylesheet" href="css/consulta_sucesso.css">

<main>
    <div class="sucesso-container">
        <h1>Consulta Marcada!</h1>

        <p>Sua consulta foi registrada com sucesso!<br>
        Agradecemos pela confiança.</p>

        <a href="dashboard_cliente.php" class="btn-voltar">Voltar ao Painel</a>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
