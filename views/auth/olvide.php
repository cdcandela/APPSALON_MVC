<h1 class="nombre-pagina">Olvidaste tu contraseña?</h1>
<p class="descripcion-pagina">Completa el formulario para restaurar tu contraseña</p>

<?php include_once __DIR__. '/../templates/alertas.php' ?>

<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email" 
            id="email"
            name="email" 
            placeholder="tu email"
        />
    </div>

    <input type="submit" class="boton" value="Enviar instrucciones">
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? inicia sesion</a>
    <a href="/crear-cuenta">Crea una nueva cuenta!</a>
</div>