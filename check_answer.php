<?php
// check_answers.php

session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener respuestas del formulario
$answers = $_POST['answers'] ?? [];
$user_name = $_SESSION['usuario'] ?? '';

if (empty($user_name) || empty($answers)) {
    echo "<script>alert('Faltan datos para evaluar.'); window.location.href='index.html';</script>";
    exit;
}

$correct_count = 0;
foreach ($answers as $question_id => $answer) {
    // Obtener la respuesta correcta de la base de datos
    $stmt = $conn->prepare("SELECT respuesPreg FROM preguntas WHERE id = ?");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $stmt->bind_result($correct_answer);
    $stmt->fetch();

    // Verificar la respuesta del usuario
    if (is_array($answer)) {
        // Para preguntas con múltiples entradas
        $answer = implode(",", $answer);
    }

    if (strtolower(trim($answer)) === strtolower(trim($correct_answer))) {
        $correct_count++;
    }

    $stmt->close();
}

// Registrar finalización y tiempo
$stmt = $conn->prepare("UPDATE users SET end_time = NOW(), score = ? WHERE name = ?");
$stmt->bind_param("is", $correct_count, $user_name);
$stmt->execute();
$stmt->close();

$conn->close();

// Redirigir a la página de resultados
header("Location: results.php?score=" . $correct_count);
exit;
?>
