<!-- ============ 1. CARRUSEL DE BANNERS ============ -->
<!-- carousel slide + data-bs-ride="carousel": los banners cambian solos (necesita el JS de Bootstrap) -->
<section class="container mt-4">
    <div id="carruselBanners" class="carousel slide rounded-4 overflow-hidden" data-bs-ride="carousel">
        <!-- Indicadores: las rayitas de abajo para saltar a cada banner -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carruselBanners" data-bs-slide-to="0" class="active" aria-label="Banner 1"></button>
            <button type="button" data-bs-target="#carruselBanners" data-bs-slide-to="1" aria-label="Banner 2"></button>
            <button type="button" data-bs-target="#carruselBanners" data-bs-slide-to="2" aria-label="Banner 3"></button>
        </div>
        <div class="carousel-inner">
            <!-- Banner 1 | El logo va de fondo con background-image -->
            <!-- background-size: 45% -> el logo ocupa casi la mitad del ancho | background-position: right 3rem center -> a la derecha, centrado en vertical -->
            <!-- Fondo blanco (el logo es azul y no se veria sobre bg-primary) y texto oscuro para que se lea -->
            <div class="carousel-item active">
                <div class="bg-dark text-white border rounded-4 text-dark d-flex align-items-center px-5" style="min-height: 340px; background-image: url('assets/imgs/logos/example1.webp'); background-repeat: no-repeat; background-size: 45% auto; background-position: right 3rem center;">
                    <div>
                        <span class="badge bg-warning text-dark mb-2">OFERTA</span>
                        <h2 class="fw-bold display-6">Tarjetas de video RTX</h2>
                        <p class="mb-4">Hasta 20% de descuento por tiempo limitado.</p>
                        <a href="#" class="btn btn-primary fw-semibold px-4">Ver ofertas</a>
                    </div>
                </div>
            </div>
            <!-- Banner 2 -->
            <div class="carousel-item">
                <div class="bg-dark text-white d-flex align-items-center px-5" style="min-height: 340px;">
                    <div>
                        <span class="badge bg-info text-dark mb-2">NUEVO</span>
                        <h2 class="fw-bold display-6">Laptops gamer</h2>
                        <p class="mb-4">Los ultimos modelos ya disponibles en tienda.</p>
                        <a href="#" class="btn btn-primary fw-semibold px-4">Ver laptops</a>
                    </div>
                </div>
            </div>
            <!-- Banner 3 -->
            <div class="carousel-item">
                <div class="bg-success text-white d-flex align-items-center px-5" style="min-height: 340px;">
                    <div>
                        <span class="badge bg-light text-dark mb-2">ENVIO GRATIS</span>
                        <h2 class="fw-bold display-6">Perifericos</h2>
                        <p class="mb-4">Envio gratis en compras mayores a S/ 300.</p>
                        <a href="#" class="btn btn-light fw-semibold px-4">Comprar ahora</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Flechas para pasar de banner -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carruselBanners" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carruselBanners" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</section>