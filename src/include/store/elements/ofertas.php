<?php
    // ============ DATOS DE LA SECCION OFERTAS ============
    // Las tarjetas salen de la tabla laptops. Se conecta con el CRUD del admin:
    //   - agregar-laptos.php: si se llena "Precio anterior", la laptop aparece aqui
    //   - editar-laptop.php: los cambios (precio, foto, modelo...) se ven aqui | si se borra el precio anterior o se pone Inactivo, sale de aqui
    //   - eliminar-laptop.php: la laptop desaparece de aqui
    require_once __DIR__ . '/../../../conexion/conexion.php';  
    // Una laptop esta "en oferta" cuando tiene precio_anterior | solo las activas | las 4 con mayor descuento
    $sqlOfertas = "SELECT l.numero_serie, l.modelo, l.precio, l.precio_anterior, l.foto, f.nombre_fabricante FROM laptops l 
    JOIN fabricantes f ON f.id_fabricante = l.id_fabricante WHERE l.activo = 1 AND l.precio_anterior IS NOT NULL
    ORDER BY (l.precio_anterior - l.precio) / l.precio_anterior DESC LIMIT 4";
    $ofertas = $conexion->query($sqlOfertas)->fetchAll(PDO::FETCH_ASSOC);
    // Carpeta de las fotos (la misma donde guarda agregar-laptos.php)
    $rutaFotosLaptops = __DIR__ . '/../../../../assets/imgs/laptops/';   // ruta del SERVIDOR (para file_exists)
    $urlFotosLaptops  = '/assets/imgs/laptops/';                         // ruta del NAVEGADOR (para el <img>)
?>
    <!-- ============ OFERTAS ============ -->
    <!-- Si no hay ninguna laptop en oferta, la seccion completa no se muestra -->
    <?php if (count($ofertas) > 0): ?>
    <section class="container mt-5">
        <!-- Titulo a la izquierda y enlace "Ver todo" a la derecha -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold mb-0">Ofertas</h3>
            <a href="/src/pages/ofertas.php" class="fw-semibold text-decoration-none">Ver todo</a>
        </div>
        <!-- col-6 col-md-4 col-lg-3: 2 por fila en movil, 3 en tablet y 4 en PC -->
        <div class="row g-3">
            <!-- UNA sola tarjeta dentro del foreach: se repite por cada laptop en oferta -->
            <?php foreach ($ofertas as $oferta): ?>
                <?php
                    // Porcentaje de descuento: 100 - (precio actual * 100 / precio anterior)
                    $descuento = round(100 - $oferta['precio'] * 100 / $oferta['precio_anterior']);
                ?>
            <div class="col-6 col-md-4 col-lg-3">
                <!-- h-100: todas las tarjetas de la fila miden lo mismo de alto -->
                <div class="card h-100 border-0 shadow-sm">
                    <!-- Imagen del producto | ratio-1x1 la hace cuadrada -->
                    <div class="ratio ratio-1x1 bg-light rounded-top">
                        <?php if (!empty($oferta['foto']) && file_exists($rutaFotosLaptops . $oferta['foto'])): ?>
                            <!-- object-fit-contain: la laptop se ve completa, sin recortarse -->
                            <img src="<?= $urlFotosLaptops . htmlspecialchars($oferta['foto']) ?>" alt="<?= htmlspecialchars($oferta['modelo']) ?>" class="object-fit-contain p-3">
                        <?php else: ?>
                            <!-- Sin foto: se muestra un icono en su lugar -->
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Etiqueta de descuento en la esquina la classe position-absolute la pone encima de la imagen -->
                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">-<?= $descuento ?>%</span>
                    <!-- d-flex flex-column + mt-auto: el boton siempre queda abajo aunque el nombre sea largo -->
                    <div class="card-body d-flex flex-column">
                        <small class="text-secondary fw-semibold text-uppercase"><?= htmlspecialchars($oferta['nombre_fabricante']) ?></small>
                        <h6 class="fw-semibold"><?= htmlspecialchars($oferta['modelo']) ?></h6>
                        <div class="mt-auto">
                            <small class="text-secondary text-decoration-line-through">S/ <?= number_format($oferta['precio_anterior'], 2) ?></small>
                            <p class="fw-bold fs-5 text-primary mb-2">S/ <?= number_format($oferta['precio'], 2) ?></p>
                            <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
