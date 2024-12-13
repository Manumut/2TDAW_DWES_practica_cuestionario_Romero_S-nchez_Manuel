<?php
session_start(); // Inicia la sesión

// Conexión a la base de datos
$servername = "localhost"; // Nombre del servidor
$username = "root"; // Usuario de la base de datos
$password = ""; // Contraseña
$dbname = "kahoot_db"; // Nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname); // Crea la conexión

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Termina el script si falla la conexión
}

// Verificar usuario
$user_name = $_GET['user'] ?? ''; // Obtiene el nombre del usuario desde la URL
if (empty($user_name)) { // Valida que el nombre no esté vacío
    header("Location: index.html"); // Redirige a la página de inicio si no hay usuario
    exit;
}

// Cargar preguntas aleatorias
$query = "SELECT idPreg AS id, pregun AS question_text, 'text' AS type FROM preguntas ORDER BY RAND() LIMIT 5"; // Selecciona 5 preguntas aleatorias
$result = $conn->query($query); // Ejecuta la consulta

if ($result->num_rows === 0) { // Si no hay preguntas disponibles
    die("No hay preguntas disponibles.");
}

$questions = [];
while ($row = $result->fetch_assoc()) { // Almacena las preguntas en un arreglo
    $questions[] = $row;
}

$conn->close(); // Cierra la conexión
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Define la codificación como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace la página responsive -->
    <title>Cuestionario</title> <!-- Título de la página -->
    <link rel="stylesheet" href="styles.css"> <!-- Vincula el archivo de estilos CSS -->
</head>
<body>
    <div class="container"> <!-- Contenedor principal -->
        <h1>Cuestionario</h1> <!-- Título de la página -->
        <!-- Formulario para responder el cuestionario -->
        <form action="check_answers.php" method="post">
            <?php foreach ($questions as $index => $question): ?> <!-- Itera sobre las preguntas cargadas -->
                <div class="question"> <!-- Contenedor de cada pregunta -->
                    <p><strong>Pregunta <?php echo $index + 1; ?>:</strong> <!-- Muestra el número de la pregunta -->
                    <?php echo htmlspecialchars($question['question_text']); ?></p> <!-- Muestra el texto de la pregunta -->
                    
                    <!-- Muestra el tipo de campo de entrada según el tipo de pregunta -->
                    <?php if ($question['type'] === 'text'): ?>
                        <input type="text" name="answers[<?php echo $question['id']; ?>]" required>
                    <?php elseif ($question['type'] === 'number'): ?>
                        <input type="number" name="answers[<?php echo $question['id']; ?>]" required>
                    <?php elseif ($question['type'] === 'multiple'): ?>
                        <input type="text" name="answers[<?php echo $question['id']; ?>][]" required>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit">Enviar Respuestas</button> <!-- Botón para enviar el formulario -->
        </form>
    </div>
</body>
</html>
