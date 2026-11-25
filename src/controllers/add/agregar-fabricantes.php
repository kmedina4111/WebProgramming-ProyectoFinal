<?php
    require_once __DIR__ . '/../../conexion/conexion.php';   // crea $conexion

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre_fabricante']);   // trim: quita espacios al inicio y al final

        try {
            $sql = "INSERT INTO fabricantes (nombre_fabricante) VALUES (:nombre)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':nombre' => $nombre
            ]);
            header('Location: ../list/listar-fabricantes.php?ok=1');
        } catch (PDOException $e) {
            // nombre_fabricante es UNIQUE: si ya existe, MySQL lanza un error y lo avisamos
            header('Location: agregar-fabricantes.php?error=1');
        }
        exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Fabricante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <body class="bg-light p-4">
        <div class="container bg-white p-4 rounded shadow-sm" style="max-width: 500px;">
            <h3 class="mb-3">Nuevo Fabricante</h3>

            <?php if (isset($_GET['ok'])): ?>
                <div class="alert alert-success">Fabricante guardado correctamente.</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">Ese fabricante ya existe.</div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre del fabricante:</label>
                    <input type="text" name="nombre_fabricante" class="form-control" maxlength="100" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Guardar Fabricante</button>
                <a href="../list/listar-fabricantes.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
            </form>
        </div>
    </body>
</html>
