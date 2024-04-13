<?php
require '../config/conex.php';
require '../fpdf186/fpdf.php'; // Asegúrate de tener la biblioteca FPDF incluida y la ruta correcta

if (isset($_POST['generar_pdf_deudor'])) {
    $fecha_inicial = $_POST['fecha_inicial_pdf'];
    $fecha_final = $_POST['fecha_final_pdf'];
    $nombre_deudor = $_POST['nombre_deudor_pdf'];
    $p_nombre = $_POST['p_nombre_pdf'];
    $s_nombre = $_POST['s_nombre_pdf'];
    $p_apellido = $_POST['p_apellido_pdf'];
    $s_apellido = $_POST['s_apellido_pdf'];

    // Consulta SQL para obtener los registros entre las fechas seleccionadas
    $sql = "SELECT * FROM historial_deudores WHERE nombre='$nombre_deudor' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY fecha DESC, hora DESC;";
    
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

        
        



        $pdf->SetFont('Arial', 'B', 16); // Tamaño de letra para el título
        // Título del PDF
        $pdf->Cell(0, 20, 'Historial de Ventas', 0, 1, 'C'); // 0 indica el ancho automático

        // Cambiar el tamaño de letra para la tabla
        $pdf->SetFont('Arial', '', 12); // Tamaño de letra más pequeño para la tabla

        // Ajustar el ancho y el espaciado de las celdas para la tabla
        $pdf->Cell(20, 12, 'ID', 1);
        $pdf->Cell(30,12,'Nombre',1);
        $pdf->Cell(30, 12, 'Producto', 1);
        $pdf->Cell(19, 12, 'Cantidad', 1);
        $pdf->Cell(25, 12, 'Precio Unit.', 1);
        $pdf->Cell(25, 12, 'Precio Total', 1);
        $pdf->Cell(25, 12, 'Fecha', 1);
        $pdf->Cell(20, 12, 'Hora', 1);
        $pdf->Ln();

        // Variable para almacenar el total de ganancias
        $total_ganancias = 0;

        foreach ($resultado as $fila) {
            $nombre = $fila['nombre'];

            $producto = $fila['nombre_producto'];
        
            // Verificar si el nombre contiene '[ ]'
            if (strpos($nombre, 'Producto') !== false && strpos($nombre, 'Devuelto') !== false) {
                // Cambiar el color de la letra a rojo para esta fila
                $pdf->SetTextColor(150, 0, 0); // Color rojo: RGB (150, 0, 0)

            }else if (strpos($nombre, 'Producto') !== false && strpos($nombre, 'Vencido') !== false) {
                // Cambiar el color de la letra a amarillo para esta fila
                $pdf->SetTextColor(180, 180, 0); // Color amarillo: RGB (180, 180, 0)
            }else if(strpos($nombre, 'Producto') !== false && strpos($nombre, 'de consumo') !== false){

                // Cambiar el color de la letra a azul para esta fila
                $pdf->SetTextColor(0, 0, 150); // Color azul: RGB (0, 0, 150)
              }else if(strpos($producto, 'Abono') !== false){

                $pdf->SetTextColor(150, 0, 0); // Color rojo: RGB (150, 0, 0)
    
              }

            
        
            // Limitar la longitud del nombre a 30 caracteres y agregar "..." si es más largo
            if (strlen($nombre) > 30) {
                $nombre = substr($nombre, 0, 27) . '...';
            }
        
            $pdf->Cell(20, 12, $fila['id'], 1);
            $pdf->Cell(30, 12, $nombre, 1);
            $pdf->Cell(30, 12, $fila['nombre_producto'], 1); // Utilizar la variable $nombre truncada
            $pdf->Cell(19, 12, $fila['cantidad'], 1);
            $pdf->Cell(25, 12, $fila['precio_unitario'], 1);
            $pdf->Cell(25, 12, $fila['precio_total'], 1);
            $pdf->Cell(25, 12, $fila['fecha'], 1);
            $pdf->Cell(20, 12, $fila['hora'], 1);
            $pdf->Ln();
        
            // Restablecer el color de la letra a negro para las filas siguientes
            $pdf->SetTextColor(0); // Restablecer a negro: RGB (0, 0, 0)
        
            // Sumar el precio total para calcular las ganancias totales
            $total_ganancias += $fila['precio_total'];
        }
        

        $pdf->SetFont('Arial', 'B', 14); // Tamaño de letra para el título
        $pdf->Ln();
        // Mostrar el total de ganancias en el PDF con el mensaje del usuario concatenado
        $pdf->Cell(0, 12, 'Total de Ganancias: $' . number_format($total_ganancias, 2), 0, 1, 'C');

        $pdf->Output('D', 'reporte.pdf'); // Mostrar el PDF en el navegador para descarga con nombre 'reporte.pdf'
        exit;
    } else {
        echo "No se encontraron resultados para el rango de fechas seleccionado.";
    }
}
?>
