<?php
session_start();
session_destroy();
header("Location: ver_contactos.php");
exit;
?>
