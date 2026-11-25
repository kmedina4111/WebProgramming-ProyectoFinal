<?php 
    session_start(); // abre la sesion ANTES de cualquier HTML (el header muestra al usuario conectado)
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> 
<body>
    <?php include __DIR__ . '/../include/store/header.php'; ?> 
    <main>
        <!-- ============ PROXIMAMENTE ============ -->
        <!-- py-5 da aire arriba y abajo | text-center centra todo el contenido -->
        <section class="container py-5 text-center">
            <!-- mx-auto + max-width: el bloque queda centrado y no se estira en pantallas grandes -->
            <div class="mx-auto" style="max-width: 560px;">
                <i class="fi fi-rr-clock text-primary d-flex justify-content-center mb-3" style="font-size: 4rem;"></i>
                <h1 class="fw-bold">Próximamente</h1>
                <p class="text-secondary mb-4">
                    Estamos trabajando en esta sección. Muy pronto estará disponible.
                </p>
                <!-- Boton para volver al inicio | d-inline-flex: el boton solo mide lo que su contenido -->
                <a href="/index.php" class="btn btn-primary fw-semibold px-4 d-inline-flex align-items-center gap-2">
                    <i class="fi fi-rr-home d-flex"></i> Volver al inicio
                </a>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../include/store/footer.php'; ?> 
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
