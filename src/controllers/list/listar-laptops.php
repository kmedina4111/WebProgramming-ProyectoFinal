<?php
require_once __DIR__ . '/../../conexion/conexion.php';   // crea $conexion

// JOIN con fabricantes: en lugar del id_fabricante (un numero) se muestra el nombre (ASUS, HP...)
$sql = "SELECT l.numero_serie, l.modelo, l.procesador, l.tarjeta_grafica, l.ram_gb, l.almacenamiento_gb,
               l.tipo_almacenamiento, l.precio, l.precio_anterior, l.foto, l.activo, f.nombre_fabricante
        FROM laptops l
        JOIN fabricantes f ON f.id_fabricante = l.id_fabricante
        ORDER BY l.creado_en DESC";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$laptops = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Carpeta donde estan las fotos de las laptops
$rutaFotos = __DIR__ . '/../../../assets/imgs/laptops/';   // ruta del SERVIDOR (para file_exists)
$urlFotos  = '/assets/imgs/laptops/';                      // ruta del NAVEGADOR (para el <img>)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Laptops</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container bg-white p-4 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Lista de Laptops</h2>
        <!-- Lado derecho: boton para volver al dashboard + boton de nuevo registro -->
        <div class="d-flex gap-2">
            <!-- Ruta absoluta (empieza con /): funciona sin importar en que carpeta este este archivo -->
            <a href="/admin/index.php" class="btn btn-outline-secondary">&larr; Volver al panel</a>
            <a href="../add/agregar-laptos.php" class="btn btn-success">+ Nueva Laptop</a>
        </div>
    </div>

    <!-- Llega desde agregar-laptos.php despues de guardar (header Location ...?ok=1) -->
    <?php if (isset($_GET['ok'])): ?>
        <div class="alert alert-success">Laptop guardada correctamente.</div>
    <?php endif; ?>
    <!-- Llega desde eliminar-laptop.php (header Location ...?eliminado=1) -->
    <?php if (isset($_GET['eliminado'])): ?>
        <div class="alert alert-warning">Laptop eliminada correctamente.</div>
    <?php endif; ?>

    <!-- Llega desde editar (header Location ...?editado=1) -->
    <?php if (isset($_GET['editado'])): ?>
        <div class="alert alert-info">Laptop actualizada correctamente.</div>
    <?php endif; ?>

    <!-- table-responsive: en pantallas pequenas la tabla se desplaza de lado en vez de romper el diseno (tiene muchas columnas) -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Foto</th>
                    <th>N° de serie</th>
                    <th>Modelo</th>
                    <th>Fabricante</th>
                    <th>Especificaciones</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($laptops as $lap): ?>
                <tr>
                    <td class="text-center">
                        <?php if (!empty($lap['foto']) && file_exists($rutaFotos . $lap['foto'])): ?>
                            <!-- object-fit-contain: la laptop se ve completa, sin recortarse -->
                            <img src="<?= $urlFotos . htmlspecialchars($lap['foto']) ?>" width="60" height="60" class="rounded object-fit-contain border bg-white">
                        <?php else: ?>
                            <span class="badge bg-secondary">Sin Foto</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-nowrap"><?= htmlspecialchars($lap['numero_serie']) ?></td>
                    <td><?= htmlspecialchars($lap['modelo']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($lap['nombre_fabricante']) ?></td>
                    <td class="small">
                        <?= htmlspecialchars($lap['procesador']) ?><br>
                        <?= htmlspecialchars($lap['tarjeta_grafica']) ?><br>
                        <?= $lap['ram_gb'] ?> GB RAM · <?= $lap['almacenamiento_gb'] ?> GB <?= $lap['tipo_almacenamiento'] ?>
                    </td>
                    <td class="text-end text-nowrap">
                        <!-- Si tiene precio_anterior, esta en oferta: se muestra tachado encima del precio actual -->
                        <?php if (!empty($lap['precio_anterior'])): ?>
                            <small class="text-secondary text-decoration-line-through d-block">S/ <?= number_format($lap['precio_anterior'], 2) ?></small>
                        <?php endif; ?>
                        <strong>S/ <?= number_format($lap['precio'], 2) ?></strong>
                    </td>
                    <td class="text-center">
                        <?php if ($lap['activo']): ?>
                            <span class="badge bg-success">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactivo</span>
                        <?php endif; ?>
                        <?php if (!empty($lap['precio_anterior'])): ?>
                            <span class="badge bg-danger">Oferta</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center text-nowrap">
                        <!-- urlencode: el numero de serie es texto (puede tener guiones u otros caracteres), asi viaja bien en la URL -->
                        <a href="../update/editar-laptop.php?id=<?= urlencode($lap['numero_serie']) ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="../delete/eliminar-laptop.php?id=<?= urlencode($lap['numero_serie']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Deseas eliminar esta laptop y su foto?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (count($laptops) === 0): ?>
                <tr>
                    <td colspan="8" class="text-center text-secondary py-4">No hay laptops registradas.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
