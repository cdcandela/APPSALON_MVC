<?php

namespace Model;

class CitaServicio extends ActiveRecord{
    // Base de datos
    protected static $tabla = 'citasservicios';
    protected static $columnasBD = ['id', 'cita_id', 'servicio_id'];

    // Atributos
    public $id;
    public $cita_id;
    public $servicio_id;

    // Constructos
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->cita_id = $args['cita_id'] ?? '';
        $this->servicio_id = $args['servicio_id'] ?? '';
    }
}