<?php
    // Esta seccion contiene el fragmento de HTML del Header

    // ===== SESION DEL USUARIO =====
    // session_status: solo abre la sesion si la pagina no la abrio antes (evita el aviso "session already started")
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Datos que guardo AuthController.php al iniciar sesion
    $sesionActiva  = isset($_SESSION['usuario_id']);
    $nombreSesion  = $_SESSION['usuario'] ?? '';
    $esAdminSesion = ($_SESSION['rol'] ?? '') === 'admin';
    // Foto: solo si el archivo existe | si no, se muestra la inicial del nombre
    $fotoSesion = null;
    if (!empty($_SESSION['foto']) && file_exists(__DIR__ . '/../../../assets/imgs/usuarios/' . $_SESSION['foto'])) {
        $fotoSesion = '/assets/imgs/usuarios/' . $_SESSION['foto'];
    }
?>
<header>
    <!-- ======================================================= HEADER PC ======================================================= -->
    <!-- Solo visible en pantallas de 1030px o mas (clase solo-pc) -->
    <!-- |-------------------------- NAV PRINCIPAL | Botones and Search --------------------------| -->
    <nav class="bg-white border-bottom py-3 solo-pc">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between gap-3 gap-lg-4">
                <div>
                    <!-- Boton Categorias - PC | Se agrego d-flex con gap-2 para que el icono y el texto queden en la misma linea -->
                    <button class="btn btn-primary px-3 py-2 rounded-3 fw-semibold flex-shrink-0 d-flex align-items-center gap-2" type="button">
                        <i class="fi fi-rr-menu-burger d-flex"></i>         <!-- Icono de menu | Mediante CDN -->
                        <small>Categorías</small>
                    </button>
                </div>
                <div>
                    <!-- LOGO -->
                    <a class="flex-shrink-1 flex-grow-1 flex-md-grow-0 text-start" style="min-width: 0;" href="#">
                        <img src="/assets/imgs/logos/logo1.webp" alt="Logo" class="img-fluid" style="max-height: 50px;">
                    </a>
                </div>
                <!-- Buscador PC -->
                <form class="flex-grow-1 mx-lg-3">
                    <input class="form-control rounded-3 py-2" type="search" placeholder="Buscar productos, código, marcas y más...">
                </form>
                <!-- Usuario y carrito -->
                <div class="d-flex align-items-center gap-3 gap-lg-4 flex-shrink-0">
                    <?php if ($sesionActiva): ?>
                    <!-- Usuario CON sesion: foto + nombre | al hacer clic se abre un menu (dropdown) -->
                    <div class="dropdown">
                        <a class="d-flex align-items-center gap-2 text-dark text-decoration-none" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if ($fotoSesion): ?>
                                <img src="<?= htmlspecialchars($fotoSesion) ?>" alt="Foto de <?= htmlspecialchars($nombreSesion) ?>" width="44" height="44" class="rounded-circle object-fit-cover border">
                            <?php else: ?>
                                <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                    <?= htmlspecialchars(strtoupper(mb_substr($nombreSesion, 0, 1))) ?>
                                </div>
                            <?php endif; ?>
                            <div class="d-none d-xl-block lh-sm">
                                <small class="text-secondary fw-semibold">HOLA</small><br>
                                <span class="fw-bold small"><?= htmlspecialchars($nombreSesion) ?></span>
                            </div>
                        </a>
                        <!-- dropdown-menu-end: el menu se alinea a la derecha para no salirse de la pantalla -->
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <?php if ($esAdminSesion): ?>
                                <li><a class="dropdown-item" href="/admin/index.php">Panel de administración</a></li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item text-danger" href="/admin/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </div>
                    <?php else: ?>
                    <!-- Usuario SIN sesion: abre el modal de login -->
                    <a class="d-flex align-items-center gap-2 text-dark text-decoration-none" href="/src/pages/login.php" data-bs-toggle="modal" data-bs-target="#modalLogin">
                        <!-- Se agrego d-flex para centrar el icono dentro del circulo -->
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="fi fi-rr-user fs-5 d-flex"></i>   <!-- Se agrego fs-5 para el tamaño y d-flex para centrarlo bien -->
                        </div>
                        <div class="d-none d-xl-block lh-sm">
                            <small class="text-secondary fw-semibold">BIENVENIDO</small><br>
                            <span class="fw-bold small">Iniciar Sesión</span>
                        </div>
                    </a>
                    <?php endif; ?>
                    <!-- Carrito -->
                    <a class="d-flex align-items-center gap-2 text-dark text-decoration-none" href="#">
                        <!-- Se agrego d-flex para centrar el icono dentro del circulo -->
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="fi fi-rr-shopping-cart fs-5 d-flex"></i>  <!-- Se agrego fs-5 para el tamaño y d-flex para centrarlo bien -->
                        </div>
                        <span class="fw-bold small d-none d-xl-inline">Carrito</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- |-------------------------- NAV SECUNDARIO | Navegación entre páginas --------------------------| -->
    <nav class="bg-primary solo-pc">
        <div class="container">
            <!-- justify-content-between reparte los enlaces en todo el ancho del container -->
            <ul class="nav justify-content-between fs-6"> <!-- fs-6 en el ul agranda la letra de todos los enlaces -->
                <li class="nav-item"><a class="nav-link text-white fw-semibold" href="/index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-white fw-semibold" href="/src/pages/ofertas.php">Ofertas</a></li>
                <!-- d-flex y gap-1 para poner el icono de flecha al lado del texto -->
                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold d-flex align-items-center gap-1" href="/src/pages/categorias.php">Categorías <i class="fi fi-rr-angle-small-down d-flex"></i></a>
                </li>
                <!-- d-flex y gap-1 para poner el icono de flecha al lado del texto -->
                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold d-flex align-items-center gap-1" href="/src/pages/terminos.php">Términos <i class="fi fi-rr-angle-small-down d-flex"></i></a>
                </li>
                <!-- d-flex y gap-1 para poner el icono de flecha al lado del texto -->
                <li class="nav-item">
                    <a class="nav-link text-white fw-semibold d-flex align-items-center gap-1" href="/src/pages/servicios.php">Servicios <i class="fi fi-rr-angle-small-down d-flex"></i></a>
                </li>
                <li class="nav-item"><a class="nav-link text-white fw-semibold" href="/src/pages/contacto.php">Contacto</a></li>
                <li class="nav-item"><a class="nav-link text-white fw-semibold" href="/src/pages/nosotros.php">Nosotros</a></li>
            </ul>
        </div>
    </nav>
    <!-- ========================================================================================================================= -->

    <!-- ===================================================== HEADER MOVIL ====================================================== -->
    <!-- Solo visible en pantallas de menos de 1030px (clase solo-movil) -->
    <!-- |-------------------------- NAV PRINCIPAL | Botones and Search en Small --------------------------| -->
    <nav class="bg-white border-bottom py-3 solo-movil">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between gap-3 gap-lg-4">
                <div>
                    <!-- Boton Categorias | Se agrego d-flex para alinear y centra elementos -->
                    <!-- Boton Categorias | Se agrego flex-shrink-0 para eviatr que los elemntos se encojan -->
                    <!-- data-bs-toggle y data-bs-target abren el menu lateral (offcanvas) con id="menuMovil" -->
                    <button class="bg-light border-0 rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuMovil">
                        <i class="fi fi-rr-menu-burger fs-5 d-flex"></i>    <!-- Icono de menu | Mediante CDN -->
                    </button>
                </div>
                <div>
                    <!-- LOGO movil | En celular el logo ocupa el espacio libre (flex-grow-1) -->
                    <a class="flex-shrink-1 flex-grow-1 flex-md-grow-0 text-start" style="min-width: 0;" href="#">
                        <img src="assets/imgs/logos/logo1.webp" alt="Logo" class="img-fluid" style="max-height: 42px;">
                    </a>
                </div>
                <!-- Usuario y carrito | En movil solo se ven los iconos -->
                <div class="d-flex align-items-center gap-3 gap-lg-4 flex-shrink-0">
                    <?php if ($sesionActiva): ?>
                    <!-- Usuario CON sesion (movil): solo la foto | al tocarla se abre el menu -->
                    <div class="dropdown">
                        <a class="d-flex text-decoration-none" href="#" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Mi cuenta">
                            <?php if ($fotoSesion): ?>
                                <img src="<?= htmlspecialchars($fotoSesion) ?>" alt="Foto de <?= htmlspecialchars($nombreSesion) ?>" width="44" height="44" class="rounded-circle object-fit-cover border">
                            <?php else: ?>
                                <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                    <?= htmlspecialchars(strtoupper(mb_substr($nombreSesion, 0, 1))) ?>
                                </div>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <!-- En movil no se ve el nombre al lado de la foto, asi que va dentro del menu -->
                            <li><span class="dropdown-item-text fw-bold"><?= htmlspecialchars($nombreSesion) ?></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php if ($esAdminSesion): ?>
                                <li><a class="dropdown-item" href="/admin/index.php">Panel de administración</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item text-danger" href="/admin/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </div>
                    <?php else: ?>
                    <!-- Usuario SIN sesion: abre el modal de login -->
                    <a class="d-flex align-items-center gap-2 text-dark text-decoration-none" href="/src/pages/login.php" data-bs-toggle="modal" data-bs-target="#modalLogin" aria-label="Iniciar sesión">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="fi fi-rr-user fs-5 d-flex"></i>
                        </div>
                    </a>
                    <?php endif; ?>
                    <!-- Carrito -->
                    <a class="d-flex align-items-center gap-2 text-dark text-decoration-none" href="#">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="fi fi-rr-shopping-cart fs-5 d-flex"></i>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Buscador para movil -->
            <form class="mt-3">
                <input class="form-control rounded-3 py-2" type="search" placeholder="Buscar productos, código, marcas y más...">
            </form>
        </div>
    </nav>

    <!-- |-------------------------- NAV SECUNDARIO | Menu Lateral Desglosable --------------------------| -->
    <!-- Menu lateral para movil (offcanvas de Bootstrap) -->
    <!-- --bs-offcanvas-width: el menu ocupa solo el 75% del ancho de la pantalla -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="menuMovil" style="--bs-offcanvas-width: 75%;">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">Menú</h5>
            <!-- Boton para cerrar el menu -->
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <!-- d-flex flex-column para poder mandar el WhatsApp y las redes al fondo con mt-auto -->
        <div class="offcanvas-body p-0 d-flex flex-column">
            <!-- list-group: lista de Bootstrap con una linea entre cada opcion -->
            <div class="list-group list-group-flush">
                <!-- d-flex y justify-content-between ponen el texto a la izquierda y la flecha a la derecha -->
                <a class="list-group-item list-group-item-action fw-semibold py-3 d-flex justify-content-between align-items-center" href="#">Categorías <i class="fi fi-rr-angle-small-down d-flex"></i></a>
                <a class="list-group-item list-group-item-action fw-semibold py-3" href="#">Ofertas</a>
                <a class="list-group-item list-group-item-action fw-semibold py-3 d-flex justify-content-between align-items-center" href="#">Términos <i class="fi fi-rr-angle-small-down d-flex"></i></a>
                <a class="list-group-item list-group-item-action fw-semibold py-3 d-flex justify-content-between align-items-center" href="#">Servicios <i class="fi fi-rr-angle-small-down d-flex"></i></a>
                <a class="list-group-item list-group-item-action fw-semibold py-3" href="#">Contacto</a>
                <a class="list-group-item list-group-item-action fw-semibold py-3" href="#">Nosotros</a>
            </div>
            <!-- mt-auto empuja este bloque hasta el fondo del menu -->
            <div class="mt-auto p-3 border-top">
                <!-- btn-success es el verde de Bootstrap, w-100 ocupa todo el ancho -->
                <a class="btn btn-success w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 mb-3" href="#" target="_blank">
                    <i class="fi fi-brands-whatsapp d-flex"></i> Escríbenos por WhatsApp
                </a>
                <!-- Circulos grises (bg-secondary-subtle) con el logo en negro (text-dark) encima | text-decoration-none quita la linea de subrayado del enlace -->
                <div class="d-flex justify-content-center gap-3 fs-5">
                    <a class="bg-secondary-subtle text-dark text-decoration-none rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" href="#"><i class="fi fi-brands-facebook d-flex"></i></a>
                    <a class="bg-secondary-subtle text-dark text-decoration-none rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" href="#"><i class="fi fi-brands-instagram d-flex"></i></a>
                    <a class="bg-secondary-subtle text-dark text-decoration-none rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;" href="#"><i class="fi fi-brands-tik-tok d-flex"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================================================================================================================= -->  
</header>

<?php include __DIR__ . '/login-modal.php'; ?> <!-- modal de inicio de sesion (disponible en todas las paginas) -->
