<?php
    session_start(); 
    // ============ DATOS DE LA PAGINA OFERTAS ============
    // Igual que la seccion de ofertas del home (src/include/store/elements/ofertas.php), pero:
    //   - muestra TODAS las ofertas activas (sin LIMIT 4)
    //   - se puede ordenar con el select "Ordenar por" (?orden=...)
    // Se conecta con el CRUD del admin: agregar / editar / eliminar laptop se ve reflejado aqui
    require_once __DIR__ . '/../conexion/conexion.php';

    // Opciones de orden permitidas: valor del <select> => ORDER BY
    // Solo se usa un valor de esta lista: el texto de la URL NUNCA va directo al SQL (evita inyeccion SQL)
    $ordenes = [
        'descuento'   => '(l.precio_anterior - l.precio) / l.precio_anterior DESC',
        'precio_asc'  => 'l.precio ASC',
        'precio_desc' => 'l.precio DESC',
        'nuevas'      => 'l.creado_en DESC',
    ];
    // Si no llega ?orden o llega un valor raro, se usa "Mayor descuento"
    $orden = $_GET['orden'] ?? 'descuento';
    if (!isset($ordenes[$orden])) {
        $orden = 'descuento';
    }

    // Una laptop esta en oferta cuando tiene precio_anterior | solo las activas
    $sqlOfertas = "SELECT l.numero_serie, l.modelo, l.procesador, l.precio, l.precio_anterior, l.foto, f.nombre_fabricante
                    FROM laptops l
                    JOIN fabricantes f ON f.id_fabricante = l.id_fabricante
                    WHERE l.activo = 1 AND l.precio_anterior IS NOT NULL
                    ORDER BY " . $ordenes[$orden];
    $ofertas = $conexion->query($sqlOfertas)->fetchAll(PDO::FETCH_ASSOC);

    // Carpeta de las fotos (la misma donde guarda agregar-laptos.php)
    $rutaFotosLaptops = __DIR__ . '/../../assets/imgs/laptops/';   // ruta del SERVIDOR (para file_exists)
    $urlFotosLaptops  = '/assets/imgs/laptops/';                   // ruta del NAVEGADOR (para el <img>)
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> <!-- head and metadata -->
<body>
    <?php include __DIR__ . '/../include/store/header.php'; ?> <!-- header -->

    <!-- ===================================================== CONTENIDO PRINCIPAL ===================================================== -->
    <!-- PAGINA DE OFERTAS | Misma estructura que la pagina de categorias, pero sin los botones de fabricantes -->
    <!-- Las ofertas salen de la base de datos (ver el bloque PHP del inicio del archivo) -->
    <main>
        <!-- ============ 1. ENCABEZADO: breadcrumb + titulo ============ -->
        <section class="container mt-4">
            <!-- Breadcrumb: muestra en que parte de la tienda esta el usuario -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-2">
                    <li class="breadcrumb-item"><a href="/index.php" class="text-decoration-none">Inicio</a></li>
                    <!-- aria-current="page": indica que es la pagina actual (no es enlace) -->
                    <li class="breadcrumb-item active" aria-current="page">Ofertas</li>
                </ol>
            </nav>
            <h1 class="fw-bold fs-2 mb-1">Ofertas</h1>
            <p class="text-secondary mb-0">Laptops con descuento por tiempo limitado.</p>
        </section>
        <!-- ============ 2. BARRA DE HERRAMIENTAS: resultados + ordenar ============ -->
        <section class="container mt-4">
            <!-- justify-content-between: resultados a la izquierda y "Ordenar" a la derecha -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom pb-3">
                <!-- count($ofertas): cuantas laptops en oferta hay | "oferta" en singular si solo hay 1 -->
                <span class="text-secondary"><strong class="text-dark"><?= count($ofertas) ?></strong> <?= count($ofertas) === 1 ? 'oferta disponible' : 'ofertas disponibles' ?></span>

                <!-- method="get": el orden viaja en la URL (ej: ofertas.php?orden=precio_asc) -->
                <!-- onchange: al elegir una opcion, el formulario se envia solo (no hace falta boton) -->
                <form class="d-flex align-items-center gap-2" method="get">
                    <label for="orden" class="small fw-semibold text-nowrap mb-0">Ordenar por</label>
                    <select id="orden" name="orden" class="form-select form-select-sm" onchange="this.form.submit()">
                        <!-- "Mayor descuento" es el orden por defecto | selected: se marca la opcion que se esta usando -->
                        <option value="descuento"   <?= $orden === 'descuento'   ? 'selected' : '' ?>>Mayor descuento</option>
                        <option value="precio_asc"  <?= $orden === 'precio_asc'  ? 'selected' : '' ?>>Precio: menor a mayor</option>
                        <option value="precio_desc" <?= $orden === 'precio_desc' ? 'selected' : '' ?>>Precio: mayor a menor</option>
                        <option value="nuevas"      <?= $orden === 'nuevas'      ? 'selected' : '' ?>>Más nuevas</option>
                    </select>
                </form>
            </div>
        </section>

        <?php if (count($ofertas) > 0): ?>
        <!-- ============ 3. GRILLA DE OFERTAS ============ -->
        <!-- row-cols-2 row-cols-md-3 row-cols-lg-4: 2 por fila en movil, 3 en tablet y 4 en PC (cada hijo solo lleva "col") -->
        <section class="container mt-4">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                <!-- UNA sola tarjeta dentro del foreach: se repite por cada laptop en oferta -->
                <?php foreach ($ofertas as $oferta): ?>
                    <?php
                        // Porcentaje de descuento: 100 - (precio actual * 100 / precio anterior)
                        $descuento = round(100 - $oferta['precio'] * 100 / $oferta['precio_anterior']);
                        // Cuanto ahorra el cliente: precio anterior - precio actual
                        $ahorro = $oferta['precio_anterior'] - $oferta['precio'];
                    ?>
                <div class="col">
                    <!-- .card ya tiene position: relative, necesario para el stretched-link y el badge -->
                    <div class="card h-100 border-0 shadow-sm">
                        <!-- Imagen del producto | ratio-1x1 la hace cuadrada -->
                        <div class="ratio ratio-1x1 bg-light rounded-top">
                            <?php if (!empty($oferta['foto']) && file_exists($rutaFotosLaptops . basename($oferta['foto']))): ?>
                                <!-- object-fit-contain: la laptop se ve completa, sin recortarse -->
                                <img src="<?= $urlFotosLaptops . htmlspecialchars($oferta['foto']) ?>" alt="<?= htmlspecialchars($oferta['modelo']) ?>" class="object-fit-contain p-3">
                            <?php else: ?>
                                <!-- Sin foto: se muestra un icono en su lugar -->
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Etiqueta de descuento en la esquina | position-absolute la pone encima de la imagen -->
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">-<?= $descuento ?>%</span>
                        <div class="card-body d-flex flex-column">
                            <small class="text-secondary fw-semibold text-uppercase"><?= htmlspecialchars($oferta['nombre_fabricante']) ?></small>
                            <!-- stretched-link: el enlace del modelo se "estira" y toda la tarjeta lleva al detalle -->
                            <h6 class="fw-semibold mb-1"><a href="#" class="stretched-link text-dark text-decoration-none"><?= htmlspecialchars($oferta['modelo']) ?></a></h6>
                            <small class="text-secondary mb-2"><?= htmlspecialchars($oferta['procesador']) ?></small>
                            <!-- mt-auto: precio y boton siempre abajo, aunque el nombre ocupe 2 lineas -->
                            <div class="mt-auto">
                                <small class="text-secondary text-decoration-line-through">S/ <?= number_format($oferta['precio_anterior'], 2) ?></small>
                                <p class="fw-bold fs-5 text-primary mb-0">S/ <?= number_format($oferta['precio'], 2) ?></p>
                                <small class="text-success fw-semibold d-block mb-2">Ahorras S/ <?= number_format($ahorro, 2) ?></small>
                                <!-- position-relative z-2: el boton queda ENCIMA del stretched-link y funciona por separado -->
                                <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                                    <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <?php else: ?>
        <!-- ============ 4. ESTADO VACIO ============ -->
        <!-- Se muestra SOLO cuando no hay ofertas activas (en lugar de la grilla) -->
        <section class="container mt-4">
            <div class="bg-light rounded-4 p-5 text-center">
                <i class="fi fi-rr-badge-percent fs-1 text-secondary d-flex justify-content-center mb-3"></i>
                <h2 class="fw-bold fs-4">No hay ofertas por ahora</h2>
                <p class="text-secondary mb-4">Vuelve pronto: publicamos nuevos descuentos cada semana.</p>
                <a href="/src/pages/categorias.php" class="btn btn-primary fw-semibold px-4">Ver todas las laptops</a>
            </div>
        </section>
        <?php endif; ?>

    </main>
    <!-- =================================================== FIN CONTENIDO PRINCIPAL =================================================== -->

    <?php include __DIR__ . '/../include/store/footer.php'; ?> 
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
