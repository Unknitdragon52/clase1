<?php
session_start(); // Asegúrate de haber iniciado la sesión

require 'config/conex.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos aquí

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id']) && isset($_POST['nueva_cantidad'])) {
    $producto_id = $_POST['producto_id'];
    $nueva_cantidad = intval($_POST['nueva_cantidad']);

    // Verifica que la nueva cantidad sea válida (mayor o igual a 1)
    if ($nueva_cantidad >= 1 && isset($_SESSION['carrito'][$producto_id])) {
        // Obtener la cantidad disponible del producto desde la base de datos
        $sql = "SELECT cantidad FROM productos WHERE id = :producto_id";
        $stmt = $mensajero->prepare($sql);
        $stmt->bindParam(':producto_id', $producto_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $cantidad_disponible = $result['cantidad'];

            // Verificar si la nueva cantidad a actualizar es menor o igual a la cantidad disponible en stock
            if ($nueva_cantidad <= $cantidad_disponible) {
                // Actualiza la cantidad del producto en el carrito
                $_SESSION['carrito'][$producto_id]['cantidad'] = $nueva_cantidad;
                echo 'Cantidad actualizada correctamente.';
            } else {
                // Restablece la cantidad a 1 si la nueva cantidad excede el stock
                $_SESSION['carrito'][$producto_id]['cantidad'] = 1;
                echo 'No puedes agregar una cantidad mayor que la disponible en stock.';
            }
        } else {
            echo 'No se pudo obtener la cantidad disponible del producto.';
        }
    } else {
        echo 'La cantidad a actualizar no es válida.';
    }
}

?>