<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dump Services</title>
</head>
<body>
    <header>
        <h1>Dump Services</h1>
        <?php
        // Verificar si la sesión no está iniciada antes de llamar a session_start()
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el usuario ya inició sesión
        if (isset($_SESSION['usuario_id'])) {
            // Mostrar el botón de cerrar sesión
            echo '<button onclick="window.location.href = \'logout.php\';">Cerrar Sesión</button>';
        } else {
            // Mostrar el botón de ingresar
            echo '<button onclick="window.location.href = \'login.php\';">Ingresar</button>';
        }
        ?>
    </header>
</body>
</html>
