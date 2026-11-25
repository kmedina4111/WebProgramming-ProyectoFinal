<?php 
    // abre la sesion ANTES de cualquier HTML (el header muestra al usuario conectado) 
    session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> <
<body>
    <?php include __DIR__ . '/../include/store/header.php'; ?> <!-- header -->
    <main>
        <!-- ============ TITULO ============ -->
        <!-- max-width: el texto no se estira tanto en pantallas grandes y se lee mejor -->
        <section class="container py-5" style="max-width: 860px;">
            <h1 class="fw-bold mb-2">Nuestros Servicios</h1>
            <p class="text-secondary mb-0">
                En <strong>NexusCorp Importaciones</strong> no solo vendemos laptops: te acompañamos desde la compra
                hasta que tu equipo llega a tus manos y durante todo su uso.
            </p>
        </section>
        <!-- ============ SERVICIOS ============ -->
        <section class="container pb-5" style="max-width: 860px;">
            <!-- d-flex gap-3: icono a la izquierda y el texto a la derecha -->
            <section class="border-top pt-4 mb-4 d-flex gap-3">
                <i class="fi fi-rr-truck-side fs-2 text-primary d-flex"></i>
                <div>
                    <h2 class="fs-5 fw-bold">Envíos a todo el país</h2>
                    <p class="mb-0">
                        Llevamos tu laptop a cualquier ciudad del Perú. Los pedidos se despachan bien embalados y con
                        código de seguimiento para que sepas en todo momento dónde está tu compra.
                        En Lima la entrega es de 24 a 48 horas y en provincias de 3 a 5 días hábiles.
                    </p>
                </div>
            </section>
            <section class="border-top pt-4 mb-4 d-flex gap-3">
                <i class="fi fi-rr-shield-check fs-2 text-primary d-flex"></i>
                <div>
                    <h2 class="fs-5 fw-bold">Garantía oficial</h2>
                    <p class="mb-0">
                        Todos nuestros equipos son nuevos, originales y cuentan con la garantía oficial del fabricante
                        (ASUS, Dell, HP, Lenovo y más). Si tu laptop presenta una falla de fábrica, te ayudamos con todo el proceso.
                    </p>
                </div>
            </section>
            <section class="border-top pt-4 mb-4 d-flex gap-3">
                <i class="fi fi-rr-credit-card fs-2 text-primary d-flex"></i>
                <div>
                    <h2 class="fs-5 fw-bold">Pago seguro</h2>
                    <p class="mb-0">
                        Paga con tarjeta de crédito o débito, transferencia bancaria o billeteras digitales.
                        Tus datos viajan protegidos y nunca guardamos la información de tu tarjeta.
                    </p>
                </div>
            </section>
            <section class="border-top pt-4 d-flex gap-3">
                <i class="fi fi-rr-headset fs-2 text-primary d-flex"></i>
                <div>
                    <h2 class="fs-5 fw-bold">Soporte técnico</h2>
                    <p class="mb-0">
                        ¿Dudas para elegir tu laptop o problemas al configurarla? Nuestro equipo te asesora antes y después
                        de tu compra: instalación de programas, configuración inicial y diagnóstico de fallas.
                    </p>
                </div>
            </section>
        </section>
    </main>
    <?php include __DIR__ . '/../include/store/footer.php'; ?> 
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
