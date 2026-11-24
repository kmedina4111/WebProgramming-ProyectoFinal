<?php
require_once __DIR__ . '/../../conexion/conexion.php';   // crea $conexion

$id = $_GET['id'] ?? null;

// Buscar el fabricante a editar
$stmt = $conexion->prepare("SELECT * FROM fabricantes WHERE id_fabricante = :id");
$stmt->execute([':id' => $id]);
$fab = $stmt->fetch(PDO::FETCH_ASSOC);

// Si el id no existe, volver a la lista
if (!$fab) {
    header('Location: ../list/listar-fabricantes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre_fabricante']);   // trim: quita espacios al inicio y al final

    try {
        $sql = "UPDATE fabricantes SET nombre_fabricante = :nombre WHERE id_fabricante = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':id'     => $id
        ]);
    } catch (PDOException $e) {
        // nombre_fabricante es UNIQUE: si otro fabricante ya tiene ese nombre, MySQL lanza un error
        header('Location: editar-fabricante.php?id=' . urlencode($id) . '&error=1');
        exit;
    }

    header('Location: ../list/listar-fabricantes.php?editado=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Fabricante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container bg-white p-4 rounded shadow-sm" style="max-width: 500px;">
    <h3 class="mb-3">Editar Fabricante #<?= $fab['id_fabricante'] ?></h3>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Ya existe otro fabricante con ese nombre.</div>
    <?php endif; ?>

    <!-- Sin enctype: este formulario no sube archivos -->
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre del fabricante:</label>
            <input type="text" name="nombre_fabricante" class="form-control" maxlength="100" value="<?= htmlspecialchars($fab['nombre_fabricante']) ?>" required>
        </div>
        <button type="submit" class="btn btn-warning w-100">Actualizar Registro</button>
        <a href="../list/listar-fabricantes.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
    </form>
</div>

</body>
</html>
