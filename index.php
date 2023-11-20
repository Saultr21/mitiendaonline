<?php 
require "cabecera.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <title>Menú Principal</title>
</head>
<body>
    <h1 class="container d-flex justify-content-center text-center mt-5">Menú Principal</h1>
    <div class="container d-flex justify-content-center align-content-center">
    <ul>
        <li><a href="crear_producto.php">Crear Producto</a></li>
        <li><a href="listado_productos.php">Consultar el Listado de Productos</a></li>
        <li><a href="modifica_producto.php">Modificar Producto</a></li>
        <li><a href="elimina_producto.php">Eliminar Producto</a></li>
    </ul>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</html>