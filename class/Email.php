<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $email;
    public $nombre;
    public $token;
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
        
    }

    public function enviarConfirmacion()
    {
        //crear el objeto de mail
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '9a14e91de7bcbb';
        $mail->Password = '0e0786f23016d4';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject= 'Confirma tu cuenta';
        
        //set html
        $mail->isHTML(TRUE);
        $mail->CharSet="UTF-8";

        $contenido="<html>";
        $contenido.= "<p><strong> Hola ".$this->nombre ." Has creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace </strong></p>";
        $contenido.= "<p>Presiona aquí: <a href='http://appsalon.com/confirmar-cuenta?token=". $this->token . "'>Confirmar Cuenta </a></p>";
        $contenido.="<p>si tu no solicitasteis esta cuenta, puedes ignorar el mensaje</p>";
        $contenido.="</html>";

        $mail->Body=$contenido;

        //enviar email
        $mail->send();
    }

    public function enviarInstrucciones()
    {
        //crear el objeto de mail
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '9a14e91de7bcbb';
        $mail->Password = '0e0786f23016d4';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject= 'Restablece tu password';
        
        //set html
        $mail->isHTML(TRUE);
        $mail->CharSet="UTF-8";

        $contenido="<html>";
        $contenido.= "<p><strong> Hola ".$this->nombre ." Has solicitado restablecer tu password sigue el siguiente enlace para hacerlo </strong></p>";
        $contenido.= "<p>Presiona aquí: <a href='http://appsalon.com/recuperar?token=". $this->token . "'>Restablecer password </a></p>";
        $contenido.="<p>si tu no solicitasteis esta cuenta, puedes ignorar el mensaje</p>";
        $contenido.="</html>";

        $mail->Body=$contenido;

        //enviar email
        $mail->send();



    }
}
