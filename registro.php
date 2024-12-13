<?php
// registro.php

// Conexión a la base de datos
$servername = "localhost"; // Nombre del servidor
$username = "root"; // Usuario de la base de datos
$password = ""; // Contraseña (vacía en XAMPP por defecto)
$dbname = "kahoot_db"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname); // Crea la conexión

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Termina el script si la conexión falla
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica si la solicitud es POST
    $user_name = trim($_POST['usuario']); // Obtiene y limpia el nombre del usuario

    if (empty($user_name)) { // Valida que el nombre no esté vacío
        echo "<script>alert('El nombre no puede estar vacío.'); window.history.back();</script>";
        exit;
    }

    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM users WHERE name = ?"); // Consulta preparada para evitar SQL Injection
    $stmt->bind_param("s", $user_name); // Asocia el parámetro
    $stmt->execute(); // Ejecuta la consulta
    $stmt->store_result(); // Almacena los resultados

    if ($stmt->num_rows > 0) { // Si el usuario ya existe
        echo "<script>alert('El nombre ya está en uso.'); window.history.back();</script>";
        exit;
    }

    $stmt->close(); // Cierra la consulta

    // Registrar al usuario
    $stmt = $conn->prepare("INSERT INTO users (name, tiempIni) VALUES (?, NOW())"); // Inserta un nuevo usuario
    $stmt->bind_param("s", $user_name); // Asocia el nombre del usuario

    if ($stmt->execute()) { // Si la inserción es exitosa
        header("Location: quiz.php?user=" . urlencode($user_name)); // Redirige a la página del cuestionario
        exit;
    } else { // Si falla la inserción
        echo "<script>alert('Error al registrar el usuario.'); window.history.back();</script>";
    }

    $stmt->close(); // Cierra la consulta
}

$conn->close(); // Cierra la conexión
?>
