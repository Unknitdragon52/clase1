<?php
require 'config/conex.php';
require 'fpdf186/fpdf.php'; // Asegúrate de tener la biblioteca FPDF incluida y la ruta correcta

if (isset($_POST['generar_pdf'])) {
    $fecha_inicial = $_POST['fecha_inicial_pdf'];
    $fecha_final = $_POST['fecha_final_pdf'];
    $p_nombre = $_POST['p_nombre_pdf'];
    $s_nombre = $_POST['s_nombre_pdf'];
    $p_apellido = $_POST['p_apellido_pdf'];
    $s_apellido = $_POST['s_apellido_pdf'];

    // Consulta SQL para obtener los registros entre las fechas seleccionadas
    $sql = "SELECT * FROM historial WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY id DESC,fecha DESC, hora DESC;";
    
    $resultado = $mensajero->query($sql);

    if ($resultado->rowCount() > 0) {
        // Configurar la generación del PDF
        $pdf = new FPDF();
        $pdf->AddPage();

        $anchoTexto = 40; // Ancho del texto estático
        $anchoCeldaTexto = 40; // Ancho de la celda para el texto
        $anchoCeldaColor = 3; // Ancho de la celda para el color
        $desplazamiento = -34; // Desplazamiento hacia la derecha

        $pdf->SetFont('Arial', 'B', 10); // Restablecer la fuente para el nombre del usuario
        $desplazamientoIzquierda = 6; // Desplazamiento hacia la izquierda
        $pdf->Cell($desplazamientoIzquierda); // Agregar un espacio en blanco para alinear con el margen izquierdo
        $pdf->Cell(0, 8, 'Reporte generado por ' . $p_nombre . ' ' . $s_nombre . ' ' . $p_apellido . ' ' . $s_apellido, 0, 1, 'L'); // Texto alineado a la izquierda

        $pdf->Cell($anchoTexto + $desplazamiento); // Espacio en blanco para alinear con el margen derecho
        $pdf->Cell($anchoCeldaTexto, 8, 'Productos devueltos:', 0, 0); // Texto estático 'Devueltos:'
        $pdf->Cell($anchoCeldaColor); // Espacio adicional para desplazar los colores hacia la derecha
        $pdf->SetFillColor(150, 0, 0); // Color rojo para productos devueltos
        $pdf->Cell(8, 8, '', 1, 0, '', true); // Cuadrado rojo para productos devueltos
        $pdf->Ln(); // Salto de línea
        
        $pdf->Cell($anchoTexto + $desplazamiento); // Espacio en blanco para alinear con el margen derecho
        $pdf->Cell($anchoCeldaTexto, 8, 'Productos vencidos:', 0, 0); // Texto estático 'Vencidos:'
        $pdf->Cell($anchoCeldaColor); // Espacio adicional para desplazar los colores hacia la derecha
        $pdf->SetFillColor(180, 180, 0); // Color amarillo para productos vencidos
        $pdf->Cell(8, 8, '', 1, 0, '', true); // Cuadrado amarillo para productos vencidos
        $pdf->Ln(); // Salto de línea

        $pdf->Cell($anchoTexto + $desplazamiento); // Espacio en blanco para alinear con el margen derecho
        $pdf->Cell($anchoCeldaTexto, 8, 'Productos consumidos:', 0, 0); // Texto estático 'Consumo:'
        $pdf->Cell($anchoCeldaColor); // Espacio adicional para desplazar los colores hacia la derecha
        $pdf->SetFillColor(0, 0, 150); // Color azul para productos de consumo
        $pdf->Cell(8, 8, '', 1, 1, '', true); // Cuadrado azul para productos de consumo y cambio de línea

        $pdf->Cell($anchoTexto + $desplazamiento); // Espacio en blanco para alinear con el margen derecho
        $pdf->Cell($anchoCeldaTexto, 8, 'Productos de deudores:', 0, 0); // Texto estático 'Consumo:'
        $pdf->Cell($anchoCeldaColor); // Espacio adicional para desplazar los colores hacia la derecha
        $pdf->SetFillColor(0, 60, 0); // Color azul para productos de consumo
        $pdf->Cell(8, 8, '', 1, 1, '', true); // Cuadrado azul para productos de consumo y cambio de línea

        $pdf->Cell($anchoTexto + $desplazamiento); // Espacio en blanco para alinear con el margen derecho
        $pdf->Cell($anchoCeldaTexto, 8, 'Productos de gastos:', 0, 0); // Texto estático 'Consumo:'
        $pdf->Cell($anchoCeldaColor); // Espacio adicional para desplazar los colores hacia la derecha
        $pdf->SetFillColor(252, 46, 25, 99); // Color azul para productos de consumo
        $pdf->Cell(8, 8, '', 1, 1, '', true); // Cuadrado azul para productos de consumo y cambio de línea

        $pdf->SetFont('Arial', 'B', 16); // Tamaño de letra para el título
        $pdf->Ln();
        // Título del PDF
        $pdf->Cell(0, 20, 'Historial de Ventas', 0, 1, 'C'); // 0 indica el ancho automático

        // Cambiar el tamaño de letra para la tabla
        $pdf->SetFont('Arial', '', 12); // Tamaño de letra más pequeño para la tabla

        // Ajustar el ancho y el espaciado de las celdas para la tabla
        $pdf->Cell(12, 12, 'ID', 1);
        $pdf->Cell(50, 12, 'Nombre', 1);
        $pdf->Cell(20, 12, 'Cantidad', 1);
        $pdf->Cell(24, 12, 'Precio Unit.', 1);
        $pdf->Cell(25, 12, 'Precio Total', 1);
        $pdf->Cell(25, 12, 'Fecha', 1);
        $pdf->Cell(20, 12, 'Hora', 1);
        $pdf->Cell(22, 12, 'Pago', 1);
        $pdf->Ln();

        // Variables para almacenar el total de ganancias por método de pago
        $total_ganancias_efectivo = 0;
        $total_ganancias_tarjeta = 0;
        $total_ganancias_nequi = 0;
        $total_ganancias_daviplata = 0;

        foreach ($resultado as $fila) {
            $nombre = $fila['nombre'];
        
            // Verificar si el nombre contiene '[ ]'
            if (strpos($nombre, 'Producto') !== false && strpos($nombre, 'Devuelto') !== false) {
                // Cambiar el color de la letra a rojo para esta fila
                $pdf->SetTextColor(150, 0, 0); // Color rojo: RGB (150, 0, 0)

            } else if (strpos($nombre, 'Producto') !== false && strpos($nombre, 'Vencido') !== false) {
                // Cambiar el color de la letra a amarillo para esta fila
                $pdf->SetTextColor(180, 180, 0); // Color amarillo: RGB (180, 180, 0)
            } else if (strpos($nombre, 'Producto') !== false && strpos($nombre, 'de consumo') !== false) {
                // Cambiar el color de la letra a azul para esta fila
                $pdf->SetTextColor(0, 0, 150); // Color azul: RGB (0, 0, 150)
            } else if (strpos($nombre, 'Deudor') !== false) {
                $pdf->SetTextColor(0, 60, 0);
            } else if (strpos($nombre, 'Producto') !== false && strpos($nombre, 'de gasto') !== false) {
                // Cambiar el color de la letra a azul para esta fila
                $pdf->SetTextColor(252, 46, 25, 99); // Color azul: RGB (252, 46, 25, 99)
            }

            // Sumar el precio total según el método de pago
            switch ($fila['pago']) {
                case 'Efectivo':
                    $total_ganancias_efectivo += $fila['precio_total'];
                    break;
                case 'Tarjeta':
                    $total_ganancias_tarjeta += $fila['precio_total'];
                    break;
                case 'Nequi':
                    $total_ganancias_nequi += $fila['precio_total'];
                    break;
                case 'DaviPlata':
                    $total_ganancias_daviplata += $fila['precio_total'];
                    break;
                // Puedes agregar más casos según sea necesario
            }

            // Limitar la longitud del nombre a 30 caracteres y agregar "..." si es más largo
            if (strlen($nombre) > 25) {
                $nombre = substr($nombre, 0, 21) . '...';
            }

            $pdf->Cell(12, 12, $fila['id'], 1);
            $pdf->Cell(50, 12, $nombre, 1); // Utilizar la variable $nombre truncada
            $pdf->Cell(20, 12, $fila['cantidad'], 1);
            $pdf->Cell(24, 12, $fila['precio_unitario'], 1);
            $pdf->Cell(25, 12, $fila['precio_total'], 1);
            $pdf->Cell(25, 12, $fila['fecha'], 1);
            $pdf->Cell(20, 12, $fila['hora'], 1);
            $pdf->Cell(22, 12, $fila['pago'], 1);
            $pdf->Ln();

            // Restablecer el color de la letra a negro para las filas siguientes
            $pdf->SetTextColor(0); // Restablecer a negro: RGB (0, 0, 0)
        }

        // ... (código existente)

        $pdf->SetFont('Arial', 'B', 14); // Tamaño de letra para el título
        $pdf->Ln();
    
// Mostrar los totales de ganancias por método de pago en el PDF
$pdf->Cell(0, 12, 'Total (Efectivo): $' . number_format($total_ganancias_efectivo, 2) .
                '  ||  Total (Tarjeta): $' . number_format($total_ganancias_tarjeta, 2), 0, 1, 'C');


$pdf->Cell(0, 12, 'Total (Nequi): $' . number_format($total_ganancias_nequi, 2) .
                '  ||  Total (DaviPlata): $' . number_format($total_ganancias_daviplata, 2), 0, 1, 'C');


        // ... (código existente)

        $pdf->Output('D', 'reporte.pdf'); // Mostrar el PDF en el navegador para descarga con nombre 'reporte.pdf'
        exit;
    } else {
        echo "No se encontraron resultados para el rango de fechas seleccionado.";
    }
}
?>
