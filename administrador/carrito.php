<html><link rel="icon" href="../images/config/defecto.png" type="image/x-icon"> <!-- Agrega los enlaces a SweetAlert2 -->
<script src="../alert2/sweetalert2.all.min.js"></script>

</html>
<?php
require '../config/conex.php';
session_start(); // Asegúrate de haber iniciado la sesión

// Función para mostrar el carrito de compras
function mostrarCarrito() {
    if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {

      echo '<span style="font-family: verdana, geneva, sans-serif;">';
      echo '<!DOCTYPE html>
      <html lang="en">';
      echo '<head>';
      echo '  <meta charset="UTF-8" />
      <title>Inventario - Stock</title>
      <link rel="stylesheet" href="../css/inicio.css" />
    
      <!-- Font Awesome Cdn Link -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>';
      echo '</head>';


      echo '<body>';
      echo '<div class="container">';
      echo '<nav>
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

    </nav>';


    echo '<section class="main">';

    echo '<div class="main-top">';

      echo '<div class="search-bar">';

      echo '</div>';

    echo '</div>';


    echo '<style>
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
      margin: 5% auto; /* Ajusta el margen superior */
      top: 10%; /* O ajusta el valor de top directamente */
      width: 50%;
      max-width: 500px;
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
  
  .color{
    color: red;
  }
  
  /* Estilo de navegación con scroll horizontal */
  nav {
    white-space: nowrap; /* Evita el retorno de línea */
    overflow-y: auto; /* Habilita el scroll horizontal si es necesario */
  }
  
  /* Estilos para la paginación */
  .pagination-container {
      overflow-x: auto;
      margin: 30px 0; /* Ajusta según sea necesario */
      width: 700px;
  }
  
  .pagination {
      display: flex;
      list-style: none;
      padding: 0;
      margin: 0;
  }
  
  .pagination a {
      display: block;
      padding: 8px 12px;
      margin-right: 5px;
      text-decoration: none;
      background-color: #3498db; /* Color de fondo azul */
      color: #fff; /* Color del texto blanco */
      border-radius: 3px;
      transition: background-color 0.3s ease;
      max-width: 100px;
  }
  
  .pagination a:hover {
      background-color: #2980b9; /* Cambia el color de fondo al pasar el ratón */
  }
  
  
  
  
  
  
  
  /* Estilos para el botón con fondo azul */
  .button-blue {
      background-color: #007bff; /* Color de fondo azul */
      color: #fff; /* Color de texto blanco */
      padding: 6px 15px; /* Relleno interno */
      border: none; /* Sin borde */
      border-radius: 5px; /* Bordes redondeados */
      cursor: pointer; /* Cambiar cursor a una mano al pasar el ratón */
      font-size: 15px; /* Tamaño de fuente */
  }
  
  /* Estilo hover para el botón */
  .button-blue:hover {
      background-color: #0056b3; /* Cambiar color de fondo al pasar el ratón */
  }
  
  .search-bar {
      display: flex;
      align-items: center; /* Centrar verticalmente los elementos */
  }
  
  .create-table-btn {
      margin-right: 10px; /* Espacio entre el botón "Añadir al Stock" y el formulario de búsqueda */
  }
  
  /* Otros estilos según sea necesario */
  /* Estilos para la tabla del carrito de compras */
  table {
      width: 1100px;
      border-collapse: collapse;
      margin-top: 20px;
      border-color: black;
     
  }

  th, td {
      padding: 15px;
      text-align: left;
      border: 1px solid #ddd;
      background-color: #f2f2f2;
  }

  td{
    
    font-size: 20px;
    }

  th {
      background-color: #f2f2f2;
      text-align:center;
  }

  .producto td {
      text-align: center;
  }

  .cantidad {
      width: 130px;
      background-color: white;
      border: 1px solid gray;
      border-radius: 4px;
      text-align: center;
  }

  #total {
      text-align: left;
  }

  #pagarr {
      background-color: #4CAF50;
      color: white;
      padding: 10px 15px;
      font-size: 16px;
      margin-top: 10px;
      cursor: pointer;
      border: none;
      border-radius: 5px;
      width:100%;

  }

  #pagarr:hover {
      background-color: #45a049;
  }

  .button-container {
      margin-top: 10px;
  }

  #createTableBtn {
      background-color: #007bff;
      color: white;
      padding: 10px 15px;
      font-size: 16px;
      cursor: pointer;
      border: none;
      border-radius: 5px;
      width: 100%;
  }

  #createTableBtn:hover {
      background-color: #0056b3;
  }
  /* Estilo para el enlace que se verá como un botón rojo */
