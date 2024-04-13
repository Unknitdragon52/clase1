<html><link rel="icon" href="images/config/defecto.png" type="image/x-icon"> <!-- Agrega los enlaces a SweetAlert2 -->
<script src="alert2/sweetalert2.all.min.js"></script></html>
<?php
require 'config/conex.php';
session_start(); // Iniciar la sesión

$usuario = $_SESSION['usuario'];
$clave = $_SESSION['password'];
$p_nombre = $_SESSION['p_nombre'];
$s_nombre = $_SESSION['s_nombre'];
$p_apellido = $_SESSION['p_apellido'];
$s_apellido = $_SESSION['s_apellido'];


?>

<!-- Resto del código HTML -->



<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Inventario - Historial</title>
  <link rel="stylesheet" href="css/inicio.css" />

  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>



</head>
<body>




  <div class="container">

  
  <nav>
      <ul>
        <li><a href="#" class="logo">
          <img src="images/config/defecto.png" alt="">
          <span class="nav-item">Inventario</span>
        </a></li>


        <li><a href="ventas.php">
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">Ventas</span>
        </a></li>


        <li><a href="historial.php">
          <i class="fas fa-tasks"></i>
          <span class="nav-item">Historial</span>
        </a></li>

        <li><a href="deudores.php">
        <img class="fas fa" src="images/config/deudores.png" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Deudores</span>
        </a></li>


        <li><a href="devolucion.php">
        <img class="fas fa" src="images/config/devolucion.jpg" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Devolución</span>
        </a></li>

        <li><a href="vencimiento.php">
        <img class="fas fa" src="images/config/vencimiento.png" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Vencimiento</span>
        </a></li>


        <li><a href="consumo.php">
        <img class="fas fa" src="images/config/consumo.png" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Consumo</span>
        </a></li>

        <li><a href="gastos.php">
        <img class="fas fa" src="images/config/gastos.png" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Gastos</span>
        </a></li>
        
        <li><a href="ingresos.php">
        <img class="fas fa" src="images/config/ingresos.jpg" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Ingresos</span>
        </a></li>

        <li><a href="ajustes.php">
          <i class="fas fa-cog"></i>
          <span class="nav-item">Ajustes</span>
        </a></li>

        <br>
        <li><a href="index.php">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Cerrar Sesión</span>
        </a></li>
      </ul>

    </nav>

    <section class="main">

    

    <div class="main-top">

  

    <div class="search-bar">

        <form method="POST" action="historial.php">
            <label for="fecha_inicial">Fecha inicial:</label>
            <input type="date" id="fecha_inicial" name="fecha_inicial">
            <label for="fecha_final">Fecha final:</label>
            <input type="date" id="fecha_final" name="fecha_final">
            <input type="submit" name="buscar" value="Buscar">
        </form>
        <br><br>
    </div>

  

</div>
<h1>Historial de ventas:</h1>
<?php

// Función para obtener el total de ganancias por método de pago
function obtenerTotalGananciasPorMetodoPago($mensajero, $fecha_inicial, $fecha_final, $metodo_pago) {
  $sql = "SELECT SUM(precio_total) AS total_ganancias FROM historial WHERE pago = :metodo_pago";
  if ($fecha_inicial && $fecha_final) {
      $sql .= " AND fecha BETWEEN :fecha_inicial AND :fecha_final";
  }

  $stmt = $mensajero->prepare($sql);
  $stmt->bindParam(':metodo_pago', $metodo_pago, PDO::PARAM_STR);
  if ($fecha_inicial && $fecha_final) {
      $stmt->bindParam(':fecha_inicial', $fecha_inicial, PDO::PARAM_STR);
      $stmt->bindParam(':fecha_final', $fecha_final, PDO::PARAM_STR);
  }

  $stmt->execute();
  $total_ganancias = $stmt->fetchColumn();
  return $total_ganancias ? $total_ganancias : 0;
}

