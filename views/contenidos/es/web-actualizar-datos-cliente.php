<?php
$datos_cliente = $lc->datos_tabla("Unico", "usuarios", "idUsu", $pagina[1]);
if ($datos_cliente->rowCount() == 1) {
    $campos = $datos_cliente->fetch();
?>

    <form class=" FormularioAjax form_emple_web text-black px-3 py-4" method="POST" data-form="update" autocomplete="off" action="<?php echo SERVERURL; ?>ajax/usuariosAjax.php">
        <h1 class="text-white text-center">Actualizar datos</h1>
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-6 col-12 mt-3">
                <div class="p-3 border rounded bg-transparent text-white">
                    <h3 class="mb-3">Informacion personal </h3>

                    <input type="hidden" name="modulo_cliente" value="actualizar">
                    <input type="hidden" name="cliente_id_up" value="<?php echo $pagina[1]; ?>">
                    <div class="form-group p-0 col-md-12">
                        <label for="nombre_usuario">Nombre completo:</label>
                        <input type="text" name="nombre_usuario_up" class="form-control" id="nombre_usuario" value="<?php echo $campos['nomUsu']; ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="tipo_documento">Tipo de Documento</label>
                            <select class="form-select" name="tipo_documento_usuario_up" id="tipo_documento">
                                <option value="<?php echo $campos['tipIdeUsu']; ?>"><?php echo $campos['tipIdeUsu']; ?></option>
                                <option value="Cedula de Ciudadania">Cedula de Ciudadania</option>
                                <option value="Pasaporte">Pasaporte</option>
                                <option value="Licencia">Licencia</option>
                                <option value="cedula de extranjería">Cedula de extranjería</option>
                            </select>
                        </div>
                        <div class="form-group col-md-7">
                            <label for="numero_documento_usuario">Numero Documento</label>
                            <input type="text" name="numero_documento_usuario_up" class="form-control" id="numero_documento_usuario" value="<?php echo $campos['docIdeUsu']; ?>">
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-6 col-12 mt-3">
                <div class="p-3 border rounded bg-transparent text-white">
                    <h3 class="mb-3">Informacion de contacto</h3>

                    <div class="form-group p-0 col-md-12">
                        <label for="correo_usuario">Correo Electronico</label>
                        <input type="email" name="correo_electronico_usuario_up" class="form-control" id="correo_usuario" value="<?php echo $campos['corEleUsu']; ?>">
                    </div>
                    <div class="form-group p-0 col-md-12">
                        <label for="telefono_usuario">Telefono</label>
                        <input type="text" name="telefono_usu_up" class="form-control" id="telefono_usuario" value="<?php echo $campos['telUsu']; ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-6 col-12 mt-3">
                <div class="p-3 border rounded bg-transparent text-white">
                    <h3 class="mb-3">Direccion</h3>
                    <div class="row gx-3">
                        <div class="col-6">
                            <label for="departamento">Departamento</label>
                            <select class="form-select" name="departamento_usuario_up" id="departamento" onchange="getCiudades()">
                                <option value="" disabled><?php echo $campos['depUsu']; ?></option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="ciudad">Ciudad</label>
                            <select class="form-select" name="ciudad_usuario_up" id="ciudad">
                                <option value=""><?php echo $campos['ciuUsu']; ?></option>
                            </select>
                        </div>
                        <div class="form-group mt-3 col-md-12">
                            <label for="direccion_recidencia">Direccion Residencia</label>
                            <input type="text" name="direccion_recidencia_up" class="form-control" id="direccion_recidencia" value="<?php echo $campos['dirResUsu']; ?>" placeholder="Direccion (Ejemplo: Barrio Calle 127 # 45-63)">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-group d-flex justify-content-center m-3">
            <button type="submit" class="btn btn-danger font-weight-bold mb-2" onclick="setHiddenFields()">Cancelar</button>
            <button type="submit" class="btn btn-success font-weight-bold mb-2 ml-2" onclick="setHiddenFields()">Actualizar</button>
        </div>


    </form>
<?php } else {
    include "./views/inc/" . LANG . "/error_alert.php";
} ?>