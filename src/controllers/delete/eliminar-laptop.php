<?php
require_once __DIR__ . '/../../conexion/conexion.php';   // crea $conexion

// Carpeta donde agregar-laptos.php guarda las fotos
$rutaFotos = __DIR__ . '/../../../assets/imgs/laptops/';

// El id llega por la URL desde el boton "Eliminar" de la lista: eliminar-laptop.php?id=ASU-TUF15-0001
// En laptops el id es el NUMERO DE SERIE (texto), no un numero autoincremental
$id = $_GET['id'] ?? null;

if ($id) {
    // Buscar los datos de la laptop para obtener el nombre de la foto
    $stmt = $conexion->prepare("SELECT foto FROM laptops WHERE numero_serie = :id");
    $stmt->execute([':id' => $id]);
    $lap = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si existe una foto en la carpeta de laptops, se borra el archivo
    // basename(): se queda solo con el nombre del archivo, asi nunca se borra algo fuera de la carpeta
    if ($lap && !empty($lap['foto']) && file_exists($rutaFotos . basename($lap['foto']))) {
        unlink($rutaFotos . basename($lap['foto']));
    }

    // Borrar el registro de la base de datos
    $sql = "DELETE FROM laptops WHERE numero_serie = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => $id]);
}

// Volver a la lista de laptops con el aviso de eliminado
header('Location: ../list/listar-laptops.php?eliminado=1');
exit;
?>
