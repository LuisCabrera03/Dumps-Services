<?php 
include 'header.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dump Services - Transporte Confiable y Eficiente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        /* General Styles */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
        }
        .section-subtitle {
            font-size: 1.2rem;
            text-align: center;
            color: #6c757d;
            margin-bottom: 60px;
        }
        /* Slider Section */
        .carousel-item img {
            height: 650px;
            object-fit: cover;
            filter: brightness(0.75); /* Slight darkening for better text readability */
        }
        .hero-section {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            text-align: center;
            color: white;
            width: 100%;
        }
        .hero-section h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }
        .hero-section p {
            font-size: 1.5rem;
            margin-bottom: 40px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }
        .hero-section .btn-primary {
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
        }
        /* About Us Section */
        .about-section {
            padding: 100px 0;
            background-color: #ffffff;
        }
        .about-section p {
            font-size: 1.2rem;
            line-height: 1.8;
            text-align: justify;
            margin-bottom: 20px;
        }
        .about-section img {
            max-width: 100%;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        /* Why Choose Us Section */
        .why-choose-us-section {
            background-color: #343a40;
            color: white;
            padding: 100px 0;
        }
        .why-choose-us-item {
            text-align: center;
            margin-bottom: 30px;
        }
        .why-choose-us-item i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #007bff;
        }
        .why-choose-us-item h5 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .why-choose-us-item p {
            font-size: 1.1rem;
        }
        /* Services Section */
        .features-section {
            padding: 100px 0;
        }
        .features-section .card {
            border: none;
            background-color: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .features-section .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        .features-section .card h5 {
            font-weight: 700;
            font-size: 1.25rem;
        }
        /* Team Section */
        .team-section {
            padding: 100px 0;
            background-color: #f1f1f1;
        }
        .team-member {
            text-align: center;
            margin-bottom: 30px;
        }
        .team-member img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        .team-member h5 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .team-member p {
            font-size: 1rem;
            color: #6c757d;
        }
        /* Testimonials Section */
        .testimonials-section {
            padding: 100px 0;
            background-color: #ffffff;
        }
        .testimonials-section .card {
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa;
            border-radius: 15px;
        }
        .testimonials-section .testimonial-text {
            font-size: 1.1rem;
            margin-top: 20px;
            color: #6c757d;
        }
        .testimonials-section .card-img-top {
            border-radius: 50%;
            margin-top: -50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        /* Contact Section */
        .contact-section {
            padding: 100px 0;
            background-color: #f8f9fa;
        }
        .contact-section .form-control {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .contact-section .btn-primary {
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
        }
        /* Footer */
        footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0;
        }
        footer p {
            margin: 0;
            text-align: center;
            font-size: 1rem;
        }
    </style>
</head>
<body>

    <!-- Carousel Section -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://www.revistaautocrash.com/wp-content/uploads/2022/09/Karguero-8-1024x683.jpg" class="d-block w-100" alt="Image 1">
            </div>
            <div class="carousel-item">
                <img src="https://comotos.co/wp-content/uploads/2021/08/Nuevo-AKT-Carguero-3W-200-2022.jpg" class="d-block w-100" alt="Image 2">
            </div>
            <div class="carousel-item">
                <img src="https://www.revistaautocrash.com/wp-content/uploads/2022/09/Karguero-6-1024x683.jpg" class="d-block w-100" alt="Image 3">
            </div>
            <div class="carousel-item">
                <img src="https://www.revistaautocrash.com/wp-content/uploads/2022/09/Karguero-1.jpg" class="d-block w-100" alt="Image 4">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        <!-- Hero Section (Overlay) -->
        <div class="hero-section">
            <div class="content">
                <h1>Bienvenido a Dump Services</h1>
                <p>Soluciones eficientes y confiables de transporte</p>
                <a href="#services" class="btn btn-primary">Explorar Servicios</a>
            </div>
        </div>
    </div>

    <!-- About Us Section -->
    <div class="about-section container">
        <h2 class="section-title">Sobre Nosotros</h2>
        <div class="row">
            <div class="col-md-6">
                <p>En Dump Services, nos especializamos en ofrecer soluciones de transporte adaptadas a las necesidades de nuestros clientes. Con una flota moderna de motocargueros y un equipo comprometido, aseguramos que tus productos lleguen a su destino de manera rápida, segura y eficiente.</p>
                <p>Nuestra misión es ser la opción preferida para el transporte de mercancías, combinando tecnología, innovación y un servicio al cliente excepcional para superar las expectativas de nuestros clientes.</p>
                <p>Nos esforzamos por mantener altos estándares de calidad en cada aspecto de nuestro servicio, desde la reserva hasta la entrega final, asegurando una experiencia sin complicaciones para nuestros usuarios.</p>
            </div>
            <div class="col-md-6">
                <img src="https://www.revistaautocrash.com/wp-content/uploads/2022/09/Karguero-1.jpg" alt="Sobre Nosotros">
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="why-choose-us-section">
        <div class="container">
            <h2 class="section-title">¿Por Qué Elegirnos?</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="why-choose-us-item">
                        <i class="fas fa-truck-moving"></i>
                        <h5>Entrega Rápida</h5>
                        <p>Garantizamos tiempos de entrega rápidos y precisos, asegurando que tus productos lleguen a tiempo.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-choose-us-item">
                        <i class="fas fa-shield-alt"></i>
                        <h5>Seguridad y Confianza</h5>
                        <p>Nuestros servicios están respaldados por medidas de seguridad avanzadas para proteger tu carga en todo momento.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-choose-us-item">
                        <i class="fas fa-headset"></i>
                        <h5>Soporte 24/7</h5>
                        <p>Nuestro equipo de soporte está disponible 24/7 para ayudarte con cualquier consulta o necesidad que puedas tener.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div id="services" class="container features-section">
        <h2 class="section-title">Nuestras Funcionalidades</h2>
        <div class="section-subtitle">Explora nuestros servicios y descubre cómo podemos ayudarte a cumplir con tus necesidades de transporte.</div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-center p-4">
                    <i class="fas fa-truck fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Transporte Eficiente</h5>
                    <p class="card-text">Servicios de transporte utilizando motocargueros rápidos y seguros para cualquier tipo de carga.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center p-4">
                    <i class="fas fa-calendar-check fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Reservas Fáciles</h5>
                    <p class="card-text">Reserva tus servicios de transporte de manera rápida y sencilla con nuestro sistema en línea.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center p-4">
                    <i class="fas fa-calculator fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Cálculo de Tarifas</h5>
                    <p class="card-text">Obtén un presupuesto inmediato para tus necesidades de transporte con nuestra herramienta en línea.</p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card text-center p-4">
                    <i class="fas fa-shield-alt fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Seguridad en los Envíos</h5>
                    <p class="card-text">Garantizamos la seguridad de tus envíos con monitoreo en tiempo real y medidas de seguridad avanzadas.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center p-4">
                    <i class="fas fa-clock fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Entrega Rápida</h5>
                    <p class="card-text">Nuestro compromiso es la entrega rápida y eficiente, cumpliendo siempre con los plazos acordados.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center p-4">
                    <i class="fas fa-calendar-alt fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Flexibilidad Horaria</h5>
                    <p class="card-text">Ofrecemos horarios de entrega flexibles para adaptarnos a tus necesidades.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="team-section">
        <div class="container">
            <h2 class="section-title">Nuestro Equipo</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="https://images.unsplash.com/photo-1573497491208-6b1acb260507" alt="Team Member 1">
                        <h5>Juan Pérez</h5>
                        <p>Director General</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="https://images.unsplash.com/photo-1607746882042-944635dfe10e" alt="Team Member 2">
                        <h5>María López</h5>
                        <p>Gerente de Operaciones</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="https://images.unsplash.com/photo-1537511446984-935f663eb1f4" alt="Team Member 3">
                        <h5>Carlos Rodríguez</h5>
                        <p>Jefe de Logística</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="container testimonials-section">
        <h2 class="section-title">Testimonios de Nuestros Clientes</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <img src="https://images.unsplash.com/photo-1573497491208-6b1acb260507" alt="Cliente 1" class="card-img-top rounded-circle mx-auto d-block mt-3" style="width: 100px;">
                    <div class="card-body">
                        <p class="testimonial-text">¡Excelente servicio! Me ayudaron a enviar mis productos de forma rápida y segura.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <img src="https://images.unsplash.com/photo-1607746882042-944635dfe10e" alt="Cliente 2" class="card-img-top rounded-circle mx-auto d-block mt-3" style="width: 100px;">
                    <div class="card-body">
                        <p class="testimonial-text">¡Muy recomendado! Me sorprendió lo eficiente que fue el proceso de envío.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <img src="https://images.unsplash.com/photo-1537511446984-935f663eb1f4" alt="Cliente 3" class="card-img-top rounded-circle mx-auto d-block mt-3" style="width: 100px;">
                    <div class="card-body">
                        <p class="testimonial-text">¡Fantástico servicio al cliente! Siempre están disponibles para responder a mis preguntas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="contact-section">
        <div class="container">
            <h2 class="section-title">Contacto</h2>
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <input type="text" class="form-control" placeholder="Nombre Completo">
                        <input type="email" class="form-control" placeholder="Correo Electrónico">
                        <textarea class="form-control" rows="5" placeholder="Mensaje"></textarea>
                        <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h4>Oficina Principal</h4>
                    <p>1234 Calle Falsa, Ciudad, País</p>
                    <h4>Teléfono</h4>
                    <p>(+123) 456-7890</p>
                    <h4>Email</h4>
                    <p>soportedumpservices@gmail.com</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 Dump Services. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

