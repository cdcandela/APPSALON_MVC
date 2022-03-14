<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Funcion que revisa que el usuario esta autenticado
function isAuth() : void{
    if(!isset($_SESSION['login'])){ // si no esta autenticado - o iniciado sesion el usuario
        header('Location: /'); // redireccionamos al user
    }
}

// funcion que verifica si un usuario es admin 
function isAdmin() : void {
    if(!isset($_SESSION['admin'])){ // si no es admin
        header('Location: /');
    }
};

// 
function esUltimo(string $actual, string $proximo): bool{
    if($actual !== $proximo){
        return true;
    } else{
        return false;
    }
}
