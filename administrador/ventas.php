<html><link rel="icon" href="../images/config/defecto.png" type="image/x-icon"> <!-- Agrega los enlaces a SweetAlert2 -->
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

// Después del bucle PHP que muestra los productos...
echo <<<EOD
<script>
// Agrega un evento 'submit' a los formularios de agregar al carrito
document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', async function(event) {
    event.preventDefault(); // Evita que se envíe el formulario por defecto

    // Realiza una solicitud AJAX para verificar si se puede agregar al carrito
    const formData = new FormData(this);
    const response = await fetch('agregar_al_carrito.php', {
      method: 'POST',
      body: formData
    });

    const data = await response.text();

    // Si la respuesta contiene el mensaje de alerta, muestra SweetAlert2
    if (data.includes('Ya has alcanzado el máximo de stock disponible para este producto.')) {
      Swal.fire({
        icon: 'warning',
        title: 'Stock máximo alcanzado',
        text: 'Ya has alcanzado el máximo de stock disponible para este producto.',
        confirmButtonText: 'Entendido'
      });
    } else {
      // Si no hay mensaje de alerta, redirige o maneja la lógica según sea necesario
      window.location.href = 'ventas.php'; // Redirige a la página de ventas después de agregar al carrito
    }
  });
});
</script>
EOD;





?>


<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Inventario - Ventas</title>
  <link rel="stylesheet" href="../css/inicio.css" />

  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

  <script>
document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', async function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    const response = await fetch('agregar_al_carrito.php', {
      method: 'POST',
      body: formData
    });

    const data = await response.json(); // Asegúrate de recibir una respuesta JSON

    if (data && data.message) {
      Swal.fire({
        icon: 'warning',
        title: 'Stock máximo alcanzado',
        text: data.message,
        confirmButtonText: 'Entendido'
      });
    } else {
      window.location.href = 'ventas.php';
    }
  });
});
</script>

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
  <button class="create-table-btn"  id="carrito">Carrito</button>

  <form id="searchForm" method="post" action="ventas.php">
        
        <input type="text" name="buscar" id="searchInput" placeholder="Buscar por nombre" value="<?php echo isset($_POST['buscar']) ? htmlspecialchars($_POST['buscar']) : ''; ?>">
        <button type="submit" class="button-blue">Buscar</button>
    </form>

  </div>

  <script>
  // Obtener el botón de "Carrito"
  var carritoBtn = document.getElementById('carrito');

  // Agregar un evento de clic al botón
  carritoBtn.addEventListener('click', function() {
    // Redireccionar a la página de carrito.php
    window.location.href = 'carrito.php';
  });
</script>



  
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
.color{
  color: red;
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



</style>


  






      <div class="main-skills">






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
 
$color = '';
if($bd_cantidad <6){
  $color = "class='color'";
}

  echo '
  <form method="post" action="agregar_al_carrito.php">
      <div class="card">
          <h1>' . $bd_nombre . '</h1>
          <i><img width="100px" src="'.$imagen_source.'" alt=""></i>
          <h3>Descripción:<br></h3>
          <h5>' . $bd_descripcion . '</h5>
          <h3 '.$color.'>Cantidad: ' . $bd_cantidad .'</h3>
          <h3>Valor:  $' . $bd_precio . ' COP</h3>
          <input type="hidden" name="nombre_producto" value="'.$bd_nombre.'">
          <input type="hidden" name="precio_producto" value="'.$bd_precio.'">
          <button type="submit" name="Carrito" value="' . $bd_id . '" class="confirm-button">Añadir al carrito</button>


          
      </div>
  </form>';

  
  


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
<script src="../alert2/sweetalert2.all.min.js"></script>
<script src="../js/jquery.js"></script>

<!-- Tu código HTML y otros scripts -->

</form>
     



    </section>
  </div>



</body>
</html></span>