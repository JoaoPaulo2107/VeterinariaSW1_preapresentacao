<?php
session_start();

// limpa variáveis de sessão
$_SESSION = [];

// remove cookie da sessão (opcional mas recomendado)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// destrói sessão
session_destroy();

// redireciona para login ou home
header('Location: ../index.php');
exit;
