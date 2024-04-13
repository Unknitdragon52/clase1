<?php
// Verificar si se recibió el nombre de usuario por POST
if (isset($_POST['newUsername'])) {
    require 'config/conex.php'; // Incluir el archivo de conexión

    // Recuperar el nombre de usuario enviado por POST
    $newUsername = $_POST['newUsername'];

    try {
        // Preparar la consulta para buscar el usuario en la base de datos
        $query = "SELECT COUNT(*) as count FROM usuarios WHERE usuario = :newUsername";
        $statement = $mensajero->prepare($query);
        $statement->bindParam(':newUsername', $newUsername);
        $statement->execute();

        // Obtener el resultado de la consulta
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe
        if ($result['count'] > 0) {
            echo 'exists'; // El usuario ya existe en la base de datos
        } else {
            echo 'available'; // El usuario está disponible para su uso
        }
    } catch (PDOException $e) {
        echo 'error'; // En caso de error en la consulta
    }
} else {
    echo 'missing_username'; // Si no se recibió el nombre de usuario por POST
}
?>
