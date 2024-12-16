<?php
session_start(); // Inicia la sesion

// Conexion a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname); // Crea la conexion


if (isset($_POST["enviar"])) { 
    $user_name = trim($_POST['usuario']); // Obtiene y limpia el nombre del usuario

    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) { // Si el usuario ya existe
        echo "<script>alert('El nombre ya está en uso.'); window.history.back();</script>";//Esto es para que me salga una alerta y me vuelva a la pagina de atras
        exit;
    }

    $stmt->close();

    // Registrar al usuario con su nombre y se guiarda el tiempo en el que se mete
    $stmt = $conn->prepare("INSERT INTO users (name, tiempIni) VALUES (?, NOW())");
    $stmt->bind_param("s", $user_name);

    if ($stmt->execute()) { // Si la insercion es exitosa
        $_SESSION['usuario'] = $user_name; // Guarda el nombre del usuario en la sesion
        header("Location: quiz.php"); // Te manda al questionario
        exit;
    }

    $stmt->close();
}

$conn->close(); // Cierra la conexion
?>
