<?php
if ($lc->encryption($_SESSION['id_virtual']) != $pagina[2]) {
    include "./views/inc/admin_security.php";
}
?>
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Producto</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <?php
            $datos_producto = $lc->datos_tabla("Unico", "producto", "idPro", $pagina[2]);
            if ($datos_producto->rowCount() == 1) {
                $campos = $datos_producto->fetch();
            ?>
                <form id="formularioEditar" action="./editarProducto.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="usuario_id_up" value="<?php echo $pagina[2]; ?>">
                    <div class="modal-body">
                        <input type="hidden" id="idEditar" name="idEditar" value="<?php echo $campos['nomPro']; ?>">
                        <div class="mb-3">
                            <label for="nombreEditar" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreEditar" name="nombreEditar">
                        </div>
                        <div class="mb-3">
                            <label for="descripcionEditar" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionEditar" name="descripcionEditar" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="cantidadEditar" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidadEditar" name="cantidadEditar">
                        </div>
                        <div class="mb-3">
                            <label for="imagenEditar" class="form-label">Imagen</label>
                            <input type="file" class="form-control-file" id="imagenEditar" name="imagenEditar">
                        </div>
                        <div class="mb-3">
                            <label for="precioEditar" class="form-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="precioEditar" name="precioEditar">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar Cambios">
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>