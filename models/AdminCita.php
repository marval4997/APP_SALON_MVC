<?php

namespace  Model;

class AdminCita extends ActiveRecord{
    protected static $tabla='citas_servicios';
    protected static $colimnasDB=['id', 'hora', 'cliente', 'email', 'telefono', 'servicio', 'precio'];

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct($args=[])
    {
        $this->id=$args['id'] ?? null;
        $this->hora=$args['hora'] ?? null;
        $this->cliente=$args['cliente'] ?? null;
        $this->email=$args['email'] ?? null;
        $this->telefono=$args['telefono'] ?? null;
        $this->servicio=$args['servicio'] ?? null;
        $this->precio=$args['precio'] ?? null;
    }
}