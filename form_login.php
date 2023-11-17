<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title>Formulario de Login</title>
</head>

<body>
    <h2 class="container text-center mt-5">Iniciar sesión</h2>
    <div class="container mt-5 d-flex justify-content-center align-items-center ">
        <form action="form.php" method="post">
            <label for="correo">Correo electrónico:</label><br>
            <input type="email" id="correo" name="correo" required>

            <br>

            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required>

            <br>
            <div class="mt-4 d-flex justify-content-center align-items-center">
                <input type="submit" value="Iniciar sesión">
            </div>
            <div>
                <a class="mt-5 btn btn-primary d-flex justify-content-center text-center" href="index.php">Volver al menú</a>
            </div>

        </form>
        <div>
</body>

</html>