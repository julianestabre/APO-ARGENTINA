<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apo";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si los datos existen en $_POST
if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST["email"])) {
    // Obtener los datos del formulario
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST["email"];

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO contactos (nombre, telefono, email) VALUES ('$name', '$phone', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Datos guardados correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No se recibieron datos del formulario.";
}

$conn->close();
?>
