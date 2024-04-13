<html><link rel="icon" href="images/config/defecto.png" type="image/x-icon"><script src="alert2/sweetalert2.all.min.js"></script></html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="/assets/logo-vt.svg" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventario - Login</title>

  </head>
  <body>

  <style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f0f0f0;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.login-container {
  background-color: #ffffff;
  padding: 30px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  max-width: 400px;
  width: 100%;
}

.login-container h2 {
  margin-bottom: 20px;
  text-align: center;
}

.input-group {
  margin-bottom: 15px;
}

.input-group label {
  display: block;
  margin-bottom: 5px;
}

.input-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

#x {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  transition: background-color 0.3s;
}

#x:hover {
  background-color: #0056b3;
}

  </style>

  <div class="login-container">
    <h2>Iniciar Sesión</h2>
    <form action="#" method="post">
      <div class="input-group">
        <label for="username">Nombre de usuario</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="input-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>
      </div>
      <input type="submit" value="Iniciar Sesión" name="enviar" id="x">
    </form>
  </div>


    <script src="js/jquery.js"></script>
  </body>
</html>

<?php

require 'config/conex.php';
session_start(); // Iniciar la sesión



if (isset($_POST['enviar'])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  
  $sql = "SELECT * FROM usuarios";
  foreach ($mensajero -> query($sql) as $fila) {

    $usuario_bd = $fila['usuario'];
  
    $password_bd = $fila['password'];

    $p_nombre = $fila['p_nombre'];

    $s_nombre = $fila['s_nombre'];

    $p_apellido = $fila['p_apellido'];

    $s_apellido = $fila['s_apellido'];
  

    // Verificar si las credenciales coinciden
    if ($username == $usuario_bd && $password == $password_bd) {


      $sql2 = 'SELECT activo,cargo FROM usuarios WHERE usuario="'.$username.'"';

      foreach ($mensajero->query($sql2) as $fila2) {
        
        $activo_bd = $fila2['activo'];

        $cargo_bd = $fila2['cargo'];
      }

      if($activo_bd == 1 && $cargo_bd == 1){

        $_SESSION['usuario'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['p_nombre'] = $p_nombre;
        $_SESSION['s_nombre'] = $s_nombre;
        $_SESSION['p_apellido'] = $p_apellido;
        $_SESSION['s_apellido'] = $s_apellido;


        // Redirigir al usuario a la pagina de administrador
        header('Location: ventas.php');
        exit(); // Asegura que el script se detenga después de la redirección



      }else if($activo_bd == 1 && $cargo_bd == 2){


        $_SESSION['usuario'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['p_nombre'] = $p_nombre;
        $_SESSION['s_nombre'] = $s_nombre;
        $_SESSION['p_apellido'] = $p_apellido;
        $_SESSION['s_apellido'] = $s_apellido;


        // Redirigir al usuario a la pagina de administrador
        header('Location: administrador/dashboard.php');
        exit(); // Asegura que el script se detenga después de la redirección
      
      
      
      }else{
        echo '<script>
        swal.fire({
            title: "Error",
            text: "Usuario desactivado",
            icon: "error",
          });
        </script>';
      }



      
    }else{

      echo '<script>
      swal.fire({
          title: "Error",
          text: "Usuario o contraseña incorrectos ",
          icon: "error",
        });
      </script>';

    }
  
  
  
    
  }


}





?>