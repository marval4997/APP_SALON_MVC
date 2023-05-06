<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<?php

use Model\Servicio;

include_once __DIR__ . '/../templates/barra.php'; ?>

<ul class="servicios">
    <?php foreach ($servicios as $servicio) : ?>
        <li>
            <p>Nombre: <span><?= $servicio->nombre ?></span></p>
            <p>Precio: <span><?= $servicio->precio ?></span></p>

            <div class="acciones">
                <a href="/servicios/actualizar?id=<?= $servicio->id ?>" class="boton">Actualizar</a>
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?= $servicio->id; ?>">
                    <input class="boton-eliminar" type="submit" value="Eliminar">
                </form>
            </div>
        </li>

    <?php endforeach; ?>
</ul>