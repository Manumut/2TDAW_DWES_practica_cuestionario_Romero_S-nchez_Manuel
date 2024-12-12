<?php
// quiz.php

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

// Verificar usuario
$user_name = $_GET['user'] ?? '';
if (empty($user_name)) {
    header("Location: index.html");
    exit;
}

// Cargar preguntas aleatorias
$query = "SELECT id, question_text, type FROM questions ORDER BY RAND() LIMIT 5";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    die("No hay preguntas disponibles.");
}

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuestionario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Cuestionario</h1>
        <form action="check_answers.php" method="post">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                    <p><strong>Pregunta <?php echo $index + 1; ?>:</strong> <?php echo htmlspecialchars($question['question_text']); ?></p>
                    <?php if ($question['type'] === 'text'): ?>
                        <input type="text" name="answers[<?php echo $question['id']; ?>]" required>
                    <?php elseif ($question['type'] === 'number'): ?>
                        <input type="number" name="answers[<?php echo $question['id']; ?>]" required>
                    <?php elseif ($question['type'] === 'multiple'): ?>
                        <input type="text" name="answers[<?php echo $question['id']; ?>][]" required>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit">Enviar Respuestas</button>
        </form>
    </div>
</body>
</html>
