<?php
include 'conexion.php';

// Manejar eliminación de usuarios
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $delete_sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Manejar edición de usuarios
if (isset($_POST['update'])) {
    $user_id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    $update_sql = "UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssi", $nombre, $email, $rol, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            display: inline;
        }
        .edit-form {
            display: none;
        }
    </style>
    <script>
        function showEditForm(id, nombre, email, rol) {
            document.getElementById('edit-form-' + id).style.display = 'table-row';
            document.getElementById('nombre-' + id).value = nombre;
            document.getElementById('email-' + id).value = email;
            document.getElementById('rol-' + id).value = rol;
        }

        function hideEditForm(id) {
            document.getElementById('edit-form-' + id).style.display = 'none';
        }
    </script>
</head>
<body>
    <h2 style="text-align: center;">Administrar Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['rol']; ?></td>
                <td>
                    <button onclick="showEditForm('<?php echo $row['id']; ?>', '<?php echo $row['nombre']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['rol']; ?>')">Editar</button>
                    <a href="admin_usuarios.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</a>
                </td>
            </tr>
            <tr id="edit-form-<?php echo $row['id']; ?>" class="edit-form">
                <form action="admin_usuarios.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><input type="text" name="nombre" id="nombre-<?php echo $row['id']; ?>" value="<?php echo $row['nombre']; ?>"></td>
                    <td><input type="email" name="email" id="email-<?php echo $row['id']; ?>" value="<?php echo $row['email']; ?>"></td>
                    <td>
                        <select name="rol" id="rol-<?php echo $row['id']; ?>">
                            <option value="admin" <?php if ($row['rol'] == 'admin') echo 'selected'; ?>>Admin</option>
                            <option value="usuario" <?php if ($row['rol'] == 'usuario') echo 'selected'; ?>>Usuario</option>
                        </select>
                    </td>
                    <td>
                        <button type="submit" name="update">Guardar</button>
                        <button type="button" onclick="hideEditForm('<?php echo $row['id']; ?>')">Cancelar</button>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
