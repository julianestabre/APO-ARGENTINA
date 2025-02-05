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

// Consultar los datos de la base de datos
$sql = "SELECT id, nombre, telefono, email FROM contactos ORDER BY fecha DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Contactos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            color: #25d366;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .no-data {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Lista de Contactos</h1>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Correo Electrónico</th>
            <th>WhatsApp</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Mostrar cada contacto en una fila de la tabla
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["nombre"];
                $phone = $row["telefono"];
                $email = $row["email"];
                $message = urlencode("Estimado/a, nos contactamos de la Asociación Profesional de Optometristas por los datos que dejó en nuestra página web. Nombre: $name. Teléfono: $phone. Correo: $email. ¿En qué podemos ayudarlo?");
                $whatsappLink = "https://wa.me/$phone?text=$message";

                echo "<tr>
                    <td>$name</td>
                    <td>$phone</td>
                    <td>$email</td>
                    <td><a href='$whatsappLink 'target='_blank'>Contactar</a></td>
                    <td>
                        <form method='POST' action='eliminar_contacto.php' style='display:inline;'>
                            <input type='hidden' name='id' value='$id'>
                            <button type='submit' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este contacto?\");'>Eliminar</button>
                        </form>
                    </td>
                  </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='no-data'>No hay contactos disponibles.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
