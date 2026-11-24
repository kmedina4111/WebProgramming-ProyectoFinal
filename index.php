<?php
    session_start();   // abre la sesion ANTES de cualquier HTML (el header muestra al usuario conectado)
    // La conexion esta en src/conexion/ (no en src/include/store/)
    require_once __DIR__ . '/src/conexion/conexion.php';   // crea $conexion
?>
<!DOCTYPE html>
<html lang="es">
<?php include 'src/include/store/head.php'; ?> <!-- head and metadata -->
<body>
    <!-- El header y el footer van DENTRO de <body>: todo lo que se ve en la pagina debe estar aqui -->
    <?php include 'src/include/store/header.php'; ?> <!-- header -->
    <main>
        <?php include 'src/include/store/elements/banners.php'; ?> <!-- banners -->
        <?php include 'src/include/store/elements/beneficios.php'; ?> <!-- beneficios -->
        <?php include 'src/include/store/elements/categorias.php'; ?> <!-- categorias -->
        <?php include 'src/include/store/elements/ofertas.php'; ?> <!-- ofertas (desde la base de datos) -->
        <?php include 'src/include/store/elements/cta.php'; ?> <!-- banner intermedio -->
        <?php include 'src/include/store/elements/marcas.php'; ?> <!-- marcas -->
        <?php include 'src/include/store/elements/newsletter.php'; ?> <!-- newsletter -->
    </main>
    <?php include 'src/include/store/footer.php'; ?> <!-- footer -->
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