if (isset($_POST['buscar'])) {
    // Obtener fechas ingresadas en el formulario
    $fecha_inicial = $_POST['fecha_inicial'];
    $fecha_final = $_POST['fecha_final'];

    // Consulta SQL para buscar registros dentro del rango de fechas
    $sqlproductos = "SELECT * FROM historial WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY id DESC,fecha DESC, hora DESC;";


    // Ejecutar la consulta
    $resultado = $mensajero->query($sqlproductos);

    echo "<form method='POST' action='generar_pdf.php' style='margin-top: 20px;'>";
    echo "<input type='hidden' name='fecha_inicial_pdf' value='$fecha_inicial'>";
    echo "<input type='hidden' name='fecha_final_pdf' value='$fecha_final'>";
    echo "<input type='hidden' name='p_nombre_pdf' value='$p_nombre'>";
    echo "<input type='hidden' name='s_nombre_pdf' value='$s_nombre'>";
    echo "<input type='hidden' name='p_apellido_pdf' value='$p_apellido'>";
    echo "<input type='hidden' name='s_apellido_pdf' value='$s_apellido'>";
    echo "<input type='submit' name='generar_pdf' value='Generar PDF' style='padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;'>";
    echo "</form>";
    echo "<br>";

    if ($resultado->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Cantidad</th><th>Precio Unitario</th><th>Precio Total</th><th>Fecha</th><th>Hora</th><th>Pago</th></tr>";
        foreach ($resultado as $fila) {


          $nombre = $fila['nombre'];
          $color = '';
      
          // Verificar si el nombre contiene los signos [ ]
          if (strpos($nombre, 'Producto') !== false && strpos($nombre, 'Devuelto') !== false) {
              // Si contiene los signos [ ], agregar una clase específica
              $color = "class='special-row'";
          }else if(strpos($nombre, 'Producto') !== false && strpos($nombre, 'Vencido') !== false){

            $color = "class='special-row1'";
          }else if(strpos($nombre, 'Producto') !== false && strpos($nombre, 'de consumo') !== false){

            $color = "class='special-row2'";
          }else if(strpos($nombre, 'Deudor') !== false){

            $color = "class='special-row3'";

          }else if(strpos($nombre, 'Producto') !== false && strpos($nombre, 'de gasto') !== false){

            $color = "class='special-row4'";
            
          }
      
            echo "<tr $color>";
            echo "<td>" . $fila['id'] . "</td>";
            echo "<td>" . $fila['nombre'] . "</td>";
            echo "<td>" . $fila['cantidad'] . "</td>";
            echo "<td>" . $fila['precio_unitario'] . "</td>";
            echo "<td>" . $fila['precio_total'] . "</td>";
            echo "<td class='date-column'>" . $fila['fecha'] . "</td>";
            echo "<td>".$fila['hora']."</td>";
            echo "<td>" . $fila['pago'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        $total_ganancias_efectivo = obtenerTotalGananciasPorMetodoPago($mensajero, $fecha_inicial, $fecha_final, 'Efectivo');
        $total_ganancias_tarjeta = obtenerTotalGananciasPorMetodoPago($mensajero, $fecha_inicial, $fecha_final, 'Tarjeta');
        $total_ganancias_nequi = obtenerTotalGananciasPorMetodoPago($mensajero, $fecha_inicial, $fecha_final, 'Nequi');
        $total_ganancias_daviplata = obtenerTotalGananciasPorMetodoPago($mensajero, $fecha_inicial, $fecha_final, 'DaviPlata');
    
        echo "<button class='styled-button'>Total (Efectivo): $" . number_format($total_ganancias_efectivo, 2) . "</button>";
        echo "<button class='styled-button'>Total (Tarjeta): $" . number_format($total_ganancias_tarjeta, 2) . "</button>";
        echo "<button class='styled-button'>Total (Nequi): $" . number_format($total_ganancias_nequi, 2) . "</button>";
        echo "<button class='styled-button'>Total (DaviPlata): $" . number_format($total_ganancias_daviplata, 2) . "</button>";


    } else {
        echo "No se encontraron resultados para el rango de fechas seleccionado.";
    }
} else {
    // Mostrar la tabla general si no se está realizando una búsqueda
    $sqlproductos = "SELECT * FROM historial ORDER BY id DESC,fecha DESC,hora DESC;";
    // Obtener los datos de la base de datos
    $resultado = $mensajero->query($sqlproductos);

    if ($resultado->rowCount() > 0) {

      
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Cantidad</th><th>Precio Unitario</th><th>Precio Total</th><th>Fecha</th><th>Hora</th><th>Pago</th></tr>";
        foreach ($resultado as $fila) {
          $nombre = $fila['nombre'];
          $color = '';
      
          // Verificar si el nombre contiene los signos [ ]
          if (strpos($nombre, 'Producto') !== false && strpos($nombre, 'Devuelto') !== false) {
              // Si contiene los signos [ ], agregar una clase específica
              $color = "class='special-row'";
          }else if(strpos($nombre, 'Producto') !== false && strpos($nombre, 'Vencido') !== false){

            $color = "class='special-row1'";
          }else if(strpos($nombre, 'Producto') !== false && strpos($nombre, 'de consumo') !== false){

            $color = "class='special-row2'";
          }else if(strpos($nombre, 'Deudor' ) !== false){

            $color = "class='special-row3'";

          }else if(strpos($nombre, 'Producto') !== false && strpos($nombre, 'de gasto') !== false){

            $color = "class='special-row4'";
            
          }
      
          echo "<tr $color>";
          echo "<td>" . $fila['id'] . "</td>";
          echo "<td>" . $nombre . "</td>";
          echo "<td>" . $fila['cantidad'] . "</td>";
          echo "<td>" . $fila['precio_unitario'] . "</td>";
          echo "<td>" . $fila['precio_total'] . "</td>";
          echo "<td class='date-column'>" . $fila['fecha'] . "</td>";
          echo "<td>" . $fila['hora'] . "</td>";
          echo "<td>" . $fila['pago'] . "</td>";
          echo "</tr>";
      }
        echo "</table>";

        $total_ganancias_efectivo = obtenerTotalGananciasPorMetodoPago($mensajero, null,null , 'Efectivo');
        $total_ganancias_tarjeta = obtenerTotalGananciasPorMetodoPago($mensajero, null,null , 'Tarjeta');
        $total_ganancias_nequi = obtenerTotalGananciasPorMetodoPago($mensajero, null,null , 'Nequi');
        $total_ganancias_daviplata = obtenerTotalGananciasPorMetodoPago($mensajero, null, null, 'DaviPlata');
    
        echo "<button class='styled-button'>Total (Efectivo): $" . number_format($total_ganancias_efectivo, 2) . "</button>";
    
        echo "<button class='styled-button'>Total (Tarjeta): $" . number_format($total_ganancias_tarjeta, 2) . "</button>";
   
        echo "<button class='styled-button'>Total (Nequi): $" . number_format($total_ganancias_nequi, 2) . "</button>";
      
        echo "<button class='styled-button'>Total (DaviPlata): $" . number_format($total_ganancias_daviplata, 2) . "</button>";
        
      
      } else {
        echo "No se encontraron resultados";
    }
}
?>





  






      <div class="main-skills">



      <style>
  /* Estilos para el modal */
  .modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .modal-dialog {
    position: relative;
    margin: 10% auto;
    width: 50%;
    max-width: 500px; /* Ancho máximo para el modal */
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
  }

  /* Estilos para el botón "Cerrar" (X) */
  .close {
    position: absolute;
    top: 5px;
    right: 5px;
    font-size: 30px;
    color: #000; /* Cambié el color a negro */
    transition: color 0.3s ease;
    cursor: pointer;
    text-shadow: none; /* Eliminamos cualquier sombra de texto */
    background: none; /* Eliminamos cualquier fondo */
    border: none; /* Eliminamos cualquier borde */
    padding: 0; /* Reducimos el espacio interno */
  }

  .close:hover {
    color: #333; /* Cambia el color al pasar el ratón sobre la "X" */
  }

  /* Estilos para el formulario */
  .form-group {
    margin-bottom: 15px;
  }

  .form-control {
    width: 100%;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
  }

  .btn {
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .btn-primary {
    background-color: #4CAF50;
    color: #fff;
  }

  /* Estilos para la tabla */
  table {
    font-family: Arial, sans-serif;
    border-collapse: collapse;
    width: 90%; /* Ancho al 100% del contenedor */
    margin-bottom: 20px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    background-color: #fff; /* Fondo blanco para la tabla */
  }

  th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #dddddd;
    color: #333; /* Color de texto más oscuro */
  }

  th {
    background-color: #f2f2f2; /* Fondo ligeramente gris para los encabezados */
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  tr:nth-child(even) {
    background-color: #f8f8f8; /* Fondo más claro para filas pares */
  }

  tr:hover {
    background-color: #e6e6e6; /* Cambio de color al pasar el ratón sobre las filas */
  }

  th.date-column,
  td.date-column {
    width: 150px; /* Ancho personalizado para la columna de fecha */
  }

  .styled-button {
  padding: 12px;
  margin-right: 10px; /* Ajusta este valor según el espacio que desees entre los botones */
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px; /* Tamaño de fuente */
  font-weight: bold; /* Negrita */
  text-transform: uppercase; /* Convertir el texto a mayúsculas */
  transition: background-color 0.3s ease; /* Efecto de transición */
}

.styled-button:hover {
  background-color: #45a049; /* Cambio de color al pasar el ratón sobre el botón */
}
.special-row td {
    color: rgb(150, 0, 0) !important; /* Cambia el color de texto a rojo */
}

.special-row1 td {
    color: rgb(180, 180, 0) !important; /* Cambia el color de texto a rojo */
}

.special-row2 td {
    color: rgb(0, 0, 150) !important; /* Cambia el color de texto a rojo */
}

.special-row3 td{
  color: rgb(0, 80, 0) !important; /* Cambia el color de texto a rojo */

}

.special-row4 td{
  color: rgb(252, 46, 25,99) !important; /* Cambia el color de texto a rojo */
}

/* Estilo de navegación con scroll horizontal */
nav {
  white-space: nowrap; /* Evita el retorno de línea */
  overflow-y: auto; /* Habilita el scroll horizontal si es necesario */
}


</style>







<!-- Asegúrate de incluir SweetAlert y jQuery -->
<script src="alert2/sweetalert2.all.min.js"></script>
<script src="js/jquery.js"></script>

<!-- Tu código HTML y otros scripts -->

</form>
     



    </section>
  </div>



</body>
</html></span>