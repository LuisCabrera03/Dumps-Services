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
        table {
            border-collapse: collapse;
            width: 100%;
            margin: auto;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit-btn, .delete-btn, .view-btn {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
        }
        .edit-btn {
            background-color: #4CAF50;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .view-btn {
            background-color: #2196F3;
        }
    </style>
</head>
<body>
    <h2>Administración de Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $correo = isset($row['correo']) ? $row['correo'] : 'No definido';
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$correo}</td>
                        <td>{$row['rol']}</td>
                        <td>
                            <a href='ver_usuario.php?id={$row['id']}' class='view-btn'>Ver</a>
                            <a href='edit_usuario.php?id={$row['id']}' class='edit-btn'>Editar</a>
                            <a href='admin_usuarios.php?delete={$row['id']}' class='delete-btn'>Eliminar</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se encontraron usuarios</td></tr>";
        }
        ?>
    </table>
</body>
</html>
