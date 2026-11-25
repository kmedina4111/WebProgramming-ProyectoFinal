<?php
    // ===================================================== LOGIN =====================================================
    // Recibe el formulario del modal de login (src/include/store/login-modal.php)
    //   - admin   -> va al panel de administracion (/admin/index.php)
    //   - cliente -> vuelve a la tienda (/index.php) con su nombre y foto en el header
    session_start();   // abre la sesion para poder guardar quien inicio sesion
    require_once __DIR__ . '/../conexion/conexion.php';   

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'login') {
        $usuario  = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';

        // Buscar al usuario por su nombre (aqui SI se pide el password: es el hash para compararlo)
        $stmt = $conexion->prepare("SELECT id, usuario, nombre, password, rol, foto FROM usuarios WHERE usuario = :usuario");
        $stmt->execute([':usuario' => $usuario]);
        $usu = $stmt->fetch(PDO::FETCH_ASSOC);

        // assword_verify compara lo que escribio con el HASH guardado (nunca se compara texto plano)
        if ($usu && password_verify($password, $usu['password'])) {
            // Genera un id de sesion nuevo al iniciar sesion (evita que alguien reutilice un id de sesion robado)
            session_regenerate_id(true);

            // Guardar en la sesion los datos que se usan en las paginas (NUNCA el password)
            $_SESSION['usuario_id'] = $usu['id'];
            $_SESSION['usuario']    = $usu['usuario'];
            // nombre: es lo que se muestra en el header | si esta vacio se usa el usuario (correo) como respaldo
            $_SESSION['nombre']     = $usu['nombre'] !== '' ? $usu['nombre'] : $usu['usuario'];
            $_SESSION['rol']        = $usu['rol'];
            $_SESSION['foto']       = $usu['foto'];

            // 4. Redirigir segun el rol
            if ($usu['rol'] === 'admin') {
                header('Location: /admin/index.php');
            } else {
                header('Location: /index.php');
            }
            exit;
        }

        // Usuario o contraseña incorrectos: volver a la tienda y reabrir el modal con el mensaje de error
        // (el mismo mensaje para los dos casos: asi no se revela si el usuario existe o no)
        header('Location: /index.php?login=error');
        exit;
    }

    // Si alguien entra a este archivo directamente (sin enviar el formulario), vuelve a la tienda
    header('Location: /index.php');
    exit;
?>
