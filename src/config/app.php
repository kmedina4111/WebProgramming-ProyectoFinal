<?php
    // Configuracion de moneda y simbolo para mostrar precios en la tienda. 
    $currencyCode   = "PEN";
    $currencySymbol = "S/";

    // Zona horaria para mostrar fechas y horas correctas en la tienda.
    $timezone    = "America/Lima";
    date_default_timezone_set($timezone);
    $time24h     = date("H:i:s");      
    $currentDate = date("Y-m-d");
?>