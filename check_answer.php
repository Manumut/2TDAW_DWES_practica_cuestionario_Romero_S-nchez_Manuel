<?php
session_start(); // Inicia la sesión para conservar el estado del usuario

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname); // Crea la conexión

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Termina si falla la conexión
}

// Obtener respuestas del formulario
$answers = $_POST['answers'] ?? []; // Obtiene las respuestas enviadas por el usuario
$user_name = $_SESSION['usuario'] ?? ''; // Obtiene el nombre del usuario de la sesión

if (empty($user_name) || empty($answers)) { // Verifica que haya usuario y respuestas
    echo "<script>alert('Faltan datos para evaluar.'); window.location.href='index.html';</script>";
    exit;
}

$correct_count = 0; // Contador de respuestas correctas
foreach ($answers as $question_id => $answer) { // Itera sobre las respuestas del usuario
    // Consulta para obtener la respuesta correcta de la base de datos
    $stmt = $conn->prepare("SELECT respuesPreg FROM preguntas WHERE idPreg = ?");
    $stmt->bind_param("i", $question_id); // Asocia el parámetro
    $stmt->execute(); // Ejecuta la consulta
    $stmt->bind_result($correct_answer); // Asocia la respuesta correcta al resultado
    $stmt->fetch();

    // Compara la respuesta del usuario con la correcta
    if (is_array($answer)) { // Si la respuesta es múltiple, conviértela a texto
        $answer = implode(",", $answer);
    }

    if (strtolower(trim($answer)) === strtolower(trim($correct_answer))) { // Compara ignorando mayúsculas y espacios
        $correct_count++;
    }

    $stmt->close(); // Cierra la consulta
}

// Registrar la finalización y puntaje del usuario
$stmt = $conn->prepare("UPDATE users SET tiempFin = NOW(), score = ? WHERE name = ?");
$stmt->bind_param("is", $correct_count, $user_name); // Asocia el puntaje y el nombre del usuario
$stmt->execute(); // Ejecuta la actualización
$stmt->close();

$conn->close(); // Cierra la conexión

// Redirige a la página de resultados con el puntaje
header("Location: results.php?score=" . $correct_count);
exit;
?>
