<html>
<head>
    <link rel="icon" href="../images/icono.png" type="image/x-icon">
    <!-- Agrega los enlaces a SweetAlert2 -->
    <script src="../alert2/sweetalert2.all.min.js"></script>
</head>
<body>
    <?php
    session_start(); // Iniciar la sesión
    require '../config/conex.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos aquí

    if (isset($_POST['Carrito'])) {
        $producto_id = $_POST['Carrito'];

        $sql = "SELECT cantidad FROM productos WHERE id = :producto_id";
        $stmt = $mensajero->prepare($sql);
        $stmt->bindParam(':producto_id', $producto_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $cantidad_disponible = $result['cantidad'];

            if ($cantidad_disponible <= 0) {
                echo '<script>
                    swal.fire({
                        title: "Error",
                        text: "Ya has alcanzado el stock máximo para este producto",
                        icon: "error"
                    });
                    setTimeout(function() {
                        window.location.href = "ventas.php";
                    }, 1500);
                </script>';
                exit();
            }

            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }

            if (isset($_SESSION['carrito'][$producto_id])) {
                if ($_SESSION['carrito'][$producto_id]['cantidad'] < $cantidad_disponible) {
                    $_SESSION['carrito'][$producto_id]['cantidad']++;
                } else {
                    echo '<script>
                        swal.fire({
                            title: "Error",
                            text: "Ya has alcanzado el stock máximo para este producto",
                            icon: "error"
                        });
                        setTimeout(function() {
                            window.location.href = "ventas.php";
                        }, 1500);
                    </script>';
                    exit();
                }
            } else {
                if ($cantidad_disponible > 0) {
                    if (isset($_POST['nombre_producto']) && isset($_POST['precio_producto'])) {
                        $nombre_producto = $_POST['nombre_producto'];
                        $precio_producto = $_POST['precio_producto'];

                        $_SESSION['carrito'][$producto_id] = [
                            'id' => $producto_id,
                            'nombre' => $nombre_producto,
                            'precio' => $precio_producto,
                            'cantidad' => 1
                        ];
                    } else {
                        echo "Error: Faltan datos del producto.";
                    }
                } else {
                    echo "El producto está fuera de stock.";
                }
            }
        } else {
            echo "El producto no existe en la base de datos.";
        }
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
    ?>
</body>
</html>
