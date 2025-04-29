<?php
session_start();
// Carga el auth.php correcto:
require_once __DIR__ . '/../includes/auth.php';

// Si ya está logueado, va al dashboard
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}
// Si se envió el formulario
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (login($username, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Admin</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 50px;
            background: #f9f9f9;
        }
        .login-form {
            max-width: 400px;
            background: white;
            padding: 20px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            margin-top: 5px;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-form">
    <h1>Login Admin</h1>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Iniciar sesión</button>
    </form>
</div>

</body>
</html>
