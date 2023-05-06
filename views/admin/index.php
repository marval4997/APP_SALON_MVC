<h1 class="nombre-paguina">Panel de Administración</h1>

<?php require_once __DIR__ . '/../templates/barra.php'; ?>
<h2>Buscar Citas</h2>
<div class="búsqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?= $fecha; ?>">
        </div>
    </form>
</div>
<?php if (count($citas) === 0) : ?>
    <h2>No Hay Citas en esta fecha</h2>
<?php endif; ?>
<div class="citas-admin">
    <ul class="citas">

        <?PHP $idCita = ''; ?>

        <?php foreach ($citas as $key => $cita) : ?>

            <?php if ($idCita !== $cita->id) : ?>
                <li>
                    <?php $total = 0 ?>

                    <p>ID: <span><?= $cita->id; ?></span></p>
                    <p>HORA: <span><?= $cita->hora; ?></span></p>
                    <p>CLIENTE: <span><?= $cita->cliente; ?></span></p>
                    <p>EMAIL: <span><?= $cita->email; ?></span></p>
                    <p>TELÉFONO: <span><?= $cita->telefono; ?></span></p>
                    <h3>Servicios</h3>

                <?php endif; ?>
                <p class="servicio"><?= $cita->servicio . " " . $cita->precio; ?></p>
                <?php $idCita = $cita->id; ?>
                <?php
                $total += $cita->precio;
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;
                ?>
                <?php if (esUltimo($actual, $proximo)) : ?>
                    <p class="total">Total: <span><?= $total; ?></span> </p>
                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?= $cita->$id ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>
                </li>
            <?php endif ?>

        <?php endforeach; ?>

    </ul>
</div>

<?php
$script = "<script src=build/js/buscador.js></script>"
?>