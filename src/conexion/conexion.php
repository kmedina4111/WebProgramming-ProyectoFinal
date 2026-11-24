<?php
    $servername = "localhost:8889";
    $username = "root";
    $password = "root";
    $dbname = "nexuscorp";
    // Quitar el echo del try ya que afecta a la pagina cuando se hace un include de este archivo.
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
?>