a.button-rojo {
  display: inline-block;
  width: 130px;
  padding: 5px 10px; /* Ajusta según sea necesario */
  background-color: #ff0000; /* Color de fondo rojo */
  color: #fff; /* Color del texto blanco */
  text-decoration: none; /* Elimina el subrayado del enlace */
  border-radius: 5px; /* Bordes redondeados */
  transition: background-color 0.3s ease; /* Efecto de transición en el color de fondo */
}

/* Cambia el color de fondo al pasar el ratón sobre el botón */
a.button-rojo:hover {
  background-color: #cc0000; /* Color de fondo rojo más oscuro al pasar el ratón */
}
  
  </style>';
 
  echo '<div class="main-skills">';



  echo '<table border="1" >

          <tr>
          <th colspan="5">
          <h1>Carrito de Compras</h1>
          </th>
          </tr>
          <tr>
              <th>Nombre del Producto</th>
              <th>Cantidad</th>
              <th>Precio unitario</th>
              <th>Subtotal</th>
              <th>Eliminar</th>
          </tr>';

  $total = 0;

  foreach ($_SESSION['carrito'] as $producto_id => $producto) {
      $subtotal = $producto['precio'] * $producto['cantidad'];
      $total += $subtotal;

      echo '<tr class="producto" data-product-id="' . $producto_id . '">
              <td>' . $producto['nombre'] . '</td>
              <td><input type="number" class="cantidad" value="' . $producto['cantidad'] . '" min="1" data-product-id="' . $producto_id . '"></td>
              <td>$' . $producto['precio'] . '</td>
              <td>$' . $subtotal . '</td>
              <td ><a href="eliminar_producto.php?id=' . $producto_id . '" class="button-rojo">Eliminar</a></td>
            </tr>';
  }

  echo '<tr>
          <td id="total" colspan="5" style="font-weight: bold; font-size: 40px;" >Total: $' . $total . '</td>

        </tr>';

  echo '<tr>
  
  <td colspan="5"><button type="button" onclick="abrirModal()" id="pagarr">Pagar</button></td>
  
  </tr>';

  echo '<tr>';
  echo '<td colspan="5">';

        echo '<div class="">'; 
        echo'
        <button id="createTableBtn" name="fiado">Pagar fiado</button>
            '; 
        echo '</div>';
  echo '</td>';
  echo '</tr>';
  echo '</table>';



  echo '<script src="../js/jquery.js"></script>';
  echo '</div>';


    echo '</section>';

      echo '</div>';
      

      echo "
      <script>
      $(document).ready(function() {
        // Función para actualizar subtotales
        function actualizarSubtotales() {
          $('.producto').each(function() {
            var producto = $(this);
            var cantidad = parseInt(producto.find('.cantidad').val());
            var precio = parseFloat(producto.find('td:nth-child(3)').text().replace('$', ''));
            var subtotal = cantidad * precio;
            producto.find('td:nth-child(4)').text('$' + subtotal.toLocaleString()); // Modificado aquí
          });
        }
      
        // Función para actualizar el total
        function actualizarTotal() {
          var total = 0;
          $('.producto').each(function() {
            var subtotal = parseFloat($(this).find('td:nth-child(4)').text().replace('$', '').replace(/\./g, '').replace(',', '.'));
            total += subtotal;
          });
          $('#total').text('Total: $' + total.toLocaleString()); // Modificado aquí
        }
      
        $('.cantidad').on('change', function() {
          var inputCantidad = $(this);
          var producto_id = inputCantidad.data('product-id');
          var nueva_cantidad = inputCantidad.val();
          var cantidadDisponible = inputCantidad.data('cantidad-disponible');
      
          $.ajax({
            type: 'POST',
            url: 'actualizar_carrito.php',
            data: {
              producto_id: producto_id,
              nueva_cantidad: nueva_cantidad
            },
            success: function(response) {
              if (response.includes('No puedes agregar una cantidad mayor que la disponible en stock.')) {
                alert('No puedes agregar más cantidad de la disponible en stock.');
                // Restablecer el valor original de la cantidad al máximo disponible
                inputCantidad.val(cantidadDisponible > 0 ? cantidadDisponible : 1);
      
                // Actualizar subtotales y total
                actualizarSubtotales();
                actualizarTotal();
              } else {
                console.log('Cantidad actualizada');
      
                // Actualizar subtotales y total después de cambiar la cantidad
                actualizarSubtotales();
                actualizarTotal();
              }
            }
          });
        });
      
        // Llamadas iniciales para actualizar subtotales y total al cargar la página
        actualizarSubtotales();
        actualizarTotal();
      });
      </script>";
      echo '</body>';



      echo '</html>';
      echo '</span>';



    } else {
        echo "<style>  /* Estilo para el enlace que se verá como un botón rojo */
        a.button-rojo {
          display: inline-block;
          width: 100px;
          padding: 5px 10px; /* Ajusta según sea necesario */
          background-color: #00cc00; /* Color de fondo rojo */
          color: #fff; /* Color del texto blanco */
          text-decoration: none; /* Elimina el subrayado del enlace */
          border-radius: 5px; /* Bordes redondeados */
          transition: background-color 0.3s ease; /* Efecto de transición en el color de fondo */
        }
        
        /* Cambia el color de fondo al pasar el ratón sobre el botón */
        a.button-rojo:hover {
          background-color: #66ff66; /* Color de fondo rojo más oscuro al pasar el ratón */
        }</style>";
        echo '<h3>No hay productos en el carrito</h3>';
        echo '<a href="ventas.php" class="button-rojo">Volver</a>';
    }
}

