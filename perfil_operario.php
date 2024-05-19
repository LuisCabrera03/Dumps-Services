<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $id_usuario = $_COOKIE['usuario_id']; // Obtener el id_usuario de la cookie

    $marca_motocarro = $_POST['marca'];
    $modelo_motocarro = $_POST['modelo'];
    $año_motocarro = $_POST['año'];
    $placa_motocarro = $_POST['placa'];

    $direccion_domicilio = $_POST['direccion'];
    $otros_detalles = $_POST['detalles'];

    // Manejar la carga de la foto del motocarro
    $ruta_foto_motocarro = '';
    if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nombre_temporal = $_FILES['foto']['tmp_name'];
        $nombre_archivo = $_FILES['foto']['name'];
        $ruta_destino = 'media/fotos/' . $nombre_archivo;
        move_uploaded_file($nombre_temporal, $ruta_destino);
        $ruta_foto_motocarro = $ruta_destino;
    }

    // Manejar la carga de las fotos adicionales
    $ruta_fotos_adicionales = array();
    for ($i = 1; $i <= 10; $i++) {
        if ($_FILES["foto_$i"]["error"] === UPLOAD_ERR_OK) {
            $nombre_temporal = $_FILES["foto_$i"]["tmp_name"];
            $nombre_archivo = $_FILES["foto_$i"]["name"];
            $ruta_destino = 'media/fotos/' . $nombre_archivo;
            move_uploaded_file($nombre_temporal, $ruta_destino);
            $ruta_fotos_adicionales[] = $ruta_destino;
        }
    }

    // Manejar la carga de los certificados
    $ruta_certificado_antecedentes = '';
    if ($_FILES['certificado_antecedentes']['error'] === UPLOAD_ERR_OK) {
        $nombre_temporal = $_FILES['certificado_antecedentes']['tmp_name'];
        $nombre_archivo = $_FILES['certificado_antecedentes']['name'];
        $ruta_destino = 'media/certificados/antecedentes/' . $nombre_archivo;
        move_uploaded_file($nombre_temporal, $ruta_destino);
        $ruta_certificado_antecedentes = $ruta_destino;
    }

    $ruta_certificado_seguridad = '';
    if ($_FILES['certificado_seguridad']['error'] === UPLOAD_ERR_OK) {
        $nombre_temporal = $_FILES['certificado_seguridad']['tmp_name'];
        $nombre_archivo = $_FILES['certificado_seguridad']['name'];
        $ruta_destino = 'media/certificados/seguridad/' . $nombre_archivo;
        move_uploaded_file($nombre_temporal, $ruta_destino);
        $ruta_certificado_seguridad = $ruta_destino;
    }

    $ruta_licencia_conduccion = '';
    if ($_FILES['licencia_conduccion']['error'] === UPLOAD_ERR_OK) {
        $nombre_temporal = $_FILES['licencia_conduccion']['tmp_name'];
        $nombre_archivo = $_FILES['licencia_conduccion']['name'];
        $ruta_destino = 'media/certificados/licencia/' . $nombre_archivo;
        move_uploaded_file($nombre_temporal, $ruta_destino);
        $ruta_licencia_conduccion = $ruta_destino;
    }

    $ruta_seguro_vehiculo = '';
    if ($_FILES['seguro_vehiculo']['error'] === UPLOAD_ERR_OK) {
        $nombre_temporal = $_FILES['seguro_vehiculo']['tmp_name'];
        $nombre_archivo = $_FILES['seguro_vehiculo']['name'];
        $ruta_destino = 'media/certificados/seguro/' . $nombre_archivo;
        move_uploaded_file($nombre_temporal, $ruta_destino);
        $ruta_seguro_vehiculo = $ruta_destino;
    }

// Insertar los datos en la tabla de operarios
$sql = "INSERT INTO operarios (id_usuario, marca_motocarro, modelo_motocarro, año_motocarro, placa_motocarro, foto_motocarro, direccion_domicilio, otros_detalles, certificado_antecedentes_judiciales, certificado_seguridad_social, licencia_conduccion, seguro_vehiculo";
for ($i = 2; $i <= 10; $i++) {
    $sql .= ", foto_$i"; // Utilizar las columnas foto_2, foto_3, ..., foto_10
}
$sql .= ") VALUES ('$id_usuario', '$marca_motocarro', '$modelo_motocarro', '$año_motocarro', '$placa_motocarro', '$ruta_foto_motocarro', '$direccion_domicilio', '$otros_detalles', '$ruta_certificado_antecedentes', '$ruta_certificado_seguridad', '$ruta_licencia_conduccion', '$ruta_seguro_vehiculo'";
for ($i = 2; $i <= 10; $i++) {
    if ($i - 1 <= count($ruta_fotos_adicionales)) {
        $sql .= ", '" . $ruta_fotos_adicionales[$i - 2] . "'"; // Utilizar las rutas de las fotos adicionales
    } else {
        $sql .= ", NULL"; // Si no hay ruta disponible, insertar NULL
    }
}
$sql .= ")";

if (mysqli_query($conn, $sql)) {
    echo "Operario registrado correctamente.";
} else {
    echo "Error al registrar operario: " . mysqli_error($conn);
}

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
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
        <input type="hidden" name="id_usuario" value="<?php echo $_COOKIE['usuario_id']; ?>">

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

        <label for="certificado_antecedentes">Certificado de Antecedentes Judiciales:</label>
        <input type="file" id="certificado_antecedentes" name="certificado_antecedentes" accept="image/*"><br><br>

        <label for="certificado_seguridad">Certificado de Seguridad Social:</label>
        <input type="file" id="certificado_seguridad" name="certificado_seguridad" accept="image/*"><br><br>

        <label for="licencia_conduccion">Licencia de Conducción:</label>
        <input type="file" id="licencia_conduccion" name="licencia_conduccion" accept="image/*"><br><br>

        <label for="seguro_vehiculo">Seguro del Vehículo:</label>
        <input type="file" id="seguro_vehiculo" name="seguro_vehiculo" accept="image/*"><br><br>

        <label for="detalles">Otros Detalles:</label>
        <textarea id="detalles" name="detalles"></textarea><br><br>

        <input type="submit" value="Registrar Operario">
    </form>
</body>
</html>
