<?php
include 'conexion.php';

// Manejo de la eliminación de usuario
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Eliminar todos los mensajes del usuario primero
        $sql_delete_messages = "DELETE FROM mensajes WHERE id_usuario = $userId";
        if ($conn->query($sql_delete_messages) !== TRUE) {
            throw new Exception("Error al eliminar mensajes del usuario: " . $conn->error);
        }

        // Obtener todos los operarios del usuario
        $sql_select_operarios = "SELECT id_operario FROM operarios WHERE id_usuario = $userId";
        $result_operarios = $conn->query($sql_select_operarios);
        if ($result_operarios->num_rows > 0) {
            while ($row_operario = $result_operarios->fetch_assoc()) {
                $operarioId = $row_operario['id_operario'];

                // Eliminar todas las solicitudes del operario
                $sql_delete_solicitudes = "DELETE FROM solicitudes WHERE id_operario = $operarioId";
                if ($conn->query($sql_delete_solicitudes) !== TRUE) {
                    throw new Exception("Error al eliminar solicitudes del operario: " . $conn->error);
                }
            }
        }

        // Eliminar todos los operarios del usuario
        $sql_delete_operarios = "DELETE FROM operarios WHERE id_usuario = $userId";
        if ($conn->query($sql_delete_operarios) !== TRUE) {
            throw new Exception("Error al eliminar operarios del usuario: " . $conn->error);
        }

        // Luego eliminar el usuario
        $sql_delete_user = "DELETE FROM usuarios WHERE id = $userId";
        if ($conn->query($sql_delete_user) !== TRUE) {
            throw new Exception("Error al eliminar usuario: " . $conn->error);
        }

        // Confirmar la transacción
        $conn->commit();
        echo "Usuario eliminado correctamente";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo $e->getMessage();
    }
}

// Manejo de la edición de usuario
if (isset($_POST['edit_user'])) {
    $userId = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    $sql = "UPDATE usuarios SET nombre='$nombre', correo='$correo', rol='$rol' WHERE id = $userId";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario actualizado correctamente";
    } else {
        echo "Error al actualizar usuario: " . $conn->error;
    }
}

// Consulta para obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 100%;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #0056b3;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .edit-btn, .delete-btn, .view-btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            margin-right: 5px;
            transition: background-color 0.3s;
            display: inline-block;
            width: 70px;
            text-align: center;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .delete-btn:hover {
            background-color: #da190b;
        }

        .view-btn {
            background-color: #2196F3;
            color: white;
        }

        .view-btn:hover {
            background-color: #0b7dda;
        }

        .no-data {
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Administración de Usuarios</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo isset($row['correo']) ? $row['correo'] : 'No definido'; ?></td>
                            <td><?php echo $row['rol']; ?></td>
                            <td>
                                <a href="ver_usuario.php?id=<?php echo $row['id']; ?>" class="view-btn">Ver</a>
                                <a href="edit_usuario.php?id=<?php echo $row['id']; ?>" class="edit-btn">Editar</a>
                                <a href="admin_usuarios.php?delete=<?php echo $row['id']; ?>" class="delete-btn">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No se encontraron usuarios.</p>
        <?php endif; ?>
    </div>
</body>
</html>
