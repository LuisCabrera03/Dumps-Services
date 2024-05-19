<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Obtener el ID del operario desde la URL
$id_operario = $_GET['id_operario'];

// Consulta para obtener los detalles del operario
$sql_operario = "SELECT 
    usuarios.nombre, 
    usuarios.apellidos, 
    usuarios.correo, 
    usuarios.telefono, 
    operarios.direccion_domicilio, 
    operarios.marca_motocarro, 
    operarios.modelo_motocarro, 
    operarios.año_motocarro, 
    operarios.placa_motocarro, 
    operarios.foto_motocarro 
FROM operarios 
JOIN usuarios ON operarios.id_usuario = usuarios.id 
WHERE operarios.id_operario = $id_operario";

$resultado_operario = mysqli_query($conn, $sql_operario);

if ($resultado_operario) {
    if (mysqli_num_rows($resultado_operario) > 0) {
        $operario = mysqli_fetch_assoc($resultado_operario);
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Solicitud de Acarreo</title>
            <script src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&libraries=places"></script>
            <script>
                function initMap() {
                    var input = document.getElementById('direccion_acarreo');
                    var autocomplete = new google.maps.places.Autocomplete(input);
                }
            </script>
        </head>
        <body onload="initMap()">
        
        <h2>Detalles del Operario</h2>
        <p><strong>Nombre:</strong> <?php echo $operario['nombre'] . " " . $operario['apellidos']; ?></p>
        <p><strong>Correo electrónico:</strong> <?php echo $operario['correo']; ?></p>
        <p><strong>Teléfono:</strong> <?php echo $operario['telefono']; ?></p>
        <p><strong>Dirección:</strong> <?php echo $operario['direccion_domicilio']; ?></p>
        <p><strong>Marca del Motocarro:</strong> <?php echo $operario['marca_motocarro']; ?></p>
        <p><strong>Modelo del Motocarro:</strong> <?php echo $operario['modelo_motocarro']; ?></p>
        <p><strong>Año del Motocarro:</strong> <?php echo $operario['año_motocarro']; ?></p>
        <p><strong>Placa del Motocarro:</strong> <?php echo $operario['placa_motocarro']; ?></p>
        <img src="<?php echo $operario['foto_motocarro']; ?>" alt="Foto del Motocarro" style="width:200px;height:200px;"><br><br>

        <h2>Solicitud de Acarreo</h2>
        <form action="procesar_solicitud.php" method="post">
            <input type="hidden" name="id_operario" value="<?php echo $id_operario; ?>">
            <label for="direccion_acarreo">Dirección del Acarreo:</label>
            <input type="text" id="direccion_acarreo" name="direccion_acarreo" required><br><br>
            <label for="detalles_acarreo">Detalles del Acarreo:</label>
            <textarea id="detalles_acarreo" name="detalles_acarreo" required></textarea><br><br>
            <button type="submit">Solicitar Acarreo</button>
        </form>

        </body>
        </html>
        <?php
    } else {
        echo "No se encontraron detalles para este operario.";
    }
} else {
    echo "Error al obtener los detalles del operario: " . mysqli_error($conn);
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
