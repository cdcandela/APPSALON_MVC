<?php

$db = mysqli_connect(
    $_ENV['DB_HOST'], // variable de entorno con el host
    $_ENV['DB_USER'], 
    $_ENV['DB_PASS'], 
    $_ENV['DB_DB']
);
$db->set_charset("utf8"); // Ver arrays en json

// debuguear($_ENV);

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
