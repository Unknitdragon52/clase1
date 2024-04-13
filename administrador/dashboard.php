<html><link rel="icon" href="../images/config/defecto.png" type="../images/x-icon"> <!-- Agrega los enlaces a SweetAlert2 -->
<script src="../alert2/sweetalert2.all.min.js"></script></html>
<?php
require '../config/conex.php';
session_start(); // Iniciar la sesión


$usuario = $_SESSION['usuario'];
$clave = $_SESSION['password'];
$p_nombre = $_SESSION['p_nombre'];
$s_nombre = $_SESSION['s_nombre'];
$p_apellido = $_SESSION['p_apellido'];
$s_apellido = $_SESSION['s_apellido'];


if(isset($_POST['enviar'])) {
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $cantidad = $_POST['cantidad'];
    $valor = $_POST['valor'];

    // Variables para la imagen
    $imagen_nombre = isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : ''; // Verifica si se envió un archivo
    $imagen_temp = isset($_FILES['imagen']['tmp_name']) ? $_FILES['imagen']['tmp_name'] : '';
    $ruta_imagen = '../images/';

    // Verificar si se ha enviado un archivo
    if (!empty($imagen_nombre) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $ruta_imagen .= $imagen_nombre;

        // Mover la imagen a la carpeta '../images'
        if (move_uploaded_file($imagen_temp, $ruta_imagen)) {
            
            
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        // No se subió ninguna imagen, usar imagen por defecto
        $ruta_imagen .= 'config/defecto.png';
       
    }


    $nuevaRuta = str_replace('../', '', $ruta_imagen);


    $sql2 = "INSERT INTO productos (usuario,nombre,descripcion,cantidad,precio,imagen) VALUES('$usuario','$nombre_producto','$descripcion_producto','$cantidad','$valor','$nuevaRuta')";

    if($mensajero->query($sql2)){

        echo '<script>
        swal.fire({
            title: "Registro exito",
            text: "producto registrado correctamente",
            icon: "success",
          });
        </script>';
    }

}







?>


<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Inventario - Stock</title>
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

  

<!-- Cambios en la barra de búsqueda -->
<div class="search-bar">
<button class="create-table-btn" id="createTableBtn">Añadir al Stock</button>
    <form id="searchForm" method="post" action="dashboard.php">
        
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
    margin: 5% auto; /* Ajusta el margen superior */
    top: -5%; /* O ajusta el valor de top directamente */
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
        <form action="dashboard.php" method="post" enctype="multipart/form-data">
          
          <div class="form-group">
            <label for="nombreproducto">Nombre:</label>
            <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" required>
            <label for="descripcion_producto">Descripción:</label><br>
            <textarea id="descripcion_producto" name="descripcion_producto" class="form-control"></textarea>

          </div>
          <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" class="form-control"  required>

      

          </div>
          <div class="form-group">
            <label for="valor">Precio:</label>
            <input type="number" id="valor" name="valor" class="form-control"  required>

            <label for="imagen">Imagen:</label><br>
      <input type="file" id="imagen" name="imagen" class="form-control">

          </div>
          <div class="form-group">
            <input type="submit" name="enviar" value="Añadir" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


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
        <form action="dashboard.php" method="post" enctype="multipart/form-data" onsubmit="return enviarDatos();">
          <!-- Campos para editar -->
          <div class="form-group">
            <input type="hidden" id="edit_bd_id" name="edit_bd_id" value="">
            <label for="edit_nombre_producto">Nombre:</label>
            <input type="text" id="edit_nombre_producto" name="edit_nombre_producto" class="form-control" required>

            <label for="descripcion_editar">Descripción:</label><br>
            <textarea id="descripcion_editar" name="descripcion_editar" class="form-control"></textarea>

            <label for="cantidad_editar">Cantidad:</label>
            <input type="number" id="cantidad_editar" name="cantidad_editar" class="form-control" required>

            <label for="valor_editar">Precio:</label>
            <input type="number" id="valor_editar" name="valor_editar" class="form-control" required><br>

            <!-- Campo oculto para almacenar la ruta de la imagen actual -->
            <br><input type="hidden" id="imagen_actual" name="imagen_actual" value="">
            
            <!-- Etiqueta para mostrar la imagen actual -->
            <img id="imagen_actual_preview" src="" alt="Imagen actual" style="max-width: 100px; max-height: 100px; margin-bottom: 10px;">

            <!-- Campo para seleccionar una nueva imagen -->
            <br><label for="imagen_editar">Nueva Imagen:</label><br>
            <input type="file" id="imagen_editar" name="imagen_editar" class="form-control">
          </div>
          <div class="form-group">
            <input type="submit" name="editar_" value="Guardar cambios" class="btn btn-primary">
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






<?php


// Obtener el número total de productos
$sql_total_productos = "SELECT COUNT(*) as total FROM productos WHERE usuario=:usuario";
$stmt_total = $mensajero->prepare($sql_total_productos);
$stmt_total->bindParam(':usuario', $usuario, PDO::PARAM_STR);
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
$sqlproductos = "SELECT * FROM productos 
                 WHERE usuario=:usuario";

// Añadir la condición de búsqueda si existe
if (!empty($buscar)) {
  $sqlproductos .= " AND (nombre LIKE :buscar OR descripcion LIKE :buscar)";
}

$sqlproductos .= " ORDER BY nombre ASC LIMIT :inicio, :productos_por_pagina";

$stmt_productos = $mensajero->prepare($sqlproductos);
$stmt_productos->bindParam(':usuario', $usuario, PDO::PARAM_STR);

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

  $bd_imagen2 = "../".$bd_imagen;


 
  $color = '';
  if($bd_cantidad <6){
    $color = "class='color'";
  }

// Verificar si $bd_imagen contiene "../"
if (strpos($bd_imagen, "../") !== false) {
  // Si $bd_imagen contiene "../", usar $bd_imagen directamente
  $imagen_source = $bd_imagen;
}else if(strpos($bd_imagen, "//") !== false){
  // Si $bd_imagen contiene "../", usar $bd_imagen directamente
  $imagen_source = $bd_imagen;
} else {
  // Si no contiene "../", usar $bd_imagen2
  $imagen_source = $bd_imagen2;
}

echo '<form method="post" action="dashboard.php">
<div class="card">
    <h1>' . $bd_nombre . '</h1>
    <i><img width="100px" src="' . $bd_imagen2 . '" alt=""></i>
    <h3>Descripción:<br></h3>
    <h5>' . $bd_descripcion . '</h5>
    <h3 '.$color.'> Cantidad: ' . $bd_cantidad . '</h3>
    <h3> Valor: $' . $bd_precio . ' COP</h3>
    <button type="button" class="edit-button" data-toggle="modal" data-target="#editModal" data-productid="' . $bd_id . '" data-img1 ="'.$bd_imagen2.'">Editar</button>
    <button type="submit" name="Eliminar" value="' . $bd_id . '" class="confirm-button">Eliminar</button>
</div>
</form>';
  


}


