<?php
require_once("conexion.php");
$db = new Database();
$conectar = $db->conectar();
session_start();

$usua = $conectar->prepare("SELECT * FROM articulos ");
$usua->execute();
$asigna = $usua->fetchAll(PDO::FETCH_ASSOC);


if (isset($asigna) && !empty($asigna)) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codigo de barras</title>
    <link rel="stylesheet" type="text/css" href="css/visualizar.css">
</head>
<body>
<div class="container mt-3">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr style="text-transform: uppercase;">
                <th>Nombre</th>
                <th>Precio</th>
                <th>Código de Barras</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($asigna as $usua) { ?>
                <tr>
                    <td><?= $usua["nombre"] ?></td>
                    <td><?= $usua["precio"] ?></td>
                    <td><img src="images/<?= $usua["codigo_barras"] ?>.png"></td> 
                    <td class="botones">
                        <a href="actualizar.php?id=<?= $usua['id_articulo'] ?>" class="editar">Editar</a>
                        <a href="eliminar.php?id=<?= $usua['id_articulo'] ?>" class="eliminar">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="Registro.php" class="boton-crear">Crear Articulo</a>
</div>
</body>
</html>



<?php
} else {
    // Si $asigna está vacía o no definida, mostrar un mensaje de error o redirigir a otra página
    echo "No se encontraron datos.";
}
?>
