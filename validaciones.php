<?php

function validarProducto($nombre, $precio, $imagen, $categoria) {
    $errores = [];

    if (empty($nombre)) {
        $errores[] = "El nombre del producto es obligatorio.";
    }

    if (!is_numeric($precio) || $precio <= 0) {
        $errores[] = "El precio debe ser un número positivo.";
    }

    if (empty($imagen)) {
        $errores[] = "La imagen es obligatoria.";
    }

    if (empty($categoria)) {
        $errores[] = "La categoría es obligatoria.";
    }

    return $errores;
}
