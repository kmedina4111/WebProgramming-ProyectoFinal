<!-- ============ 1. ENCABEZADO: breadcrumb + titulo ============ -->
<section class="container mt-4">
    <!-- Breadcrumb: muestra en que parte de la tienda esta el usuario -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small mb-2">
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Laptops</a></li>
            <!-- aria-current="page": indica que es la pagina actual (no es enlace) -->
            <li class="breadcrumb-item active" aria-current="page">Todas</li>
        </ol>
    </nav>
    <!-- Con PHP: "Todas las laptops" o el nombre del fabricante elegido (ej: "Laptops ASUS") -->
    <h1 class="fw-bold fs-2 mb-0">Todas las laptops</h1>
</section>

<!-- ============ 2. ACCESOS RAPIDOS POR FABRICANTE ============ -->
<!-- d-flex flex-wrap: los botones van en fila y bajan a otra linea si no caben (en movil) -->
<!-- Con PHP: un foreach sobre la tabla fabricantes | href="categoria.php?fabricante=ID" -->
<section class="container mt-3">
    <div class="d-flex flex-wrap gap-2">
        <!-- El fabricante activo va relleno (btn-primary) y los demas con borde (btn-outline-primary) -->
        <a href="#" class="btn btn-primary rounded-pill px-3 fw-semibold" aria-current="page">Todas</a>
        <a href="#" class="btn btn-outline-primary rounded-pill px-3 fw-semibold">ASUS</a>
        <a href="#" class="btn btn-outline-primary rounded-pill px-3 fw-semibold">Lenovo</a>
        <a href="#" class="btn btn-outline-primary rounded-pill px-3 fw-semibold">HP</a>
        <a href="#" class="btn btn-outline-primary rounded-pill px-3 fw-semibold">Acer</a>
        <a href="#" class="btn btn-outline-primary rounded-pill px-3 fw-semibold">MSI</a>
    </div>
</section>

<!-- ============ 3. BARRA DE HERRAMIENTAS: resultados + ordenar ============ -->
<section class="container mt-4">
    <!-- justify-content-between: resultados a la izquierda y "Ordenar" a la derecha -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom pb-3">
        <!-- Con PHP: count($laptops) -->
        <span class="text-secondary"><strong class="text-dark">8</strong> laptops encontradas</span>

        <!-- method="get": el orden viaja en la URL (ej: categoria.php?orden=precio_asc) -->
        <!-- onchange: al elegir una opcion, el formulario se envia solo (no hace falta boton) -->
        <form class="d-flex align-items-center gap-2" method="get">
            <label for="orden" class="small fw-semibold text-nowrap mb-0">Ordenar por</label>
            <select id="orden" name="orden" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="nuevas" selected>Más nuevas</option>
                <option value="precio_asc">Precio: menor a mayor</option>
                <option value="precio_desc">Precio: mayor a menor</option>
                <option value="ofertas">Ofertas primero</option>
            </select>
        </form>
    </div>
</section>