if(isset($_POST['Eliminar'])){
  $id = $_POST['Eliminar'];

  // Verificar si la eliminación ya se realizó
  if(!isset($_SESSION['eliminacion_realizada'])){
      // Mostrar una ventana emergente de SweetAlert2 para confirmar la eliminación
      echo '<script>
          Swal.fire({
              title: "¿Estás seguro?",
              text: "Esta acción eliminará el registro. ¿Estás seguro de continuar?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Sí, eliminar",
              cancelButtonText: "Cancelar"
          }).then((result) => {
              if (result.isConfirmed) {
                  var id = "' . $id . '"; // Obtener el ID del producto a eliminar
                  // Enviar una solicitud AJAX para eliminar el registro
                  var xhr = new XMLHttpRequest();
                  xhr.open("POST", "eliminar.php", true);
                  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                  xhr.onload = function() {
                      if(xhr.status === 200) {
                          var respuesta = JSON.parse(xhr.responseText);
                          if(respuesta.success) {
                              Swal.fire("¡Eliminado!", "El producto ha sido eliminado.", "success")
                                  .then(() => {
                                      // Marcar que la eliminación se ha realizado
                                      delete window.sessionStorage.eliminacion_realizada;
                                      window.location.reload(); // Recargar la página
                                  });
                          } else {
                              Swal.fire("Error", "Hubo un error al eliminar el producto.", "error");
                          }
                      }
                  };
                  xhr.send("Eliminar=" + id);
              } else {
                  Swal.fire("Cancelado", "La eliminación ha sido cancelada.", "info");
              }
          });
      </script>';

      // Marcar que la eliminación se ha realizado para evitar repeticiones
      $_SESSION['eliminacion_realizada'] = true;
  } else {
      // Eliminar la variable de sesión si ya se ha eliminado un artículo
      unset($_SESSION['eliminacion_realizada']);
  }
}







