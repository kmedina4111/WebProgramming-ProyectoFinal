<?php
require_once __DIR__ . '/../../conexion/conexion.php';   // crea $conexion

// El id llega por la URL desde el boton "Eliminar" de la lista: eliminar-fabricante.php?id=5
$id = $_GET['id'] ?? null;

if ($id) {
    try {
        // Borrar el registro de la base de datos (los fabricantes no tienen foto, asi que no hay archivo que borrar)
        $sql = "DELETE FROM fabricantes WHERE id_fabricante = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        // La llave foranea de laptops tiene ON DELETE RESTRICT:
        // si el fabricante todavia tiene laptops, MySQL NO deja borrarlo y lanza un error.
        // En vez de mostrar el error de PHP, volvemos a la lista con un aviso.
        header('Location: ../list/listar-fabricantes.php?error=1');
        exit;
    }
}

// Volver a la lista de fabricantes con el aviso de eliminado
header('Location: ../list/listar-fabricantes.php?eliminado=1');
exit;
?>
