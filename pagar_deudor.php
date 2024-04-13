<html><link rel="icon" href="images/config/defecto.png" type="images/x-icon"><script src="alert2/sweetalert2.all.min.js"></script></html>
<?php
require 'config/conex.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener información del deudor
    $stmt = $mensajero->prepare("SELECT * FROM deudores WHERE id = ?");
    $stmt->execute([$id]);
    $deudor = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($deudor) {

      if($deudor['valor'] == 0){

        echo '<script>
        Swal.fire({
            title: "Error",
            text: "No puedes pagar una cuenta de cero.",
            icon: "error",
        }).then(() => {
            window.location.href = "deudores.php";
        });
      </script>';



      }else{

        $nombre = $deudor['nombre'];
        $telefono = $deudor['descripcion'];
        $valor = $deudor['valor'];

        // Actualizar información del deudor (aquí puedes realizar la lógica de pago)
        $nuevoValor = 0; // Puedes establecer aquí la lógica de pago según tus necesidades

        $stmt = $mensajero->prepare("UPDATE deudores SET valor = ? WHERE id = ?");
        $stmt->execute([$nuevoValor, $id]);

        echo '<script>
                Swal.fire({
                    title: "Pago exitoso",
                    text: "Se ha realizado el pago de la cuenta de ' . $nombre . '.",
                    icon: "success",
                }).then(() => {
                    window.location.href = "deudores.php";
                });
              </script>';

                
        $sql = "SELECT * FROM historial_deudores WHERE nombre ='$nombre'";
        
        foreach($mensajero->query($sql) as $fila){

                $producto = $fila['nombre_producto'];

                $cantidad = $fila['cantidad'];

                $precio_unitario = $fila['precio_unitario'];

                $precio_total = $fila['precio_total'];

                $fecha = $fila['fecha'];

                $hora = $fila['hora'];



        
            }

            $name="Deudor ".$nombre;

            $sql2 = "INSERT INTO `historial` (`nombre`, `cantidad`, `precio_unitario`, `precio_total`, `pago`)
            VALUES ('$name', 1, '$valor', '$valor','Efectivo');";
      
            if($mensajero->query($sql2)){
      
            }


            $sql4 = "SELECT nombre FROM deudores WHERE id = '$id'";

            foreach ($mensajero->query($sql4) as $fila3) {
      
              $nn = $fila3['nombre'];
              
            }
      
            $sql5 = "DELETE FROM historial_deudores WHERE nombre='$nn'";
      
            if($mensajero->query($sql5)){
              
            }

      }



        
        

    } else {
        // El deudor no existe
        echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "El deudor no existe.",
                    icon: "error",
                }).then(() => {
                    window.location.href = "deudores.php";
                });
              </script>';
    }
} else {
    // ID no proporcionado o no es válido
    echo '<script>
            Swal.fire({
                title: "Error",
                text: "ID de deudor no válido.",
                icon: "error",
            }).then(() => {
                window.location.href = "deudores.php";
            });
          </script>';
}
?>

<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Inventario - Stock</title>
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

        <li><a href="#">
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
  <button class="create-table-btn" id="createTableBtn">Añadir deudor</button>
  <input type="text" id="searchInput" placeholder="Buscar por nombre">
</div>




  
</div>
<br>

<?php



$sqldeudores = "SELECT * FROM deudores ORDER BY id ASC;";



echo '<table id="tablaDeudores" border="1">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Valor</th>
          <th>Detalles</th>
          <th>Abonar</th>
          <th>Pago</th>
          <th>Eliminar</th>
        </tr>';

foreach ($mensajero->query($sqldeudores) as $fila) {

    

    $bd_id = $fila['id'];
    $bd_nombre = $fila['nombre'];
    $bd_telefono = $fila['descripcion'];
    $bd_valor = $fila['valor'];

    $sqlvalor = "SELECT valor AS total_precio
FROM deudores
WHERE nombre = '$bd_nombre';";

foreach($mensajero->query($sqlvalor) as $fila2){

  $bd_valor = $fila2['total_precio'];

}



    echo '<tr>
            <td>' . $bd_id . '</td>
            <td>' . $bd_nombre . '</td>
            <td>' . $bd_telefono . '</td>
            <td>' . $bd_valor . '</td>
            <td>
              <form method="post" action="deudores.php">
                <input type="hidden" name="id" value="' . $bd_id . '">
                <input type="hidden" name="nombre" value="' . $bd_nombre . '">
                <input type="hidden" name="telefono" value="' . $bd_telefono . '">
                <input type="hidden" name="valor" value="' . $bd_valor . '">
                <input type="submit" id="detalles" name="detalles" value="Detalles">
              </form>
            </td>

            <td>
            <button id="abonoBtn"  onclick="abrirModal('.$bd_id.')">Abono</button>
            </td>

            <td>
            <button id="pagar" onclick="confirmarPagar(' . $bd_id . ', \'' . $bd_nombre . '\', ' . $bd_valor . ')">Pagar</button>
            </td>



            <td>
            <button id="eliminar" onclick="confirmarEliminar(' . $bd_id . ', \'' . $bd_nombre . '\')">Eliminar</button>
          </td>

          </tr>';
}

