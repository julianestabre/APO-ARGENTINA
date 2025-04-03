<?php
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

// Verificar que se recibió el ID
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Eliminar el contacto
    $sql = "DELETE FROM contactos WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Contacto eliminado correctamente.";
    } else {
        echo "Error al eliminar el contacto: " . $conn->error;
    }
} else {
    echo "No se recibió un ID válido.";
}

$conn->close();

// Redirigir de vuelta a la lista de contactos
header("Location: ver_contactos.php");
exit();
?>
