<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dump Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel='stylesheet' type='text/css' media='screen' href='css/solicitante.css'>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="hero-dump">
        <div class="overlay"></div>
        <img src="fonts/imagenes/logo.png" alt="Descripción de la imagen" class="imagen-logotipo-dump">
        <h1 class="titulo-dump">¡Bienvenido a Dump Services!</h1>
        <h3 class="subtitulo-dump">Soluciones eficientes y confiables de transporte</h3>
        <p class="descripcion-dump">Ubicados en La Plata, Huila, especializados en el transporte de carga</p>
        <button class="cta-button" onclick="explorarServicios()">Explorar Servicios</button>
        <div class="social-icons">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        function explorarServicios() {
            window.location.href = 'servicios.php';
        }
    </script>
</body>

</html>
