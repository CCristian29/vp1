<?php
if ($lc->encryption($_SESSION['id_virtual']) != $pagina[2]) {
    include "./views/inc/admin_security.php";
}
?>
<div class="container mt-3">
    <?php
    $datos_producto = $lc->datos_tabla("Unico", "usuarios", "idUsu", $pagina[2]);
    if ($datos_producto->rowCount() == 1) {
        $campos = $datos_producto->fetch();
    ?>
        <form class="dashboard-container FormularioAjax" method="POST" data-form="update" autocomplete="off" action="<?php echo SERVERURL; ?>ajax/usuariosAjax.php">

            <input type="hidden" name="modulo_cliente" value="actualizar">
            <input type="hidden" name="cliente_id_up" value="<?php echo $pagina[2]; ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nombre_usuario">Nombre</label>
                    <input type="text" name="nombre_usuario_up" class="form-control" id="nombre_usuario" value="<?php echo $campos['nomUsu']; ?>">
                </div>

                <div class="form-group col-md-4">
                    <label for="tipo_documento">Tipo de Documento</label>
                    <select class="form-select" name="tipo_documento_usuario_up" id="tipo_documento">
                        <option value="<?php echo $campos['tipIdeUsu']; ?>"><?php echo $campos['tipIdeUsu']; ?></option>
                        <option value="Cedula de Ciudadania">Cedula de Ciudadania</option>
                        <option value="Pasaporte">Pasaporte</option>
                        <option value="Licencia">Licencia</option>
                        <option value="cedula de extranjería">Cedula de extranjería</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="numero_documento_usuario">Numero Documento</label>
                    <input type="text" name="numero_documento_usuario_up" class="form-control" id="numero_documento_usuario" value="<?php echo $campos['docIdeUsu']; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="correo_usuario">Correo Electronico</label>
                    <input type="email" name="correo_electronico_usuario_up" class="form-control" id="correo_usuario" value="<?php echo $campos['corEleUsu']; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="telefono_usuario">Telefono</label>
                    <input type="text" name="telefono_usu_up" class="form-control" id="telefono_usuario" value="<?php echo $campos['telUsu']; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="col-4">
                    <label for="departamento">Departamento</label>
                    <select class="form-select" name="departamento_usuario_up" id="departamento" onchange="getCiudades()">
                        <option value="" disabled><?php echo $campos['depUsu']; ?></option>
                    </select>
                </div>
                <div class="col-4">
                    <label for="ciudad">Ciudad</label>
                    <select class="form-select" name="ciudad_usuario_up" id="ciudad">
                        <option value=""><?php echo $campos['ciuUsu']; ?></option>
                    </select>
                </div>
                <input type="hidden" name="departamento_usuario_up" id="departamento_usuario_hidden" value="<?php echo $campos['depUsu']; ?>">
                <input type="hidden" name="ciudad_usuario_up" id="ciudad_usuario_hidden" value="<?php echo $campos['ciuUsu']; ?>">

                <div class="form-group col-md-4">
                    <label for="direccion_recidencia">Direccion Residencia</label>
                    <input type="text" name="direccion_recidencia_up" class="form-control" id="direccion_recidencia" value="<?php echo $campos['dirResUsu']; ?>" placeholder="Direccion (Ejemplo: Barrio Calle 127 # 45-63)">
                </div>

                <div class="form-group col-md-4">
                    <label for="clave_up">Contraseña</label>
                    <input type="password" class="form-control" name="clave_usu_up" id="clave_up">
                </div>
                <div class="form-group col-md-4">
                    <label for="clave_up">Confirmar contraseña</label>
                    <input type="password" class="form-control" name="clave_rep_usu_up" id="clave_up">
                </div>
            </div>
            <div class="form-group">

            </div>
            <button type="submit" class="btn btn-primary" onclick="setHiddenFields()">Actualizar</button>
        </form>
    <?php } ?>
</div>