// Verificar si se realizó el pago
if (isset($_POST['pagar'])) {

  if (isset($_POST['descuento']) && !empty($_POST['descuento'])) {
    $descuento = $_POST['descuento'];


    $opcion = $_POST['opcion'];

    if($opcion == 1){

      $opcion = "Efectivo";

    }else if($opcion == 2){

      $opcion = "Tarjeta";

    }else if($opcion == 3){

      $opcion = "Nequi";

    }else if($opcion == 4){

      $opcion = "DaviPlata";

    }

    // Verificar si existen productos en el carrito para procesar el pago
    if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
        // Recuperar los datos del carrito y procesar el pago
        $carrito = $_SESSION['carrito'];
        $contar = "";
        $total1 = 0;


    
        foreach ($carrito as $producto_id => $producto) {

   
            $id = $producto['id'];
            $nombre = $producto['nombre'];
            $cantidad = $producto['cantidad'];
            $precio_unitario = $producto['precio'];

            $precio_total = $precio_unitario * $cantidad;

            $contar = $contar.$nombre.",";
            $total1 = $total1 + $precio_total;



            $sql = "INSERT INTO  historial (nombre,cantidad,precio_unitario,precio_total,pago) VALUES('$nombre','$cantidad','$precio_unitario','$precio_total','$opcion')";

            if($mensajero->query($sql)){

            
            }

            $sql2 = "SELECT cantidad FROM productos WHERE id='$id'";

            foreach ($mensajero->query($sql2) as $fila) {
                
                $cantidad_bd = $fila['cantidad'];

         


            }

            $cantidad_bd = $cantidad_bd-$cantidad;

                
            $sql3 = "UPDATE productos SET cantidad='$cantidad_bd' WHERE id='$id'";

            if($mensajero->query($sql3)){

            }

        // Vaciar la sesión 'carrito' después de completar el procesamiento del pago
        unset($_SESSION['carrito']);

        echo '<script>
        swal.fire({
            title: "Pago exitoso",
            text: "Productos pagados correctamente",
            icon: "success",
          });
    
        // Redireccionar a otra página después de 1.5 segundos
        setTimeout(function() {
            window.location.href = "ventas.php"; // Reemplaza "tu_otra_pagina.php" con la URL de la página a la que deseas redirigir
        }, 1500); // 1500 milisegundos = 1.5 segundos
    </script>';
        }
       
    
                        // Lógica de procesamiento de pago...
                        $porcentaje = ($descuento / $total1) * 100;
                        // Redondear a dos decimales
                        $porcentaje_redondeado = round($porcentaje, 1);
                        $n = "Descuento del ".$porcentaje_redondeado."% en [".$contar."] Productos";
                        $n_valor = $descuento*-1;
                
                
                        $sql6 = "INSERT INTO historial (nombre,cantidad,precio_unitario,precio_total,pago) VALUES('$n',1,'$total1','$n_valor','$opcion')";

                        if($mensajero->query($sql6)){

                        }


    } else {
        echo '<h3>No hay productos en el carrito para procesar el pago.</h3>';
    }


} else {
    
  $opcion = $_POST['opcion'];

  if($opcion == 1){

    $opcion = "Efectivo";

  }else if($opcion == 2){

    $opcion = "Tarjeta";

  }else if($opcion == 3){

    $opcion = "Nequi";

  }else if($opcion == 4){

    $opcion = "DaviPlata";

  }

  // Verificar si existen productos en el carrito para procesar el pago
  if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
      // Recuperar los datos del carrito y procesar el pago
      $carrito = $_SESSION['carrito'];

      // Lógica de procesamiento de pago...
      
  
      foreach ($carrito as $producto_id => $producto) {

 
          $id = $producto['id'];
          $nombre = $producto['nombre'];
          $cantidad = $producto['cantidad'];
          $precio_unitario = $producto['precio'];

          $precio_total = $precio_unitario * $cantidad;


          $sql = "INSERT INTO  historial (nombre,cantidad,precio_unitario,precio_total,pago) VALUES('$nombre','$cantidad','$precio_unitario','$precio_total','$opcion')";

          if($mensajero->query($sql)){

          
          }

          $sql2 = "SELECT cantidad FROM productos WHERE id='$id'";

          foreach ($mensajero->query($sql2) as $fila) {
              
              $cantidad_bd = $fila['cantidad'];

       


          }

          $cantidad_bd = $cantidad_bd-$cantidad;

              
          $sql3 = "UPDATE productos SET cantidad='$cantidad_bd' WHERE id='$id'";

          if($mensajero->query($sql3)){

          }

      // Vaciar la sesión 'carrito' después de completar el procesamiento del pago
      unset($_SESSION['carrito']);

      echo '<script>
      swal.fire({
          title: "Pago exitoso",
          text: "Productos pagados correctamente",
          icon: "success",
        });
  
      // Redireccionar a otra página después de 1.5 segundos
      setTimeout(function() {
          window.location.href = "ventas.php"; // Reemplaza "tu_otra_pagina.php" con la URL de la página a la que deseas redirigir
      }, 1500); // 1500 milisegundos = 1.5 segundos
  </script>';
      }
      // Lógica adicional de procesamiento de pago aquí (guardar en BD, enviar confirmación, etc.)
  } else {
      echo '<h3>No hay productos en el carrito para procesar el pago.</h3>';
  }

    
}


} else {
    // Si no se realizó el pago, muestra el carrito de compras normalmente
    mostrarCarrito();
}

