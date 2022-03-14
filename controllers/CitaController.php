<?php

namespace Controllers;

use MVC\Router;

class CitaController{

    public static function index(Router $router){

        if(!isset($_SESSION)) // verificmaos si ya existe una sesion iniciada
        { 
            session_start(); // iniciamos sesion
            isAuth(); // verificamos si inicio sesion
        } 
        
        $nombre = $_SESSION['nombre']; // extraemos el nombre de la info de la sesion
        $id = $_SESSION['id']; 

        $router->render('cita/index', [
            'nombre'=>$nombre,
            'id'=>$id
        ]);
    }
}