<?php
    // Se abre con cualquier boton/enlace que tenga: data-bs-toggle="modal" y data-bs-target="#modalLogin"
?>
<!-- ===================================================== MODAL LOGIN ===================================================== -->
<!-- fade: animacion al abrir | tabindex="-1": permite cerrar con la tecla escape -->
<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginTitulo" aria-hidden="true">
    <!-- modal-dialog-centered: centra la ventana en vertical | modal-fullscreen-sm-down: en celulares pequeños ocupa toda la pantalla -->
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 pb-0"> <!-- Boton cerrar -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body px-4 px-md-5 pb-5 pt-0">
                <div class="text-center mb-4"> <!-- Titulo -->
                    <h2 class="h3 fw-bold mb-1" id="modalLoginTitulo">Iniciar sesión</h2>
                    <p class="text-secondary small mb-0">Ingresa a tu cuenta para ver tus pedidos y comprar más rápido.</p>
                </div>
                <!-- Mensaje de error: AuthController.php vuelve con ?login=error si el usuario o la contraseña no coinciden -->
                <?php if (($_GET['login'] ?? '') === 'error'): ?>
                    <div class="alert alert-danger small py-2">Usuario o contraseña incorrectos.</div>
                <?php endif; ?>
                <!-- Formulario | action: AuthController.php revisa los datos y redirige segun el rol (admin -> panel, cliente -> tienda) -->
                <!-- novalidate: desactiva los mensajes del navegador para usar los de Bootstrap -->
                <form id="formModalLogin" action="/src/controllers/AuthController.php" method="post" novalidate>
                    <input type="hidden" name="accion" value="login">
                    <!-- Usuario (la tabla usuarios inicia sesion con el campo "usuario", no con correo) -->
                    <div class="mb-3">
                        <label for="modalUsuario" class="form-label fw-semibold small">Usuario</label>
                        <input type="text" class="form-control rounded-3 py-2" id="modalUsuario" name="usuario" placeholder="Tu nombre de usuario" autocomplete="username" maxlength="50" required>
                        <div class="invalid-feedback">Ingresa tu usuario.</div>
                    </div>
                    <!-- Contraseña | input-group junta el campo y el boton de ver/ocultar -->
                    <div class="mb-3">
                        <label for="modalPassword" class="form-label fw-semibold small">Contraseña</label>
                        <div class="input-group has-validation">
                            <input type="password" class="form-control rounded-start-3 py-2" id="modalPassword" name="password" placeholder="••••••••" autocomplete="current-password" minlength="6" required>
                            <button class="btn btn-outline-secondary rounded-end-3 d-flex align-items-center" type="button" id="modalVerPassword" aria-label="Mostrar contraseña">
                                <i class="fi fi-rr-eye d-flex"></i>
                            </button>
                            <div class="invalid-feedback">La contraseña debe tener al menos 6 caracteres.</div>
                        </div>
                    </div>
                    <!-- Recordarme y olvide mi contraseña -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="modalRecordar" name="recordar" value="1">
                            <label class="form-check-label small" for="modalRecordar">Recordarme</label>
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
<script>
    // ===== Validacion de Bootstrap =====
    // Si hay campos invalidos, se cancela el envio y se muestran los mensajes en rojo (.invalid-feedback)
    const formModalLogin = document.getElementById('formModalLogin');
    formModalLogin.addEventListener('submit', function (e) {
        if (!formModalLogin.checkValidity()) {
            e.preventDefault();
        }
        formModalLogin.classList.add('was-validated');
    });
    // ===== Mostrar / ocultar contraseña =====
    const modalPassword = document.getElementById('modalPassword');
    const modalVerPassword = document.getElementById('modalVerPassword');
    modalVerPassword.addEventListener('click', function () {
        const oculto = modalPassword.type === 'password';
        modalPassword.type = oculto ? 'text' : 'password';
        modalVerPassword.querySelector('i').className = oculto ? 'fi fi-rr-eye-crossed d-flex' : 'fi fi-rr-eye d-flex';
        modalVerPassword.setAttribute('aria-label', oculto ? 'Ocultar contraseña' : 'Mostrar contraseña');
    });
    // ===== Al cerrar el modal: limpiar el formulario =====
    // Asi, si se vuelve a abrir, no aparecen los errores en rojo ni la contraseña escrita
    document.getElementById('modalLogin').addEventListener('hidden.bs.modal', function () {
        formModalLogin.reset();
        formModalLogin.classList.remove('was-validated');
        modalPassword.type = 'password';
        modalVerPassword.querySelector('i').className = 'fi fi-rr-eye d-flex';
    });
    // ===== Al abrir el modal: poner el cursor en el usuario =====
    document.getElementById('modalLogin').addEventListener('shown.bs.modal', function () {
        document.getElementById('modalUsuario').focus();
    });
    // ===== Abrir el modal automaticamente =====
    // ?login=error -> los datos estaban mal | ?login=1 -> se intento entrar al panel sin iniciar sesion
    // DOMContentLoaded: espera a que cargue bootstrap.bundle.min.js (esta al final de la pagina)
    if (new URLSearchParams(window.location.search).has('login')) {
        document.addEventListener('DOMContentLoaded', function () {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalLogin')).show();
        });
    }
</script>
