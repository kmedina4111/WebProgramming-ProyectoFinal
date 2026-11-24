<!DOCTYPE html>
<html lang="es">
<?php include 'src/include/store/head.php'; ?> <!-- head and metadata -->  
<?php include 'src/include/store/header.php'; ?> <!-- header -->
    <body>
        <main>
            <?php include 'src/include/store/elements/banners.php'; ?> <!-- header -->
            <?php include 'src/include/store/elements/beneficios.php'; ?> <!-- header -->
            <?php include 'src/include/store/elements/categorias.php'; ?> <!-- header -->

            <?php include 'src/include/store/elements/cta.php'; ?> <!-- header -->

            <?php include 'src/include/store/elements/marcas.php'; ?> <!-- header -->
            <?php include 'src/include/store/elements/newsletter.php'; ?> <!-- header -->
        </main>
    </body>
    <?php include 'src/include/store/footer.php'; ?> <!-- footer -->
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>

