<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Actualizar de Servicios</p>

<?php include_once __DIR__ .'/../templates/barra.php'; ?>

<?php include_once __DIR__ .'/../templates/alertas.php'; ?>
<form class="formulario"  method="POST">
    <?php include_once 'formulario.php'; ?>

    <input class="boton" type="submit" value="guardar">
</form>