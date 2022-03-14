<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{
    public static function index(Router $router){
        if(!isset($_SESSION)) // verificmaos si ya existe una sesion iniciada
        { 
            session_start(); // iniciamos sesion
            // isAuth(); // verificamos si inicio sesion
        }

        isAdmin();

        // debuguear($_SESSION);

        $fecha = $_GET['fecha'] ?? date('Y-m-d'); // formato fecha = aaaa-mm-dd - si no hay genermos la fecha del servidor
        $fechas = explode('-', $fecha); // seperamos el string de fecha en un array con el año, mes y dia
        if( !checkdate($fechas[1], $fechas[2], $fechas[0]) ){ // si NO es una fecha valida - validamos si es un fecha valida
            header('Location: /404'); // dirigimos a not found
        }

        // Consultar BD
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuario_id=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.cita_id=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicio_id ";
        $consulta .= " WHERE fecha =  '${fecha}' "; // por defecto mostramos las citas para la fecha de hoy

        $citas = AdminCita::SQL($consulta);
        // debuguear($citas);
        
        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}