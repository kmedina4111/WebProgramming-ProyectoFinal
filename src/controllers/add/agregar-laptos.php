<?php
    require_once __DIR__ . '/../../conexion/conexion.php';   // crea $conexion

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numeroSerie        = trim($_POST['numero_serie']);
        $modelo             = trim($_POST['modelo']);
        $descripcion        = trim($_POST['descripcion']);
        $procesador         = trim($_POST['procesador']);
        $tarjetaGrafica     = trim($_POST['tarjeta_grafica']);
        $ramGb              = $_POST['ram_gb'];
        $almacenamientoGb   = $_POST['almacenamiento_gb'];
        $tipoAlmacenamiento = $_POST['tipo_almacenamiento'];
        $precio             = $_POST['precio'];
        // Si se deja vacio, se guarda NULL (la laptop no esta en oferta)
        $precioAnterior     = $_POST['precio_anterior'] !== '' ? $_POST['precio_anterior'] : null;
        $idFabricante       = $_POST['id_fabricante'];
        $nombreFoto = null;

        // Procesar la subida del archivo de imagen
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // La extension se toma del tipo REAL del archivo, no del nombre (evita que suban un .php)
            $permitidos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
            $tipo = mime_content_type($_FILES['foto']['tmp_name']);
            if (isset($permitidos[$tipo])) {
                // Generar un nombre único para evitar duplicados
                $nombreFoto = time() . '_' . uniqid() . '.' . $permitidos[$tipo];
                move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__ . '/../../../assets/imgs/laptops/' . $nombreFoto);
            }
        }

        try {
            $sql = "INSERT INTO laptops (numero_serie, modelo, descripcion, procesador, tarjeta_grafica, ram_gb, almacenamiento_gb,
                                        tipo_almacenamiento, precio, precio_anterior, id_fabricante, foto)
                    VALUES (:numero_serie, :modelo, :descripcion, :procesador, :tarjeta_grafica, :ram_gb, :almacenamiento_gb,
                            :tipo_almacenamiento, :precio, :precio_anterior, :id_fabricante, :foto)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':numero_serie'        => $numeroSerie,
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
                ':foto'                => $nombreFoto
            ]);
            header('Location: ../list/listar-laptops.php?ok=1');
        } catch (PDOException $e) {
            // Falla si el numero de serie ya existe o si no se cumple una regla CHECK (ej: precio_anterior menor que precio)
            header('Location: agregar-laptos.php?error=1');
        }
        exit;
}

    // Fabricantes para llenar el <select> (asi no se escribe el id a mano)
    $fabricantes = $conexion->query("SELECT id_fabricante, nombre_fabricante FROM fabricantes ORDER BY nombre_fabricante")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Laptop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container bg-white p-4 rounded shadow-sm" style="max-width: 700px;">
    <h3 class="mb-3">Nueva Laptop</h3>

    <?php if (isset($_GET['ok'])): ?>
        <div class="alert alert-success">Laptop guardada correctamente.</div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">No se pudo guardar: el número de serie ya existe o el precio anterior no es mayor que el precio.</div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-2">
            <div class="col-md-6">
                <label class="form-label">Número de serie:</label>
                <input type="text" name="numero_serie" class="form-control" maxlength="50" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Modelo:</label>
                <input type="text" name="modelo" class="form-control" maxlength="100" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fabricante:</label>
                <!-- Las opciones salen de la tabla fabricantes -->
                <select name="id_fabricante" class="form-select" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($fabricantes as $f): ?>
                        <option value="<?= $f['id_fabricante'] ?>"><?= htmlspecialchars($f['nombre_fabricante']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Procesador:</label>
                <input type="text" name="procesador" class="form-control" maxlength="100" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tarjeta gráfica:</label>
                <input type="text" name="tarjeta_grafica" class="form-control" maxlength="100" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">RAM (GB):</label>
                <input type="number" name="ram_gb" class="form-control" min="1" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Almacenamiento (GB):</label>
                <input type="number" name="almacenamiento_gb" class="form-control" min="1" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tipo de almacenamiento:</label>
                <select name="tipo_almacenamiento" class="form-select">
                    <option value="SSD">SSD</option>
                    <option value="HDD">HDD</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Precio (S/):</label>
                <input type="number" name="precio" class="form-control" min="0.01" step="0.01" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Precio anterior (S/) <small class="text-secondary">opcional, solo si está en oferta</small>:</label>
                <input type="number" name="precio_anterior" class="form-control" min="0.01" step="0.01">
            </div>
            <div class="col-12">
                <label class="form-label">Descripción:</label>
                <textarea name="descripcion" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Seleccionar Foto:</label>
                <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Guardar Laptop</button>
        <a href="../list/listar-laptops.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
    </form>
</div>

</body>
</html>
