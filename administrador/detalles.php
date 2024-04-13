<html><link rel="icon" href="../images/config/defecto.png" type="images/x-icon"> <!-- Agrega los enlaces a SweetAlert2 -->
<script src="../alert2/sweetalert2.all.min.js"></script>
<script src="../js/jquery.js"></script></html>
<?php
require '../config/conex.php';
session_start(); // Iniciar la sesión


$usuario = $_SESSION['usuario'];
$clave = $_SESSION['password'];
$p_nombre = $_SESSION['p_nombre'];
$s_nombre = $_SESSION['s_nombre'];
$p_apellido = $_SESSION['p_apellido'];
$s_apellido = $_SESSION['s_apellido'];







?>


<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Inventario - Detalles</title>
  <link rel="stylesheet" href="../css/inicio.css" />

  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

  
</head>
<body>




  <div class="container">

  
    <nav>
      <ul>
        <li><a href="#" class="logo">
          <img src="../images/config/defecto.png" alt="">
          <span class="nav-item">Inventario</span>
        </a></li>
        <li><a href="dashboard.php">
          <i class="fas fa-home"></i>
          <span class="nav-item">Inicio - Stock</span>
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
        <img class="fas fa" src="../images/config/deudores.png" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Deudores</span>
        </a></li>

        <li><a href="devolucion.php">
        <img class="fas fa" src="../images/config/devolucion.jpg" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Devolución</span>
        </a></li>


        <li><a href="vencimiento.php">
        <img class="fas fa" src="../images/config/vencimiento.png" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Vencimiento</span>
        </a></li>

        <li><a href="consumo.php">
        <img class="fas fa" src="../images/config/consumo.png" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Consumo</span>
        </a></li>

        <li><a href="gastos.php">
        <img class="fas fa" src="../images/config/gastos.png" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Gastos</span>
        </a></li>

        <li><a href="ingresos.php">
        <img class="fas fa" src="../images/config/ingresos.jpg" alt="" style="width:40px; height:40px; margin-left:15px;">
        <span style="margin-left:25px;" >Ingresos</span>
        </a></li>


        <li><a href="ajustes.php">
          <i class="fas fa-cog"></i>
          <span class="nav-item">Ajustes</span>
        </a></li>

        <br>
        <li><a href="../index.php">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Cerrar Sesión</span>
        </a></li>
      </ul>
    </nav>

    <section class="main">

    <div class="main-top">

  

    <div class="search-bar">
    <form method="POST" action="detalles.php">
            <label for="fecha_inicial">Fecha inicial:</label>
            <input type="date" id="fecha_inicial" name="fecha_inicial">
            <label for="fecha_final">Fecha final:</label>
            <input type="date" id="fecha_final" name="fecha_final">
            <input type="submit" name="buscar" value="Buscar">
        </form>
        <br><br>
