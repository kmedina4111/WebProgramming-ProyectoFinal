<?php
    require_once __DIR__ . '/../../conexion/conexion.php';   
    // Carpeta donde se guardan las fotos de los usuarios
    $rutaFotos = __DIR__ . '/../../../assets/imgs/usuarios/';   // ruta del SERVIDOR
    $urlFotos  = '/assets/imgs/usuarios/';                      // ruta del NAVEGADOR
    $id = $_GET['id'] ?? null;
    // Buscar el usuario a editar (sin la columna password: el formulario nunca debe mostrar el hash)
    $stmt = $conexion->prepare("SELECT id, usuario, nombre, rol, foto FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $usu = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si el id no existe, volver a la lista
    if (!$usu) {
        header('Location: ../list/listar-usuarios.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario    = trim($_POST['usuario']);
        $nombre     = trim($_POST['nombre']);
        $rol        = $_POST['rol'];
        $nombreFoto = $usu['foto']; // Mantener la foto anterior por defecto

        // Si se selecciona un nuevo archivo de imagen
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // La extension se toma del tipo REAL del archivo, no del nombre (evita que suban un .php)
            $permitidos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
            $tipo = mime_content_type($_FILES['foto']['tmp_name']);
            if (isset($permitidos[$tipo])) {
                // Eliminar la foto anterior del disco si existe
                if (!empty($usu['foto']) && file_exists($rutaFotos . basename($usu['foto']))) {
                    unlink($rutaFotos . basename($usu['foto']));
                }
                // Subir la nueva foto
                $nombreFoto = time() . '_' . uniqid() . '.' . $permitidos[$tipo];
                move_uploaded_file($_FILES['foto']['tmp_name'], $rutaFotos . $nombreFoto);
            }
        }

        try {
            // La contraseña es opcional: si el campo se deja vacio, se mantiene la actual
            if ($_POST['password'] !== '') {
                $sql = "UPDATE usuarios SET usuario = :usuario, nombre = :nombre, password = :password, rol = :rol, foto = :foto WHERE id = :id";
                $datos = [
                    ':usuario'  => $usuario,
                    ':nombre'   => $nombre,
                    ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT),   // se guarda el HASH, nunca el texto plano
                    ':rol'      => $rol,
                    ':foto'     => $nombreFoto,
                    ':id'       => $id
                ];
            } else {
                $sql = "UPDATE usuarios SET usuario = :usuario, nombre = :nombre, rol = :rol, foto = :foto WHERE id = :id";
                $datos = [
                    ':usuario' => $usuario,
                    ':nombre'  => $nombre,
                    ':rol'     => $rol,
                    ':foto'    => $nombreFoto,
                    ':id'      => $id
                ];
            }
            $stmt = $conexion->prepare($sql);
            $stmt->execute($datos);
        } catch (PDOException $e) {
            // POR DEFECTO EL USER ESA UNIQUE Y CUANDO SE REPITE EL NOMBRE DE USUARIO, LANZA ERROR
            header('Location: editar-usuario.php?id=' . urlencode($id) . '&error=1');
            exit;
        }
        header('Location: ../list/listar-usuarios.php?editado=1');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 rounded shadow-sm" style="max-width: 500px;">
        <h3 class="mb-3">Editar Usuario #<?= $usu['id'] ?></h3>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Ese nombre de usuario ya está en uso.</div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-2">
                <label class="form-label">Usuario:</label>
                <!-- htmlspecialchars dentro de value: si el texto tiene comillas, no rompe el atributo -->
                <input type="text" name="usuario" class="form-control" maxlength="50" value="<?= htmlspecialchars($usu['usuario']) ?>" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" maxlength="100" value="<?= htmlspecialchars($usu['nombre']) ?>" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Nueva contraseña:</label>
                <!-- Sin required: es opcional -->
                <input type="password" name="password" class="form-control" minlength="6">
                <small class="text-muted">Déjala vacía si no deseas cambiar la contraseña.</small>
            </div>
            <div class="mb-2">
                <label class="form-label">Rol:</label>
                <select name="rol" class="form-select">
                    <!-- selected: deja marcada la opcion que el usuario ya tiene -->
                    <option value="cliente" <?= $usu['rol'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                    <option value="admin" <?= $usu['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
            <div class="mb-3 text-center">
                <label class="form-label d-block text-start">Foto Actual:</label>
                <?php if (!empty($usu['foto']) && file_exists($rutaFotos . $usu['foto'])): ?>
                    <img src="<?= $urlFotos . htmlspecialchars($usu['foto']) ?>" width="80" height="80" class="rounded-circle object-fit-cover mb-2 border">
                <?php else: ?>
                    <p class="text-muted">Sin Foto Actual</p>
                <?php endif; ?>
                <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
                <small class="text-muted">Selecciona un archivo solo si deseas cambiar la foto.</small>
            </div>
            <button type="submit" class="btn btn-warning w-100">Actualizar Registro</button>
            <a href="../list/listar-usuarios.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        </form>
    </div>
</body>
</html>
