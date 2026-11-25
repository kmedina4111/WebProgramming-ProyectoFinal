<?php
    // Cerrar sesion, borra los datos de la sesion y vuelve a la tienda
    session_start();      
    $_SESSION = [];       // vacia todas las variables de sesion ex. usuario_id
    session_destroy();    // elimina la sesion del servidor
    header('Location: /index.php');
    exit;
?>