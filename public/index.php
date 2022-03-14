<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

/** RUTAS PROYECTO */
// Iniciar sesion
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
// Cerrar sesion
$router->get('/logout', [LoginController::class, 'logout']);
// Recuperar password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);
// Confirmar cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

// Area privada - Requiere tener cuenta e iniciar sesion
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

// API de citas
$router->get('/api/servicios', [APIController::class, 'index']); // endpoint del API - mostramos los servicios con los que cuenta el salon
$router->post('/api/citas', [APIController::class, 'guardar']); // lee datos enviados desde le formulario 
$router->post('/api/eliminar', [APIController::class, 'eliminar']); // elimina la cita 

// CRUD de servicios
$router->get('/servicios', [ServicioController::class, 'index']); // muestra todos los servicios
$router->get('/servicios/crear', [ServicioController::class, 'crear']); // muestra formulario para crear nuevo servicio
$router->post('/servicios/crear', [ServicioController::class, 'crear']); // lee datos del formulario
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']); // muestra formulario para crear nuevo servicio
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']); // muestra formulario para crear nuevo servicio
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']); // muestra formulario para crear nuevo servicio

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();