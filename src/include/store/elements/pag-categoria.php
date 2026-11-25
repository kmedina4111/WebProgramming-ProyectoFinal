<?php
    // ===================================================== CATALOGO DE LAPTOPS =====================================================
    // Muestra TODAS las laptops activas (con y sin descuento) y permite filtrar por fabricante y ordenar.
    // Los filtros viajan en la URL (GET):
    //   categorias.php                          -> todas
    //   categorias.php?fabricante=3             -> solo las del fabricante con id 3
    //   categorias.php?fabricante=3&orden=precio_asc -> filtradas y ordenadas
    require_once __DIR__ . '/../../../conexion/conexion.php';   

    // ============ LEER LOS FILTROS DE LA URL ============
    // (int): convierte a numero | si no viene o es invalido queda en 0 = "Todas"
    $idFabricante = (int) ($_GET['fabricante'] ?? 0);

    // Ordenes permitidos: la clave viene de la URL y el valor es el ORDER BY real.
    // Asi nunca se pega texto del usuario dentro del SQL (evita inyeccion SQL).
    $ordenes = [
        'nuevas'      => 'l.creado_en DESC',
        'precio_asc'  => 'l.precio ASC',
        'precio_desc' => 'l.precio DESC',
        'ofertas'     => '(l.precio_anterior IS NULL) ASC, l.precio ASC',   // primero las que tienen precio_anterior
    ];
    $orden = $_GET['orden'] ?? 'nuevas';
    if (!isset($ordenes[$orden])) {
        $orden = 'nuevas';
    }

    // ============ FABRICANTES (para los botones de filtro) ============
    $fabricantes = $conexion->query("SELECT id_fabricante, nombre_fabricante FROM fabricantes ORDER BY nombre_fabricante")->fetchAll(PDO::FETCH_ASSOC);

    // Nombre del fabricante elegido (para el titulo y el breadcrumb)
    $nombreFabricante = null;
    foreach ($fabricantes as $fab) {
        if ((int) $fab['id_fabricante'] === $idFabricante) {
            $nombreFabricante = $fab['nombre_fabricante'];
        }
    }
    // Si el id de la URL no existe, se muestran todas
    if ($nombreFabricante === null) {
        $idFabricante = 0;
    }

    // ============ LAPTOPS ============
    // activo = 1: las inactivas no se muestran en la tienda | con y sin precio_anterior (con y sin descuento)
    $sql = "SELECT l.numero_serie, l.modelo, l.procesador, l.ram_gb, l.almacenamiento_gb, l.tipo_almacenamiento, l.precio, l.precio_anterior, 
    l.foto, f.nombre_fabricante FROM laptops l JOIN fabricantes f ON f.id_fabricante = l.id_fabricante WHERE l.activo = 1";
    $params = [];
    if ($idFabricante > 0) {
        $sql .= " AND l.id_fabricante = :fabricante";   // el filtro solo se agrega si se eligio un fabricante
        $params[':fabricante'] = $idFabricante;
    }
    $sql .= " ORDER BY " . $ordenes[$orden];   // valor sacado del arreglo $ordenes, no de la URL

    $stmt = $conexion->prepare($sql);
    $stmt->execute($params);
    $laptops = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Carpeta de las fotos (la misma donde guarda agregar-laptos.php)
    $rutaFotosLaptops = __DIR__ . '/../../../../assets/imgs/laptops/';   // ruta del SERVIDOR (para file_exists)
    $urlFotosLaptops  = '/assets/imgs/laptops/';                         // ruta del NAVEGADOR (para el <img>)

    // Direccion de esta pagina (para los enlaces de los filtros)
    $urlCatalogo = '/src/pages/categorias.php';
?>
<!-- ============ ENCABEZADO: breadcrumb + titulo ============ -->
<section class="container mt-4">
    <!-- Breadcrumb: muestra en que parte de la tienda esta el usuario -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small mb-2">
            <li class="breadcrumb-item"><a href="/index.php" class="text-decoration-none">Inicio</a></li>
            <?php if ($nombreFabricante): ?>
                <li class="breadcrumb-item"><a href="<?= $urlCatalogo ?>" class="text-decoration-none">Laptops</a></li>
                <!-- aria-current="page": indica que es la pagina actual -->
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($nombreFabricante) ?></li>
            <?php else: ?>
                <li class="breadcrumb-item active" aria-current="page">Laptops</li>
            <?php endif; ?>
        </ol>
    </nav>
    <!-- "Todas las laptops" o "Laptops ASUS" segun el filtro -->
    <h1 class="fw-bold fs-2 mb-0">
        <?= $nombreFabricante ? 'Laptops ' . htmlspecialchars($nombreFabricante) : 'Todas las laptops' ?>
    </h1>
</section>

<!-- ============ FILTRO POR FABRICANTE ============ -->
<!-- d-flex flex-wrap: los botones van en fila y bajan a otra linea si no caben (en movil) -->
<!-- Cada enlace conserva el orden elegido (&orden=...) para no perderlo al cambiar de fabricante -->
<section class="container mt-3">
    <nav class="d-flex flex-wrap gap-2" aria-label="Filtrar por fabricante">
        <!-- El activo va relleno (btn-primary) y los demas con borde (btn-outline-primary) -->
        <a href="<?= $urlCatalogo ?>?orden=<?= $orden ?>" class="btn <?= $idFabricante === 0 ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-3 fw-semibold"
        <?= $idFabricante === 0 ? 'aria-current="page"' : '' ?>>Todas</a>

        <?php foreach ($fabricantes as $fab): ?>
            <?php $activo = (int) $fab['id_fabricante'] === $idFabricante; ?>
            <a href="<?= $urlCatalogo ?>?fabricante=<?= $fab['id_fabricante'] ?>&orden=<?= $orden ?>" class="btn <?= $activo ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-3 fw-semibold"
            <?= $activo ? 'aria-current="page"' : '' ?>><?= htmlspecialchars($fab['nombre_fabricante']) ?></a>
        <?php endforeach; ?>
    </nav>
