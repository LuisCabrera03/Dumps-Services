<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $id_usuario = $_COOKIE['id_usuario']; // Obtener el id_usuario de la cookie

    $marca_motocarro = $_POST['marca'];
    $modelo_motocarro = $_POST['modelo'];
    $año_motocarro = $_POST['año'];
    $placa_motocarro = $_POST['placa'];

    $direccion_domicilio = $_POST['direccion'];

    // Manejar la carga de la foto del motocarro
    $ruta_foto_motocarro = '';
    if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nombre_temporal = $_FILES['foto']['tmp_name'];
        $nombre_archivo = $_FILES['foto']['name'];
        $ruta_destino = 'ruta/de/la/carpeta/' . $nombre_archivo;
        move_uploaded_file($nombre_temporal, $ruta_destino);
        $ruta_foto_motocarro = $ruta_destino;
    }

    // Manejar la carga de las fotos adicionales
    $ruta_fotos_adicionales = array();
    $num_fotos = 0;
    for ($i = 1; $i <= 10; $i++) {
        if ($_FILES["foto_$i"]["error"] === UPLOAD_ERR_OK) {
            $num_fotos++;
            $nombre_temporal = $_FILES["foto_$i"]["tmp_name"];
            $nombre_archivo = $_FILES["foto_$i"]["name"];
            $ruta_destino = 'ruta/de/la/carpeta/fotos_adicionales/' . $nombre_archivo;
            move_uploaded_file($nombre_temporal, $ruta_destino);
            $ruta_fotos_adicionales[] = $ruta_destino;
        }
    }

    $otros_detalles = $_POST['detalles'];

    // Insertar los datos en la tabla de operarios
    $sql = "INSERT INTO operarios (id_usuario, marca_motocarro, modelo_motocarro, año_motocarro, placa_motocarro, foto_motocarro, direccion_domicilio, otros_detalles";
    for ($i = 1; $i <= $num_fotos; $i++) {
        $sql .= ", foto_$i";
    }
    $sql .= ") VALUES ('$id_usuario', '$marca_motocarro', '$modelo_motocarro', '$año_motocarro', '$placa_motocarro', '$ruta_foto_motocarro', '$direccion_domicilio', '$otros_detalles'";
    foreach ($ruta_fotos_adicionales as $ruta_foto) {
        $sql .= ", '$ruta_foto'";
    }
    $sql .= ")";

    if (mysqli_query($conexion, $sql)) {
        echo "Operario registrado correctamente.";
    } else {
        echo "Error al registrar operario: " . mysqli_error($conexion);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro de Operario</title>
</head>
<body>
    <h2>Registro de Operario</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <!-- Input oculto para el id_usuario -->
        <input type="hidden" name="id_usuario" value="<?php echo $_COOKIE['id_usuario']; ?>">

        <label for="marca">Marca del Motocarro:</label>
        <input type="text" id="marca" name="marca" required><br><br>

        <label for="modelo">Modelo del Motocarro:</label>
        <input type="text" id="modelo" name="modelo" required><br><br>

        <label for="año">Año de Fabricación:</label>
        <input type="number" id="año" name="año" required><br><br>

        <label for="placa">Placa del Motocarro:</label>
        <input type="text" id="placa" name="placa" required><br><br>

        <label for="foto">Foto del Motocarro:</label>
        <input type="file" id="foto" name="foto" accept="image/*" required><br><br>

        <label for="direccion">Dirección del Domicilio:</label>
        <input type="text" id="direccion" name="direccion" required><br><br>

        <?php for ($i = 1; $i <= 10; $i++) : ?>
            <label for="foto_<?php echo $i; ?>">Foto adicional <?php echo $i; ?>:</label>
            <input type="file" id="foto_<?php echo $i; ?>" name="foto_<?php echo $i; ?>" accept="image/*"><br><br>
        <?php endfor; ?>

        <label for="detalles">Otros Detalles:</label>
        <textarea id="detalles" name="detalles"></textarea><br><br>

        <input type="submit" value="Registrar Operario">
    </form>
</body>
</html>
