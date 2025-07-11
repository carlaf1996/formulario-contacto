<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "formulario");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Sanitizar datos del formulario
$nombre = htmlspecialchars(trim($_POST['nombre']));
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$mensaje = htmlspecialchars(trim($_POST['mensaje']));

// Validar que no estén vacíos
if ($nombre && $email && $mensaje) {
    // Sentencia preparada para evitar inyección SQL
    $stmt = $conexion->prepare("INSERT INTO contactos (nombre, email, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $mensaje);

    if ($stmt->execute()) {
        // Redirigir a página de gracias
        header("Location: gracias.html");
        exit();
    } else {
        echo "Error al guardar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Por favor completá todos los campos correctamente.";
}

$conexion->close();
?>