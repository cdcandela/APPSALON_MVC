<h1 class="nombre-pagina">Reestablece tu password</h1>
<p class="descripcion-pagina">Ingresa el nuevo password de tu cuenta</p>

<?php include_once __DIR__. '/../templates/alertas.php' ?>

<?php if(!$error):?>
    <form action="" class="formulario" method="POST">
        <div class="campo">
            <label for="password">Password</label>
            <input 
                type="password"
                id="password"
                placeholder="tu nuevo password"
                name="password"  
            />
        </div>

        <input type="submit" class="boton" value="Reestablecer password">
    </form>

<?php endif;?>

<div class="acciones">
    <a href="/">Incia sesion</a>
    <a href="/crear-cuenta">Crea una nueva cuenta!</a>
</div>