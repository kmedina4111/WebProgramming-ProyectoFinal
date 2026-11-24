<?php
require_once __DIR__ . '/../../conexion/conexion.php';   // crea $conexion

// No se pide la columna password: la lista nunca debe mostrar ni cargar el hash
$sql = "SELECT id, usuario, rol, foto, creado_en FROM usuarios ORDER BY id DESC";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Carpeta donde estan las fotos de los usuarios
$rutaFotos = __DIR__ . '/../../../assets/imgs/usuarios/';   // ruta del SERVIDOR (para file_exists)
$urlFotos  = '/assets/imgs/usuarios/';                      // ruta del NAVEGADOR (para el <img>)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container bg-white p-4 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Lista de Usuarios</h2>
        <!-- Lado derecho: boton para volver al dashboard + boton de nuevo registro -->
        <div class="d-flex gap-2">
            <!-- Ruta absoluta (empieza con /): funciona sin importar en que carpeta este este archivo -->
            <a href="/admin/index.php" class="btn btn-outline-secondary">&larr; Volver al panel</a>
            <a href="../add/agregar-usuario.php" class="btn btn-success">+ Nuevo Usuario</a>
        </div>
    </div>

    <!-- Llega desde agregar-usuario.php despues de guardar (header Location ...?ok=1) -->
    <?php if (isset($_GET['ok'])): ?>
        <div class="alert alert-success">Usuario guardado correctamente.</div>
    <?php endif; ?>
    <!-- Llega desde eliminar-usuario.php (header Location ...?eliminado=1) -->
    <?php if (isset($_GET['eliminado'])): ?>
        <div class="alert alert-warning">Usuario eliminado correctamente.</div>
    <?php endif; ?>

    <!-- Llega desde editar (header Location ...?editado=1) -->
    <?php if (isset($_GET['editado'])): ?>
        <div class="alert alert-info">Usuario actualizado correctamente.</div>
    <?php endif; ?>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Fecha de registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usu): ?>
            <tr>
                <td class="text-center"><?= $usu['id'] ?></td>
                <td class="text-center">
                    <?php if (!empty($usu['foto']) && file_exists($rutaFotos . $usu['foto'])): ?>
                        <img src="<?= $urlFotos . htmlspecialchars($usu['foto']) ?>" width="50" height="50" class="rounded-circle object-fit-cover border">
                    <?php else: ?>
                        <span class="badge bg-secondary">Sin Foto</span>
                    <?php endif; ?>
                </td>
                <!-- htmlspecialchars: si alguien se registra con codigo HTML como nombre, se muestra como texto y no se ejecuta -->
                <td><?= htmlspecialchars($usu['usuario']) ?></td>
                <td class="text-center">
                    <?php if ($usu['rol'] === 'admin'): ?>
                        <span class="badge bg-primary">Administrador</span>
                    <?php else: ?>
                        <span class="badge bg-info text-dark">Cliente</span>
                    <?php endif; ?>
                </td>
                <td class="text-center"><?= date('d/m/Y', strtotime($usu['creado_en'])) ?></td>
                <td class="text-center">
                    <a href="../update/editar-usuario.php?id=<?= $usu['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="../delete/eliminar-usuario.php?id=<?= $usu['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Deseas eliminar este usuario y su foto?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>

            <?php if (count($usuarios) === 0): ?>
            <tr>
                <td colspan="6" class="text-center text-secondary py-4">No hay usuarios registrados.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
