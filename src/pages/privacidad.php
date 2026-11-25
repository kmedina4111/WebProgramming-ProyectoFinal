<?php 
    session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> 
<body>
    <?php include __DIR__ . '/../include/store/header.php'; ?> <!-- header -->
    <main>
        <!-- ============ TITULO ============ -->
        <!-- max-width: el texto no se estira tanto en pantallas grandes y se lee mejor -->
        <section class="container py-5" style="max-width: 860px;">
            <h1 class="fw-bold mb-2">Política de Privacidad</h1>
            <p class="text-secondary mb-0">Última actualización: noviembre de 2026</p>
            <p class="mt-3 mb-0">
                En <strong>NexusCorp Importaciones</strong> cuidamos tu información personal. En esta página te explicamos
                qué datos recopilamos, para qué los usamos y cómo los protegemos.
            </p>
        </section>
        <!-- ============ CONTENIDO ============ -->
        <section class="container pb-5" style="max-width: 860px;">
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">1. Datos que recopilamos</h2>
                <ul class="mb-0">
                    <li>Datos de tu cuenta: nombre, usuario y foto de perfil (opcional).</li>
                    <li>Datos de contacto: correo electrónico y teléfono, cuando nos escribes o haces un pedido.</li>
                    <li>Datos de envío: dirección de entrega de tus compras.</li>
                </ul>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">2. Para qué usamos tus datos</h2>
                <ul class="mb-0">
                    <li>Gestionar tu cuenta y tus pedidos.</li>
                    <li>Coordinar el envío y la entrega de tus productos.</li>
                    <li>Responder tus consultas y solicitudes de soporte.</li>
                    <li>Enviarte ofertas y novedades, solo si te suscribes a nuestro boletín.</li>
                </ul>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">3. Protección de la información</h2>
                <p class="mb-0">
                    Tus contraseñas se guardan encriptadas y nadie del equipo puede verlas. No almacenamos los datos
                    de tu tarjeta: los pagos se procesan a través de plataformas de pago seguras.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">4. Compartir datos con terceros</h2>
                <p class="mb-0">
                    No vendemos ni compartimos tus datos personales. Solo entregamos la información necesaria a la empresa
                    de transporte para que tu pedido llegue a su destino.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">5. Cookies</h2>
                <p class="mb-0">
                    Usamos cookies para mantener tu sesión iniciada mientras navegas por la tienda.
                    Puedes borrarlas desde la configuración de tu navegador cuando quieras.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">6. Tus derechos</h2>
                <p class="mb-0">
                    Puedes pedirnos ver, corregir o eliminar tus datos personales en cualquier momento,
                    así como darte de baja de nuestro boletín.
                </p>
            </section>
            <section class="border-top pt-4">
                <h2 class="fs-5 fw-bold">7. Contacto</h2>
                <p class="mb-0">
                    Si tienes dudas sobre el uso de tus datos, escríbenos desde nuestra página de
                    <a href="/src/pages/contacto.php" class="text-decoration-none">contacto</a>.
                </p>
            </section>
        </section>
    </main>
    <?php include __DIR__ . '/../include/store/footer.php'; ?> 
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
