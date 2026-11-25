<?php 
    session_start(); 
    require_once __DIR__ . '/../conexion/conexion.php';  
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> 
<body>
    <main>
        <?php include __DIR__ . '/../include/store/header.php'; ?> 
        <?php include __DIR__ . '/../include/store/elements/pag-categoria.php'; ?> 
    </main>
    <?php include __DIR__ . '/../include/store/footer.php'; ?> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
