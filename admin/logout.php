<?php
// Cerrar sesion: borra los datos de la sesion y vuelve a la tienda
session_start();      // hay que "abrir" la sesion para poder destruirla
$_SESSION = [];       // vacia todas las variables de sesion (usuario_id, rol...)
session_destroy();    // elimina la sesion del servidor

header('Location: /index.php');
exit;
