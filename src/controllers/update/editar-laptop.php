<?php
    require_once __DIR__ . '/../../conexion/conexion.php';   
    // Carpeta donde se guardan las fotos de las laptops
    $rutaFotos = __DIR__ . '/../../../assets/imgs/laptops/';   // ruta del SERVIDOR
    $urlFotos  = '/assets/imgs/laptops/';                      // ruta del NAVEGADOR
    // En laptops el id es el NUMERO DE SERIE (texto)
    $id = $_GET['id'] ?? null;
    // Buscar la laptop a editar
    $stmt = $conexion->prepare("SELECT * FROM laptops WHERE numero_serie = :id");
    $stmt->execute([':id' => $id]);
    $lap = $stmt->fetch(PDO::FETCH_ASSOC);
    // Si el numero de serie no existe, volver a la lista
    if (!$lap) {
        header('Location: ../list/listar-laptops.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $modelo             = trim($_POST['modelo']);
        $descripcion        = trim($_POST['descripcion']);
        $procesador         = trim($_POST['procesador']);
        $tarjetaGrafica     = trim($_POST['tarjeta_grafica']);
        $ramGb              = $_POST['ram_gb'];
        $almacenamientoGb   = $_POST['almacenamiento_gb'];
        $tipoAlmacenamiento = $_POST['tipo_almacenamiento'];
        $precio             = $_POST['precio'];
        // si se deja vacio o null en la db la laptop deja de esatr en oferta
        $precioAnterior     = $_POST['precio_anterior'] !== '' ? $_POST['precio_anterior'] : null;
        $idFabricante       = $_POST['id_fabricante'];
        $activo             = $_POST['activo'];
        $nombreFoto         = $lap['foto']; 

        // Si se selecciona un nuevo archivo de imagen
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // La extension se toma del tipo REAL del archivo, no del nombre (evita que suban un .php)
            $permitidos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
            $tipo = mime_content_type($_FILES['foto']['tmp_name']);
            if (isset($permitidos[$tipo])) {
                // Eliminar la foto anterior del disco si existe
                if (!empty($lap['foto']) && file_exists($rutaFotos . basename($lap['foto']))) {
                    unlink($rutaFotos . basename($lap['foto']));
                }
                // Subir la nueva foto
                $nombreFoto = time() . '_' . uniqid() . '.' . $permitidos[$tipo];
                move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFotos . $nombreFoto);
            }
        }

        try {
            // El numero de serie NO se actualiza: es la llave primaria (identifica a la laptop)
            $sql = "UPDATE laptops SET modelo = :modelo, descripcion = :descripcion, procesador = :procesador, tarjeta_grafica = :tarjeta_grafica, 
            ram_gb = :ram_gb, almacenamiento_gb = :almacenamiento_gb, tipo_almacenamiento = :tipo_almacenamiento, precio = :precio, 
            precio_anterior = :precio_anterior, id_fabricante = :id_fabricante, foto = :foto, activo = :activo WHERE numero_serie = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':modelo'              => $modelo,
                ':descripcion'         => $descripcion,
                ':procesador'          => $procesador,
                ':tarjeta_grafica'     => $tarjetaGrafica,
                ':ram_gb'              => $ramGb,
                ':almacenamiento_gb'   => $almacenamientoGb,
                ':tipo_almacenamiento' => $tipoAlmacenamiento,
                ':precio'              => $precio,
                ':precio_anterior'     => $precioAnterior,
                ':id_fabricante'       => $idFabricante,
                ':foto'                => $nombreFoto,
                ':activo'              => $activo,
                ':id'                  => $id
            ]);
        } catch (PDOException $e) {
            // Falla si no se cumple una regla CHECK (ej: precio_anterior menor que precio)
            header('Location: editar-laptop.php?id=' . urlencode($id) . '&error=1');
            exit;
        }

        header('Location: ../list/listar-laptops.php?editado=1');
        exit;
}
    // Fabricantes para llenar el <select>
    $fabricantes = $conexion->query("SELECT id_fabricante, nombre_fabricante FROM fabricantes ORDER BY nombre_fabricante")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Laptop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 rounded shadow-sm" style="max-width: 700px;">
        <h3 class="mb-3">Editar Laptop <?= htmlspecialchars($lap['numero_serie']) ?></h3>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">No se pudo actualizar: el precio anterior debe ser mayor que el precio actual.</div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">Número de serie:</label>
                    <!-- disabled: se muestra pero no se puede cambiar (y no se envia en el formulario) -->
                    <input type="text" class="form-control" value="<?= htmlspecialchars($lap['numero_serie']) ?>" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Modelo:</label>
                    <input type="text" name="modelo" class="form-control" maxlength="100" value="<?= htmlspecialchars($lap['modelo']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fabricante:</label>
                    <!-- selected: deja marcado el fabricante que la laptop ya tiene -->
                    <select name="id_fabricante" class="form-select" required>
                        <?php foreach ($fabricantes as $f): ?>
                            <option value="<?= $f['id_fabricante'] ?>" <?= $f['id_fabricante'] == $lap['id_fabricante'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($f['nombre_fabricante']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Procesador:</label>
                    <input type="text" name="procesador" class="form-control" maxlength="100" value="<?= htmlspecialchars($lap['procesador']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tarjeta gráfica:</label>
                    <input type="text" name="tarjeta_grafica" class="form-control" maxlength="100" value="<?= htmlspecialchars($lap['tarjeta_grafica']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">RAM (GB):</label>
                    <input type="number" name="ram_gb" class="form-control" min="1" value="<?= $lap['ram_gb'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Almacenamiento (GB):</label>
                    <input type="number" name="almacenamiento_gb" class="form-control" min="1" value="<?= $lap['almacenamiento_gb'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipo de almacenamiento:</label>
                    <select name="tipo_almacenamiento" class="form-select">
                        <option value="SSD" <?= $lap['tipo_almacenamiento'] === 'SSD' ? 'selected' : '' ?>>SSD</option>
                        <option value="HDD" <?= $lap['tipo_almacenamiento'] === 'HDD' ? 'selected' : '' ?>>HDD</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Precio (S/):</label>
                    <input type="number" name="precio" class="form-control" min="0.01" step="0.01" value="<?= $lap['precio'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Precio anterior (S/) <small class="text-secondary">vacío = sin oferta</small>:</label>
                    <input type="number" name="precio_anterior" class="form-control" min="0.01" step="0.01" value="<?= $lap['precio_anterior'] ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado:</label>
                    <!-- Inactivo: la laptop sigue en la base de datos pero no se mostrara en la tienda -->
                    <select name="activo" class="form-select">
                        <option value="1" <?= $lap['activo'] ? 'selected' : '' ?>>Activo</option>
                        <option value="0" <?= !$lap['activo'] ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción:</label>
                    <textarea name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($lap['descripcion'] ?? '') ?></textarea>
                </div>
                <div class="col-12 mb-3 text-center">
                    <label class="form-label d-block text-start">Foto Actual:</label>
                    <?php if (!empty($lap['foto']) && file_exists($rutaFotos . $lap['foto'])): ?>
                        <img src="<?= $urlFotos . htmlspecialchars($lap['foto']) ?>" width="120" height="120" class="rounded object-fit-contain mb-2 border bg-white">
                    <?php else: ?>
                        <p class="text-muted">Sin Foto Actual</p>
                    <?php endif; ?>
                    <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
                    <small class="text-muted">Selecciona un archivo solo si deseas cambiar la foto.</small>
                </div>
            </div>
            <button type="submit" class="btn btn-warning w-100">Actualizar Registro</button>
            <a href="../list/listar-laptops.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        </form>
    </div>
</body>
</html>
