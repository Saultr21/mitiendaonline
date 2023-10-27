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
    <form action="crear_producto.php" method="post">
        Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>"><br>
        Precio: <input type="text" name="precio" value="<?php echo htmlspecialchars($precio); ?>"><br>
        Imagen: <input type="text" name="imagen" value="<?php echo htmlspecialchars($imagen); ?>"><br>
        Categoría:
        <select name="categoria">
            <option value="">Selecciona una categoría</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['id']); ?>" <?php echo $cat['id'] === $categoria ? "selected" : ""; ?>>
                    <?php echo htmlspecialchars($cat['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" value="Crear Producto">
    </form>
<?php endif; ?>

