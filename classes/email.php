<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    // Atributos
    public $email;
    public $nombre;
    public $token;

    // Constructor
    public function __construct($email, $nombre, $token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){

        // crear objeto de email - setamos con mailtrap
        $mail = new PHPMailer();
        $mail->isSMTP(); // enviar por protocolo de envio de email
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '6c0a899f6202cc';
        $mail->Password = '1f352a06104661';
        
        $mail->setFrom('cuentas@appsalon.com'); // dominio del sitio
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com'); 
        $mail->Subject = 'Confirma tu cuenta';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        // Contenido del correo
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre. "</strong> has creado tu cuenta en App Salon,
        solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=". $this->token. "'> Confirmar cuenta</a></p>";
        $contenido .= "<p>Si no solicitaste esta cuenta, por favor, ingnora este mensaje</p>";
        $contenido .= "</html>";
        // adjuntamos contenido al correo
        $mail->Body = $contenido;

        // Enviar email
        $mail->send();


    }

    public function enviarInstrucciones(){
        // crear objeto de email - setamos con mailtrap
        $mail = new PHPMailer();
        $mail->isSMTP(); // enviar por protocolo de envio de email
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '6c0a899f6202cc';
        $mail->Password = '1f352a06104661';
        
        $mail->setFrom('cuentas@appsalon.com'); // dominio del sitio
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com'); 
        $mail->Subject = 'Reestablece tu password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        // Contenido del correo
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre. "</strong>has solicitado reestablecer tu password,
        sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token=". $this->token. "'> Reestablecer password</a></p>";
        $contenido .= "<p>Si no solicitaste esta cuenta, por favor, ingnora este mensaje</p>";
        $contenido .= "</html>";
        // adjuntamos contenido al correo
        $mail->Body = $contenido;

        // Enviar email
        $mail->send();
    }
}