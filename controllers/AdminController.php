<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController
{
    public static function index(Router $router)
    {
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas= explode('-', $fecha);

        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){
            header('location: /404');
        }
        session_start();

        isAdmin();

        $consulta =  " SELECT citas.id, citas.hora, ";
        $consulta .= " CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente ,";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio FROM citas ";
        $consulta .= " LEFT OUTER JOIN usuarios ON citas.usuario_id=usuarios.id ";
        $consulta .= " LEFT OUTER JOIN citas_servicios ON citas_servicios.cita_id=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ON servicios.id=citas_servicios.servicio_id ";
        $consulta .= " WHERE fecha =  '$fecha' ";
        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas'=>$citas,
            'fecha'=>$fecha
        ]);
    }
}
