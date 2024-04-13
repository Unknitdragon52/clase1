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


if(isset($_POST['user'])){

  $usuario_antiguo = $_POST['currentUsername'];

  $usuario_nuevo = $_POST['newUsername'];


  $_SESSION['usuario'] = $usuario_nuevo;

  $sql = "UPDATE usuarios SET usuario ='$usuario_nuevo' WHERE usuario='$usuario_antiguo'";

  $sql2 = "UPDATE productos SET usuario ='$usuario_nuevo' WHERE usuario='$usuario_antiguo'";

  if($mensajero->query($sql) && $mensajero->query($sql2)){

    echo '<script>
    swal.fire({
        title: "Actualización exitosa",
        text: "Usuario actualizado correctamente",
        icon: "success",
      });

    // Redireccionar a otra página después de 1.5 segundos
    setTimeout(function() {
        window.location.href = "ajustes.php"; // Reemplaza "tu_otra_pagina.php" con la URL de la página a la que deseas redirigir
    }, 1500); // 1500 milisegundos = 1.5 segundos
</script>';
  }



}

if(isset($_POST['clave'])){

    $clave_nueva = $_POST['newPassword'];

    $_SESSION['password'] = $clave_nueva;

    $sql3 = "UPDATE usuarios SET password='$clave_nueva' WHERE usuario='$usuario'";


    if($mensajero->query($sql3)){

        echo '<script>
        swal.fire({
            title: "Actualización exitosa",
            text: "Contraseña actualizada correctamente",
            icon: "success",
          });
    
        // Redireccionar a otra página después de 1.5 segundos
        setTimeout(function() {
            window.location.href = "ajustes.php"; // Reemplaza "tu_otra_pagina.php" con la URL de la página a la que deseas redirigir
        }, 1500); // 1500 milisegundos = 1.5 segundos
    </script>';
      }
    
}


?>
<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Inventario - Ajustes</title>
  <link rel="stylesheet" href="css/inicio.css" />

  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  
 <!-- Asegúrate de incluir SweetAlert y jQuery -->
 <script src="js/jquery.js"></script>


  <script>$(document).ready(function () {
  // Cambiar Usuario
  $('#currentUsername, #newUsername').on('input', function () {
    var currentUsername = $('#currentUsername').val();
    var newUsername = $('#newUsername').val();

    // Validar que el usuario actual coincida con el de sesión
    if (currentUsername !== '<?php echo $usuario; ?>') {
      $('#changeUserBtn').prop('disabled', true);
      $('#userMessage').text('Usuario actual incorrecto');
      return;
    }

    // Verificar en el servidor si el nuevo usuario existe
    $.ajax({
      url: 'check_username.php',
      method: 'POST',
      data: { newUsername: newUsername },
      success: function (response) {
        if (response === 'exists') {
          $('#changeUserBtn').prop('disabled', true);
          $('#userMessage').text('Este usuario ya existe');
        } else {
          $('#changeUserBtn').prop('disabled', false);
          $('#userMessage').text('');
        }
      }
    });
  });

  // Cambiar Contraseña
  $('#currentPassword, #newPassword, #confirmPassword').on('input', function () {
    var currentPassword = $('#currentPassword').val();
    var newPassword = $('#newPassword').val();
    var confirmPassword = $('#confirmPassword').val();

    // Validar contraseña actual
    if (currentPassword !== '<?php echo $clave; ?>') {
      $('#changePassBtn').prop('disabled', true);
      $('#passMessage').text('Contraseña actual incorrecta');
      return;
    }

    // Validar que las contraseñas coincidan
    if (newPassword !== confirmPassword) {
      $('#changePassBtn').prop('disabled', true);
      $('#passMessage').text('Las contraseñas no coinciden');
    } else {
      $('#changePassBtn').prop('disabled', false);
      $('#passMessage').text('');
    }
  });

  // Aquí manejarías la subida de formularios usando AJAX o un submit convencional
});
</script> 
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

    input[type="text"],
    input[type="password"] {
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
    <h1>Cambiar Usuario</h1>
    <form id="userForm" method="post" action="ajustes.php">
      <label for="currentUsername">Usuario actual:</label>
      <input type="text" id="currentUsername" name="currentUsername" required>

      <label for="newUsername">Nuevo Usuario:</label>
      <input type="text" id="newUsername" name="newUsername" required>

      <button type="submit" id="changeUserBtn" disabled name="user">Cambiar Usuario</button>
      <p class="error-message" id="userMessage"></p>
    </form>
  </div>
  <br>

  <div class="form-container" id="changePassForm">
    <h1>Cambiar Contraseña</h1>
    <form id="passForm" method="post" action="ajustes.php">
      <label for="currentPassword">Contraseña actual:</label>
      <input type="password" id="currentPassword" name="currentPassword" required>

      <label for="newPassword">Nueva Contraseña:</label>
      <input type="password" id="newPassword" name="newPassword" required>

      <label for="confirmPassword">Repetir Nueva Contraseña:</label>
      <input type="password" id="confirmPassword" name="confirmPassword" required>

      <button type="submit" id="changePassBtn" disabled name="clave">Cambiar Contraseña</button>
      <p class="error-message" id="passMessage"></p>
    </form>
  </div>




<!-- Asegúrate de incluir SweetAlert y jQuery -->
<script src="js/jquery.js"></script>

<!-- Tu código HTML y otros scripts -->

</form>
     



    </section>
  </div>



</body>
</html></span>