if(isset($_POST['editar_'])) {
  
  // Recuperar los datos del formulario
  $bd_id = $_POST['edit_bd_id']; // Recuperar el ID del producto

  // Recuperar otros datos del formulario
  $edit_nombre_producto = $_POST['edit_nombre_producto'];
  $descripcion_editar = $_POST['descripcion_editar'];
  $cantidad_editar = $_POST['cantidad_editar'];
  $valor_editar = $_POST['valor_editar'];
  $imagen_actual = $_POST['imagen_actual'];
  //Nueva imagen
  $nueva_imagen = $_FILES['imagen_editar']['name'];


  //Validacion de que las variables no esten vacias//
if (empty($nueva_imagen)) {
  
  $nueva_imagen = $imagen_actual;

}

move_uploaded_file($_FILES['imagen_editar']['tmp_name'], '../images/' . $nueva_imagen);

if (strpos($nueva_imagen, "images/") === false) {
  // Agregar el texto "images/"
  $nueva_imagen = 'images/' . $nueva_imagen;
}

$nueva_imagen = str_replace('../', '', $nueva_imagen);

$sq = "UPDATE productos SET usuario='$usuario', nombre='$edit_nombre_producto',descripcion='$descripcion_editar',cantidad='$cantidad_editar',precio='$valor_editar',imagen='$nueva_imagen' WHERE id='$bd_id'";


if($mensajero->query($sq)){

  echo '<script>
  swal.fire({
      title: "Actualización exitosa",
      text: "producto actualizado correctamente",
      icon: "success",
  });

  // Esperar 1.5 segundos y luego redirigir
  setTimeout(function() {
    window.location.href = "dashboard.php"; // Reemplaza "tu_otra_pagina.php" con la URL deseada
  }, 1500);
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












<!-- Asegúrate de incluir SweetAlert y jQuery -->
<script src="../js/jquery.js"></script>

<!-- Tu código HTML y otros scripts -->

</form>
     



    </section>

    
  </div>


  <script>
function openEditModal() {
  // Obtener el modal de edición por su ID
  var editModal = document.getElementById("editModal");
  editModal.style.display = "block";

  // Obtener el botón de cerrar del modal
  var closeButton = editModal.querySelector('.close');
  closeButton.addEventListener('click', function() {
    editModal.style.display = "none";
  });

  // Cerrar el modal si se hace clic fuera de él
  window.onclick = function(event) {
    if (event.target == editModal) {
      editModal.style.display = "none";
    }
  }

  // Obtener el botón que activó el modal
  var button = this;
  var productId = button.getAttribute("data-productid");
  var productName = button.parentElement.querySelector('h1').innerText;
  var productDescription = button.parentElement.querySelector('h5').innerText;
  var productQuantity = button.parentElement.querySelector('h3:nth-of-type(2)').innerText;
  var productPrice = button.parentElement.querySelector('h3:nth-of-type(3)').innerText;
  var productImage = button.parentElement.querySelector('img').src; // Obtener la URL de la imagen
  var productimg1 = button.getAttribute("data-img1");

  // Rellenar los campos del formulario con los datos actuales
  document.getElementById('edit_bd_id').value = productId;
  document.getElementById('edit_nombre_producto').value = productName;
  document.getElementById('descripcion_editar').value = productDescription;
  document.getElementById('cantidad_editar').value = parseInt(productQuantity.split(': ')[1]);
  document.getElementById('valor_editar').value = parseFloat(productPrice.split('$')[1]);

  // Mostrar la imagen actual en el modal
  document.getElementById('imagen_actual_preview').src = productImage;
  // Almacenar la ruta de la imagen actual en el campo oculto
  document.getElementById('imagen_actual').value = productimg1;

  // Mostrar el modal de edición
  $('#editModal').modal('show');
}

// Obtener todos los botones de editar y agregar un evento de clic a cada uno
var editButtons = document.querySelectorAll('.edit-button');
editButtons.forEach(function(button) {
  button.addEventListener('click', openEditModal);
});
</script>




</body>
</html></span>