/////////////////////////////////////////////////////////////////



if(isset($_POST['fiar'])){

  $nombre_deudor = $_POST['nombre_deudor'];

      // Verificar si existen productos en el carrito para procesar el pago
      if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
        // Recuperar los datos del carrito y procesar el pago
        $carrito = $_SESSION['carrito'];

        // Lógica de procesamiento de pago...
        
    
        foreach ($carrito as $producto_id => $producto) {

   
            $id = $producto['id'];
            $nombre = $producto['nombre'];
            $cantidad = $producto['cantidad'];
            $precio_unitario = $producto['precio'];

            $precio_total = $precio_unitario * $cantidad;

            $sql = "INSERT INTO  historial_deudores (nombre,nombre_producto,cantidad,precio_unitario,precio_total) VALUES('$nombre_deudor','$nombre','$cantidad','$precio_unitario','$precio_total')";

            if($mensajero->query($sql)){


            }

            $sql2 = "SELECT cantidad FROM productos WHERE id='$id'";

            foreach ($mensajero->query($sql2) as $fila) {
                
                $cantidad_bd = $fila['cantidad'];

         


            }

            $cantidad_bd = $cantidad_bd-$cantidad;

                
            $sql3 = "UPDATE productos SET cantidad='$cantidad_bd' WHERE id='$id'";

            if($mensajero->query($sql3)){

            }


            $sql4 = "SELECT SUM(precio_total) AS total_precio
            FROM historial_deudores
            WHERE nombre = '$nombre_deudor';";

            foreach($mensajero->query($sql4) as $fila){

              $totalidad = $fila['total_precio'];

            }

            $sql5 = "UPDATE deudores SET valor='$totalidad' WHERE nombre='$nombre_deudor'";

            if($mensajero->query($sql5)){

            }



        // Vaciar la sesión 'carrito' después de completar el procesamiento del pago
        unset($_SESSION['carrito']);

        echo '<script>
        swal.fire({
            title: "Pago exitoso",
            text: "Productos pagados correctamente",
            icon: "success",
          });
    
        // Redireccionar a otra página después de 1.5 segundos
        setTimeout(function() {
            window.location.href = "ventas.php"; // Reemplaza "tu_otra_pagina.php" con la URL de la página a la que deseas redirigir
        }, 1500); // 1500 milisegundos = 1.5 segundos
    </script>';
        }
        // Lógica adicional de procesamiento de pago aquí (guardar en BD, enviar confirmación, etc.)
    } else {
        echo '<h3>No hay productos en el carrito para procesar el pago.</h3>';
    }

}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Inventario - Carrito</title>

  <script>
      <?php
      $totalsito = 0;
      foreach ($_SESSION['carrito'] as $producto_id => $producto) {
        $subtotal = $producto['precio'] * $producto['cantidad'];
        $totalsito += $subtotal;
    
        echo '<tr class="producto" data-product-id="' . $producto_id . '">
                <td>' . $producto['nombre'] . '</td>
                <td><input type="number" class="cantidad" value="' . $producto['cantidad'] . '" min="1" data-product-id="' . $producto_id . '"></td>
                <td>$' . $producto['precio'] . '</td>
                <td>$' . $subtotal . '</td>
                <td><a href="eliminar_producto.php?id=' . $producto_id . '">Eliminar</a></td>
              </tr>';
      }
      ?>
    
    
    
    </script>
  
  <script src="../js/jquery.js"></script>
 

  <!-- Modal para el formulario -->
