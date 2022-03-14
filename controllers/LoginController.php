<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function login(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST); // nueva instancia de user
            $alertas = $auth->validarLogin(); // validamos campos del login
            
            if(empty($alertas)){ // si no hay alertas
                // Buscamos usuario por el email - si existe
                $usuario = Usuario::where('email', $auth->email);
                if(!$usuario){ // si el user no existe
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                } else { // si el usuario existe
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){ // validamos si esta confirmado y el password
                        // Autenticar el user - SESION
                        session_start(); // iniciamos sesion
                        
                        // Guardamos info de la sesion en la super global
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre." ".$usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        
                        // Redireccionamiento
                        if($usuario->admin === "1"){ // user es un admin
                            $_SESSION['admin'] = $usuario->admin ?? null; // agregamos atributo de admin
                            header('Location: /admin'); // redirigimos
                        } else{ // user el cliente
                            header('Location: /cita'); // redirigimos
                        }
                    }                  
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout(){
        session_start();
        $_SESSION = []; // reseteamos la info de la sesion
        header('Location: /');  // redirigimos al login
    }
    // cuando user olvida password
    public static function olvide(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas= $auth->validarEmail();
            
            if(empty($alertas)){ // si llena el campo
                $usuario = Usuario::where('email', $auth->email);
                // $usuario = Usuario::where('email', "correo0@correo.com"); // buscamos user por el email
                if($usuario && $usuario->confirmado === "1"){ // si el user esxiste y esta confirmado
                    // Generamos token
                    $usuario->crearToken(); // generar nuevo token
                    $usuario->guardar(); // actualizamos info del registro en la BD

                    // enviamos un nuevo email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    // debuguear($email);

                    Usuario::setAlerta('exito', 'reiniciando password'); // alerta de exito
                    
                } else{ // si el user NO existe
                    Usuario::setAlerta('error', 'Usuario no existe o no esta confirmado');
                }
            }
        }
        
        $alertas = Usuario::getAlertas();
        
        $router->render('auth/olvide', [
            'alertas'=> $alertas
        ]);
    }
    // recuperar password
    public static function recuperar(Router $router){
        $alertas = [];
        $error = false; // permite mostrar o no el formulario segun el token sea valido o no
        $token = s($_GET['token']); // obtenemos token de la url
        $usuario = Usuario::where('token', $token); // buscamos usuario por el token
        
        // Validamos si el user con el token existe
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Leer nuevo password y guardarlo
            $newPassword = new Usuario($_POST); // nueva instancia
            $newPassword->validarPassword();
            
            if(empty($alertas)){ // si pasa validacion
                $usuario->password = null; // reseteo password anterior
                $usuario->password = $newPassword->password; // asignamos nuevo password
                $usuario->hashPassword(); // hasheamos el password
                $usuario->token = ""; // eliminamos token
                $resultado = $usuario->guardar(); // guardamos cambios en la BD

                if($resultado){ // si se realizaron los cambio en la BD
                    header('Location: /');
                }

                debuguear($usuario);

            }
        }
        
        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas'=>$alertas,
            'error' =>$error
        ]);
    }
    // crear cuenta
    public static function crear(Router $router){
        // Nuevo usuario
        $usuario = new Usuario();
        // Alertar vacias - validacion
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST); // mantener info en el formulario
            $alertas = $usuario->validarNuevaCuenta();

            // revisamos si alertas esta vacio
            if(empty($alertas)){
                // Validamos que el user no exista
                $resultado = $usuario->existeUsuario();
                // si hay resultado
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                } else { // no esta registrado - almacenamos en la BD
                    // Hashear password
                    $usuario->hashPassword();
                    
                    // Generar un Token unico
                    $usuario->crearToken();
                    
                    // Enviamos email de confirmacion
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario'=> $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
        $alertas = [];
        // leemos token de la url - NO olvidar sanitizar
        $token = s($_GET['token']);
        $columna = 'token';
        $usuario = Usuario::where($columna, $token);
        // si el user esta vacio - no existe
        if(empty($usuario)){
            // Monstrar mensaje de error
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            $usuario->confirmado = "1"; // Modificar atributo confirmado de 0 a 1
            $usuario->token = ""; // Eliminamos token
            $usuario->guardar(); // Actualizamos cambios en la BD
            // Monstrar mensaje de exito
            Usuario::setAlerta('exito', 'Token valido, estamos confirmando tu usuario...');
        }

        // Obtener alertas
        $alertas = Usuario::getAlertas();

        // Renederizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }

}