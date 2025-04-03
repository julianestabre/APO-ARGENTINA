<?php
session_start();

// Ajustar la zona horaria a Argentina
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Definir credenciales
$usuario_valido = "admin";
$contraseña_valida = "Optometria2025";

// Si no está logueado, mostrar el formulario de inicio de sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['user'] === $usuario_valido && $_POST['password'] === $contraseña_valida) {
            $_SESSION['loggedin'] = true;
            header("Location: ver_contactos.php");
            exit;
        } else {
            echo "<p style='color:red; text-align:center;'>Usuario o contraseña incorrectos</p>";
        }
    }
?>
    <form method="POST" style="text-align:center; margin-top: 50px;">
        <input type="text" name="user" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
<?php
    exit;
}

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

// Consultar los datos de la base de datos
$sql = "SELECT id, nombre, telefono, email, fecha FROM contactos ORDER BY fecha DESC";
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
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            /* Permite scroll horizontal en pantallas pequeñas */
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            min-width: 600px;
            /* Evita que la tabla se achique demasiado */
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
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

        /* Ajustes para Mobile */
        @media (max-width: 768px) {
            body {
                margin: 10px;
            }

            th,
            td {
                padding: 8px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <h1>Lista de Contactos</h1>
    <a href="log_out.php" style="display:block; text-align:center; margin:20px;">Cerrar sesión</a>
    <div class="table-container">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Fecha de Registro</th>
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
                    $fecha = date("d/m/Y", strtotime($row["fecha"])); // Formato dd/mm/yyyy HH:MM

                    // Si el número tiene el prefijo "+" se asume que es internacional y se deja como está
                    if (strpos($phone, '+') === false) {
                        $phone = preg_replace('/\D/', '', $phone); // Eliminar caracteres no numéricos

                        // Si el número tiene 10 dígitos (típico en Argentina), agregar +54
                        if (strlen($phone) == 10) {
                            $phone = "54" . $phone;
                        }
                    }

                    $message = urlencode("Estimado/a, nos contactamos de la Asociación Profesional de Optometristas por los datos que dejó en nuestra página web. Nombre: $name. Teléfono: $phone. Correo: $email. ¿En qué podemos ayudarlo?");
                    $whatsappLink = "https://wa.me/$phone?text=$message";

                    echo "<tr>
                    <td>$name</td>
                    <td>$phone</td>
                    <td>$email</td>
                    <td>$fecha</td>
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