<?php
include 'conexion.php';
include 'header.php';
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

                // Obtener todas las solicitudes del operario
                $sql_select_solicitudes = "SELECT id FROM solicitudes WHERE id_operario = $operarioId";
                $result_solicitudes = $conn->query($sql_select_solicitudes);
                if ($result_solicitudes->num_rows > 0) {
                    while ($row_solicitud = $result_solicitudes->fetch_assoc()) {
                        $solicitudId = $row_solicitud['id'];

                        // Eliminar todas las calificaciones de la solicitud
                        $sql_delete_calificaciones = "DELETE FROM calificaciones WHERE id_solicitud = $solicitudId";
                        if ($conn->query($sql_delete_calificaciones) !== TRUE) {
                            throw new Exception("Error al eliminar calificaciones de la solicitud: " . $conn->error);
                        }
                    }

                    // Eliminar todas las solicitudes del operario
                    $sql_delete_solicitudes = "DELETE FROM solicitudes WHERE id_operario = $operarioId";
                    if ($conn->query($sql_delete_solicitudes) !== TRUE) {
                        throw new Exception("Error al eliminar solicitudes del operario: " . $conn->error);
                    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            border-radius: 10px;
            overflow: hidden;
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
            <table class="table table-striped">
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
                                <a href="#" class="view-btn" data-bs-toggle="modal" data-bs-target="#viewUserModal" data-id="<?php echo $row['id']; ?>" data-nombre="<?php echo $row['nombre']; ?>" data-correo="<?php echo $row['correo']; ?>" data-rol="<?php echo $row['rol']; ?>">Ver</a>
                                <a href="edit_usuario.php?id=<?php echo $row['id']; ?>" class="edit-btn">Editar</a>
                                <a href="admin_usuarios.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No se encontraron usuarios.</p>
        <?php endif; ?>
    </div>

    <!-- Modal para ver usuario -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUserModalLabel">Detalles del Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="userId"></span></p>
                    <p><strong>Nombre:</strong> <span id="userName"></span></p>
                    <p><strong>Correo:</strong> <span id="userEmail"></span></p>
                    <p><strong>Rol:</strong> <span id="userRole"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script>
        var viewUserModal = document.getElementById('viewUserModal');
        viewUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var userId = button.getAttribute('data-id');
            var userName = button.getAttribute('data-nombre');
            var userEmail = button.getAttribute('data-correo');
            var userRole = button.getAttribute('data-rol');

            var modalTitle = viewUserModal.querySelector('.modal-title');
            var modalBodyId = viewUserModal.querySelector('#userId');
            var modalBodyName = viewUserModal.querySelector('#userName');
            var modalBodyEmail = viewUserModal.querySelector('#userEmail');
            var modalBodyRole = viewUserModal.querySelector('#userRole');

            modalTitle.textContent = 'Detalles del Usuario: ' + userName;
            modalBodyId.textContent = userId;
            modalBodyName.textContent = userName;
            modalBodyEmail.textContent = userEmail;
            modalBodyRole.textContent = userRole;
        });
    </script>
</body>
</html>
