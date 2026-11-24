<?php session_start(); // abre la sesion ANTES de cualquier HTML (el header muestra al usuario conectado) ?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> <!-- head and metadata -->
<body>
    <?php include __DIR__ . '/../include/store/header.php'; ?> <!-- header -->

    <!-- ===================================================== CONTENIDO PRINCIPAL ===================================================== -->
    <!-- PAGINA DE OFERTAS | Misma estructura que la pagina de categorias, pero sin los botones de fabricantes -->
    <!-- PRUEBA: son las laptops de database.sql que tienen precio_anterior. Luego saldran de la base de datos con PHP: -->
    <!-- SELECT ... FROM laptops WHERE activo = 1 AND precio_anterior IS NOT NULL -->
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
                <!-- Con PHP: count($ofertas) -->
                <span class="text-secondary"><strong class="text-dark">4</strong> ofertas disponibles</span>

                <!-- method="get": el orden viaja en la URL (ej: ofertas.php?orden=precio_asc) -->
                <!-- onchange: al elegir una opcion, el formulario se envia solo (no hace falta boton) -->
                <form class="d-flex align-items-center gap-2" method="get">
                    <label for="orden" class="small fw-semibold text-nowrap mb-0">Ordenar por</label>
                    <select id="orden" name="orden" class="form-select form-select-sm" onchange="this.form.submit()">
                        <!-- "Mayor descuento" es el orden por defecto en una pagina de ofertas -->
                        <option value="descuento" selected>Mayor descuento</option>           
                        <option value="precio_asc">Precio: menor a mayor</option>
                        <option value="precio_desc">Precio: mayor a menor</option>
                        <option value="nuevas">Más nuevas</option>
                    </select>
                </form>
            </div>
        </section>

        <!-- ============ 3. GRILLA DE OFERTAS ============ -->
        <!-- row-cols-2 row-cols-md-3 row-cols-lg-4: 2 por fila en movil, 3 en tablet y 4 en PC (cada hijo solo lleva "col") -->
        <!-- Ordenadas por mayor descuento | Con PHP: se escribe UNA sola tarjeta dentro de un foreach -->
        <section class="container mt-4">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                <!-- Oferta 1 -->
                <div class="col">
                    <!-- .card ya tiene position: relative, necesario para el stretched-link y el badge -->
                    <div class="card h-100 border-0 shadow-sm">
                        <!-- Imagen | ratio-1x1 la hace cuadrada. Reemplazar el icono por <img class="object-fit-contain p-3"> -->
                        <div class="ratio ratio-1x1 bg-light rounded-top">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                        <!-- Con PHP: round(100 - precio * 100 / precio_anterior) -->
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">-20%</span>
                        <div class="card-body d-flex flex-column">
                            <small class="text-secondary fw-semibold">ASUS</small>
                            <!-- stretched-link: el enlace del modelo se "estira" y toda la tarjeta lleva al detalle -->
                            <h6 class="fw-semibold mb-1"><a href="#" class="stretched-link text-dark text-decoration-none">TUF Gaming F15</a></h6>
                            <small class="text-secondary mb-2">Intel Core i5-12500H</small>
                            <!-- mt-auto: precio y boton siempre abajo, aunque el nombre ocupe 2 lineas -->
                            <div class="mt-auto">
                                <small class="text-secondary text-decoration-line-through">S/ 4,299.00</small>
                                <p class="fw-bold fs-5 text-primary mb-0">S/ 3,439.00</p>
                                <!-- Cuanto ahorra el cliente | Con PHP: precio_anterior - precio -->
                                <small class="text-success fw-semibold d-block mb-2">Ahorras S/ 860.00</small>
                                <!-- position-relative z-2: el boton queda ENCIMA del stretched-link y funciona por separado -->
                                <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                                    <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Oferta 2 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="ratio ratio-1x1 bg-light rounded-top">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">-11%</span>
                        <div class="card-body d-flex flex-column">
                            <small class="text-secondary fw-semibold">MSI</small>
                            <h6 class="fw-semibold mb-1"><a href="#" class="stretched-link text-dark text-decoration-none">Thin GF63</a></h6>
                            <small class="text-secondary mb-2">Intel Core i7-12650H</small>
                            <div class="mt-auto">
                                <small class="text-secondary text-decoration-line-through">S/ 4,399.00</small>
                                <p class="fw-bold fs-5 text-primary mb-0">S/ 3,899.00</p>
                                <small class="text-success fw-semibold d-block mb-2">Ahorras S/ 500.00</small>
                                <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                                    <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Oferta 3 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="ratio ratio-1x1 bg-light rounded-top">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">-11%</span>
                        <div class="card-body d-flex flex-column">
                            <small class="text-secondary fw-semibold">HP</small>
                            <h6 class="fw-semibold mb-1"><a href="#" class="stretched-link text-dark text-decoration-none">Pavilion 14</a></h6>
                            <small class="text-secondary mb-2">Intel Core i7-1355U</small>
                            <div class="mt-auto">
                                <small class="text-secondary text-decoration-line-through">S/ 3,699.00</small>
                                <p class="fw-bold fs-5 text-primary mb-0">S/ 3,299.00</p>
                                <small class="text-success fw-semibold d-block mb-2">Ahorras S/ 400.00</small>
                                <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                                    <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Oferta 4 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="ratio ratio-1x1 bg-light rounded-top">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">-10%</span>
                        <div class="card-body d-flex flex-column">
                            <small class="text-secondary fw-semibold">LENOVO</small>
                            <h6 class="fw-semibold mb-1"><a href="#" class="stretched-link text-dark text-decoration-none">IdeaPad Slim 5</a></h6>
                            <small class="text-secondary mb-2">AMD Ryzen 7 7730U</small>
                            <div class="mt-auto">
                                <small class="text-secondary text-decoration-line-through">S/ 3,099.00</small>
                                <p class="fw-bold fs-5 text-primary mb-0">S/ 2,799.00</p>
                                <small class="text-success fw-semibold d-block mb-2">Ahorras S/ 300.00</small>
                                <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                                    <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ============ 4. ESTADO VACIO ============ -->
        <!-- Se muestra SOLO cuando no hay ofertas activas -->
        <!-- Ahora esta oculto con d-none. Con PHP: if (count($ofertas) === 0) en lugar de la grilla -->
        <section class="container mt-4 d-none">
            <div class="bg-light rounded-4 p-5 text-center">
                <i class="fi fi-rr-badge-percent fs-1 text-secondary d-flex justify-content-center mb-3"></i>
                <h2 class="fw-bold fs-4">No hay ofertas por ahora</h2>
                <p class="text-secondary mb-4">Vuelve pronto: publicamos nuevos descuentos cada semana.</p>
                <a href="/src/pages/categorias.php" class="btn btn-primary fw-semibold px-4">Ver todas las laptops</a>
            </div>
        </section>

    </main>
    <!-- =================================================== FIN CONTENIDO PRINCIPAL =================================================== -->

    <?php include __DIR__ . '/../include/store/footer.php'; ?> <!-- footer -->
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
