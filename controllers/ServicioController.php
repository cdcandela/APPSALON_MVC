<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router){

        if(!isset($_SESSION)) // verificmaos si ya existe una sesion iniciada
        { 
            session_start(); // iniciamos sesion
            // isAuth(); // verificamos si inicio sesion
        }
        isAdmin();

        $servicios = Servicio::all(); // traemos todos los registros de servicios de la BD

        $router->render('servicios/index', [
            'nombre'=> $_SESSION['nombre'],
            'servicios'=> $servicios
        ]);
    }

    public static function crear(Router $router){

        if(!isset($_SESSION)) // verificmaos si ya existe una sesion iniciada
        { 
            session_start(); // iniciamos sesion
        }
        isAdmin();

        $servicio = new Servicio();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST); 
            $alertas = $servicio->validar(); // validamos

            if(empty($alertas)){ // si no hay alertas
                $servicio->guardar(); // guardamos nuevo servicio en la BD
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre'=> $_SESSION['nombre'],
            'servicio'=> $servicio,
            'alertas'=> $alertas
        ]);
    }

    public static function actualizar(Router $router){
        
        if(!isset($_SESSION)) // verificmaos si ya existe una sesion iniciada
        { 
            session_start(); // iniciamos sesion
        }
        isAdmin();
        
        $idServicio = $_GET['id'];

        if(!is_numeric($_GET['id'])) return;
        $servicio = Servicio::find($idServicio);
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST); 
            $alertas = $servicio->validar(); // validamos

            if(empty($alertas)){ // si no hay alertas
                $servicio->guardar(); // guardamos nuevo servicio en la BD
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre'=> $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(){
        if(!isset($_SESSION)) // verificmaos si ya existe una sesion iniciada
        { 
            session_start(); // iniciamos sesion
        }
        isAdmin();

        if($_SERVER["REQUEST_METHOD"] === "POST"){ 
            $idEliminar = $_POST['id'];
            // debuguear($idEliminar);
            $servicio = Servicio::find($idEliminar);
            $servicio->eliminar($idEliminar);
            header('Location: /servicios');
        }
    }
}