<?php 
    session_start(); // abre la sesion ANTES de cualquier HTML (el header muestra al usuario conectado) 
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
            <h1 class="fw-bold mb-2">Términos y Condiciones</h1>
            <p class="text-secondary mb-0">Última actualización: noviembre de 2026</p>
            <p class="mt-3 mb-0">
                Al navegar y comprar en <strong>NexusCorp Importaciones</strong> aceptas los siguientes términos y condiciones.
                Te recomendamos leerlos antes de realizar cualquier compra.
            </p>
        </section>
        <!-- ============ CONTENIDO ============ -->
        <section class="container pb-5" style="max-width: 860px;">

            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">1. Uso del sitio</h2>
                <p>
                    Este sitio web es una tienda en línea de laptops. Al usarlo te comprometes a brindar información verdadera
                    y a no utilizarlo con fines ilegales o que perjudiquen a la tienda o a otros usuarios.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">2. Cuenta de usuario</h2>
                <p>
                    Para comprar debes iniciar sesión con tu usuario y contraseña. Eres responsable de mantener tu contraseña
                    en secreto y de todas las acciones que se realicen desde tu cuenta.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">3. Productos y precios</h2>
                <ul>
                    <li>Todos los precios están expresados en soles (S/) e incluyen IGV.</li>
                    <li>Los precios y ofertas pueden cambiar sin previo aviso y son válidos hasta agotar stock.</li>
                    <li>Las imágenes de los productos son referenciales.</li>
                    <li>El precio tachado corresponde al precio anterior del producto antes de la oferta.</li>
                </ul>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">4. Pagos</h2>
                <p>
                    El pedido se confirma una vez que el pago ha sido aprobado. Si el pago es rechazado o no se completa,
                    el pedido será anulado automáticamente.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">5. Envíos y entregas</h2>
                <p>
                    Los tiempos de entrega son aproximados y pueden variar según la zona de destino.
                    Al recibir tu pedido, revisa que el empaque esté en buen estado antes de firmar la conformidad.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">6. Garantía</h2>
                <p>
                    Todas las laptops cuentan con la garantía del fabricante. La garantía no cubre daños causados por golpes,
                    líquidos, mal uso o reparaciones hechas por terceros.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">7. Cambios y devoluciones</h2>
                <p>
                    Puedes solicitar un cambio o devolución dentro de los 7 días posteriores a la entrega, siempre que el producto
                    esté sin uso, con su empaque original y todos sus accesorios.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">8. Privacidad de datos</h2>
                <p>
                    Tus datos personales se usan solo para gestionar tu cuenta y tus pedidos. No los compartimos con terceros
                    sin tu autorización. Las contraseñas se guardan encriptadas.
                </p>
            </section>
            <section class="border-top pt-4 mb-4">
                <h2 class="fs-5 fw-bold">9. Cambios en los términos</h2>
                <p>
                    NexusCorp Importaciones puede actualizar estos términos en cualquier momento. Los cambios se publicarán
                    en esta misma página con su nueva fecha de actualización.
                </p>
            </section>
            <section class="border-top pt-4">
                <h2 class="fs-5 fw-bold">10. Contacto</h2>
                <p class="mb-0">
                    Si tienes dudas sobre estos términos, escríbenos desde nuestra página de
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
