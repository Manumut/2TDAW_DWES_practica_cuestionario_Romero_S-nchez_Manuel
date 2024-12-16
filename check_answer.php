<?php

// Inicia la sesion
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname);




if (isset($_POST["Enviar"])) {
    $answers = $_POST['answers']; // Captura las respuestas enviadas por el formulario
    $user_name = $_SESSION['usuario'] ?? ''; // Obtiene el nombre del usuario desde la sesion

    

    // Inicializar contador de respuestas correctas
    $correct_count = 0;

    // Miro a ver las respuestas
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

        $stmt->close();
    }

    // Registrar el tiempo final y el puntaje del usuario en la base de datos
    $stmt = $conn->prepare("UPDATE users SET tiempFin = NOW(), score = ? WHERE name = ?");
    $stmt->bind_param("is", $correct_count, $user_name);
    $stmt->execute();
    $stmt->close();

    // Cerrar la conexion
    $conn->close();

    // Mando a la pagina de resultados con el puntaje
    header("Location: results.php");
    exit;
}
?>
