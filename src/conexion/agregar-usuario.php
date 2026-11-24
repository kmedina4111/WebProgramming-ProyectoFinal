<?php
    require_once 'conexion.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario    = $_POST['usuario'];
        $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);   // se guarda el HASH, nunca el texto plano
        $rol        = $_POST['rol'];
        $nombreFoto = null;

        // Procesar la subida del archivo de imagen
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            // Generar un nombre único para evitar duplicados
            $nombreFoto = time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], 'imagenes/' . $nombreFoto);
        }

        $sql = "INSERT INTO usuarios (usuario, password, rol, foto) VALUES (:usuario, :password, :rol, :foto)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':usuario'  => $usuario,
            ':password' => $password,
            ':rol'      => $rol,
            ':foto'     => $nombreFoto
        ]);
        header('Location: agregar-usuario.php?ok=1');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
</head>
<body>
    <h3>Nuevo Usuario</h3>

    <?php if (isset($_GET['ok'])): ?>
        <p style="color: green;">Usuario guardado correctamente.</p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Usuario:</label>
        <input type="text" name="usuario"><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password"><br><br>

        <label>Rol:</label>
        <select name="rol">
            <option value="cliente">Cliente</option>
            <option value="admin">Administrador</option>
        </select><br><br>

        <label>Seleccionar Foto:</label>
        <input type="file" name="foto"><br><br>

        <button type="submit">Guardar Usuario</button>
    </form>
</body>
</html>
