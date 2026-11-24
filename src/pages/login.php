<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> <!-- head and metadata -->
<body>
    <?php include __DIR__ . '/../include/store/header.php'; ?> <!-- header -->

    <main>
        <!-- py-5 da espacio arriba y abajo | row + justify-content-center centra la tarjeta -->
        <section class="container py-5">
            <div class="row justify-content-center">
                <!-- Ancho de la tarjeta: completo en celular, mas angosto en pantallas grandes -->
                <div class="col-12 col-sm-10 col-md-7 col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">

                            <!-- Titulo -->
                            <div class="text-center mb-4">
                                <h1 class="h3 fw-bold mb-1">Iniciar sesión</h1>
                                <p class="text-secondary small mb-0">Ingresa a tu cuenta para ver tus pedidos y comprar más rápido.</p>
                            </div>

                            <!-- Formulario | action: el controlador que procesara el login (se crea despues) -->
                            <!-- novalidate: desactiva los mensajes del navegador para usar los de Bootstrap -->
                            <form id="formLogin" action="/src/controllers/AuthController.php" method="post" novalidate>
                                <!-- Indica al controlador que accion ejecutar -->
                                <input type="hidden" name="accion" value="login">

                                <!-- Correo -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold small">Correo electrónico</label>
                                    <input type="email" class="form-control rounded-3 py-2" id="email" name="email" placeholder="tucorreo@ejemplo.com" autocomplete="email" required>
                                    <div class="invalid-feedback">Ingresa un correo válido.</div>
                                </div>

                                <!-- Contraseña | input-group junta el campo y el boton de ver/ocultar -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold small">Contraseña</label>
                                    <div class="input-group has-validation">
                                        <input type="password" class="form-control rounded-start-3 py-2" id="password" name="password" placeholder="••••••••" autocomplete="current-password" minlength="6" required>
                                        <button class="btn btn-outline-secondary rounded-end-3 d-flex align-items-center" type="button" id="verPassword" aria-label="Mostrar contraseña">
                                            <i class="fi fi-rr-eye d-flex"></i>
                                        </button>
                                        <div class="invalid-feedback">La contraseña debe tener al menos 6 caracteres.</div>
                                    </div>
                                </div>

                                <!-- Recordarme y olvide mi contraseña | justify-content-between los separa a cada lado -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="recordar" name="recordar" value="1">
                                        <label class="form-check-label small" for="recordar">Recordarme</label>
                                    </div>
                                    <a href="#" class="small text-decoration-none">¿Olvidaste tu contraseña?</a>
                                </div>

                                <!-- Boton enviar -->
                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">Ingresar</button>
                            </form>

                            <!-- Enlace a registro -->
                            <p class="text-center small text-secondary mt-4 mb-0">
                                ¿No tienes cuenta? <a href="#" class="fw-semibold text-decoration-none">Regístrate</a>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/../include/store/footer.php'; ?> <!-- footer -->

    <!-- JS de Bootstrap: offcanvas del header movil y acordeon del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ===== Validacion de Bootstrap =====
        // Si hay campos invalidos, se cancela el envio y se muestran los mensajes en rojo (.invalid-feedback)
        const formLogin = document.getElementById('formLogin');
        formLogin.addEventListener('submit', function (e) {
            if (!formLogin.checkValidity()) {
                e.preventDefault();
            }
            formLogin.classList.add('was-validated');
        });

        // ===== Mostrar / ocultar contraseña =====
        const inputPassword = document.getElementById('password');
        const btnVer = document.getElementById('verPassword');
        btnVer.addEventListener('click', function () {
            const oculto = inputPassword.type === 'password';
            inputPassword.type = oculto ? 'text' : 'password';
            // Cambia el icono (ojo / ojo tachado) y el texto para lectores de pantalla
            btnVer.querySelector('i').className = oculto ? 'fi fi-rr-eye-crossed d-flex' : 'fi fi-rr-eye d-flex';
            btnVer.setAttribute('aria-label', oculto ? 'Ocultar contraseña' : 'Mostrar contraseña');
        });
    </script>
</body>
</html>