<!-- ============ 4. GRILLA DE LAPTOPS ============ -->
<!-- row-cols-2 row-cols-md-3 row-cols-lg-4: 2 por fila en movil, 3 en tablet y 4 en PC (cada hijo solo lleva "col") -->
<!-- Con PHP: se escribe UNA sola tarjeta dentro de un foreach -->
<section class="container mt-4">
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">

        <!-- Laptop 1 (en oferta) -->
        <div class="col">
            <!-- .card ya tiene position: relative, necesario para el stretched-link y el badge -->
            <div class="card h-100 border-0 shadow-sm">
                <!-- Imagen | ratio-1x1 la hace cuadrada. Reemplazar el icono por <img class="object-fit-contain p-3"> -->
                <div class="ratio ratio-1x1 bg-light rounded-top">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                    </div>
                </div>
                <span class="badge bg-danger position-absolute top-0 start-0 m-2">-20%</span>
                <div class="card-body d-flex flex-column">
                    <small class="text-secondary fw-semibold">ASUS</small>
                    <!-- stretched-link: el enlace del modelo se "estira" y toda la tarjeta lleva al detalle -->
                    <h6 class="fw-semibold mb-1"><a href="#" class="stretched-link text-dark text-decoration-none">TUF Gaming F15</a></h6>
                    <small class="text-secondary mb-2">Intel Core i5-12500H</small>
                    <!-- mt-auto: precio y boton siempre abajo, aunque el nombre ocupe 2 lineas -->
                    <div class="mt-auto">
                        <small class="text-secondary text-decoration-line-through">S/ 4,299.00</small>
                        <p class="fw-bold fs-5 text-primary mb-2">S/ 3,439.00</p>
                        <!-- position-relative z-2: el boton queda ENCIMA del stretched-link y funciona por separado -->
                        <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                            <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laptop 2 -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="ratio ratio-1x1 bg-light rounded-top">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <small class="text-secondary fw-semibold">ASUS</small>
                    <h6 class="fw-semibold mb-1"><a href="#" class="stretched-link text-dark text-decoration-none">Vivobook 16</a></h6>
                    <small class="text-secondary mb-2">Intel Core i5-1335U</small>
                    <div class="mt-auto">
                        <p class="fw-bold fs-5 text-primary mb-2">S/ 2,299.00</p>
                        <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                            <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laptop 3 (en oferta) -->
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
                        <p class="fw-bold fs-5 text-primary mb-2">S/ 2,799.00</p>
                        <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                            <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laptop 4 -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="ratio ratio-1x1 bg-light rounded-top">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <small class="text-secondary fw-semibold">LENOVO</small>
                    <h6 class="fw-semibold mb-1"><a href="#" class="stretched-link text-dark text-decoration-none">LOQ 15</a></h6>
                    <small class="text-secondary mb-2">Intel Core i5-12450HX</small>
                    <div class="mt-auto">
                        <p class="fw-bold fs-5 text-primary mb-2">S/ 3,599.00</p>
                        <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                            <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laptop 5 -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="ratio ratio-1x1 bg-light rounded-top">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <small class="text-secondary fw-semibold">HP</small>
                    <h6 class="fw-semibold mb-1"><a href="#" class="stretched-link text-dark text-decoration-none">Victus 15</a></h6>
                    <small class="text-secondary mb-2">AMD Ryzen 5 7535HS</small>
                    <div class="mt-auto">
                        <p class="fw-bold fs-5 text-primary mb-2">S/ 2,999.00</p>
                        <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                            <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laptop 6 (en oferta) -->
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
                        <p class="fw-bold fs-5 text-primary mb-2">S/ 3,299.00</p>
                        <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                            <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laptop 7 -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="ratio ratio-1x1 bg-light rounded-top">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fi fi-rr-laptop text-secondary d-flex" style="font-size: 4rem;"></i>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <small class="text-secondary fw-semibold">ACER</small>
                    <h6 class="fw-semibold mb-1"><a href="#" class="stretched-link text-dark text-decoration-none">Nitro V 15</a></h6>
                    <small class="text-secondary mb-2">Intel Core i5-13420H</small>
                    <div class="mt-auto">
                        <p class="fw-bold fs-5 text-primary mb-2">S/ 3,199.00</p>
                        <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                            <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laptop 8 (en oferta) -->
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
                        <p class="fw-bold fs-5 text-primary mb-2">S/ 3,899.00</p>
                        <a href="#" class="btn btn-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 position-relative z-2">
                            <i class="fi fi-rr-shopping-cart d-flex"></i> Agregar
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ============ 5. ESTADO VACIO ============ -->
<!-- Se muestra SOLO cuando no hay laptops (ej: un fabricante sin productos) -->
<!-- Ahora esta oculto con d-none. Con PHP: if (count($laptops) === 0) en lugar de la grilla -->
<section class="container mt-4 d-none">
    <div class="bg-light rounded-4 p-5 text-center">
        <i class="fi fi-rr-search fs-1 text-secondary d-flex justify-content-center mb-3"></i>
        <h2 class="fw-bold fs-4">No encontramos laptops</h2>
        <p class="text-secondary mb-4">No hay productos disponibles para esta categoría por ahora.</p>
        <a href="#" class="btn btn-primary fw-semibold px-4">Ver todas las laptops</a>
    </div>
</section>