<?php
session_start(); // Inicia la sesion

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Consulta para obtener el ranking de los usuarios
$query = "SELECT name, TIMESTAMPDIFF(SECOND, tiempIni, tiempFin) AS duration, score FROM users WHERE tiempFin IS NOT NULL ORDER BY duration ASC";
$result = $conn->query($query);

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
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="resultados-container">
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
                        <td><?php echo ($user['name']); ?></td>
                        <td><?php echo ($user['duration']); ?></td>
                        <td><?php echo ($user['score']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.html" class="button">Volver al inicio</a>
    </div>
</body>
</html>
