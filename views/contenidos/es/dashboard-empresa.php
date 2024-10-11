
<div class="full-box page-header">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-store-alt fa-fw"></i> &nbsp; Empresa
    </h3>
</div>


<div class="container-fluid">
       <form class="dashboard-container FormularioAjax" method="POST" data-form="update" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL; ?>ajax/empresaAjax.php">
            <input type="hidden" name="modulo_empresa" value="actualizar">
            <input type="hidden" name="empresa_id_up" >
            <fieldset class="mb-4">
                <legend><i class="far fa-building"></i> &nbsp; Información de la empresa</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="">
                                <select class="form-control" name="empresa_tipo_documento_up" id="empresa_tipo_documento">
                                    <option value="" selected="">Tipo de documento</option>
                                   
                                </select>
                                <label for="empresa_tipo_documento" class="form-label"></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z0-9-]{4,30}" class="form-control" name="empresa_numero_documento_up" id="empresa_numero_documento" maxlength="30">
                                <label for="empresa_numero_documento" class="form-label">Número de documento </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{3,80}" class="form-control" name="empresa_nombre_up"  id="empresa_nombre" maxlength="80">
                                <label for="empresa_nombre" class="form-label">Nombre </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="empresa_telefono_up" value="<?php echo $campos['empresa_telefono']; ?>" id="empresa_telefono" maxlength="20">
                                <label for="empresa_telefono" class="form-label">Teléfono</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <input type="email" class="form-control" name="empresa_email_up"  id="empresa_email" maxlength="47">
                                <label for="empresa_email" class="form-label">Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}" class="form-control" name="empresa_direccion_up"  id="empresa_direccion" maxlength="97">
                                <label for="empresa_direccion" class="form-label">Dirección</label>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="mb-4">
                <legend><i class="fas fa-coins"></i> &nbsp; Impuestos & facturas</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z]{2,7}" class="form-control" name="empresa_impuesto_nombre_up" value="<?php echo $campos['empresa_impuesto_nombre']; ?>" id="empresa_impuesto_nombre" maxlength="7">
                                <label for="empresa_impuesto_nombre" class="form-label">Nombre de impuesto</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[0-9]{1,2}" class="form-control" name="empresa_impuesto_porcentaje_up"  id="empresa_impuesto_porcentaje" maxlength="2">
                                <label for="empresa_impuesto_porcentaje" class="form-label">Impuesto porcentaje % </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-4">
                                <span><strong>¿Mostrar impuestos en facturas y tickets?</strong></span>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="empresa_impuesto_factura_up" value="Si" id="empresa_impuesto_si" 
                                    <label class="form-check-label" for="empresa_impuesto_si">Si</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="empresa_impuesto_factura_up" value="No" id="empresa_impuesto_no" 
                                    <label class="form-check-label" for="empresa_impuesto_no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <p class="text-center" style="margin-top: 40px;">
                <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
            </p>
            <p class="text-center">
                <small>Los campos marcados con  son obligatorios</small>
            </p>
        </form>
        <form class="dashboard-container FormularioAjax" method="POST" data-form="save" data-lang="<?php echo LANG; ?>" autocomplete="off" action="<?php echo SERVERURL; ?>ajax/empresaAjax.php">
            <input type="hidden" name="modulo_empresa" value="registro">
            <fieldset class="mb-4">
                <legend><i class="far fa-building"></i> &nbsp; Información de la empresa</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="">
                                <select class="form-control" name="empresa_tipo_documento_reg" id="empresa_tipo_documento">
                                    <option value="" selected="">Tipo de documento</option>
                                  
                                </select>
                                <label for="empresa_tipo_documento" class="form-label"></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z0-9-]{4,30}" class="form-control" name="empresa_numero_documento_reg" id="empresa_numero_documento" maxlength="30">
                                <label for="empresa_numero_documento" class="form-label">Número de documento</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., ]{3,80}" class="form-control" name="empresa_nombre_reg" id="empresa_nombre" maxlength="80">
                                <label for="empresa_nombre" class="form-label">Nombre </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="empresa_telefono_reg" id="empresa_telefono" maxlength="20">
                                <label for="empresa_telefono" class="form-label">Teléfono</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <input type="email" class="form-control" name="empresa_email_reg" id="empresa_email" maxlength="47">
                                <label for="empresa_email" class="form-label">Email</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{4,97}" class="form-control" name="empresa_direccion_reg" id="empresa_direccion" maxlength="97">
                                <label for="empresa_direccion" class="form-label">Dirección</label>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="mb-4">
                <legend><i class="fas fa-coins"></i> &nbsp; Impuestos & facturas</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[a-zA-Z]{2,7}" class="form-control" name="empresa_impuesto_nombre_reg" id="empresa_impuesto_nombre" maxlength="7">
                                <label for="empresa_impuesto_nombre" class="form-label">Nombre de impuesto </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <input type="text" pattern="[0-9]{1,2}" class="form-control" name="empresa_impuesto_porcentaje_reg" id="empresa_impuesto_porcentaje" maxlength="2">
                                <label for="empresa_impuesto_porcentaje" class="form-label">Impuesto porcentaje % </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-4">
                                <span><strong>¿Mostrar impuestos en facturas y tickets?</strong></span>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="empresa_impuesto_factura_reg" value="Si" id="empresa_impuesto_si" checked />
                                    <label class="form-check-label" for="empresa_impuesto_si">Si</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="empresa_impuesto_factura_reg" value="No" id="empresa_impuesto_no" />
                                    <label class="form-check-label" for="empresa_impuesto_no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <p class="text-center" style="margin-top: 40px;">
                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
            </p>
            <p class="text-center">
                <small>Los campos marcados con son obligatorios</small>
            </p>
        </form>

</div>