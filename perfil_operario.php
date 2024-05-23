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
        if (isset($_FILES["foto_$i"]) && $_FILES["foto_$i"]["error"] === UPLOAD_ERR_OK) {
            $nombre_temporal = $_FILES["foto_$i"]["tmp_name"];
            $nombre_archivo = $_FILES["foto_$i"]["name"];
            $ruta_destino = 'media/fotos/' . $nombre_archivo;
            move_uploaded_file($nombre_temporal, $ruta_destino);
            $ruta_fotos_adicionales[$i] = $ruta_destino;
        } else {
            $ruta_fotos_adicionales[$i] = null; // Si no hay foto adicional, poner null
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
        $sql .= ", " . ($ruta_fotos_adicionales[$i] ? "'" . $ruta_fotos_adicionales[$i] . "'" : "NULL");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Variables CSS */
        :root {
            --primary-color: #00132B;
            --secondary-color: #3B4149;
            --background-color: #f2f2f2;
            --text-color: #333;
            --input-background: #fff;
            --link-color: #064575;
            --font-family: 'Roboto', sans-serif;
            --transition-speed: 0.3s;
        }

        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            color: var(--text-color);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header, footer {
            width: 100%;
            background-color: var(--primary-color);
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        .container {
            background: var(--input-background);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 1200px;
            margin: auto;
            margin-top: 20px;
            margin-bottom: 20px;
            animation: slideIn var(--transition-speed) ease-out;
            border-left: 5px solid var(--primary-color);
            border-right: 5px solid var(--secondary-color);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--primary-color);
            position: relative;
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

        form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--primary-color);
            display: block;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--primary-color);
            border-radius: 5px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background: #f9f9f9;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 10px rgba(59, 65, 73, 0.2);
            background: #fff;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .form-group button,
        .form-group input[type="submit"] {
            padding: 10px;
            background: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.3s ease;
            width: 100%;
        }

        .form-group button:hover,
        .form-group input[type="submit"]:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .form-group button:active,
        .form-group input[type="submit"]:active {
            transform: translateY(-1px);
        }

        .form-group.full-width textarea {
            height: 100px;
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

        /* Estilos para filas */
        .row {
            width: 100%;
        }

        .row .form-group {
            width: 100%;
            margin-bottom: 20px;
        }

        .row.full-width .form-group {
            width: 100%;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de Operario</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <!-- Input oculto para el id_usuario -->
            <input type="hidden" name="id_usuario" value="<?php echo $_COOKIE['usuario_id']; ?>">

            <!-- Fila 1 -->
            <div class="row">
                <div class="form-group">
                    <label for="marca">Marca del Motocarro:</label>
                    <input type="text" id="marca" name="marca">
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo del Motocarro:</label>
                    <input type="text" id="modelo" name="modelo">
                </div>
                <div class="form-group">
                    <label for="año">Año de Fabricación:</label>
                    <input type="number" id="año" name="año">
                </div>
                <div class="form-group">
                    <label for="placa">Placa del Motocarro:</label>
                    <input type="text" id="placa" name="placa">
                </div>
            </div>

            <!-- Fila 2 -->
            <div class="row">
                <div class="form-group">
                    <label for="foto">Foto del Motocarro:</label>
                    <input type="file" id="foto" name="foto" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección del Domicilio:</label>
                    <input type="text" id="direccion" name="direccion">
                </div>
                <?php for ($i = 1; $i <= 2; $i++) : ?>
                <div class="form-group">
                    <label for="foto_<?php echo $i; ?>">Foto adicional <?php echo $i; ?>:</label>
                    <input type="file" id="foto_<?php echo $i; ?>" name="foto_<?php echo $i; ?>" accept="image/*">
                </div>
                <?php endfor; ?>
            </div>

            <!-- Fila 3 -->
            <div class="row">
                <div class="form-group">
                    <label for="certificado_antecedentes">Certificado de Antecedentes Judiciales:</label>
                    <input type="file" id="certificado_antecedentes" name="certificado_antecedentes" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="certificado_seguridad">Certificado de Seguridad Social:</label>
                    <input type="file" id="certificado_seguridad" name="certificado_seguridad" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="licencia_conduccion">Licencia de Conducción:</label>
                    <input type="file" id="licencia_conduccion" name="licencia_conduccion" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="seguro_vehiculo">Seguro del Vehículo:</label>
                    <input type="file" id="seguro_vehiculo" name="seguro_vehiculo" accept="image/*">
                </div>
            </div>

            <!-- Fila 4 -->
            <div class="row">
                <?php for ($i = 3; $i <= 6; $i++) : ?>
                <div class="form-group">
                    <label for="foto_<?php echo $i; ?>">Foto adicional <?php echo $i; ?>:</label>
                    <input type="file" id="foto_<?php echo $i; ?>" name="foto_<?php echo $i; ?>" accept="image/*">
                </div>
                <?php endfor; ?>
                <div class="form-group full-width">
                    <label for="detalles">Otros Detalles:</label>
                    <textarea id="detalles" name="detalles"></textarea>
                </div>
                <div class="form-group full-width">
                    <input type="submit" value="Registrar Operario">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
