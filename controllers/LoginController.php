<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function login(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                //comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    //verificar el password y que este confirmado
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        session_start();
                        $_SESSION['id']=$usuario->id;
                        $_SESSION['nombre']=$usuario->nombre. " " . $usuario->apellido;
                        $_SESSION['email']=$usuario->email;
                        $_SESSION['login']=true;

                        //direccionamiento
                        if($usuario->admin==="1"){
                            $_SESSION['admin']=$usuario->admin ?? null;
                            header('location: /admin');
                        }else{
                            header('location: /citas');
                        }

                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }
        $alertas=Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //revisar que alertas este vació
            if (empty($alertas)) {
                //verificar que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //hashear el password
                    $usuario->hashPassword();
                    //generar un token único
                    $usuario->crearToken();
                    //enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    //enviar confirmación
                    $email->enviarConfirmacion();
                    //crear cuenta
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                    debuguear($usuario);
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        session_start();
        $_SESSION=[];
        header('location: /');
    }

    public static function olvide(Router $router)
    {
        $alertas=[];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
            $auth=new Usuario($_POST);
            $alertas= $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado==='1'){
                    //generar un token
                    $usuario->crearToken();
                    $usuario->guardar();
                    //enviar email
                    $email=new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    //alerta de exito
                    Usuario::setAlerta('exito', 'revisa tu email');
                }else{
                    Usuario::setAlerta('error', 'el usuario no esta confirmado');
                    
                }
            }
        }
        $alertas=Usuario::getAlertas();
        $router->render('auth/olvide-password', [
            'alertas'=>$alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas=[];
        $error=false;
        $token=s($_GET['token']);

        //buscar usuario por su token
        $usuario=Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'token no valido');
            $error=true;
        }

        if($_SERVER['REQUEST_METHOD']==="POST"){
            $password=new Usuario($_POST);
            $alertas=$password->validarPassword();

            if(empty($alertas)){
                $usuario->password=null;

                $usuario->password= $password->password;
                $usuario->hashPassword();
                $usuario->token=null;

                $resultado=$usuario->guardar();

                if($resultado){
                    header('location: /');
                }
            }
        }

        $router->render('auth/recuperar-password',[
            'alertas'=>$alertas,
            'error'=>$error    
        ]);
    }


    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje', []);
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            //modificar el usuario
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuneta confirmada correctamente');
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
