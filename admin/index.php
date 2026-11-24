<?php
    // ===================== DASHBOARD DEL ADMINISTRADOR =====================
    // Por ahora usa DATOS DE EJEMPLO. Cuando exista la base de datos, estos arreglos
    // se reemplazan por consultas de los modelos (Producto, Pedido, Usuario).
    // Pendiente: proteger esta pagina con src/lib/auth.php (solo usuarios con rol admin).

    $moneda = '$'; // Cambiar por la moneda de la tienda (ej. 'S/')

    // Tarjetas de resumen
    $resumen = [
        ['titulo' => 'Ventas del mes',   'valor' => $moneda . ' 12,450.00', 'icono' => 'fi-rr-chart-line-up',   'color' => 'primary'],
        ['titulo' => 'Pedidos',          'valor' => '38',                   'icono' => 'fi-rr-shopping-cart',   'color' => 'success'],
        ['titulo' => 'Clientes',         'valor' => '124',                  'icono' => 'fi-rr-users',           'color' => 'info'],
        ['titulo' => 'Stock bajo',       'valor' => '5',                    'icono' => 'fi-rr-box-open',        'color' => 'danger'],
    ];

    // Ultimos pedidos
    $pedidos = [
        ['id' => 1045, 'cliente' => 'Cliente de prueba 1', 'fecha' => '22/11/2026', 'total' => 1899.90, 'estado' => 'Pendiente'],
        ['id' => 1044, 'cliente' => 'Cliente de prueba 2', 'fecha' => '21/11/2026', 'total' => 349.00,  'estado' => 'Enviado'],
        ['id' => 1043, 'cliente' => 'Cliente de prueba 3', 'fecha' => '21/11/2026', 'total' => 89.50,   'estado' => 'Entregado'],
        ['id' => 1042, 'cliente' => 'Cliente de prueba 4', 'fecha' => '20/11/2026', 'total' => 2450.00, 'estado' => 'Cancelado'],
    ];

    // Color del badge segun el estado del pedido
    $colorEstado = [
        'Pendiente' => 'warning',
        'Enviado'   => 'primary',
        'Entregado' => 'success',
        'Cancelado' => 'secondary',
    ];

    // Productos con poco stock
    $stockBajo = [
        ['nombre' => 'Tarjeta de video RTX 4060', 'stock' => 2],
        ['nombre' => 'Procesador Ryzen 5 7600',   'stock' => 3],
        ['nombre' => 'Mouse inalámbrico',         'stock' => 1],
    ];

    // Menu lateral | 'activo' marca la pagina actual
    $menu = [
        ['texto' => 'Dashboard',  'icono' => 'fi-rr-apps',          'url' => '/admin/index.php',      'activo' => true],
        ['texto' => 'Productos',  'icono' => 'fi-rr-box-open',      'url' => '/admin/productos.php',  'activo' => false],
        ['texto' => 'Categorías', 'icono' => 'fi-rr-list',          'url' => '/admin/categorias.php', 'activo' => false],
        ['texto' => 'Marcas',     'icono' => 'fi-rr-tags',          'url' => '/admin/marcas.php',     'activo' => false],
        ['texto' => 'Pedidos',    'icono' => 'fi-rr-shopping-cart', 'url' => '/admin/pedidos.php',    'activo' => false],
        ['texto' => 'Usuarios',   'icono' => 'fi-rr-users',         'url' => '/admin/usuarios.php',   'activo' => false],
    ];
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../src/include/store/head.php'; ?> <!-- head and metadata (por ahora el mismo de la tienda) -->
<body class="bg-light">

    <div class="d-flex min-vh-100">

        <!-- ===================================================== SIDEBAR ===================================================== -->
        <!-- offcanvas-lg: en PC (992px o mas) se ve fijo a la izquierda | en movil se esconde y se abre con el boton de menu -->
        <aside class="offcanvas-lg offcanvas-start bg-dark text-white flex-shrink-0" tabindex="-1" id="sidebarAdmin" style="width: 250px;">
            <div class="offcanvas-header border-bottom border-secondary">
                <span class="fw-bold">Nexus Admin</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarAdmin" aria-label="Cerrar"></button>
            </div>
            <!-- d-flex flex-column + mt-auto: manda el boton "Ver tienda" al fondo -->
            <div class="offcanvas-body d-flex flex-column p-3 h-100">
                <!-- Logo | solo en PC (en movil ya esta el titulo del offcanvas-header) -->
                <a href="/admin/index.php" class="d-none d-lg-block fs-5 fw-bold text-white text-decoration-none mb-4 px-2">Nexus Admin</a>

                <!-- Enlaces del menu | nav-pills marca en azul el activo -->
                <ul class="nav nav-pills flex-column gap-1">
                    <?php foreach ($menu as $item): ?>
                        <li class="nav-item">
                            <a href="<?= $item['url'] ?>" class="nav-link d-flex align-items-center gap-2 <?= $item['activo'] ? 'active' : 'text-white-50' ?>">
                                <i class="fi <?= $item['icono'] ?> d-flex"></i> <?= $item['texto'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="mt-auto pt-3 border-top border-secondary">
                    <a href="/index.php" class="nav-link text-white-50 d-flex align-items-center gap-2 px-2">
                        <i class="fi fi-rr-shop d-flex"></i> Ver tienda
                    </a>
                </div>
            </div>
        </aside>
        <!-- =================================================== FIN SIDEBAR =================================================== -->

        <!-- Contenido principal | flex-grow-1 ocupa el resto del ancho | min-width: 0 evita que la tabla desborde -->
        <div class="flex-grow-1" style="min-width: 0;">

            <!-- ===================================================== TOPBAR ===================================================== -->
            <nav class="bg-white border-bottom px-3 px-md-4 py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <!-- Boton menu | d-lg-none: solo en movil, abre el sidebar -->
                    <button class="btn btn-light rounded-circle d-lg-none d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarAdmin" aria-label="Abrir menú">
                        <i class="fi fi-rr-menu-burger d-flex"></i>
                    </button>
                    <h1 class="h5 fw-bold mb-0">Dashboard</h1>
                </div>

                <!-- Perfil del administrador | dropdown de Bootstrap -->
                <div class="dropdown">
                    <button class="btn btn-light d-flex align-items-center gap-2 rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fi fi-rr-user d-flex"></i>
                        <span class="small fw-semibold d-none d-sm-inline">Administrador</span>
                        <i class="fi fi-rr-angle-small-down d-flex"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="#">Mi perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- Pendiente: cerrar sesion desde AuthController -->
                        <li><a class="dropdown-item text-danger" href="#">Cerrar sesión</a></li>
                    </ul>
                </div>
            </nav>
            <!-- =================================================== FIN TOPBAR =================================================== -->

            <main class="p-3 p-md-4">

                <!-- ============================ Tarjetas de resumen ============================ -->
                <!-- row-cols: 1 columna en celular, 2 en tablet, 4 en PC -->
                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-4">
                    <?php foreach ($resumen as $tarjeta): ?>
                        <div class="col">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <!-- Circulo del icono | bg-*-subtle: fondo claro del mismo color -->
                                    <div class="bg-<?= $tarjeta['color'] ?>-subtle text-<?= $tarjeta['color'] ?> rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px;">
                                        <i class="fi <?= $tarjeta['icono'] ?> fs-4 d-flex"></i>
                                    </div>
                                    <div>
                                        <small class="text-secondary fw-semibold"><?= $tarjeta['titulo'] ?></small>
                                        <div class="fs-4 fw-bold"><?= $tarjeta['valor'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="row g-3">
                    <!-- ============================ Ultimos pedidos ============================ -->
                    <div class="col-12 col-xl-8">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                                <h2 class="h6 fw-bold mb-0">Últimos pedidos</h2>
                                <a href="/admin/pedidos.php" class="small text-decoration-none">Ver todos</a>
                            </div>
                            <div class="card-body">
                                <!-- table-responsive: en celular la tabla hace scroll horizontal en vez de romper el diseño -->
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr class="small text-secondary">
                                                <th>#</th>
                                                <th>Cliente</th>
                                                <th>Fecha</th>
                                                <th class="text-end">Total</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pedidos as $pedido): ?>
                                                <tr>
                                                    <td class="fw-semibold"><?= $pedido['id'] ?></td>
                                                    <td><?= htmlspecialchars($pedido['cliente']) ?></td>
                                                    <td class="text-secondary small"><?= $pedido['fecha'] ?></td>
                                                    <td class="text-end"><?= $moneda . ' ' . number_format($pedido['total'], 2) ?></td>
                                                    <td><span class="badge rounded-pill text-bg-<?= $colorEstado[$pedido['estado']] ?>"><?= $pedido['estado'] ?></span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============================ Stock bajo ============================ -->
                    <div class="col-12 col-xl-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                                <h2 class="h6 fw-bold mb-0">Stock bajo</h2>
                                <a href="/admin/productos.php" class="small text-decoration-none">Ver productos</a>
                            </div>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($stockBajo as $producto): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="small"><?= htmlspecialchars($producto['nombre']) ?></span>
                                        <span class="badge text-bg-danger rounded-pill"><?= $producto['stock'] ?> und.</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- JS de Bootstrap: necesario para el sidebar en movil (offcanvas) y el menu del perfil (dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
