<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['correo']) && isset($_POST['password'])) {
        $correo = $_POST['correo'];
        $password = $_POST['password'];
    }

    $stmt = $conn->prepare("SELECT id, nombre, contrasena_hash FROM usuarios2 WHERE correo_electronico = :correo");
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $contrasena_hash = $result['contrasena_hash'];

        if (password_verify($password, $contrasena_hash)) {
            // Iniciar la sesión
            session_start();
            $_SESSION['usuario_id'] = $result['id'];
            $_SESSION['usuario'] = $result['nombre'];

            // Redirigir al usuario a la página almacenada o a la página por defecto
            $pagina_destino = ($_SESSION['pagina_destino']);
            header("Location: $pagina_destino");
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta'); history.back();</script>";

        }
    } else {
        echo "<script>alert('Usuario no encontrado'); history.back();</script>";

    }
}

$conn = null;
?>