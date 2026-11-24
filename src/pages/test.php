<!DOCTYPE html>
<html lang="es">
<?php include __DIR__ . '/../include/store/head.php'; ?>
    <body>
        <?php include __DIR__ . '/../include/store/header.php'; ?>
        <?php
            $currencyCode   = "PEN";
            $currencySymbol = "S/";
            $price          = 89.90;

            $timezone    = "America/Lima";
            date_default_timezone_set($timezone);
            $currentTime = date("h:i A");      // Ej. "07:13 AM"
            $time24h     = date("H:i:s");      // Ej. "07:13:00"
            $currentDate = date("Y-m-d");      // Ej. "2026-11-22"
        ?>

        <section class="py-4">
            <div class="container">
                <h1><b>HELLO WORLD</b></h1><hr>
                <div class="d-flex align-items-baseline gap-2">
                    <span class="fs-4 fw-bold text-success">
                        <?= htmlspecialchars($currencySymbol) ?> <?= number_format($price, 2) ?>
                    </span>
                    <small class="text-muted text-uppercase">
                        <?= htmlspecialchars($currencyCode) ?>
                    </small>
                </div>
                <div class="d-flex align-items-center gap-2 text-muted small">
                    <i class="bi bi-clock"></i>
                    <span>Hora del sistema: <strong><?= htmlspecialchars($currentTime) ?></strong></span>
                    <span>(<?= htmlspecialchars($timezone) ?>)</span>
                </div>
                
            </div>
        </section>
        <?php include __DIR__ . '/../include/store/footer.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>