</div>





  
</div>
<?php
if (isset($_POST['buscar'])) {

    $fecha_inicial = $_POST['fecha_inicial'];
    $fecha_final = $_POST['fecha_final'];
    $nombre_deudor = $_SESSION['nombre_deudor'];

    $contador = 0;


    // Consulta SQL para buscar registros dentro del rango de fechas
    $sqlproductos = "SELECT * FROM historial_deudores WHERE nombre='$nombre_deudor' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ORDER BY fecha DESC, hora DESC;";

        // Ejecutar la consulta
        $resultado = $mensajero->query($sqlproductos);

        $id_deudor= $_SESSION['id_deudor'];

        

        $telefono_deudor = $_SESSION['telefono_deudor'];

        $valor_deudor = $_SESSION['valor_deudor'];

        echo "<form method='POST' action='generar_pdf_deudor.php' style='margin-top: 20px;'>";
        echo "<input type='hidden' name='nombre_deudor_pdf' value='$nombre_deudor'>";
        echo "<input type='hidden' name='fecha_inicial_pdf' value='$fecha_inicial'>";
        echo "<input type='hidden' name='fecha_final_pdf' value='$fecha_final'>";
        echo "<input type='hidden' name='p_nombre_pdf' value='$p_nombre'>";
        echo "<input type='hidden' name='s_nombre_pdf' value='$s_nombre'>";
        echo "<input type='hidden' name='p_apellido_pdf' value='$p_apellido'>";
        echo "<input type='hidden' name='s_apellido_pdf' value='$s_apellido'>";
        echo "<input type='submit' name='generar_pdf_deudor' value='Generar PDF' style='padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;'>";
        echo "</form>";
        echo "<br>";


        if ($resultado->rowCount() > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Precio Total</th><th>Fecha</th><th>Hora</th></tr>";
            foreach ($resultado as $fila) {
    
              $nombre_d = $fila['nombre'];
              $nombre = $fila['nombre_producto'];
              $color = '';
              $contador = $contador + $fila['precio_total'];
              // Verificar si el nombre contiene los signos [ ]
              if (strpos($nombre, 'Producto') !== false && strpos($nombre, 'Devuelto') !== false) {
                  // Si contiene los signos [ ], agregar una clase específica
                  $color = "class='special-row'";
              }else if(strpos($nombre, 'Producto') !== false && strpos($nombre, 'Vencido') !== false){
    
                $color = "class='special-row1'";
              }else if(strpos($nombre, 'Producto') !== false && strpos($nombre, 'de consumo') !== false){
    
                $color = "class='special-row2'";
              }else if(strpos($nombre, 'Abono') !== false){
    
                $color = "class='special-row'";
    
              }
          
                echo "<tr $color>";
                echo "<td>" . $fila['id'] . "</td>";
                echo "<td>" . $fila['nombre'] . "</td>";
                echo "<td>" . $fila['nombre_producto'] . "</td>";
                echo "<td>" . $fila['cantidad'] . "</td>";
                echo "<td>" . $fila['precio_unitario'] . "</td>";
                echo "<td>" . $fila['precio_total'] . "</td>";
                echo "<td class='date-column'>" . $fila['fecha'] . "</td>";
                echo "<td>".$fila['hora']."</td>";
                echo "</tr>";
            }
            echo "</table>";

            echo'<br><br>';
    
            echo '<span id="totalPagar" class="styled-button">Total de Ganancias(Todos los registros): $'.$contador.'</span>';
  
        } else {
            echo "No se encontraron resultados para el rango de fechas seleccionado.";
        }
}else{

    $id_deudor= $_POST['id'];

$nombre_deudor = $_POST['nombre'];

$telefono_deudor = $_POST['telefono'];

$valor_deudor = $_POST['valor'];

$_SESSION['id_deudor'] = $id_deudor;
$_SESSION['nombre_deudor'] = $nombre_deudor;
$_SESSION['telefono_deudor'] = $telefono_deudor;
$_SESSION['valor_deudor'] = $valor_deudor;


$sqldeudores = "SELECT * FROM historial_deudores WHERE nombre='$nombre_deudor'  ORDER BY fecha DESC, hora DESC;";

$contador = 0;

echo '<table id="tablaDeudores" border="1">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio Unitario</th>
          <th>Precio Total</th>
          <th>Fecha</th>
          <th>Hora</th>
        </tr>';

foreach ($mensajero->query($sqldeudores) as $fila) {

    $id = $fila['id'];

    $nombre = $fila['nombre'];

    $producto = $fila['nombre_producto'];

    $cantidad = $fila['cantidad'];

    $precio_unitario = $fila['precio_unitario'];

    $precio_total = $fila['precio_total'];

    $fecha = $fila['fecha'];

    $hora = $fila['hora'];

    $contador = $contador + $precio_total;

    $color = '';

    if(strpos($producto, 'Abono') !== false){
    
      $color = "class='special-row'";

    }


    echo '<tr '.$color.'>
            <td>' . $id . '</td>
            <td>' . $nombre . '</td>
            <td>' . $producto . '</td>
            <td>' . $cantidad . '</td>
            <td>' . $precio_unitario . '</td>
            <td>' . $precio_total . '</td>
            <td>' . $fecha . '</td>
            <td>' . $hora . '</td>

          </tr>';
}

echo '</table>';


echo'<br><br>';

echo '<span id="totalPagar" class="styled-button">Total de Ganancias(Todos los registros): $'.$contador.'</span>';



}

