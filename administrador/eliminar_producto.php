<?php
session_start(); // Asegúrate de haber iniciado la sesión

// Verifica si se ha enviado un ID de producto para eliminar
if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Verificar si el producto existe en el carrito
    if (isset($_SESSION['carrito'][$producto_id])) {
        // Reducir la cantidad del producto en el carrito o eliminarlo si la cantidad es uno
        if ($_SESSION['carrito'][$producto_id]['cantidad'] > 1) {
            $_SESSION['carrito'][$producto_id]['cantidad']--;
        } else {
            unset($_SESSION['carrito'][$producto_id]); // Eliminar completamente el producto del carrito
        }
    }
}

// Redireccionar de vuelta a la página del carrito
header('Location: carrito.php');
exit();
?>
