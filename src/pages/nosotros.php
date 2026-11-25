<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?> 
<body>
    <?php include __DIR__ . '/../include/store/header.php'; ?> 
    <main>
        <!-- ============ QUIENES SOMOS (descripcion de la empresa) ============ -->
        <!-- max-width: el texto no se estira tanto en pantallas grandes y se lee mejor -->
        <section class="container pt-5" style="max-width: 860px;">
            <h1 class="fw-bold mb-3">Sobre Nosotros</h1>
            <p>
                <strong>NexusCorp Importaciones</strong> es una tienda peruana especializada en la venta de laptops nuevas y originales.
                Importamos equipos de las mejores marcas del mercado, como ASUS, ROG, Dell, Alienware, Lenovo y HP,
                para ofrecer tecnología confiable a estudiantes, profesionales, empresas y gamers.
            </p>
            <p class="mb-0">
                Nuestro objetivo es que comprar una laptop sea fácil y seguro: te asesoramos para elegir el equipo ideal,
                lo enviamos a cualquier parte del país y te acompañamos con garantía oficial y soporte técnico después de tu compra.
            </p>
        </section>
        <!-- ============ MISION Y VISION ============ -->
        <!-- row g-3: una al lado de la otra en PC (col-md-6) y una debajo de la otra en movil -->
        <section class="container mt-5" style="max-width: 860px;">
            <div class="row g-3">
                <!-- article: cada bloque se entiende por si solo | h-100: las dos cajas miden lo mismo de alto -->
                <article class="col-md-6">
                    <div class="bg-light rounded-4 p-4 h-100">
                        <i class="fi fi-rr-bullseye-arrow fs-2 text-primary d-flex mb-2"></i>
                        <h2 class="fs-4 fw-bold">Misión</h2>
                        <p class="mb-0">
                            Brindar laptops originales de las mejores marcas a precios competitivos, con una atención cercana,
                            envíos a todo el país y un servicio postventa que dé tranquilidad a cada cliente.
                        </p>
                    </div>
                </article>
                <article class="col-md-6">
                    <div class="bg-light rounded-4 p-4 h-100">
                        <i class="fi fi-rr-eye fs-2 text-primary d-flex mb-2"></i>
                        <h2 class="fs-4 fw-bold">Visión</h2>
                        <p class="mb-0">
                            Ser la tienda de laptops de referencia en el Perú, reconocida por la confianza, la calidad
                            de sus productos y la innovación en la experiencia de compra en línea.
                        </p>
                    </div>
                </article>
            </div>
        </section>
        <!-- ============ SECCIONES REUTILIZADAS DEL INICIO ============ -->
        <?php include __DIR__ . '/../include/store/elements/beneficios.php'; ?> 
        <?php include __DIR__ . '/../include/store/elements/ofertas.php'; ?>   
        <?php include __DIR__ . '/../include/store/elements/cta.php'; ?>        
        <?php include __DIR__ . '/../include/store/elements/marcas.php'; ?>     
        <?php include __DIR__ . '/../include/store/elements/newsletter.php'; ?> 
    </main>
    <?php include __DIR__ . '/../include/store/footer.php'; ?> 
    <!-- JS de Bootstrap: necesario para que funcione el offcanvas (menu lateral) del header movil y el acordeon (collapse) del footer movil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
