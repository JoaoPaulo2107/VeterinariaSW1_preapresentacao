<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erro no cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #e7f1ff, #f4f9ff);
            height: 100vh;
        }
        .card {
            border: 2px solid #0d6efd;
            border-radius: 20px;
            max-width: 600px;
        }
        h2 {
            color: #dc3545;
        }
        p {
            color: #0d6efd;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

    <div class="card shadow p-5 text-center w-100">
        <h2 class="mb-3">
            <i class="bi bi-x-circle-fill"></i> Ocorreu um erro
        </h2>
        <p>Não foi possível completar o cadastro do pet.</p>

        <a href="meuspets.php" class="btn btn-outline-primary w-100 mt-3">Tentar novamente</a>
    </div>

</body>
</html>