<div class="modal" id="myModal" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form action="carrito.php" method="post" enctype="multipart/form-data">
          
          <div class="form-group">
            <label for="nombredeudor">Seleccione el deudor:</label>
            

            <?php
            $sqldeudor = "SELECT * FROM deudores ";
            
            echo'<select name="nombre_deudor" id="nombre_deudor" class="form-control" required>';

            foreach ($mensajero ->query($sqldeudor) as $fila) {
              
              $nombre_bd = $fila['nombre'];

              $telefono_bd = $fila['telefono'];

              $valor_bd = $fila['valor'];

              
              
                 echo  '<option value="'.$nombre_bd.'">'.$nombre_bd.'</option>';

                   

            }
            echo '</select>';
            
            ?>
    
           


          </div>


      

          </div>
          

          </div>
          <br>
          <div class="form-group">
            <input type="submit" name="fiar" value="Pagar fiado" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




<!-- Modal para opciones de pago-->
<div class="modal" id="editModal" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
      <form action="carrito.php" method="post" enctype="multipart/form-data">
  <!-- Campos para editar -->
  <div class="form-group">
    <label for="edit_nombre_producto">Seleccione el método de pago:</label>
    <select id="opcion" name="opcion" class="form-control" required>
      <option value="1">Efectivo</option>
      <option value="2">Tarjeta</option>
      <option value="3">Nequi</option>
      <option value="4">DaviPlata</option>
    </select>
  </div>

  <!-- Checkbox para activar/desactivar descuento -->
  <div class="form-group">
    <label>
      <input type="checkbox" id="activarDescuento" onchange="mostrarOcultarDescuento()"> Aplicar Descuento
    </label>
  </div>

  <!-- Campo de descuento (inicialmente oculto) -->
  <div class="form-group" id="campoDescuento" style="display:none;">
    <label for="descuento">Digite el descuento:</label>
    <input type="number" name="descuento" id="descuento" class="form-control" oninput="validarDescuento()" min="1">
    <span id="mensajeError" style="color: red;"></span> <!-- Mensaje de error -->

  </div>

  <div class="form-group">
    <input type="submit" name="pagar" id="btnPagar" value="Pagar" class="btn btn-primary">
  </div>
