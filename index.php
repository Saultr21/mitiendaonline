<?php session_start();
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
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
<div class="border" style="max-height: 80px; background-color: grey; display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
    <h1 class="text-center">Mi Tienda Online</h1>
    <div style="display: flex; align-items: center;">
        <?php if (isset($_SESSION['usuario'])) : ?>
            <span style="margin-right: 10px;"><?php echo "Nombre de usuario: ".$_SESSION['usuario']; ?></span>
            <form action="" method="POST" style="display: inline;">
                <button type="submit" name="cerrar_sesion">Cerrar sesión</button>
            </form>
        <?php endif; ?>
    </div>
</div>


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