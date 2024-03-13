<?php
require 'vendor/autoload.php';
require_once("conexion.php");
$db = new Database();
$conectar = $db->conectar();


use Picqer\Barcode\BarcodeGeneratorPNG;

// Obtener datos de la base de datos
$usua = $conectar->prepare("SELECT * FROM articulos ");
$usua->execute();
$asigna = $usua->fetchAll(PDO::FETCH_ASSOC);

if ((isset($_POST["registro"])) && ($_POST["registro"] == "formu")) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    $codigo_barras = uniqid() . rand(1000, 9999);

    $generator = new BarcodeGeneratorPNG();

    $codigo_barras_imagen = $generator->getBarcode($codigo_barras, $generator::TYPE_CODE_128);

    file_put_contents(__DIR__ . '/images/' . $codigo_barras . '.png', $codigo_barras_imagen);

    $insertsql = $conectar->prepare("INSERT INTO articulos(nombre, precio, codigo_barras) VALUES (?, ?, ?)");
    $insertsql->execute([$nombre, $precio, $codigo_barras]);

    
    echo '<script>alert("Registro exitoso.");</script>';
    echo '<script>window.location="visualizar.php"</script>';
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articulos</title>
    <link rel="stylesheet" type="text/css" href="css/registro.css">
</head>
<body>
    
<main class="contenedor sombra">
    <div class="container mt-5">
        <h2>Crear Articulo</h2>
        <form method="POST" action="registro.php" enctype="multipart/form-data">

            <div class="form-group">
                <label for="nombre">Nombre del Articulo:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" required>
            </div>
                
            <div class="btn-container">
                <a href="visualizar.php" class="btn btn-secondary red">Cancelar</a>
                <input type="submit" class="btn btn-success" value="Crear Articulo">
            </div>
            <input type="hidden" name="registro" value="formu">
        </form>
    </div>
</main>
</body>
</html>

