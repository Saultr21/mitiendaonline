<?php
include 'config.php';

try {
    $stmt = $conn->query("SELECT productos.*, categorías.Nombre as categoria_nombre FROM productos 
    JOIN categorías ON productos.Categoría = categorías.Id;");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de consulta: " . $e->getMessage());
}
?>

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
        <h1>Listado de Productos</h1>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Categoría</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['id']) ?></td>
                        <td><?= htmlspecialchars($producto['Nombre']) ?></td>
                        <td><?= htmlspecialchars($producto['Precio']) ?></td>
                        <td><img src="<?= htmlspecialchars($producto['Imagen']) ?>" alt="<?= htmlspecialchars($producto['Nombre']) ?>" height="50"></td>
                        <td><?= htmlspecialchars($producto['categoria_nombre']) ?></td>
                        <td><a class="btn btn-warning" href="modifica_producto.php?id=<?= htmlspecialchars($producto['id']) ?>">Editar</a></td>
                        <td><a class="btn btn-danger" href="elimina_producto.php?id=<?= htmlspecialchars($producto['id']) ?>">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a class="btn btn-primary" href="index.php">Volver al menú</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
