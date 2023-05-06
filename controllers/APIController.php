<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController
{
    public static function index()
    {
        $servicio = Servicio::all();

        echo json_encode($servicio);
    }

    public static function guardar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // alacena la cita y devuelve el id
            $cita = new Cita($_POST);
            $resultado = $cita->guardar();
            $id = $resultado['id'];

            //Almacena la Cita y el Servicio
            $idServicios = explode(',',$_POST['servicios']);
            foreach($idServicios as $idServicio) {
                $args = [
                    'cita_id' => $id,
                    'servicio_id' => $idServicio
                ];
                $citaServicio = new CitaServicio($args);
                $citaServicio->guardar();
            }
            echo json_encode(['resultado' => $resultado]);
        }
    }

    public static function eliminar(){

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id=$_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();

            header('Location:'.$_SERVER['HTTP_REFERER']);
        }
    }
}
