<?php
require_once("conexion.php");
$db = new Database();
$conectar = $db->conectar();
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        
        if (empty($nombre)) {
            echo '<script>alert("Por favor, ingresa un nombre válido.");</script>';
        } else {
            $update = $conectar->prepare("UPDATE articulos SET nombre = ?, precio = ? WHERE id_articulo = ?");
            $update->execute([$nombre, $precio, $id]);
            
            echo '<script>alert("Registro actualizado exitosamente.");</script>';
            echo '<script>window.location="visualizar.php"</script>';
            exit();
        }
    }
    
    $consulta = $conectar->prepare("SELECT * FROM articulos WHERE id_articulo = ?");
    $consulta->execute([$id]);
    $articulo = $consulta->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: visualizar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Articulo</title>
    <link rel="stylesheet" type="text/css" href="css/actualizar.css">
</head>
<body>

    <main class="contenedor sombra">
        <div class="container mt-5">
            <h2>Editar Articulo</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre del Articulo:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($articulo['nombre']) ?>">
                </div>
                <div class="form-group">
                    <label for="precio">Precio:</label>
                    <input type="number" name="precio" value="<?= htmlspecialchars($articulo['precio']) ?>">
                </div>
                <div class="btn-container">
                <a href="visualizar.php" class="btn-cancelar">Cancelar</a>
                    <input type="submit" class="btn-actualizar" value="Actualizar">
                    
                </div>
            </form>
        </div>
    </main>

</body>
</html>
