<?php
require 'config/conex.php';
session_start(); // Iniciar la sesión

if(isset($_POST['Eliminar'])){
    $id = $_POST['Eliminar'];

    $sqleliminar = "DELETE FROM productos WHERE id='$id'";

    if($mensajero->query($sqleliminar)){
        // Envía una respuesta JSON indicando éxito
        echo json_encode(array('success' => true));
        exit();
    } else {
        // En caso de error en la eliminación
        echo json_encode(array('success' => false));
        exit();
    }
}
?>
