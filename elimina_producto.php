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

// Obtener el producto a eliminar si se ha proporcionado un ID
if (isset($_POST['id'])) {
    $producto_id = $_POST['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM productos WHERE id = :id");
        $stmt->bindParam(':id', $producto_id, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Producto eliminado correctamente');</script>";
    } catch (PDOException $e) {
        die("Error de eliminación: " . $e->getMessage());
    }
}

$categorías = [];
try {
    $stmt = $conn->query("SELECT id, nombre FROM categorías");
    $categorías = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Eliminar Producto</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Eliminar Producto</h1>

        <!-- Menú desplegable para seleccionar el producto a eliminar -->
        <form method="post">
            <div class="form-group">
                <label for="producto">Seleccionar producto:</label>
                <select class="form-control" id="producto" name="id">
                    <option value="">-- Seleccionar --</option>
                    <?php foreach ($listaProductos as $p) : ?>
                        <option value="<?= $p['id'] ?>">
                            <?= htmlspecialchars($p['Nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-danger mt-2">Eliminar Producto</button>
            </div>
        </form>

        <a class="btn btn-secondary mt-3" href="listado_productos.php">Volver al listado</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