?>

<br>








<!-- Añade el botón de "Generar Reporte" al final de la tabla, pero inicialmente oculto -->
<button id="generarReporte" onclick="generarReporte()" style="display: none;">Generar Reporte</button>





<script>

  function actualizarTotal() {
    var checkboxes = document.querySelectorAll('input[name="seleccionados[]"]:checked');
    var total = 0;

    checkboxes.forEach(function (checkbox) {
      var fila = checkbox.closest('tr');
      var precioTotal = parseFloat(fila.querySelector('td:nth-child(7)').textContent);
      total += precioTotal;
    });

    document.getElementById('totalPagar').textContent = 'Total a pagar(Registros seleccionados): $' + total.toFixed(2);
  }

  // Resto del código...
</script>


<script>

  function actualizarTotal() {
    var checkboxes = document.querySelectorAll('input[name="seleccionados[]"]:checked');
    var total = 0;

    checkboxes.forEach(function (checkbox) {
      var fila = checkbox.closest('tr');
      var precioTotal = parseFloat(fila.querySelector('td:nth-child(7)').textContent);
      total += precioTotal;
    });

    document.getElementById('totalPagar').textContent = 'Total a pagar(Registros seleccionados): $' + total.toFixed(2);
  }
</script>




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
  padding: 10px 15px;
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

#detalles{
    background-color: #007bff;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  #detalles:hover {
    background-color: #0056b3; /* Color de fondo al pasar el mouse */
    transform: scale(1.05);
  }

  #pagar,#abonar {
    background-color: #4CAF50;
    color: white;
    display: inline-block;
  padding: 10px 40px;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  cursor: pointer;
  border: 2px solid #4CAF50; /* Borde del botón */
  border-radius: 5px; /* Bordes redondeados */
  }

  #pagar:hover,#abonar:hover {
    background-color: #006400; /* Color de fondo al pasar el mouse */
    transform: scale(1.05);
  }

  #eliminar{
    background-color: #FF0000;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  #eliminar:hover {
    background-color: #8B0000; /* Color de fondo al pasar el mouse */
    transform: scale(1.05);
  }

/* Estilo para el botón con id "suma" */
#totalPagar {
  display: inline-block;
  padding: 10px 20px;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  cursor: pointer;
  border: 2px solid #007bff; /* Borde del botón */
  border-radius: 5px; /* Bordes redondeados */
  color: #fff; /* Color del texto */
  background-color: #007bff; /* Color de fondo azul */
}

/* Cambio de color al pasar el ratón sobre el botón con id "suma" */
#totalPagar:hover {

}

#buscar{

    display: inline-block;
  padding: 5px 10px;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  cursor: pointer;
  border: 2px solid gray; /* Borde del botón */
  border-radius: 5px; /* Bordes redondeados */
  color: gray; /* Color del texto */
  background-color: white; /* Color de fondo azul */

}

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
  padding: 10px 15px;
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

/* Estilo de navegación con scroll horizontal */
nav {
  white-space: nowrap; /* Evita el retorno de línea */
  overflow-y: auto; /* Habilita el scroll horizontal si es necesario */
}

</style>


  






      <div class="main-skills">








<!-- Asegúrate de incluir SweetAlert y jQuery -->
<script src="../js/jquery.js"></script>
<script src="../alert2/sweetalert2.all.min.js"></script>


<!-- Tu código HTML y otros scripts -->

</form>
     



    </section>
  </div>



</body>
</html></span>