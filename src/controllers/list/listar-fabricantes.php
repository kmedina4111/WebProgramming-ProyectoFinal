<?php
require_once __DIR__ . '/../../conexion/conexion.php';   // crea $conexion

// LEFT JOIN + COUNT: ademas del fabricante, cuenta cuantas laptops tiene registradas
// LEFT JOIN (y no JOIN) para que tambien aparezcan los fabricantes que tienen 0 laptops
$sql = "SELECT f.id_fabricante, f.nombre_fabricante, COUNT(l.numero_serie) AS total_laptops
        FROM fabricantes f
        LEFT JOIN laptops l ON l.id_fabricante = f.id_fabricante
        GROUP BY f.id_fabricante, f.nombre_fabricante
        ORDER BY f.id_fabricante DESC";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$fabricantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Fabricantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container bg-white p-4 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Lista de Fabricantes</h2>
        <!-- Lado derecho: boton para volver al dashboard + boton de nuevo registro -->
        <div class="d-flex gap-2">
            <!-- Ruta absoluta (empieza con /): funciona sin importar en que carpeta este este archivo -->
            <a href="/admin/index.php" class="btn btn-outline-secondary">&larr; Volver al panel</a>
            <a href="../add/agregar-fabricantes.php" class="btn btn-success">+ Nuevo Fabricante</a>
        </div>
    </div>

    <!-- Llega desde agregar-fabricantes.php despues de guardar (header Location ...?ok=1) -->
    <?php if (isset($_GET['ok'])): ?>
        <div class="alert alert-success">Fabricante guardado correctamente.</div>
    <?php endif; ?>
    <!-- Llega desde eliminar-fabricante.php (header Location ...?eliminado=1) -->
    <?php if (isset($_GET['eliminado'])): ?>
        <div class="alert alert-warning">Fabricante eliminado correctamente.</div>
    <?php endif; ?>
    <!-- Llega desde eliminar-fabricante.php cuando MySQL no deja borrar (header Location ...?error=1) -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">No se puede eliminar un fabricante que todavía tiene laptops registradas. Elimina o cambia de fabricante esas laptops primero.</div>
    <?php endif; ?>

    <!-- Llega desde editar (header Location ...?editado=1) -->
    <?php if (isset($_GET['editado'])): ?>
        <div class="alert alert-info">Fabricante actualizado correctamente.</div>
    <?php endif; ?>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Fabricante</th>
                <th>Laptops registradas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fabricantes as $fab): ?>
            <tr>
                <td class="text-center"><?= $fab['id_fabricante'] ?></td>
                <!-- htmlspecialchars: el nombre se muestra como texto aunque tenga caracteres como < > -->
                <td><?= htmlspecialchars($fab['nombre_fabricante']) ?></td>
                <td class="text-center">
                    <span class="badge bg-secondary"><?= $fab['total_laptops'] ?></span>
                </td>
                <td class="text-center">
                    <a href="../update/editar-fabricante.php?id=<?= $fab['id_fabricante'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="../delete/eliminar-fabricante.php?id=<?= $fab['id_fabricante'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Deseas eliminar este fabricante?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>

            <?php if (count($fabricantes) === 0): ?>
            <tr>
                <td colspan="4" class="text-center text-secondary py-4">No hay fabricantes registrados.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
