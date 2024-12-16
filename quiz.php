<?php

session_start(); // Inicia la sesión

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cargar preguntas aleatorias
$query = "SELECT idPreg, pregun FROM preguntas ORDER BY RAND() LIMIT 5";
$result = $conn->query($query);

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row; // Almacena las preguntas en un array
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuestionario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="preguntas">
    <div class="container">
        <h1>Cuestionario</h1>
        <form action="check_answer.php" method="post">
    <?php foreach ($questions as $index => $question): ?>
        <div class="question">
            <p><strong>Pregunta <?php echo $index + 1; ?>:</strong> <?php echo $question['pregun']; ?></p>
            <input type="text" name="answers[<?php echo $question['idPreg']; ?>]" required>
        </div>
    <?php endforeach; ?>
    <input type="submit" value="Enviar" name="Enviar">
</form>

    </div>
</body>
</html>
