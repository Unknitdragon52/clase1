<html><link rel="icon" href="images/config/defecto.png" type="images/x-icon"> <!-- Agrega los enlaces a SweetAlert2 -->
<script src="alert2/sweetalert2.all.min.js"></script></html>
<?php
require 'config/conex.php';
session_start(); // Iniciar la sesión



if(isset($_POST['user'])){

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

  $descripcion = $_POST['descripcion'];

  $valor= $_POST['valor'];

  $valor = $valor * 1;

  $precio_unitario = $valor * 1;

  $nombre_def = "[".$descripcion."] Producto de ingreso";


  $sql = "INSERT INTO  historial (nombre,cantidad,precio_unitario,precio_total,pago) VALUES('$nombre_def',1,'$precio_unitario','$valor','$opcion')";



  if($mensajero->query($sql)){

    echo '<script>
    swal.fire({
        title: "Ingreso exitoso",
        text: "Ingreso añadido correctamente",
        icon: "success",
      });

    // Redireccionar a otra página después de 1.5 segundos
    setTimeout(function() {
        window.location.href = "ingresos.php"; // Reemplaza "tu_otra_pagina.php" con la URL de la página a la que deseas redirigir
    }, 1000); // 1500 milisegundos = 1.5 segundos
</script>';
  }



}



?>
<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Inventario - Gastos</title>
  <link rel="stylesheet" href="css/inicio.css" />

  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  
 <!-- Asegúrate de incluir SweetAlert y jQuery -->
 <script src="js/jquery.js"></script>


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

  

  
</div>

<style>



    .form-container {
  width: 350px;
  background-color: #fff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  margin-bottom: 30px; /* Agregado para separar los formularios */
}

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #555;
    }

    input[type="text"],select,
    input[type="number"],textarea{
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
    }

/* Estilo para el botón desactivado */
button:disabled {
  background-color: #ccc; /* Color de fondo cuando está desactivado */
  color: #999; /* Color de texto cuando está desactivado */
  cursor: not-allowed; /* Cursor no disponible cuando está desactivado */
  opacity: 0.7; /* Opacidad reducida cuando está desactivado */
  border: 20px;
  padding: 20px;
}

/* Estilo para el botón activado */
button:enabled {
  background-color: #007bff; /* Color de fondo cuando está activado */
  color: #fff; /* Color de texto cuando está activado */
  cursor: pointer; /* Cambia el cursor cuando está activado */
  transition: background-color 0.3s ease; /* Efecto de transición */
  border: 20px;
  padding: 20px;
}

/* Estilo para el botón activado al pasar el mouse */
button:enabled:hover {
  background-color: #0056b3; /* Color de fondo al pasar el mouse */
  transform: scale(1.05); /* Efecto de escala al pasar el mouse */
  border: 20px;
  padding: 20px;
}


    /* Estilos específicos para los mensajes de error */
    .error-message {
      color: red;
      margin-top: 5px;
      font-size: 14px;
    }

/* Estilo de navegación con scroll horizontal */
nav {
  white-space: nowrap; /* Evita el retorno de línea */
  overflow-y: auto; /* Habilita el scroll horizontal si es necesario */
}
</style>


  






      <div class="main-skills">

      <div class="form-container" id="changeUserForm">
    <h1>Agregar Ingreso</h1>
    <form id="userForm" method="post" action="ingresos.php">
      <label for="currentUsername">Descripción:</label>
    <textarea   id="" cols="30" rows="3" id="descripcion" name="descripcion" required></textarea>
      

      <label for="newUsername">Valor:</label>
      <input type="number" id="valor" name="valor" required>

      <label for="edit_nombre_producto">Seleccione el método de Ingreso:</label>
    <select id="opcion" name="opcion" class="form-control" required>
      <option value="1">Efectivo</option>
      <option value="2">Tarjeta</option>
      <option value="3">Nequi</option>
      <option value="4">DaviPlata</option>
    </select>

      <button type="submit" id="changeUserBtn"  name="user">Añadir ingreso</button>
    </form>
  </div>
  <br>



<!-- Asegúrate de incluir SweetAlert y jQuery -->
<script src="js/jquery.js"></script>

<!-- Tu código HTML y otros scripts -->

</form>
     



    </section>
  </div>



</body>
</html></span>