<?php

// Ajustar la zona horaria a Argentina
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Conectar a la base de datos
$servername = "localhost";
$username = "u556471774_apo";
$password = "Optometria2025";
$dbname = "u556471774_apoargentina";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si los datos existen en $_POST
if (!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST["email"])) {
    // Obtener los datos del formulario
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST["email"]);

    // Insertar los datos en la base de datos usando una consulta preparada
    $stmt = $conn->prepare("INSERT INTO contactos (nombre, telefono, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $phone, $email);

    if ($stmt->execute()) {
        echo "Datos guardados correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No se recibieron datos válidos del formulario.";
}

$conn->close();
?>

