<?php
if ($lc->encryption($_SESSION['id_virtual']) != $pagina[2]) {
    include "./views/inc/admin_security.php";
}
?>

<div class="container-fluid">
    <?php

    $datos_producto = $lc->datos_tabla("Unico", "producto", "idPro", $pagina[2]);
    if ($datos_producto->rowCount() == 1) {
        $campos = $datos_producto->fetch();
    ?>
        <form class="dashboard-container FormularioAjax" method="POST" data-form="update" action="<?php echo SERVERURL; ?>ajax/productoAjax.php">
            <input type="hidden" name="modulo_producto" value="actualizar">
            <input type="hidden" name="producto_id_up" value="<?php echo $pagina[2]; ?>">
            <fieldset class="mb-4">
                <legend><i class="fa-solid fa-circle-info"></i> &nbsp; Información basica</legend>
                <div class="container-fluid">
                    <h2 class="text-center"><?php echo $campos['nomPro']; ?></h2>
                    <div class="d-flex justify-content-center align-items-center">
                        <?php
                        // Preprocesa la URL de la imagen
                        $imgUrl = str_replace('.jfif', '.jpg', SERVERURL . $campos['imgPro']);
                        ?>

                        <img class="w-25" src="<?php echo htmlspecialchars($imgUrl); ?>" alt="">
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-outline mb-4">
                                <label for="producto_codigo" class="form-label">Codigo del producto</label>
                                <input type="text" pattern="[a-zA-Z0-9 ]{4,35}" class="form-control" name="producto_codigo_up" value="<?php echo $campos['codPro']; ?>" id="producto_codigo" maxlength="35">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-outline mb-4">
                                <label for="producto_nombre" class="form-label">Nombre del producto</label>
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="producto_nombre_up" value="<?php echo $campos['nomPro']; ?>" id="producto_nombre" maxlength="35">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="mb-4">
                <legend><i class="fa-solid fa-circle-info"></i> &nbsp; detalles de fabricacion</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-outline mb-4">
                                <label for="producto_fabricante" class="form-label">Fabricante</label>
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="producto_fabricante_up" value="<?php echo $campos['fabPro']; ?>" id="producto_fabricante" maxlength="35">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-outline mb-4">
                                <label for="producto_fecha_elaboracion" class="form-label">Fecha de elaboracion</label>
                                <input type="date" class="form-control" name="producto_fecha_elaboracion_up" value="<?php echo $campos['fecElaPro']; ?>" id="producto_fecha_elaboracion" maxlength="35">
                            </div>
                        </div>

                    </div>
                </div>
            </fieldset>
            <fieldset class="mb-4">
                <legend><i class="fa-solid fa-dumpster"></i> &nbsp; Aspectos comerciales y caracteristicas fisicas</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-outline mb-4">
                                <label for="producto_precio" class="form-label">Precio</label>
                                <input type="text" class="form-control" name="precio_up" value="<?php echo $campos['prePro']; ?>" id="producto_precio" maxlength="47">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-outline mb-4">
                                <label for="producto_cantidad" class="form-label">Cantidad disponible</label>
                                <input type="number" class="form-control" name="cantidad_disponible_up" value="<?php echo $campos['canDisPro']; ?>" id="producto_cantidad" maxlength="47">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-outline mb-4">
                                <label for="producto_nivel_alcohol" class="form-label">Nivel del alcohol</label>
                                <input type="text" class="form-control" name="nivel_alcohol_up" value="<?php echo $campos['nivAlcPro']; ?>" id="nivel_alcohol" maxlength="47">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-outline mb-4">
                                <label for="producto_volumen" class="form-label">Volumen</label>
                                <input type="text" class="form-control" name="volumen_up" value="<?php echo $campos['volPro']; ?>" id="volumen" maxlength="47">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="producto_deccripcion">Descripcion</label>
                <textarea pattern="[0-9()+]{8,20}" class="form-control" id="producto_descripcion" name="producto_descripcion_up" rows="3"><?php echo $campos['desPro']; ?></textarea>
            </div>


            <p class="text-center" style="margin-top: 40px;">
                <a class="btn btn-danger" href="<?= SERVERURL . DASHBOARD . "/ver-producto/" ?>">CANCELAR</a>
                <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
            </p>

        </form>
    <?php
    }
    ?>
</div>