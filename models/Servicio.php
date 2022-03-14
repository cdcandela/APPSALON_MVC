<?php

namespace Model;

class Servicio extends ActiveRecord{
    // Base de datos
    protected static $tabla = 'servicios'; // tabla de la BD a consultar
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    // Atributos
    public $id;
    public $nombre;
    public $precio;

    // Contructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->precio = $args['precio'] ?? null;
    }

    public function validar(){
        if(!$this->nombre){
            self::$alertas['error'][] = ' El nombre del servicio es obligatorio';
        }
        if(!$this->precio){
            self::$alertas['error'][] = ' El precio del servicio es obligatorio';
        } else if(!is_numeric($this->precio)){
            self::$alertas['error'][] = ' El precio no es valido';
        }
        
        return self::$alertas;
    }
}