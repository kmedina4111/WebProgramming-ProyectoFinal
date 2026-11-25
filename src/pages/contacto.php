<?php
    session_start(); // abre la sesion ANTES de cualquier HTML (el header muestra al usuario conectado)

    // ============ PROCESAR EL FORMULARIO ============
    // El formulario se envia a esta misma pagina (action="") por POST
    $errores = [];
    $datos   = ['nombre' => '', 'correo' => '', 'asunto' => '', 'mensaje' => ''];
    $asuntos = ['Consulta sobre un producto', 'Estado de mi pedido', 'Garantía y soporte técnico', 'Otro'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // trim: quita los espacios del inicio y del final
        $datos['nombre']  = trim($_POST['nombre'] ?? '');
        $datos['correo']  = trim($_POST['correo'] ?? '');
        $datos['asunto']  = $_POST['asunto'] ?? '';
        $datos['mensaje'] = trim($_POST['mensaje'] ?? '');

        // Validacion en el SERVIDOR (la del navegador se puede saltar, esta no)
        if ($datos['nombre'] === '') {
            $errores[] = 'Ingresa tu nombre.';
        }
        // filter_var con FILTER_VALIDATE_EMAIL: revisa que el correo tenga un formato valido (ej: nombre@correo.com)
        if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'Ingresa un correo válido.';
        }
        // in_array: el asunto debe ser una de las opciones de la lista
        if (!in_array($datos['asunto'], $asuntos, true)) {
            $errores[] = 'Elige un asunto.';
        }
        if (mb_strlen($datos['mensaje']) < 10) {
            $errores[] = 'El mensaje debe tener al menos 10 caracteres.';
        }

        // Sin errores: volver a la pagina con ?enviado=1 (asi al recargar no se reenvia el formulario)
        // Aqui se podria guardar el mensaje en la base de datos o enviarlo por correo
        if (count($errores) === 0) {
            header('Location: contacto.php?enviado=1');
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> <!-- head and metadata -->
<!-- Estructura: body > main > section | el header y el footer van DENTRO de <body> -->
<body>
    <?php include __DIR__ . '/../include/store/header.php'; ?> <!-- header -->

    <main>
        <!-- ============ TITULO ============ -->
        <!-- max-width: el contenido no se estira tanto en pantallas grandes -->
        <section class="container pt-5 pb-4" style="max-width: 860px;">
            <h1 class="fw-bold mb-2">Contáctanos</h1>
            <p class="text-secondary mb-0">
                ¿Tienes dudas sobre un producto, tu pedido o la garantía? Escríbenos y te responderemos lo antes posible.
            </p>
        </section>

        <!-- ============ FORMULARIO ============ -->
        <section class="container pb-5" style="max-width: 860px;">

            <!-- Mensaje de exito: llega con ?enviado=1 despues de enviar -->
            <?php if (isset($_GET['enviado'])): ?>
                <div class="alert alert-success">¡Gracias! Recibimos tu mensaje y te responderemos pronto.</div>
            <?php endif; ?>

            <!-- Errores de validacion: se muestran todos en una lista -->
            <?php if (count($errores) > 0): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errores as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- action="": se envia a esta misma pagina | value con htmlspecialchars: si hubo error, se conserva lo escrito -->
            <form action="" method="POST" class="bg-light rounded-4 p-4">
                <!-- row g-3: nombre y correo uno al lado del otro en PC (col-md-6) y uno debajo del otro en movil -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-semibold small">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" maxlength="100" value="<?= htmlspecialchars($datos['nombre']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="correo" class="form-label fw-semibold small">Correo electrónico</label>
                        <input type="email" id="correo" name="correo" class="form-control" maxlength="150" placeholder="nombre@correo.com" value="<?= htmlspecialchars($datos['correo']) ?>" required>
                    </div>
                    <div class="col-12">
                        <label for="asunto" class="form-label fw-semibold small">Asunto</label>
                        <select id="asunto" name="asunto" class="form-select" required>
                            <option value="">Elige una opción</option>
                            <?php foreach ($asuntos as $asunto): ?>
                                <!-- selected: si hubo error, deja marcada la opcion que se eligio -->
                                <option value="<?= $asunto ?>" <?= $datos['asunto'] === $asunto ? 'selected' : '' ?>><?= $asunto ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="mensaje" class="form-label fw-semibold small">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" class="form-control" rows="5" minlength="10" maxlength="1000" required><?= htmlspecialchars($datos['mensaje']) ?></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary fw-semibold px-4 d-inline-flex align-items-center gap-2">
                            <i class="fi fi-rr-paper-plane d-flex"></i> Enviar mensaje
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <?php include __DIR__ . '/../include/store/footer.php'; ?> <!-- footer -->
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
