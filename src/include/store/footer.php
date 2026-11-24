<?php
    // Esta seccion contiene el fragmento de HMTL de Footer, tanto para PC como para Movil.
?>
<!-- ======================================================= FOOTER PC ======================================================= -->
<!-- Solo visible en pantallas de 1030px o mas -->
<footer class="bg-primary text-white solo-pc mt-5">
    <div class="container py-5">
        <!-- d-flex y justify-content-between reparten las 4 columnas a lo largo de todo el ancho -->
        <div class="d-flex justify-content-between">
            <!-- Columna 1 -->
            <div style="max-width: 300px;">  <!-- max-width para que el texto no se estire demasiado -->
                <h3 class="fw-bold mb-3">Nexus Importaciones</h3>
                <p class="small">Productos importados de calidad, al mejor precio y con envío a todo el país.</p>
                <!-- Redes sociales | Iconos mediante el CDN de Flaticon -->
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width: 40px; height: 40px;">
                        <i class="fi fi-brands-facebook d-flex"></i>
                    </a>
                    <a href="#" class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width: 40px; height: 40px;">
                        <i class="fi fi-brands-instagram d-flex"></i>
                    </a>
                    <a href="#" class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width: 40px; height: 40px;">
                        <i class="fi fi-brands-tik-tok d-flex"></i>
                    </a>
                    <a href="#" class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width: 40px; height: 40px;">
                        <i class="fi fi-brands-whatsapp d-flex"></i>
                    </a>
                </div>
            </div>
            <div>
                <!-- Columna 2 -->
                <h5 class="fw-bold mb-3">Tienda</h5>
                <ul class="list-unstyled"><!-- list-unstyled quita los puntos de la lista -->
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Ofertas</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Categorías</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Ofertas</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Novedades</a></li>
                </ul>
            </div>
            <div>
                <!-- Columna 3 -->
                <h5 class="fw-bold mb-3">Páginas</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Inicio</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Servicios</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Nosotros</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">FaQ</a></li>
                </ul>
            </div>
            <div>
                <!-- Columna 4 -->
                <h5 class="fw-bold mb-3">Información</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Contacto</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Términos y condiciones</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Política de privacidad</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Envíos y devoluciones</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Linea separadora y derechos reservados -->
    <div class="border-top border-white border-opacity-75">
        <div class="container py-3 text-center">
            <small>© 2026 NexusCorp Importaciones. Todos los derechos reservados.</small>
        </div>
    </div>
</footer>
<!-- ========================================================================================================================= -->

<!-- ===================================================== FOOTER MOVIL ====================================================== -->
<!-- Solo visible en pantallas de menos de 1030px (clase solo-movil) -->
<footer class="bg-primary text-white solo-movil mt-5">
    <!-- Seccion 1 -->
    <div class="container py-4 text-center">
        <h3 class="fw-bold mb-3">NexusCorp Importaciones</h3>
        <p class="small">Productos importados de calidad, al mejor precio y con envío a todo el país.</p>
        <div class="d-flex gap-2 mt-3 justify-content-center"> <!-- Centra los elementos RRSS -->
            <a href="#" class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width: 40px; height: 40px;">
                <i class="fi fi-brands-facebook d-flex"></i>
            </a>
            <a href="#" class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width: 40px; height: 40px;">
                <i class="fi fi-brands-instagram d-flex"></i>
            </a>
            <a href="#" class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width: 40px; height: 40px;">
                <i class="fi fi-brands-tik-tok d-flex"></i>
            </a>
            <a href="#" class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none" style="width: 40px; height: 40px;">
                <i class="fi fi-brands-whatsapp d-flex"></i>
            </a>
        </div>
    </div>
    <!-- Secciones en forma de acordeon -->
    <!-- id="acordeonFooter": con data-bs-parent, al abrir una seccion se cierra la otra -->
    <div class="container pb-3 px-4" id="acordeonFooter">  <!-- px-4 da mas espacio a los lados para que el acordeon no quede pegado al borde -->
        <!-- ================================== Seccion 2: Tienda ================================== -->
        <!-- data-bs-toggle="collapse" y data-bs-target abren y cierran la lista con id="footerTienda" -->
        <!-- La flecha queda a la derecha con justify-content-between y centrada con align-items-center -->
        <!-- border-0 quita el borde que trae el btn por todos lados -->
        <button class="btn text-white fw-bold w-100 py-3 px-0 d-flex justify-content-between align-items-center border-0 border-bottom border-white border-opacity-25 rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#footerTienda">
            Tienda <i class="fi fi-rr-angle-small-down d-flex"></i>
        </button>
        <!-- collapse: la lista empieza cerrada -->
        <div class="collapse" id="footerTienda" data-bs-parent="#acordeonFooter">
            <ul class="list-unstyled py-2">
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Ofertas</a></li>
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Categorías</a></li>
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Ofertas</a></li>
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Novedades</a></li>
            </ul>
        </div>
        <!-- =================================== Seccion 3: Paginas =================================== -->
        <button class="btn text-white fw-bold w-100 py-3 px-0 d-flex justify-content-between align-items-center border-0 border-bottom border-white border-opacity-25 rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#footerPaginas">
            Páginas <i class="fi fi-rr-angle-small-down d-flex"></i>
        </button>
        <div class="collapse" id="footerPaginas" data-bs-parent="#acordeonFooter">
            <ul class="list-unstyled py-2">
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Inicio</a></li>
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Servicios</a></li>
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Nosotros</a></li>
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">FaQ</a></li>
            </ul>
        </div>
        <!-- ================================== Seccion 4: Informacion ================================== -->
        <button class="btn text-white fw-bold w-100 py-3 px-0 d-flex justify-content-between align-items-center border-0 border-bottom border-white border-opacity-25 rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#footerInfo">
            Información <i class="fi fi-rr-angle-small-down d-flex"></i>
        </button>
        <div class="collapse" id="footerInfo" data-bs-parent="#acordeonFooter">
            <ul class="list-unstyled py-2">
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Contacto</a></li>
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Términos y condiciones</a></li>
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Política de privacidad</a></li>
                <li class="mb-2"><a href="#" class="text-white text-decoration-none">Envíos y devoluciones</a></li>
            </ul>
        </div>
    </div>
    <!-- ================================== copy centrado ================================== -->
    <div class="border-top border-white border-opacity-75">
        <div class="container py-3 text-center">
            <small>© 2026 NexusCorp Importaciones. Todos los derechos reservados.</small>
        </div>
    </div>
</footer>
<!-- ========================================================================================================================= -->
