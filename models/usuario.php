<?php

namespace Model;
class Usuario extends ActiveRecord{

    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    // Atributos de la clase
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    // Constructor
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // Mensajes validacion - creacion cuenta
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][] = 'El apellido del cliente es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El email del cliente es obligatorio';
        }
        if(!$this->telefono){
            self::$alertas['error'][] = 'El telefono del cliente es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'Debes definir una contraseña';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'Password debe tener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    // Mensajes validacion - login
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'Debes ingresar con tu email';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'Debes ingresar tu password';
        }
        return self::$alertas;
    }

    // Mensajes validacion - recuperar password
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'Debes ingresar el email asociado a tu cuenta';
        }
        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){ // si no hay password
            self::$alertas['error'][] = 'Debes ingresar un nuevo password';
        } else if(strlen($this->password)  <  6){ // si el password tiene menos de 6 caracteres
            self::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }
        return self::$alertas;
    }


    // Revisa si usuario existe
    public function existeUsuario(){
        // definimos consulta
        $query = "SELECT * FROM ". self::$tabla." WHERE email = '". $this->email. "' LIMIT 1"; // consulta
        // realizamos consulta
        $resultado = self::$db->query($query); // conectamos a la BD y obtenemos resultados
        // si hay resultado agregamos a alertas
        if($resultado->num_rows){ // si existe num_rows es porque hay un resultado
            self::$alertas['error'][] = 'Usuario ya registrado';
        }        
        return $resultado;
    }

    public function hashPassword(){
        // reescribimos y hasheamos password
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid(); // generamos secuencia del token
    }

    public function comprobarPasswordAndVerificado($password){
        // Validamos password
        $resultado = password_verify($password, $this->password); // true - false
        if(!$resultado || !$this->confirmado){ // 
            Usuario::$alertas['error'][] = 'Password incorrecto o tu cuenta no ha sido confirmada';
        } else{
            return true;
        }  
    }
}