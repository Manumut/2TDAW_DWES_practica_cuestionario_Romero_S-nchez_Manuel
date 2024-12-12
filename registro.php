<?php
// register.php

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = trim($_POST['usuario']);

    if (empty($user_name)) {
        echo "<script>alert('El nombre no puede estar vacío.'); window.history.back();</script>";
        exit;
    }

    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('El nombre ya está en uso.'); window.history.back();</script>";
        exit;
    }

    $stmt->close();

    // Registrar al usuario
    $stmt = $conn->prepare("INSERT INTO users (name, tiempIni) VALUES (?, NOW())");
    $stmt->bind_param("s", $user_name);

    if ($stmt->execute()) {
        // Redirigir a la página del cuestionario
        header("Location: quiz.php?user=" . urlencode($user_name));
        exit;
    } else {
        echo "<script>alert('Error al registrar el usuario.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
