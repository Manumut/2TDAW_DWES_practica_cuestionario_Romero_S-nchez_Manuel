<?php
// results.php

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener ranking de usuarios
$query = "SELECT name, TIMESTAMPDIFF(SECOND, start_time, end_time) AS duration, score 
          FROM users 
          WHERE end_time IS NOT NULL 
          ORDER BY duration ASC";
$result = $conn->query($query);

if (!$result) {
    die("Error al obtener resultados: " . $conn->error);
}

$ranking = [];
while ($row = $result->fetch_assoc()) {
    $ranking[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Ranking de Usuarios</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Duración (segundos)</th>
                    <th>Puntaje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ranking as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['duration']); ?></td>
                        <td><?php echo htmlspecialchars($user['score']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.html" class="button">Volver al inicio</a>
    </div>
</body>
</html>
