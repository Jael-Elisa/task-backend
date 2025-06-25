<?php
// Conexión a la base de datos (ajusta si tu config es diferente)
$host = "localhost:3307";
$user = "root";
$pass = "";
$dbname = "task"; // Cambia al nombre real de tu base de datos

$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Datos del usuario admin
$name = "Administrador";
$email = "admin@example.com";
$password = "admin123";
$role = "admin";

// Hashear contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepara SQL
$sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

// Ejecuta
if ($stmt->execute()) {
    echo "✅ Usuario admin insertado correctamente.";
} else {
    echo "❌ Error al insertar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
