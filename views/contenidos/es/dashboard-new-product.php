<div class="container mt-5">
    <form method="post" action="<?= SERVERURL; ?>ajax/productoAjax.php" class="p-4 border rounded mb-5 FormularioAjax" enctype="multipart/form-data" data-form="save">
        <input type="hidden" name="modulo_producto" value="agregar">
        <h2 class="mb-4">Formulario de Producto</h2>
        <div class="form-group">
            <label for="idproducto">Código de producto</label>
            <input type="text" class="form-control" name="codigo_pro" maxlength="11" minlength="10" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre del producto</label>
            <input type="text" class="form-control" name="nombre_pro" required>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-outline mb-4">
                    <label for="producto_fabricante" class="form-label">Fabricante</label>
                    <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="fabricante_pro" id="producto_fabricante" maxlength="35">
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="form-outline mb-4">
                    <label for="producto_fecha_elaboracion" class="form-label">Fecha de elaboracion</label>
                    <input type="date" class="form-control" name="fecha_elaboracion_pro" id="producto_fecha_elaboracion" maxlength="35">
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-md-3">
                <div class="form-outline mb-4">
                    <label for="producto_precio" class="form-label">Precio</label>
                    <input type="text" class="form-control" name="precio_pro" id="producto_precio" maxlength="47">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-outline mb-4">
                    <label for="producto_cantidad" class="form-label">Cantidad disponible</label>
                    <input type="number" class="form-control" name="cantidad_disponible_pro" id="producto_cantidad" maxlength="47">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-outline mb-4">
                    <label for="producto_nivel_alcohol" class="form-label">Nivel del alcohol</label>
                    <input type="text" class="form-control" name="nivel_alcohol_pro" id="nivel_alcohol" maxlength="47">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-outline mb-4">
                    <label for="producto_volumen" class="form-label">Volumen</label>
                    <input type="text" class="form-control" name="volumen_pro" id="volumen" maxlength="47">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="mb-4">
                    <label for="producto_categoria" class="form-label">Categoría de producto</label>
                    <select class="form-control" name="producto_categoria_reg" id="producto_categoria">
                        <option value="" selected="">** Categoría de producto **</option>
                        <?php
                        $datos_categoria = $lc->datos_tabla("Normal", "categoria WHERE categoria_estado='Habilitada'", "categoria_id,categoria_nombre,categoria_estado", 0);
                        $cc = 1;
                        while ($campos_categoria = $datos_categoria->fetch()) {
                            echo '<option value="' . $campos_categoria['categoria_id'] . '">' . $cc . ' - ' . $campos_categoria['categoria_nombre'] . '</option>';
                            $cc++;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="mb-4">
                    <label for="producto_estado" class="form-label">Estado de producto</label>
                    <select class="form-control" name="producto_estado_reg" id="producto_estado">
                        <option value="" selected="">** Estado de producto **</option>
                        <option value="Habilitado">Habilitado</option>
                        <option value="Deshabilitado">Deshabilitado</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="form-group">
            <label for="imagen_pro">Imagen del producto</label>
            <input type="file" class="form-control-file" name="imagen_pro">
        </div>

        <label for="descripcion">Descripción</label>
        <input type="text" class="form-control" name="descripcion_pro" required>

        <div class="row mt-3">
            <div class="col-12 col-md-6 col-lg-2 mr-1">
                <div class="form-outline">
                    <input type="submit" class="btn btn-primary" value="Enviar datos">
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 ml-0">
                <div class="form-outline mb-4">
                    <a class="btn btn-secondary ml-2" href="./index.php">Volver a Inicio</a>
                </div>
            </div>

        </div>


    </form>
</div>