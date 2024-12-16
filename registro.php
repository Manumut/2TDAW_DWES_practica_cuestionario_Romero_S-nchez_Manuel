<?php
session_start(); // Inicia la sesión
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname); // Crea la conexión


if (isset($_POST["enviar"])) { // Verifica si el formulario fue enviado
    $user_name = trim($_POST['usuario']); // Obtiene y limpia el nombre del usuario

    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) { // Si el usuario ya existe
        echo "<script>alert('El nombre ya está en uso.'); window.history.back();</script>";//Esto es para que me vuelva a la pagina de atras
        exit;
    }

    $stmt->close();

    // Registrar al usuario con su nombre y
    $stmt = $conn->prepare("INSERT INTO users (name, tiempIni) VALUES (?, NOW())");
    $stmt->bind_param("s", $user_name);

    if ($stmt->execute()) { // Si la inserción es exitosa
        $_SESSION['usuario'] = $user_name; // Guarda el nombre del usuario en la sesión
        header("Location: quiz.php"); // Redirige al cuestionario
        exit;
    }

    $stmt->close();
}

$conn->close(); // Cierra la conexión
?>
