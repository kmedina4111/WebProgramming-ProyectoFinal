<?php
    require_once __DIR__ . '/../../conexion/conexion.php';   

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario  = $_POST['usuario'];
        $nombre   = trim($_POST['nombre']);   // nombre de la persona (se muestra en el header y en el panel)
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);   // se guarda el HASH(se encripta en la db ps).
        $rol      = $_POST['rol'];
        $nombreFoto = null;

        // Procesar la subida del archivo de imagen
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            // Generar un nombre único para evitar duplicados
            $nombreFoto = time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__ . '/../../../assets/imgs/usuarios/' . $nombreFoto);
        }

        $sql = "INSERT INTO usuarios (usuario, nombre, password, rol, foto) VALUES (:usuario, :nombre, :password, :rol, :foto)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':usuario'  => $usuario,
            ':nombre'   => $nombre,
            ':password' => $password,
            ':rol'      => $rol,
            ':foto'     => $nombreFoto
        ]);

        header('Location: ../list/listar-usuarios.php?ok=1');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 rounded shadow-sm" style="max-width: 500px;">
        <h3 class="mb-3">Nuevo Usuario</h3>

        <?php if (isset($_GET['ok'])): ?>
            <div class="alert alert-success">Usuario guardado correctamente.</div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-2">
                <label class="form-label">Usuario:</label>
                <input type="text" name="usuario" class="form-control" maxlength="50" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" maxlength="100" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" minlength="6" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Rol:</label>
                <select name="rol" class="form-select">
                    <option value="cliente">Cliente</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Seleccionar Foto:</label>
                <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
            </div>
            <button type="submit" class="btn btn-primary w-100">Guardar Usuario</button>
            <a href="../list/listar-usuarios.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        </form>
    </div>
</body>
</html>
