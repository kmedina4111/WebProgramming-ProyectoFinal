<?php
    session_start();   
    require_once __DIR__ . '/../src/conexion/conexion.php';  

    // ============ SOLO ADMINISTRADORES ============
    // vuelve a la tienda y se abre el modal de login (?login=1)
    if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] ?? '') !== 'admin') {
        header('Location: /index.php?login=1');
        exit;
    }

    // ============ ADMINISTRADOR CONECTADO (bloque de abajo del menu lateral) ============
    // Se vuelve a leer de la base de datos, si se edita su nombre o foto se ve reflejado el cambio
    $stmt = $conexion->prepare("SELECT usuario, nombre, rol, foto FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['usuario_id']]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Nombre que se muestra abajo del menu: el nombre de la persona, o el usuario (correo) si aun no tiene nombre
    $nombreAdmin = '';
    if ($admin) {
        $nombreAdmin = $admin['nombre'] !== '' ? $admin['nombre'] : $admin['usuario'];
    }

    // Ruta de la foto: se usa solo si el archivo existe de verdad
    $fotoAdmin = null;
    if ($admin && !empty($admin['foto']) && file_exists(__DIR__ . '/../assets/imgs/usuarios/' . $admin['foto'])) {
        $fotoAdmin = '/assets/imgs/usuarios/' . $admin['foto'];
    }

    // ============ NUMEROS PARA LAS TARJETAS DE RESUMEN ============
    // COUNT(*) cuenta filas | fetchColumn() devuelve directamente el primer valor (el numero)
    $totalLaptops     = $conexion->query("SELECT COUNT(*) FROM laptops")->fetchColumn();
    $totalOfertas     = $conexion->query("SELECT COUNT(*) FROM laptops WHERE precio_anterior IS NOT NULL")->fetchColumn();
    $totalFabricantes = $conexion->query("SELECT COUNT(*) FROM fabricantes")->fetchColumn();
    $totalUsuarios    = $conexion->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();

    // ============ ULTIMAS 10 LAPTOPS REGISTRADAS ============
    // Se puede cambiar el limite medianrte LIMIT 10, a elecccion del usr
    $sql = "SELECT l.numero_serie, l.modelo, l.precio, l.precio_anterior, l.activo, f.nombre_fabricante
            FROM laptops l
            JOIN fabricantes f ON f.id_fabricante = l.id_fabricante
            ORDER BY l.creado_en DESC
            LIMIT 10";
    $ultimasLaptops = $conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // ============ LAPTOPS POR FABRICANTE ============
    // LEFT JOIN: tambien aparecen los fabricantes con 0 laptops
    $sql = "SELECT f.nombre_fabricante, COUNT(l.numero_serie) AS total
            FROM fabricantes f
            LEFT JOIN laptops l ON l.id_fabricante = f.id_fabricante
            GROUP BY f.id_fabricante, f.nombre_fabricante
            ORDER BY total DESC";
    $porFabricante = $conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // Tarjetas: se escriben una sola vez en un foreach (titulo, numero, icono, color, enlace)
    $tarjetas = [
        ['Laptops',     $totalLaptops,     'fi-rr-laptop',        'primary', '/src/controllers/list/listar-laptops.php'],
        ['En oferta',   $totalOfertas,     'fi-rr-badge-percent', 'danger',  '/src/controllers/list/listar-laptops.php'],
        ['Fabricantes', $totalFabricantes, 'fi-rr-industry-alt',  'success', '/src/controllers/list/listar-fabricantes.php'],
        ['Usuarios',    $totalUsuarios,    'fi-rr-users',         'warning', '/src/controllers/list/listar-usuarios.php'],
    ];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de administración - NexusCorp</title>
    <link rel="icon" type="image/png" href="/assets/imgs/favicon/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/4.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
</head>
<!-- min-vh-100: el body mide como minimo el alto completo de la ventana -->
<!-- d-flex flex-column: barra superior arriba y el resto (menu + contenido) debajo, ocupando lo que sobra -->
<body class="bg-light d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-dark bg-dark px-3">
            <span class="navbar-brand fw-bold mb-0">NexusCorp · Admin</span>
            <a href="/index.php" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
                <i class="fi fi-rr-shop d-flex"></i> Ver tienda
            </a>
        </nav>
    </header>
    <!-- flex-grow-1: ocupa todo el alto que deja la barra superior | d-flex flex-column: para que la fila tambien pueda estirarse -->
    <main class="container-fluid flex-grow-1 d-flex flex-column">
        <!-- row: la grilla de Bootstrap necesita este div para poner el menu y el contenido lado a lado -->
        <!-- flex-grow-1: la fila llega hasta abajo, y sus columnas (menu y contenido) se estiran con ella -->
        <div class="row flex-grow-1">

            <!-- ============ MENU LATERAL ============ -->
            <!-- col-md-3 col-lg-2: angosto en PC | en movil ocupa todo el ancho y queda arriba del contenido -->
            <!-- d-flex flex-column: el menu arriba y el bloque del usuario empujado hasta abajo (con mt-auto) -->
            <aside class="col-md-3 col-lg-2 bg-white border-end p-3 d-flex flex-column">
                <!-- nav-pills flex-column: botones del menu uno debajo del otro | active marca la pagina actual -->
                <nav class="nav nav-pills flex-column gap-1">
                    <a href="/admin/index.php" class="nav-link active d-flex align-items-center gap-2">
                        <i class="fi fi-rr-dashboard d-flex"></i> Overview
                    </a>
                    <a href="/src/controllers/list/listar-laptops.php" class="nav-link text-dark d-flex align-items-center gap-2">
                        <i class="fi fi-rr-laptop d-flex"></i> Laptops
                    </a>
                    <a href="/src/controllers/list/listar-fabricantes.php" class="nav-link text-dark d-flex align-items-center gap-2">
                        <i class="fi fi-rr-industry-alt d-flex"></i> Fabricantes
                    </a>
                    <a href="/src/controllers/list/listar-usuarios.php" class="nav-link text-dark d-flex align-items-center gap-2">
                        <i class="fi fi-rr-users d-flex"></i> Usuarios
                    </a>
                </nav>

                <!-- ============ USUARIO ADMINISTRADOR (abajo del menu) ============ -->
                <!-- mt-auto: ocupa todo el espacio libre de arriba, asi el bloque queda pegado abajo -->
                <?php if ($admin): ?>
                <div class="mt-auto pt-3 border-top d-flex align-items-center gap-2">
                    <!-- Foto en circulo | flex-shrink-0: no se achica aunque el nombre sea largo o se redimensiones la pantalla -->
                    <?php if ($fotoAdmin): ?>
                        <img src="<?= htmlspecialchars($fotoAdmin) ?>" alt="Foto de <?= htmlspecialchars($nombreAdmin) ?>" width="40" height="40" class="rounded-circle object-fit-cover border flex-shrink-0">
                    <?php else: ?>
                        <!-- Sin foto: circulo con la inicial del nombre -->
                        <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                            <?= htmlspecialchars(strtoupper(mb_substr($nombreAdmin, 0, 1))) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Nombre en negrita y rol debajo | min-w-0 + text-truncate: si el nombre es largo se corta con "..." -->
                    <div class="lh-sm" style="min-width: 0;">
                        <p class="fw-bold mb-0 text-truncate"><?= htmlspecialchars($nombreAdmin) ?></p>
                        <small class="text-secondary"><?= $admin['rol'] === 'admin' ? 'Administrador' : 'Cliente' ?></small>
                    </div>

                    <!-- Icono de salir | ms-auto: lo empuja al extremo derecho -->
                    <a href="/admin/logout.php" class="ms-auto text-secondary text-decoration-none d-flex p-1" title="Cerrar sesión" aria-label="Cerrar sesión">
                        <i class="fi fi-rr-sign-out-alt d-flex fs-5"></i>
                    </a>
                </div>
                <?php endif; ?>
            </aside>
            <!-- ============ CONTENIDO (Overview) ============ -->
            <!-- section: un bloque tematico de la pagina, con su propio titulo (h1) -->
            <section class="col-md-9 col-lg-10 p-4">
                <h1 class="fs-3 fw-bold mb-4">Overview</h1>

                <!-- 1. Tarjetas de resumen | 2 por fila en movil, 4 en PC -->
                <!-- aria-label: le da nombre a la seccion ya que no tiene un titulo visible -->
                <section class="row row-cols-2 row-cols-lg-4 g-3 mb-4" aria-label="Resumen">
                    <?php foreach ($tarjetas as [$titulo, $numero, $icono, $color, $enlace]): ?>
                    <!-- article: cada tarjeta es un elemento independiente (se entiende solo) -->
                    <!-- col: la columna de la grilla | position-relative + stretched-link: toda la tarjeta lleva a su lista -->
                    <article class="col">
                        <div class="card border-0 shadow-sm h-100 position-relative">
                            <div class="card-body d-flex align-items-center gap-3">
                                <!-- bg-opacity-10: fondo del mismo color pero muy claro -->
                                <div class="bg-<?= $color ?> bg-opacity-10 text-<?= $color ?> rounded-3 p-3 d-flex">
                                    <i class="fi <?= $icono ?> fs-3 d-flex"></i>
                                </div>
                                <div>
                                    <h2 class="text-secondary small fw-normal mb-0"><?= $titulo ?></h2>
                                    <p class="fs-3 fw-bold mb-0 lh-1"><?= $numero ?></p>
                                </div>
                            </div>
                            <a href="<?= $enlace ?>" class="stretched-link" aria-label="Ver <?= $titulo ?>"></a>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </section>

                <!-- 2. Botones de acciones rapidas | nav: es un grupo de enlaces -->
                <nav class="d-flex flex-wrap gap-2 mb-4" aria-label="Acciones rápidas">
                    <!-- fi fi-rr-plus: icono "+" del CDN de Flaticon (uicons-regular-rounded, cargado en el head) | d-flex en el icono lo alinea al centro del texto -->
                    <a href="/src/controllers/add/agregar-laptos.php" class="btn btn-primary d-flex align-items-center gap-2"><i class="fi fi-rr-plus d-flex"></i> Nueva laptop</a>
                    <a href="/src/controllers/add/agregar-fabricantes.php" class="btn btn-success d-flex align-items-center gap-2"><i class="fi fi-rr-plus d-flex"></i> Nuevo fabricante</a>
                    <a href="/src/controllers/add/agregar-usuario.php" class="btn btn-warning d-flex align-items-center gap-2"><i class="fi fi-rr-plus d-flex"></i> Nuevo usuario</a>
                </nav>

                <!-- 3. Detalle: ultimas laptops y laptops por fabricante -->
                <section class="row g-3" aria-label="Detalle">
                    <!-- Ultimas laptops | col-lg-8: ocupa 2/3 en PC -->
                    <article class="col-lg-8">
                        <div class="card border-0 shadow-sm h-100">
                            <!-- header dentro de article: la cabecera de esa tarjeta (titulo + enlace) -->
                            <header class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h2 class="fs-6 fw-semibold mb-0">Últimas laptops registradas</h2>
                                <a href="/src/controllers/list/listar-laptops.php" class="small text-decoration-none">Ver todas</a>
                            </header>
                            <div class="table-responsive">
                                <!-- ps-4 / pe-4: espacio en la primera y ultima columna para que el texto no quede pegado a los bordes de la tarjeta | py-3: mas alto cada fila -->
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4 py-3">Modelo</th>
                                            <th class="py-3">Fabricante</th>
                                            <th class="text-end py-3">Precio</th>
                                            <th class="text-center pe-4 py-3">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ultimasLaptops as $lap): ?>
                                        <tr>
                                            <td class="ps-4 py-3"><?= htmlspecialchars($lap['modelo']) ?></td>
                                            <td class="py-3"><?= htmlspecialchars($lap['nombre_fabricante']) ?></td>
                                            <td class="text-end text-nowrap py-3">S/ <?= number_format($lap['precio'], 2) ?></td>
                                            <td class="text-center pe-4 py-3">
                                                <?php if ($lap['activo']): ?>
                                                    <span class="badge bg-success">Activo</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Inactivo</span>
                                                <?php endif; ?>
                                                <?php if (!empty($lap['precio_anterior'])): ?>
                                                    <span class="badge bg-danger">Oferta</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>

                                        <?php if (count($ultimasLaptops) === 0): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-secondary py-4">Aún no hay laptops registradas.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </article>

                    <!-- Laptops por fabricante | col-lg-4: ocupa 1/3 en PC -->
                    <article class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <header class="card-header bg-white">
                                <h2 class="fs-6 fw-semibold mb-0">Laptops por fabricante</h2>
                            </header>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($porFabricante as $fab): ?>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span><?= htmlspecialchars($fab['nombre_fabricante']) ?></span>
                                        <span class="fw-semibold"><?= $fab['total'] ?></span>
                                    </div>
                                    <!-- Barra: el ancho es el porcentaje de laptops de ese fabricante sobre el total -->
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" style="width: <?= $totalLaptops > 0 ? round($fab['total'] * 100 / $totalLaptops) : 0 ?>%;"></div>
                                    </div>
                                </li>
                                <?php endforeach; ?>

                                <?php if (count($porFabricante) === 0): ?>
                                <li class="list-group-item text-center text-secondary py-4">Aún no hay fabricantes.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </article>
                </section>
            </section>

        </div>
    </main>
</body>
</html>
