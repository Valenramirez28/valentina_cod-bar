<?php
require_once("conexion.php");
$db = new Database();
$conectar = $db->conectar();
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $delete = $conectar->prepare("DELETE FROM articulos WHERE id_articulo = ?");
    $delete->execute([$id]);
    
    echo '<script>alert("Registro eliminado exitosamente.");</script>';
    echo '<script>window.location="visualizar.php"</script>';
    exit();
} else {
    echo '<script>alert("ID de registro no especificado.");</script>';
    echo '<script>window.location="visualizar.php"</script>';
    exit();
}
?>
