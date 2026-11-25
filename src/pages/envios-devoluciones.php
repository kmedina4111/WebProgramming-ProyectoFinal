<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> 
<body>
    <?php include __DIR__ . '/../include/store/header.php'; ?> 
    <main>
        <!-- ============ TITULO ============ -->
        <!-- max-width: el texto no se estira tanto en pantallas grandes y se lee mejor -->
        <section class="container py-5" style="max-width: 860px;">
            <h1 class="fw-bold mb-2">Envíos y Devoluciones</h1>
            <p class="text-secondary mb-0">Última actualización: noviembre de 2026</p>
            <p class="mt-3 mb-0">
                Aquí encontrarás cómo enviamos tus pedidos y qué hacer si necesitas cambiar o devolver un producto
                comprado en <strong>NexusCorp Importaciones</strong>.
            </p>
        </section>
        <!-- ============ CONTENIDO ============ -->
        <!-- Cada punto es un section con su propio titulo (h2) | border-top separa un punto del otro -->
        <section class="container pb-5" style="max-width: 860px;">

            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">1. Cobertura de envíos</h2>
                <p class="mb-0">
                    Realizamos envíos a todo el Perú. Los pedidos se despachan bien embalados y con un código de seguimiento
                    para que sepas en todo momento dónde está tu compra.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">2. Tiempos de entrega</h2>
                <ul class="mb-0">
                    <li>Lima Metropolitana: de 24 a 48 horas hábiles.</li>
                    <li>Provincias: de 3 a 5 días hábiles.</li>
                    <li>Los tiempos se cuentan desde que el pago es aprobado.</li>
                </ul>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">3. Recepción del pedido</h2>
                <p class="mb-0">
                    Al recibir tu pedido revisa que la caja esté cerrada y en buen estado antes de firmar.
                    Si notas golpes o el empaque abierto, indícalo al transportista y comunícate con nosotros el mismo día.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">4. Cambios y devoluciones</h2>
                <p>Puedes solicitar un cambio o devolución dentro de los <strong>7 días</strong> posteriores a la entrega, siempre que:</p>
                <ul class="mb-0">
                    <li>El producto no haya sido usado.</li>
                    <li>Esté en su empaque original, con todos sus accesorios y manuales.</li>
                    <li>Presentes tu comprobante de compra.</li>
                </ul>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">5. Productos con falla</h2>
                <p class="mb-0">
                    Si tu laptop llega con una falla de fábrica, la cambiamos por una nueva sin costo adicional.
                    Pasado el plazo de devolución, la reparación se gestiona mediante la garantía oficial del fabricante.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">6. Reembolsos</h2>
                <p class="mb-0">
                    Una vez revisado el producto devuelto, el reembolso se realiza por el mismo medio de pago
                    en un plazo de 5 a 10 días hábiles.
                </p>
            </section>
            <section class="border-top pt-4">
                <h2 class="fs-5 fw-bold">7. ¿Cómo solicitar un cambio o devolución?</h2>
                <p class="mb-0">
                    Escríbenos desde nuestra página de <a href="/src/pages/contacto.php" class="text-decoration-none">contacto</a>
                    eligiendo el asunto "Estado de mi pedido", e indícanos tu número de pedido y el motivo.
                </p>
            </section>
        </section>
    </main>
    <?php include __DIR__ . '/../include/store/footer.php'; ?> 
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
