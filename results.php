<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kahoot_db";

$conn = new mysqli($servername, $username, $password, $dbname); // Crea la conexión

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Termina si falla la conexión
}

// Consulta para obtener el ranking de los usuarios
$query = "SELECT name, TIMESTAMPDIFF(SECOND, tiempIni, tiempFin) AS duration, score
          FROM users
          WHERE tiempFin IS NOT NULL
          ORDER BY duration ASC";
$result = $conn->query($query); // Ejecuta la consulta

if (!$result) {
    die("Error al obtener resultados: " . $conn->error); // Muestra un error si la consulta falla
}

$ranking = [];
while ($row = $result->fetch_assoc()) { // Almacena los resultados en un arreglo
    $ranking[] = $row;
}

$conn->close(); // Cierra la conexión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Define la codificación como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace la página responsive -->
    <title>Resultados</title> <!-- Título de la página -->
    <link rel="stylesheet" href="styles.css"> <!-- Vincula el archivo de estilos CSS -->
</head>
<body>
    <div class="container"> <!-- Contenedor principal -->
        <h1>Ranking de Usuarios</h1> <!-- Título de la página -->
        <table> <!-- Tabla para mostrar el ranking -->
            <thead>
                <tr>
                    <th>Nombre</th> <!-- Encabezado de columna para el nombre -->
                    <th>Duración (segundos)</th> <!-- Encabezado de columna para la duración -->
                    <th>Puntaje</th> <!-- Encabezado de columna para el puntaje -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ranking as $user): ?> <!-- Itera sobre los usuarios en el ranking -->
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td> <!-- Muestra el nombre del usuario -->
                        <td><?php echo htmlspecialchars($user['duration']); ?></td> <!-- Muestra la duración -->
                        <td><?php echo htmlspecialchars($user['score']); ?></td> <!-- Muestra el puntaje -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.html" class="button">Volver al inicio</a> <!-- Enlace para volver al inicio -->
    </div>
</body>
</html>
