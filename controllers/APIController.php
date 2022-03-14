<?php

namespace Controllers;

use Attribute;
use Model\Cita;
use Model\CitaServicio;
use MVC\Router;
use Model\Servicio;

class APIController{
    public static function index(Router $router){
        $servicios = Servicio::all(); // Consultamos todos los serivios de la BD
        echo json_encode($servicios); // convetimos el array en un json
    }

    public static function guardar(){
        // Alamcenar la cita y devuelve el id de la cita
        $cita = new Cita($_POST); // instanciamos nuevo objeto Cita con info de $_POST
        $resultado = $cita->guardar(); // guardamos la cita en la BD - nos da true/false y el id de la cita
        
        // Almacena los servicios con el id de la cita
        $idServicios = explode(",", $_POST['servicios']); // separamos elementos de la var por las comas
        foreach($idServicios as $idServicio){ // iteramos por cada uno de los servicios seleccionados
            $args = [
                'cita_id' => $resultado['id'], // id de la cita
                'servicio_id' => $idServicio // id del servicio
            ];
            $citaServicio = new CitaServicio($args); // nueva instancia de la clase CitaServicio
            $citaServicio->guardar();
        }

        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id']; // id de la cita a eliminar
            // debuguear($_SERVER["HTTP_REFERER"]);
            $cita = Cita::find($id); // buscamos la cita a eliminar
            $cita->eliminar(); // eliminamos la cita
            header('Location:'.$_SERVER["HTTP_REFERER"]); // redirigimos a la pagina anterior donde se encontraba
        }
    }
}