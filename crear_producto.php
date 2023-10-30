<?php
include 'config.php';
include 'validaciones.php';

$errores = [];
$nombre = $precio = $imagen = $categoria = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];
    $categoria = $_POST['categoria'];

    $errores = validarProducto($nombre, $precio, $imagen, $categoria);
    
    if (empty($errores)) {
        try {
            $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, imagen, categoria) VALUES (:nombre, :precio, :imagen, :categoria)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->execute();
            echo "<p>Producto creado con éxito. <a href='index.php'>Volver al menú principal</a></p>";
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
}

// Obtener categorías de la BD
$categorias = [];
try {
    $stmt = $conn->query("SELECT id, nombre FROM categorias");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>

<?php if (!empty($errores)): ?>
    <p>Error(es):</p>
    <ul>
        <?php foreach ($errores as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="crear_producto.php">Volver al formulario</a>
<?php else: ?>
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <title>Listado de Productos</title>
</head>
<body>
<div class="container mt-5">
    <form action="crear_producto.php" method="post">
    <div class="form-group">
        <label for="Nombre">Nombre: </label>
        <input class="form-control" type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
    </div>
    <div class="form-group">
        <label for="Nombre">Precio: </label>
        <input class="form-control" type="text" name="precio" value="<?php echo htmlspecialchars($precio); ?>">
    </div>
    <div class="form-group">
        <label for="Nombre">Imagen: </label>
        <input class="form-control" type="text" name="imagen" value="<?php echo htmlspecialchars($imagen); ?>">
    </div>
    <div class="form-group">
        <label for="Nombre">Categoria: </label>
        <select class="form-control" id="Categoria" name="Categoria" required>
            <option value="">Selecciona una categoría</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['id']); ?>" <?php echo $cat['id'] === $categoria ? "selected" : ""; ?>>
                    <?php echo htmlspecialchars($cat['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>
    </div>
        <input class="btn btn-primary" type="submit" value="Crear Producto">
        

    <a class="btn btn-primary" href="index.php">Volver al menú</a>
    </form>
</div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php endif; ?>

