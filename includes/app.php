<?php 

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // ubica el archivo con las variables de entorno .env
$dotenv->safeLoad(); // permite seguir con el funcionamiento en caso de que el archivo no exista

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
use Dotenv\Dotenv;
use Model\ActiveRecord;
ActiveRecord::setDB($db);