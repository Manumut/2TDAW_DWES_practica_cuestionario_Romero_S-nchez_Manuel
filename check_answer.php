<?php
// check_answer.php

// Inicia la sesión para acceder a los datos del usuario
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname);



// Validar si el formulario fue enviado correctamente
if (isset($_POST["Enviar"])) {
    $answers = $_POST['answers']; // Captura las respuestas enviadas por el formulario
    $user_name = $_SESSION['usuario'] ?? ''; // Obtiene el nombre del usuario desde la sesión

    

    // Inicializar contador de respuestas correctas
    $correct_count = 0;

    // Procesar cada respuesta enviada
    foreach ($answers as $question_id => $answer) {
        // Consulta para obtener la respuesta correcta de la pregunta
        $stmt = $conn->prepare("SELECT respuesPreg FROM preguntas WHERE idPreg = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $stmt->bind_result($correct_answer);
        $stmt->fetch();

        // Validar si la respuesta del usuario coincide con la correcta
        if (strtolower(trim($answer)) === strtolower(trim($correct_answer))) {
            $correct_count++;
        }

        // Cerrar el statement
        $stmt->close();
    }

    // Registrar el tiempo final y el puntaje del usuario en la base de datos
    $stmt = $conn->prepare("UPDATE users SET tiempFin = NOW(), score = ? WHERE name = ?");
    $stmt->bind_param("is", $correct_count, $user_name);
    $stmt->execute();
    $stmt->close();

    // Cerrar la conexión
    $conn->close();

    // Redirigir a la página de resultados con el puntaje
    header("Location: results.php?score=" . $correct_count);
    exit;
} else {
    // Manejar casos donde no se reciben respuestas correctamente
    echo "<script>alert('No se recibieron respuestas.'); window.location.href='quiz.php';</script>";
    exit;
}
?>