</section>

<!-- ============ BARRA DE HERRAMIENTAS: resultados + ordenar ============ -->
<section class="container mt-4">
    <!-- justify-content-between: resultados a la izquierda y "Ordenar" a la derecha -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom pb-3">
        <!-- count(): cuantas laptops trajo la consulta -->
        <span class="text-secondary">
            <strong class="text-dark"><?= count($laptops) ?></strong> <?= count($laptops) === 1 ? 'laptop encontrada' : 'laptops encontradas' ?>
        </span>
        <!-- method="get": el orden viaja en la URL | onchange: al elegir una opcion el formulario se envia solo -->
        <form class="d-flex align-items-center gap-2" method="get" action="<?= $urlCatalogo ?>">
            <!-- input hidden: conserva el fabricante elegido al cambiar el orden -->
            <?php if ($idFabricante > 0): ?>
                <input type="hidden" name="fabricante" value="<?= $idFabricante ?>">
            <?php endif; ?>
            <label for="orden" class="small fw-semibold text-nowrap mb-0">Ordenar por</label>
            <select id="orden" name="orden" class="form-select form-select-sm" onchange="this.form.submit()">
                <!-- selected: deja marcada la opcion que esta en la URL -->
                <option value="nuevas"      <?= $orden === 'nuevas'      ? 'selected' : '' ?>>Más nuevas</option>
                <option value="precio_asc"  <?= $orden === 'precio_asc'  ? 'selected' : '' ?>>Precio: menor a mayor</option>
                <option value="precio_desc" <?= $orden === 'precio_desc' ? 'selected' : '' ?>>Precio: mayor a menor</option>
                <option value="ofertas"     <?= $orden === 'ofertas'     ? 'selected' : '' ?>>Ofertas primero</option>
            </select>
        </form>
    </div>
</section>

<?php if (count($laptops) > 0): ?>
<!-- ============ GRILLA DE LAPTOPS ============ -->
<!-- row-cols-2 row-cols-md-3 row-cols-lg-4: 2 por fila en movil, 3 en tablet y 4 en PC (cada hijo solo lleva "col") -->
<section class="container mt-4">
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
        <?php foreach ($laptops as $lap): ?>
            <?php
                // Tiene descuento solo si hay precio anterior (mayor que el precio actual, lo asegura la base de datos)
                $enOferta  = !empty($lap['precio_anterior']);
                $descuento = $enOferta ? round(100 - ($lap['precio'] * 100 / $lap['precio_anterior'])) : 0;
            ?>
            <!-- article: cada tarjeta es un producto independiente -->
            <article class="col">
                <!-- .card ya tiene position: relative, necesario para el stretched-link y el badge -->
                <div class="card h-100 border-0 shadow-sm">
                    <!-- Imagen | ratio-1x1 la hace cuadrada -->
                    <div class="ratio ratio-1x1 bg-light rounded-top">
                        <?php if (!empty($lap['foto']) && file_exists($rutaFotosLaptops . $lap['foto'])): ?>
                            <img src="<?= $urlFotosLaptops . htmlspecialchars($lap['foto']) ?>" alt="<?= htmlspecialchars($lap['modelo']) ?>" class="object-fit-contain p-3">
                        <?php else: ?>
                            <!-- Sin foto: se muestra un icono en su lugar -->
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Badge de descuento: solo si esta en oferta -->
                    <?php if ($enOferta): ?>
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">-<?= $descuento ?>%</span>
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <small class="text-secondary fw-semibold"><?= htmlspecialchars($lap['nombre_fabricante']) ?></small>
                        <!-- stretched-link: el enlace del modelo se "estira" y toda la tarjeta lleva al detalle -->
                        <h2 class="fs-6 fw-semibold mb-1">
                            <a href="#" class="stretched-link text-dark text-decoration-none"><?= htmlspecialchars($lap['modelo']) ?></a>
                        </h2>
                        <small class="text-secondary"><?= htmlspecialchars($lap['procesador']) ?></small>
                        <small class="text-secondary mb-2"><?= $lap['ram_gb'] ?> GB RAM · <?= $lap['almacenamiento_gb'] ?> GB <?= $lap['tipo_almacenamiento'] ?></small>

                        <!-- mt-auto: precio y boton siempre abajo, aunque el nombre ocupe 2 lineas -->
                        <div class="mt-auto">
                            <?php if ($enOferta): ?>
                                <small class="text-secondary text-decoration-line-through">S/ <?= number_format($lap['precio_anterior'], 2) ?></small>
                            <?php endif; ?>
                            <p class="fw-bold fs-5 text-primary mb-2">S/ <?= number_format($lap['precio'], 2) ?></p>
                            <!-- position-relative z-2: el boton queda ENCIMA del stretched-link y funciona por separado -->
                            <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                                <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php else: ?>
<!-- ============ ESTADO VACIO ============ -->
<!-- Se muestra solo cuando no hay laptops  -->
<section class="container mt-4">
    <div class="bg-light rounded-4 p-5 text-center">
        <i class="fi fi-rr-search fs-1 text-secondary d-flex justify-content-center mb-3"></i>
        <h2 class="fw-bold fs-4">No encontramos laptops</h2>
        <p class="text-secondary mb-4">No hay productos disponibles para este fabricante por ahora.</p>
        <a href="<?= $urlCatalogo ?>" class="btn btn-primary fw-semibold px-4">Ver todas las laptops</a>
    </div>
</section>
<?php endif; ?>
