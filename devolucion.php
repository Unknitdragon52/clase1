<html><link rel="icon" href="images/config/defecto.png" type="images/x-icon"> <!-- Agrega los enlaces a SweetAlert2 -->
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


<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Inventario - Devolución</title>
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
  <form id="searchForm" method="post" action="devolucion.php">
        
        <input type="text" name="buscar" id="searchInput" placeholder="Buscar por nombre" value="<?php echo isset($_POST['buscar']) ? htmlspecialchars($_POST['buscar']) : ''; ?>">
        <button type="submit" class="button-blue">Buscar</button>
    </form>
  </div>


  
</div>

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
</style>


  






      <div class="main-skills">



<!-- Modal para editar producto -->
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
      <form action="devolucion.php" method="post" enctype="multipart/form-data">
          <!-- Campos para editar -->
          <div class="form-group">
          
          <input type="hidden" id="edit_bd_id" name="edit_bd_id" value="">

            <label for="cantidad_editar">Cantidad:</label>
            <input type="number" id="cantidad_editar" name="cantidad_editar" class="form-control" min="1"  required>

    <label for="edit_nombre_producto">Seleccione el método de devolución:</label>
    <select id="opcion" name="opcion" class="form-control" required>
      <option value="1">Efectivo</option>
      <option value="2">Tarjeta</option>
      <option value="3">Nequi</option>
      <option value="4">DaviPlata</option>
    </select>

          </div>
          <div class="form-group">
            <input type="submit" name="devolver" value="Devolver" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>






<?php
// Obtener el número total de productos
$sql_total_productos = "SELECT COUNT(*) as total FROM productos";
$stmt_total = $mensajero->prepare($sql_total_productos);
$stmt_total->execute();
$total_productos = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];

// Establecer el límite de productos por página
$productos_por_pagina = 20;

// Calcular el número total de páginas
$total_paginas = ceil($total_productos / $productos_por_pagina);

// Obtener el número de página actual
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el índice de inicio para la consulta SQL
$indice_inicio = ($pagina_actual - 1) * $productos_por_pagina;

// Obtener el término de búsqueda
$buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';

// Modificar la consulta SQL para aplicar la búsqueda
$sqlproductos = "SELECT * FROM productos";

// Añadir la condición de búsqueda si existe
if (!empty($buscar)) {
  $sqlproductos .= " WHERE nombre LIKE :buscar OR descripcion LIKE :buscar";
}

$sqlproductos .= " ORDER BY nombre ASC LIMIT :inicio, :productos_por_pagina";

$stmt_productos = $mensajero->prepare($sqlproductos);

// Añadir parámetro de búsqueda solo si hay un término de búsqueda
if (!empty($buscar)) {
  $stmt_productos->bindValue(':buscar', '%' . $buscar . '%', PDO::PARAM_STR);
}

$stmt_productos->bindParam(':inicio', $indice_inicio, PDO::PARAM_INT);
$stmt_productos->bindParam(':productos_por_pagina', $productos_por_pagina, PDO::PARAM_INT);
$stmt_productos->execute();
$result_productos = $stmt_productos->fetchAll(PDO::FETCH_ASSOC);


foreach ($result_productos as $fila) {
  $bd_id = $fila['id'];
  
  $bd_usuario = $fila['usuario'];

  $bd_nombre = $fila['nombre'];

  $bd_descripcion = $fila['descripcion'];

  $bd_cantidad = $fila['cantidad'];

  $bd_precio = $fila['precio'];

  $bd_imagen = $fila['imagen'];




  echo '
  <form method="post" action="dashboard.php">
      <div class="card">
          <h1>' . $bd_nombre . '</h1>
          <i><img width="100px" src="'.$bd_imagen.'" alt=""></i>
          
          <h3>Descripción:<br></h3>
          <h5>' . $bd_descripcion . '</h5>
          <h3>Valor:  $' . $bd_precio . ' COP</h3>
          <button type="button" class="edit-button" data-toggle="modal" data-target="#editModal" data-productid="' . $bd_id . '">Devolver</button>
      </div>
  </form>';
  


}






if(isset($_POST['devolver'])) {
  
  // Recuperar los datos del formulario
  $bd_id = $_POST['edit_bd_id']; // Recuperar el ID del producto

  // Recuperar otros datos del formulario
  $cantidad_devolucion = $_POST['cantidad_editar'];

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

  // Aquí puedes realizar las acciones que desees con los datos recuperados
  // Por ejemplo, actualizar los datos en la base de datos usando $bd_id


  $sql = "SELECT * FROM productos WHERE id='$bd_id'";

  foreach ($mensajero ->query($sql) as $fila) {

    $nombre_bd = $fila['nombre'];

    $precio_bd = $fila['precio'];

    $cantidad_bd = $fila['cantidad'];

  }

  $precio_total = ($precio_bd * $cantidad_devolucion)* -1;

  $nombre_def = "[".$nombre_bd."] Producto Devuelto";

  




$sql = "INSERT INTO historial (nombre,cantidad,precio_unitario,precio_total,pago) VALUES('$nombre_def','$cantidad_devolucion','$precio_bd','$precio_total','$opcion')";

$cantidad_actualizada = $cantidad_bd + $cantidad_devolucion;

$sql2 = "UPDATE productos SET cantidad='$cantidad_actualizada' WHERE id='$bd_id' ";

if($mensajero->query($sql2)){

}


  
  if($mensajero->query($sql)){

    echo '<script>
    swal.fire({
        title: "Devolución exitosa",
        text: "Producto devuelto correctamente",
        icon: "success",
      });

    // Redireccionar a otra página después de 1.5 segundos
    setTimeout(function() {
        window.location.href = "devolucion.php"; // Reemplaza "tu_otra_pagina.php" con la URL de la página a la que deseas redirigir
    }, 1500); // 1500 milisegundos = 1.5 segundos
</script>';


  }
  

}



// Enlaces de paginación
echo '<div class="pagination-container">';
echo '<div class="pagination">';
for ($i = 1; $i <= $total_paginas; $i++) {
    // Construir la cadena de consulta solo con el parámetro de la página
    $pagina_url = '?pagina=' . $i;

    // Agregar el parámetro de búsqueda solo si está presente
    if (!empty($buscar)) {
        $pagina_url .= '&buscar=' . urlencode($buscar);
    }

    echo '<a href="' . $pagina_url . '">#' . $i . ' Pagina</a>';
}
echo '</div>';
echo '</div>';


?>



<script>
function openEditModal() {
  var editModal = document.getElementById("editModal");
  editModal.style.display = "block";

  var closeButton = editModal.querySelector('.close');
  closeButton.addEventListener('click', function() {
    editModal.style.display = "none";
  });

  window.onclick = function(event) {
    if (event.target == editModal) {
      editModal.style.display = "none";
    }
  }

  var button = this;
  var productId = button.getAttribute("data-productid");
  document.getElementById('edit_bd_id').value = productId;

}



var editButtons = document.querySelectorAll('.edit-button');
editButtons.forEach(function(button) {
  button.addEventListener('click', openEditModal);
});
</script>






<!-- Asegúrate de incluir SweetAlert y jQuery -->
<script src="alert2/sweetalert2.all.min.js"></script>
<script src="js/jquery.js"></script>

<!-- Tu código HTML y otros scripts -->

</form>
     



    </section>
  </div>



</body>
</html></span>