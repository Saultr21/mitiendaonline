<?php
include 'config.php';

// Obtener la lista de productos para el menú desplegable
try {
    $stmt = $conn->query("SELECT id, Nombre FROM productos");
    $listaProductos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de consulta: " . $e->getMessage());
}

$producto = null;

// Obtener el producto a editar si se ha proporcionado un ID
if (isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("SELECT productos.*, categorias.Nombre as categoria_nombre FROM productos 
        JOIN categorias ON productos.Categoria = categorias.Id WHERE productos.id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error de consulta: " . $e->getMessage());
    }
}

// Si se ha enviado el formulario, actualizar la información del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y procesar la entrada aquí

    // Actualizar el producto en la base de datos
    try {
        $stmt = $conn->prepare("UPDATE productos SET Nombre = :Nombre, Precio = :Precio, Imagen = :Imagen, Categoria = :Categoria WHERE id = :id");
        $stmt->bindParam(':Nombre', $_POST['Nombre']);
        $stmt->bindParam(':Precio', $_POST['Precio']);
        $stmt->bindParam(':Imagen', $_POST['Imagen']);
        $stmt->bindParam(':Categoria', $_POST['Categoria']);
        $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
        $producto['Nombre'] = $_POST['Nombre'];
        $producto['Precio'] = $_POST['Precio'];
        $producto['Imagen'] = $_POST['Imagen'];
        $producto['Categoria'] = $_POST['Categoria'];
    } catch (PDOException $e) {
        die("Error de actualización: " . $e->getMessage());
    }

    echo "<script>alert('Producto actualizado correctamente');</script>";
}

$categorias = [];
try {
    $stmt = $conn->query("SELECT id, nombre FROM categorias");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Producto</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Producto</h1>

        <!-- Menú desplegable para seleccionar el producto a editar -->
        <form method="get">
            <div class="form-group">
                <label for="producto">Seleccionar producto:</label>
                <select class="form-control" id="producto" name="id" onchange="this.form.submit()">
                    <option value="">-- Seleccionar --</option>
                    <?php foreach ($listaProductos as $p) : ?>
                        <option value="<?= $p['id'] ?>" <?= $producto && $producto['id'] == $p['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['Nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <!-- Formulario para editar el producto -->
        <?php if ($producto) : ?>
            <form method="post">
                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                <div class="form-group">
                    <label for="Nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?= htmlspecialchars($producto['Nombre']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="Precio">Precio:</label>
                    <input type="number" class="form-control" id="Precio" name="Precio" value="<?= htmlspecialchars($producto['Precio']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="Imagen">Imagen:</label>
                    <input type="text" class="form-control" id="Imagen" name="Imagen" value="<?= htmlspecialchars($producto['Imagen']) ?>">
                </div>
                <div class="form-group">
                    <label for="Categoria">Categoría:</label>
                    <select class="form-control" id="Categoria" name="Categoria" required>
                        <option value="">Selecciona una categoría</option>
                        <?php foreach ($categorias as $cat) : ?>
                            <option value="<?= htmlspecialchars($cat['id']); ?>" <?= $cat['id'] == $producto['Categoria'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
        <?php endif; ?>

        <a class="btn btn-secondary mt-3" href="listado_productos.php">Volver al listado</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>