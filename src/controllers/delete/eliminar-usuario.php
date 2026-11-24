<?php
require_once __DIR__ . '/../../conexion/conexion.php';   // crea $conexion

// Carpeta donde agregar-usuario.php guarda las fotos
$rutaFotos = __DIR__ . '/../../../assets/imgs/usuarios/';

// El id llega por la URL desde el boton "Eliminar" de la lista: eliminar-usuario.php?id=5
$id = $_GET['id'] ?? null;

if ($id) {
    // Buscar los datos del usuario para obtener el nombre de la foto
    $stmt = $conexion->prepare("SELECT foto FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $usu = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si existe una foto en la carpeta de usuarios, se borra el archivo
    // basename(): se queda solo con el nombre del archivo, asi nunca se borra algo fuera de la carpeta
    if ($usu && !empty($usu['foto']) && file_exists($rutaFotos . basename($usu['foto']))) {
        unlink($rutaFotos . basename($usu['foto']));
    }

    // Borrar el registro de la base de datos
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':id' => $id]);
}

// Volver a la lista de usuarios con el aviso de eliminado
header('Location: ../list/listar-usuarios.php?eliminado=1');
exit;
?>
