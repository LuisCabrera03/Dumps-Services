<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dump Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Variables CSS */
        :root {
            --primary-color: #032b53;
            --secondary-color: #064575;
            --background-color: #f2f2f2;
            --footer-background: #021027;
            --footer-text-color: #f2f2f2;
            --footer-link-hover-color: #ddd;
            --transition-speed: 0.3s;
            --font-family: 'Roboto', sans-serif;
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
            line-height: 1.6;
        }

        /* Estilos del pie de página */
        footer {
            position: relative;
            background: var(--footer-background);
            color: var(--footer-text-color);
            text-align: center;
            padding: 60px 20px 20px;
            margin-top: 40px;
            overflow: hidden;
        }

        footer::before {
            content: "";
            position: absolute;
            top: -20px;
            left: 0;
            width: 100%;
            height: 40px;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTI4MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDEyODAgNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgMjZjMTYyLTc4IDMzOC05IDUwMCAwczMyOCA3OCA2MDYgMTYuMnYxNzIuOEgxVi0zMS44eiIgZmlsbD0iI2YyZjJmMiIgLz48L3N2Zz4=') no-repeat center;
            background-size: cover;
            z-index: 1;
        }

        footer hr {
            border: 0;
            height: 1px;
            background: var(--footer-text-color);
            margin: 20px 0;
            opacity: 0.2;
        }

        footer p {
            margin: 0;
            font-size: 1rem;
            font-family: var(--font-family);
        }

        .footer-content {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 40px;
            padding: 20px 0;
            z-index: 2;
            position: relative;
        }

        .footer-content div {
            flex: 1;
            min-width: 250px;
        }

        .footer-content h3 {
            margin-bottom: 15px;
            font-size: 1.2rem;
            color: var(--footer-link-hover-color);
        }

        .footer-content ul {
            list-style: none;
            padding: 0;
        }

        .footer-content li {
            margin: 10px 0;
        }

        .footer-content a {
            color: var(--footer-text-color);
            text-decoration: none;
            transition: color var(--transition-speed) ease;
        }

        .footer-content a:hover {
            color: var(--footer-link-hover-color);
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        .social-icons a {
            color: var(--footer-text-color);
            font-size: 1.5rem;
            transition: color var(--transition-speed) ease;
        }

        .social-icons a:hover {
            color: var(--footer-link-hover-color);
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-content">
            <div>
                <h3>Sobre nosotros</h3>
                <p>Dump Services es líder en la industria de servicios, proporcionando soluciones de alta calidad para todos nuestros clientes.</p>
            </div>
            <div>
                <h3>Enlaces útiles</h3>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Servicios</a></li>
                </ul>
            </div>
            <div>
                <h3>Contacto</h3>
                <p>Gmail: soportedumpservices@gmail.com</p>
                <p>Teléfono: +57 (320) 952 8762</p>
            </div>
        </div>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <hr>
        <p>© <?php echo date("Y"); ?> Dump Services. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
