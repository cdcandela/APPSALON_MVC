<?php

namespace Model;

class Cita extends ActiveRecord{
    // Base de datos
    protected static $tabla = 'citas'; // tabla de la BD
    protected static $columnasDB = ['id', 'fecha', 'hora', 'usuario_id'];

    // Atributos
    public $id;
    public $fecha;
    public $hora;
    public $usuario_id;

    // Constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->hora = $args['hora'] ?? null;
        $this->usuario_id = $args['usuario_id'] ?? null;
    }
}