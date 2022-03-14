<h1 class="nombre-pagina">login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php include_once __DIR__. '/../templates/alertas.php' ?>

<form action="" class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            placeholder="email"
            name="email"  
        />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            placeholder="clave"
            name="password"  
        />
    </div>

    <input type="submit" class="boton" value="Iniciar sesion">

</form>

<div class="acciones">
    <a href="/crear-cuenta">Crea una nueva cuenta!</a>
    <a href="/olvide">Olvidaste tu password?</a>
</div>