</form>
      </div>
    </div>
  </div>
</div>

<script>
function mostrarOcultarDescuento() {
  var campoDescuento = document.getElementById('campoDescuento');
  var activarDescuento = document.getElementById('activarDescuento');
  var descuentoInput = document.getElementById('descuento');
  

  if (activarDescuento.checked) {
    campoDescuento.style.display = 'block';

  // Llamar a validarDescuento() después de mostrar/ocultar para refrescar la validación
  validarDescuento();

  } else {
    campoDescuento.style.display = 'none';
    descuentoInput.value = ''; // Limpiar el valor del campo de descuento
  }


}

function validarDescuento() {
  var descuentoInput = document.getElementById('descuento');
  var btnPagar = document.getElementById('btnPagar');
  var mensajeError = document.getElementById('mensajeError');
  var total = <?php echo $totalsito; ?>;

  console.log("Valor del descuento: " + descuentoInput.value);

  // Verifica si el descuento es menor al total
  if (descuentoInput.value > total) {
    mensajeError.innerHTML = "El descuento debe ser menor o igual al total.";
    btnPagar.disabled = true; // Desactiva el botón de enviar
  } else if (descuentoInput.value < 1) {
    mensajeError.innerHTML = "El descuento debe ser mayor a cero.";
    btnPagar.disabled = true; // Desactiva el botón de enviar
  } else {
    mensajeError.innerHTML = ""; // Limpia el mensaje de error
    btnPagar.disabled = false; // Activa el botón de enviar
  }
}
</script>



<script>
  // Script para abrir el modal
  function abrirModal() {
    // Mostrar el modal de abonar
    document.getElementById("editModal").style.display = "block";

    // Agregar un evento de clic al fondo oscuro del modal para cerrarlo
    window.onclick = function (event) {
      var modal = document.getElementById("editModal");
      if (event.target == modal) {
        cerrarModal();
      }
    };
  }

  // Script para cerrar el modal
  function cerrarModal() {
    // Ocultar el modal de abonar
    document.getElementById("editModal").style.display = "none";

    // Eliminar el evento de clic en el fondo oscuro para evitar conflictos
    window.onclick = null;
  }

  // También puedes cerrar el modal al hacer clic en el botón de cierre del modal
  document.getElementsByClassName("close")[1].onclick = function () {
    cerrarModal();
  };
</script>


<!-- Dentro del head de carrito.php -->
<script src="../js/jquery.js"></script>


<script>
  // Obtener el botón "Crear mesa" por su ID
  var createTableBtn = document.getElementById("createTableBtn");

  // Obtener el modal por su ID
  var modal = document.getElementById("myModal");

  // Cuando se hace clic en el botón, mostrar el modal
  createTableBtn.onclick = function() {
    modal.style.display = "block";
  }

  // Cuando se hace clic en la 'x' del modal, cerrarlo
  document.getElementsByClassName("close")[0].onclick = function() {
    modal.style.display = "none";
  }

  // Cuando el usuario hace clic fuera del modal, cerrarlo
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>






</head>
<body>
</body>
</html>