echo '</table>';
?>

<script>
var searchInput = document.getElementById('searchInput');
var tableRows = document.querySelectorAll('#tablaDeudores tr');

searchInput.addEventListener('input', function () {
    var filter = searchInput.value.trim().toUpperCase(); // Obtener el texto de búsqueda y convertirlo a mayúsculas

    // Filtrar las filas de la tabla
    tableRows.forEach(function (row) {
        var nombreColumna = row.cells[1].innerText.toUpperCase(); // Suponiendo que la columna del nombre es la segunda (índice 1)

        // Comprobar si el nombre de la fila coincide con el texto de búsqueda
        if (nombreColumna.indexOf(filter) > -1) {
            row.style.display = ''; // Mostrar la fila si coincide
        } else {
            row.style.display = 'none'; // Ocultar la fila si no coincide
        }
    });
});
</script>

<script>
// Función para mostrar SweetAlert2 y confirmar la eliminación
function confirmarEliminar(id, nombre) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Estás a punto de eliminar a ' + nombre + '.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, redirige el formulario para procesar la eliminación
            window.location.href = 'eliminar_deudor.php?id=' + id;
        }
    });
}
</script>

<script>
// Función para mostrar SweetAlert2 y confirmar el pago
function confirmarPagar(id, nombre, valor) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas pagar la cuenta de ' + nombre + ' por un monto de $' + valor + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, pagar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, redirige el formulario para procesar el pago
            window.location.href = 'pagar_deudor.php?id=' + id;
        }
    });
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

  #pagar,#abonobtn {
    background-color: #4CAF50;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  #pagar:hover,#abonobtn:hover {
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

</style>


  






      <div class="main-skills">


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
        <form action="deudores.php" method="post" enctype="multipart/form-data">
          
          <div class="form-group">
            <label for="nombreproducto">Nombre:</label>
            <input type="text" id="nombre_producto" name="nombre_deudor" class="form-control" required>


          </div>


      

          </div>
          <label for="celular">Telefono</label>
          <input type="number" name="celular" id="celular" class="form-control" required>
          

          </div>
          <br>
          <div class="form-group">
            <input type="submit" name="enviar" value="Añadir" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal para abonar-->
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
        <form action="deudores.php" method="post" enctype="multipart/form-data" >
          <!-- Campos para editar -->
          <div class="form-group">
            <input type="hidden" id="edit_bd_id" name="edit_bd_id" value="">
            <label for="edit_nombre_producto">Digite la cantidad que desea abonar:</label>
            <input type="number" id="edit_abonar" name="edit_abonar" class="form-control" required>


          

          </div>
          <div class="form-group">
            <input type="submit" name="abonar_" value="Abonar" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


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




<script>
  // Script para abrir el modal
  function abrirModal(id) {
    // Asignar el valor del ID al campo de ID en el formulario de abonar
    document.getElementById("edit_bd_id").value = id;

    
    // Mostrar el modal de abonar
    document.getElementById("editModal").style.display = "block";
  }

  // Script para cerrar el modal
  function cerrarModal() {
    // Ocultar el modal de abonar
    document.getElementById("editModal").style.display = "none";
  }

  // También puedes cerrar el modal al hacer clic en el botón de cierre del modal
  document.getElementsByClassName("close")[1].onclick = function() {
    cerrarModal();
  };
</script>







<!-- Asegúrate de incluir SweetAlert y jQuery -->
<script src="js/jquery.js"></script>
<script src="alert2/sweetalert2.all.min.js"></script>


<!-- Tu código HTML y otros scripts -->

</form>
     



    </section>
  </div>



</body>
</html></span>
