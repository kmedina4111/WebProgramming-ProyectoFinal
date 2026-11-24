<?php
    // Pagina de error 404: se muestra cuando la direccion que se busca no existe.
    // http_response_code(404) le avisa al navegador y a Google que la pagina NO existe (si no, responderia 200 = "todo bien").
    // Debe ir ANTES de cualquier HTML.
    http_response_code(404);
    session_start();   // abre la sesion ANTES de cualquier HTML (el header muestra al usuario conectado)
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> <!-- head and metadata -->
<body>
    <?php include __DIR__ . '/../include/store/header.php'; ?> <!-- header -->

    <main>
        <!-- ============ CONTENIDO 404 ============ -->
        <!-- py-5 da aire arriba y abajo | text-center centra todo el contenido -->
        <section class="container py-5 text-center">
            <!-- mx-auto + max-width: el bloque queda centrado y no se estira en pantallas grandes -->
            <div class="mx-auto" style="max-width: 560px;">

                <!-- Logo de la tienda | ruta absoluta (empieza con /) para que funcione desde cualquier carpeta -->
                <img src="/assets/imgs/logos/logo1.webp" alt="Nexus Importaciones" class="img-fluid mb-4" style="max-height: 80px;">

                <!-- Numero 404 grande | display-1: el tamaño de titulo mas grande de Bootstrap | lh-1 quita el espacio extra de la linea -->
                <p class="display-1 fw-bold text-primary lh-1 mb-3">404</p>

                <h1 class="fw-bold fs-3">Página no encontrada</h1>
                <p class="text-secondary mb-4">
                    La página que buscas no existe, cambió de dirección o fue eliminada.
                    Revisa que la dirección esté bien escrita o vuelve al inicio.
                </p>

                <!-- Botones | flex-column en movil (uno debajo del otro) y flex-sm-row desde 576px (uno al lado del otro) -->
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                    <a href="/index.php" class="btn btn-primary fw-semibold px-4 d-flex align-items-center justify-content-center gap-2">
                        <i class="fi fi-rr-home d-flex"></i> Volver al inicio
                    </a>
                    <a href="/src/pages/categorias.php" class="btn btn-outline-primary fw-semibold px-4 d-flex align-items-center justify-content-center gap-2">
                        <i class="fi fi-rr-laptop d-flex"></i> Ver laptops
                    </a>
                </div>

            </div>
        </section>
    </main>

    <?php include __DIR__ . '/../include/store/footer.php'; ?> <!-- footer -->
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
