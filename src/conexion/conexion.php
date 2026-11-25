<?php
    // Detecta donde se esta ejecutando: en la PC (MAMP) o en el hosting (InfinityFree)
    // HTTP_HOST trae el dominio, por ejemplo "localhost:8888"; se le quita el puerto
    $host    = explode(":", $_SERVER["HTTP_HOST"] ?? "localhost")[0];
    $esLocal = in_array($host, ["localhost", "127.0.0.1"], true);

    if ($esLocal) {
        // Datos de MAMP (PC)
        $servername = "localhost:8889";
        $username = "root";
        $password = "root";
        $dbname = "nexuscorp";
    } else {
        // Datos de InfinityFree (hosting)
        $servername = "sql311.infinityfree.com";
        $username = "if0_43116021";
        $password = "RGpNPqtD6d";
        $dbname = "if0_43116021_nexuscorp";
    }
    // Quitar el echo del try ya que afecta a la pagina cuando se hace un include de este archivo.
    // ya se quito el echo
    try {
        $dsn = "mysql:host={$servername};dbname={$dbname};charset=utf8mb4";
        $conexion = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ]);
        // Pro ahora se deja el echo para verificar la conexion a la DB
    } catch (PDOException $e) {
        die("FALLO: " . $e->getMessage());
    }
