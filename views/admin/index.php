<h1 class="nombre-pagina">Panel de administracion</h1>

<?php
    include_once __DIR__.'/../templates/barra.php';
?>

<h2>Buscar citas </h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha ?>"
            />
        </div>
    </form>
</div>

<!-- si no hay cita para una fecha dada, mostramos mensaje -->
<?php
    if(count($citas) === 0){
        echo "<h2>No hay citas para esta fecha</h2>";
    }
?>

<div class="citas-admin">
    <ul class="citas">
        <?php 
            $idCita = '';
            foreach($citas as $key => $cita): // key funciona como la posicion en el arreglo
                if($idCita !== $cita->id): // para que no se repitan las citas
                    $totalServicios = 0;
        ?>
                    <li>
                        <p>ID: <span><?php echo $cita->id ?></span></p>
                        <p>Hora: <span><?php echo $cita->hora ?></span></p>
                        <p>Cliente: <span><?php echo $cita->cliente ?></span></p>
                        <p>Email: <span><?php echo $cita->email ?></span></p>
                        <h3>Servicios</h3>
                    
        <?php   $idCita = $cita->id; 
                endif;
                $totalServicios = $totalServicios + $cita->precio;
        ?>            
                        <p class="servicio"><?php echo $cita->servicio. ": ".$cita->precio ?></p>
                    <!-- </li> -->
        <?php
                $actual = $cita->id; // id en el cual nos encontramos
                $proximo = $citas[$key + 1]->id ?? 0;

                if(esUltimo($actual, $proximo)): ?>
                    <p class="total">Total: <span><?php echo $totalServicios ?></span></p>
                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id", value="<?php echo $cita->id ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>
        <?php 
                endif;
            endforeach; 
        ?>
    </ul>
</div>


<?php
    $script = "<script src='build/js/buscador.js'></script>"
?>