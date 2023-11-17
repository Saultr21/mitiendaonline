<?php session_start(); ?>
<div class="" style="max-height: 80px; background-color: grey; display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
    <h1 class="text-center">Mi Tienda Online</h1>
    <div style="display: flex; align-items: center;">
        <?php if (isset($_SESSION['usuario'])) : ?>
            <span style="margin-right: 10px;"><?php echo "Nombre de usuario: ".$_SESSION['usuario']; ?></span>
            <form action="" method="POST" style="display: inline;">
                <button class="mt-3" type="submit" name="cerrar_sesion">Cerrar sesión</button>
            </form>
        <?php endif; ?>
    </div>
</div>