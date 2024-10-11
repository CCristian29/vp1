<?php
if ($lc->encryption($_SESSION['id_virtual']) != $pagina[2]) {
    include "./views/inc/admin_security.php";
}
?>

<div class="container-fluid">
    <?php
    include "./views/inc/" . LANG . "/boton_atras.php";

    $datos_usuario = $lc->datos_tabla("Unico", "usuarios", "idUsu", $pagina[2]);
    if ($datos_usuario->rowCount() == 1) {
        $campos = $datos_usuario->fetch();
    ?>
        <form class="dashboard-container FormularioAjax" method="POST" data-form="update" autocomplete="off" action="<?php echo SERVERURL; ?>ajax/admAjax.php">
            <input type="hidden" name="modulo_administrador" value="actualizar">
            <input type="hidden" name="usuario_id_up" value="<?php echo $pagina[2]; ?>">
            <fieldset class="mb-4">
                <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <label for="usuario_nombre" class="form-label">Nombre Completo</label>
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{4,35}" class="form-control" name="usuario_nombre_up" value="<?php echo $campos['nomUsu']; ?>" id="usuario_nombre" maxlength="35">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-outline mb-4">
                                <label for="usuario_telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="usuario_telefono_up" value="<?php echo $campos['telUsu']; ?>" id="usuario_telefono" maxlength="10">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="mb-4">
                <div class="container-fluid">
                    <div class="row">
                        <?php if ($_SESSION['rol_virtual'] == "1" && $campos['idUsu'] != 1 && $lc->encryption($_SESSION['id_virtual']) != $pagina[2]) { ?>
                            <div class="col-12 col-md-6">
                                <legend><i class="fas fa-user-secret"></i> &nbsp; Cargo</legend>
                                <div class="mb-4">
                                    <div class="form-check mb-2">
                                        <!-- Enviar 1 para Administrador -->
                                        <input class="form-check-input" type="radio" name="usuario_cargo_up" value="1" id="usuario_cargo_admin"
                                            <?php if ($campos['rolUsu'] == 1) {
                                                echo "checked";
                                            } ?> />
                                        <label class="form-check-label" for="usuario_cargo_admin">Administrador</label>
                                    </div>

                                    <div class="form-check">

                                        <input class="form-check-input" type="radio" name="usuario_cargo_up" value="2" id="usuario_cargo_cajero"
                                            <?php if ($campos['rolUsu'] == 2) {
                                                echo "checked";
                                            } ?> />
                                        <label class="form-check-label" for="usuario_cargo_cajero">Cajero</label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </fieldset>
            <fieldset class="mb-4">
                <legend><i class="fas fa-user-lock"></i> Datos de la cuenta</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <label for="usuario_email" class="form-label">Correo</label>
                                <input type="email" class="form-control" name="usuario_correo_up" value="<?php echo $campos['corEleUsu']; ?>" id="usuario_email" maxlength="80">
                            </div>
                        </div>
                        <div class="col-12">
                            <p class="text-start">Si desea <strong>actualizar la contraseña</strong> de esta cuenta debe de introducir una nueva contraseña y repetirla. Por el contrario, <strong>si no desea actualizarla</strong> deje vacíos los campos.</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <label for="usuario_clave_1" class="form-label">Nueva contraseña </label>
                                <input type="password" class="form-control" name="usuario_nueva_clave_1_up" id="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <label for="usuario_clave_2" class="form-label">Repetir contraseña </label>
                                <input type="password" class="form-control" name="usuario_nueva_clave_2_up" id="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-4">

                <div class="container-fluid">
                    <p>Para poder actualizar los datos en el sistema debe de introducir su <strong>nombre de usuario</strong> y su <strong>contraseña</strong> actual</p>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <label for="administrador_usuario" class="form-label"><i class="fa-solid fa-user"></i> Usuario: </label>
                                <input type="email" class="form-control" name="administrador_usuario_up" id="administrador_usuario" maxlength="80">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-outline mb-4">
                                <label for="administrador_clave" class="form-label"><i class="fa-solid fa-lock"></i> Contraseña: </label>
                                <input type="password" class="form-control" name="administrador_clave_up" id="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <p class="text-center" style="margin-top: 40px;">
                <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
            </p>

        </form>
    <?php
    } else {
        include "./views/inc/" . LANG . "/error_alert.php";
    }
    ?>
</div>