<?php
require_once __DIR__ . '/../src/conexion/conexion.php';   // crea $conexion

// ============ 1. NUMEROS PARA LAS TARJETAS DE RESUMEN ============
// COUNT(*) cuenta filas | fetchColumn() devuelve directamente el primer valor (el numero)
$totalLaptops     = $conexion->query("SELECT COUNT(*) FROM laptops")->fetchColumn();
$totalOfertas     = $conexion->query("SELECT COUNT(*) FROM laptops WHERE precio_anterior IS NOT NULL")->fetchColumn();
$totalFabricantes = $conexion->query("SELECT COUNT(*) FROM fabricantes")->fetchColumn();
$totalUsuarios    = $conexion->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();

// ============ 2. ULTIMAS 5 LAPTOPS REGISTRADAS ============
$sql = "SELECT l.numero_serie, l.modelo, l.precio, l.precio_anterior, l.activo, f.nombre_fabricante
        FROM laptops l
        JOIN fabricantes f ON f.id_fabricante = l.id_fabricante
        ORDER BY l.creado_en DESC
        LIMIT 5";
$ultimasLaptops = $conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// ============ 3. LAPTOPS POR FABRICANTE ============
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
    ['Fabricantes', $totalFabricantes, 'fi-rr-factory',       'success', '/src/controllers/list/listar-fabricantes.php'],
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
<body class="bg-light">

<!-- ============ BARRA SUPERIOR ============ -->
<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand fw-bold mb-0">NexusCorp · Admin</span>
    <a href="/index.php" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
        <i class="fi fi-rr-shop d-flex"></i> Ver tienda
    </a>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- ============ MENU LATERAL ============ -->
        <!-- col-md-3 col-lg-2: angosto en PC | en movil ocupa todo el ancho y queda arriba del contenido -->
        <aside class="col-md-3 col-lg-2 bg-white border-end p-3">
            <!-- nav-pills flex-column: botones del menu uno debajo del otro | active marca la pagina actual -->
            <nav class="nav nav-pills flex-column gap-1">
                <a href="/admin/index.php" class="nav-link active d-flex align-items-center gap-2">
                    <i class="fi fi-rr-dashboard d-flex"></i> Dashboard
                </a>
                <a href="/src/controllers/list/listar-laptops.php" class="nav-link text-dark d-flex align-items-center gap-2">
                    <i class="fi fi-rr-laptop d-flex"></i> Laptops
                </a>
                <a href="/src/controllers/list/listar-fabricantes.php" class="nav-link text-dark d-flex align-items-center gap-2">
                    <i class="fi fi-rr-factory d-flex"></i> Fabricantes
                </a>
                <a href="/src/controllers/list/listar-usuarios.php" class="nav-link text-dark d-flex align-items-center gap-2">
                    <i class="fi fi-rr-users d-flex"></i> Usuarios
                </a>
            </nav>
        </aside>

        <!-- ============ CONTENIDO ============ -->
        <main class="col-md-9 col-lg-10 p-4">
            <h1 class="fs-3 fw-bold mb-4">Dashboard</h1>

            <!-- 1. Tarjetas de resumen | 2 por fila en movil, 4 en PC -->
            <div class="row row-cols-2 row-cols-lg-4 g-3 mb-4">
                <?php foreach ($tarjetas as [$titulo, $numero, $icono, $color, $enlace]): ?>
                <div class="col">
                    <!-- position-relative + stretched-link: toda la tarjeta lleva a su lista -->
                    <div class="card border-0 shadow-sm h-100 position-relative">
                        <div class="card-body d-flex align-items-center gap-3">
                            <!-- bg-opacity-10: fondo del mismo color pero muy claro -->
                            <div class="bg-<?= $color ?> bg-opacity-10 text-<?= $color ?> rounded-3 p-3 d-flex">
                                <i class="fi <?= $icono ?> fs-3 d-flex"></i>
                            </div>
                            <div>
                                <p class="text-secondary small mb-0"><?= $titulo ?></p>
                                <p class="fs-3 fw-bold mb-0 lh-1"><?= $numero ?></p>
                            </div>
                        </div>
                        <a href="<?= $enlace ?>" class="stretched-link" aria-label="Ver <?= $titulo ?>"></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- 2. Acciones rapidas -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="/src/controllers/add/agregar-laptos.php" class="btn btn-primary">+ Nueva laptop</a>
                <a href="/src/controllers/add/agregar-fabricantes.php" class="btn btn-success">+ Nuevo fabricante</a>
                <a href="/src/controllers/add/agregar-usuario.php" class="btn btn-warning">+ Nuevo usuario</a>
            </div>

            <div class="row g-3">
                <!-- 3. Ultimas laptops | col-lg-8: ocupa 2/3 en PC -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Últimas laptops registradas</span>
                            <a href="/src/controllers/list/listar-laptops.php" class="small text-decoration-none">Ver todas</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Modelo</th>
                                        <th>Fabricante</th>
                                        <th class="text-end">Precio</th>
                                        <th class="text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ultimasLaptops as $lap): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($lap['modelo']) ?></td>
                                        <td><?= htmlspecialchars($lap['nombre_fabricante']) ?></td>
                                        <td class="text-end text-nowrap">S/ <?= number_format($lap['precio'], 2) ?></td>
                                        <td class="text-center">
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
                </div>

                <!-- 4. Laptops por fabricante | col-lg-4: ocupa 1/3 en PC -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white fw-semibold">Laptops por fabricante</div>
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
                </div>
            </div>
        </main>

    </div>
</div>

</body>
</html>
