<?php
include 'config.php';
include 'validaciones.php';
require 'cabecera.php';
// Almacenar la página actual como destino
$_SESSION['pagina_destino'] = basename($_SERVER['PHP_SELF']);
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: form_login.php'); // Redirigir si no hay sesión
    exit();
}
$errores = [];
$nombre = $precio = $imagen = $categoría = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $categoría = $_POST['categoría'];
      // Procesar imagen subida
      if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];
        $imagen_tipo = $_FILES['imagen']['type'];
        $imagen_tamano = $_FILES['imagen']['size'];
        // Verificar que el archivo subido sea una imagen
        $permitidos = array("image/jpg", "image/jpeg", "image/png");
        if (in_array($imagen_tipo, $permitidos)) {
            // Mover la imagen a la carpeta media
            $ruta = "media/" . $imagen_nombre;
            move_uploaded_file($imagen_temp, $ruta);
            $imagen = $imagen_nombre;
        } else {
            $errores[] = "El archivo subido no es una imagen válida.";
        }
    }
    $errores = validarProducto($nombre, $precio, $imagen, $categoría);
    if (empty($errores)) {
        try {
            $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, imagen, categoría) VALUES (:nombre, :precio, :imagen, :categoria)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':categoria', $categoría);
            $stmt->execute();
            echo "<p>Producto creado con éxito. <a href='index.php'>Volver al menú principal</a></p>";
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
}
// Obtener categorías de la BD
$categorías = [];
try {
    $stmt = $conn->query("SELECT id, nombre FROM categorías");
    $categorías = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <form action="crear_producto.php" method="post" enctype="multipart/form-data">
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
        <input class="form-control" type="file" name="imagen" value="<?php echo htmlspecialchars($imagen); ?>">
    </div>
    <div class="form-group">
        <label for="Nombre">Categoría: </label>
        <select class="form-control" id="categoría" name="categoría" required>
            <option value="">Selecciona una categoria</option>
            <?php foreach ($categorías as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['id']); ?>" <?php echo $cat['id'] === $categoría ? "selected" : ""; ?>>
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

