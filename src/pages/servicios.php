<?php session_start(); // abre la sesion ANTES de cualquier HTML (el header muestra al usuario conectado) ?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> <!-- head and metadata -->  
<?php include __DIR__ . '/../include/store/header.php'; ?> <!-- header -->
    <body>
        <main>
            <section class="container">
                <h1>Servicios</h1>
                <p>Descubre los servicios que ofrecemos para satisfacer tus necesidades de cómputo.</p>
            </section>
        </main>
    </body>
    <?php include __DIR__ . '/../include/store/footer.php'; ?> <!-- footer -->
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
