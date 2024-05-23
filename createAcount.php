<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Variables para almacenar mensajes de éxito o error
$mensaje = '';
$errores = [];
$cuentaCreada = false; // Nueva variable para verificar si la cuenta se creó correctamente

// Verificar si se ha enviado el formulario de creación de cuenta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
    $tipo_documento = trim($_POST['tipo_documento']);
    $numero_documento = trim($_POST['numero_documento']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $rol = trim($_POST['rol']);
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Validaciones del lado del servidor
    if (empty($nombre)) {
        $errores['nombre'] = "El nombre es obligatorio.";
    }
    if (empty($apellidos)) {
        $errores['apellidos'] = "Los apellidos son obligatorios.";
    }
    if (empty($fecha_nacimiento)) {
        $errores['fecha_nacimiento'] = "La fecha de nacimiento es obligatoria.";
    }
    if (empty($tipo_documento)) {
        $errores['tipo_documento'] = "El tipo de documento es obligatorio.";
    }
    if (empty($numero_documento)) {
        $errores['numero_documento'] = "El número de documento es obligatorio.";
    } elseif (!ctype_digit($numero_documento)) {
        $errores['numero_documento'] = "El número de documento debe ser numérico.";
    }
    if (empty($telefono)) {
        $errores['telefono'] = "El teléfono es obligatorio.";
    } elseif (!ctype_digit($telefono)) {
        $errores['telefono'] = "El teléfono debe ser numérico.";
    }
    if (empty($correo)) {
        $errores['correo'] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo electrónico no es válido.";
    }
    if (empty($rol)) {
        $errores['rol'] = "El rol es obligatorio.";
    }
    if (empty($contrasena)) {
        $errores['contrasena'] = "La contraseña es obligatoria.";
    } elseif ($contrasena !== $confirmar_contrasena) {
        $errores['contrasena'] = "Las contraseñas no coinciden.";
    }

    // Verificar si el correo ya existe en la base de datos
    if (empty($errores)) {
        $sql_verificar_usuario = "SELECT id FROM usuarios WHERE correo = '$correo'";
        $resultado_verificar_usuario = $conn->query($sql_verificar_usuario);

        if ($resultado_verificar_usuario->num_rows > 0) {
            $errores['correo'] = "Ya existe una cuenta asociada a este correo electrónico.";
        }
    }

    if (empty($errores)) {
        // Insertar el usuario en la base de datos
        $sql_insertar_usuario = "INSERT INTO usuarios (nombre, apellidos, fecha_nacimiento, tipo_documento, numero_documento, correo, rol, contrasena, telefono) VALUES ('$nombre', '$apellidos', '$fecha_nacimiento', '$tipo_documento', '$numero_documento', '$correo', '$rol', '$contrasena', '$telefono')";

        if ($conn->query($sql_insertar_usuario) === TRUE) {
            $cuentaCreada = true; // Establecer la variable a true si la cuenta se creó correctamente
        } else {
            $mensaje = "Error al crear la cuenta: " . $conn->error;
        }
    } else {
        $mensaje = "Por favor, corrija los errores en el formulario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Dump Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <style>
        /* Variables CSS */
        :root {
            --primary-color: #00132B; /* Color primario */
            --secondary-color: #3B4149; /* Color secundario */
            --background-color: #f2f2f2; /* Color de fondo */
            --text-color: #333; /* Color de texto */
            --input-background: #fff; /* Color de fondo de input */
            --link-color: #064575; /* Color de enlaces */
            --font-family: 'Roboto', sans-serif; /* Fuente principal */
            --transition-speed: 0.3s; /* Velocidad de transición */
        }

        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box; /* Para que el padding no afecte al tamaño total */
        }

        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Altura completa de la ventana */
            margin: 0;
            padding: 20px;
        }

        .container {
            background: var(--input-background);
            padding: 20px; /* Reducir padding para hacer el contenedor más pequeño */
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px; /* Reducir tamaño máximo del contenedor */
            animation: slideIn var(--transition-speed) ease-out;
            border-left: 5px solid var(--primary-color);
            border-right: 5px solid var(--secondary-color);
        }

        h2 {
            text-align: center;
            margin-bottom: 15px; /* Reducir margen inferior */
            color: var(--primary-color);
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        h2:after {
            content: "";
            width: 50px;
            height: 3px;
            background: var(--secondary-color);
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .form-group {
            margin-bottom: 15px; /* Reducir margen inferior */
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--primary-color);
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background: #f9f9f9;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 10px rgba(59, 65, 73, 0.2);
            background: #fff;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .form-group button:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .form-group button:active {
            transform: translateY(-1px);
        }

        .form-group span.error {
            color: red;
            font-size: 0.9em;
            display: block;
            margin-top: 5px;
        }

        .form-group p {
            margin-top: 10px;
            text-align: center;
            color: var(--primary-color);
            font-weight: bold;
        }

        /* Animaciones */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Crear Cuenta</h2>

        <?php
        // Mostrar mensaje general de error
        if (!empty($mensaje)) {
            echo "<p>$mensaje</p>";
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="nombre">Nombres:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre ?? ''); ?>">
                <?php if (isset($errores['nombre'])) echo '<span class="error">'.$errores['nombre'].'</span>'; ?>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($apellidos ?? ''); ?>">
                <?php if (isset($errores['apellidos'])) echo '<span class="error">'.$errores['apellidos'].'</span>'; ?>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($fecha_nacimiento ?? ''); ?>">
                <?php if (isset($errores['fecha_nacimiento'])) echo '<span class="error">'.$errores['fecha_nacimiento'].'</span>'; ?>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="number" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono ?? ''); ?>">
                <?php if (isset($errores['telefono'])) echo '<span class="error">'.$errores['telefono'].'</span>'; ?>
            </div>
            <div class="form-group">
                <label for="tipo_documento">Tipo de Documento:</label>
                <select id="tipo_documento" name="tipo_documento">
                    <option value="">Seleccione</option>
                    <option value="CC" <?php echo (isset($tipo_documento) && $tipo_documento == 'CC') ? 'selected' : ''; ?>>Cédula de Ciudadanía</option>
                    <option value="CE" <?php echo (isset($tipo_documento) && $tipo_documento == 'CE') ? 'selected' : ''; ?>>Cédula de Extranjería</option>
                </select>
                <?php if (isset($errores['tipo_documento'])) echo '<span class="error">'.$errores['tipo_documento'].'</span>'; ?>
            </div>
            <div class="form-group">
                <label for="numero_documento">Número de Documento:</label>
                <input type="number" id="numero_documento" name="numero_documento" value="<?php echo htmlspecialchars($numero_documento ?? ''); ?>">
                <?php if (isset($errores['numero_documento'])) echo '<span class="error">'.$errores['numero_documento'].'</span>'; ?>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($correo ?? ''); ?>">
                <?php if (isset($errores['correo'])) echo '<span class="error">'.$errores['correo'].'</span>'; ?>
            </div>
            <div class="form-group">
                <label for="rol">Rol:</label>
                <select id="rol" name="rol">
                    <option value="">Seleccione</option>
                    <option value="operador_logistico" <?php echo (isset($rol) && $rol == 'operador_logistico') ? 'selected' : ''; ?>>Operador Logístico</option>
                    <option value="solicitante_transporte" <?php echo (isset($rol) && $rol == 'solicitante_transporte') ? 'selected' : ''; ?>>Solicitante de Transporte</option>
                </select>
                <?php if (isset($errores['rol'])) echo '<span class="error">'.$errores['rol'].'</span>'; ?>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" value="<?php echo htmlspecialchars($contrasena ?? ''); ?>">
                <?php if (isset($errores['contrasena'])) echo '<span class="error">'.$errores['contrasena'].'</span>'; ?>
            </div>
            <div class="form-group">
                <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" value="<?php echo htmlspecialchars($confirmar_contrasena ?? ''); ?>">
                <?php if (isset($errores['confirmar_contrasena'])) echo '<span class="error">'.$errores['confirmar_contrasena'].'</span>'; ?>
            </div>
            <div class="form-group">
                <button type="submit">Crear Cuenta</button>
            </div>
        </form>
    </div>
    <?php if ($cuentaCreada): ?>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var notyf = new Notyf({
                duration: 5000,
                position: { x: 'center', y: 'top' },
                types: [
                    {
                        type: 'success',
                        background: 'green',
                        icon: {
                            className: 'fas fa-check-circle',
                            tagName: 'i',
                            text: ''
                        }
                    }
                ]
            });
            notyf.success('Cuenta creada correctamente. Redirigiendo...');
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 3000); 
        });
    </script>
    <?php endif; ?>
</body>
</html>
