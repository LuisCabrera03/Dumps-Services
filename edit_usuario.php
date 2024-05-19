<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Consulta para obtener los datos del usuario
    $sql = "SELECT * FROM usuarios WHERE id = $userId";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

if (isset($_POST['edit_user'])) {
    $userId = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    $sql = "UPDATE usuarios SET nombre='$nombre', correo='$correo', rol='$rol' WHERE id = $userId";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_usuarios.php");
    } else {
        echo "Error al actualizar usuario: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <style>
        form {
            width: 300px;
            margin: auto;
        }
        label, input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Editar Usuario</h2>
    <form action="edit_usuario.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $user['nombre']; ?>" required>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $user['correo']; ?>" required>
        <label for="rol">Rol:</label>
        <input type="text" id="rol" name="rol" value="<?php echo $user['rol']; ?>" required>
        <input type="submit" name="edit_user" value="Guardar Cambios">
    </form>
</body>
</html>
