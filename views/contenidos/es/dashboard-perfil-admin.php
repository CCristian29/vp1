<div class="conta-per mt-0 bg-black">
    <div class="row justify-content-center ">
        <div class="col-md-3 col-sm-3 col-12 text-center">
            <div class="im-per mt-5">
                <div>
                    <div class="im-per">
                        <i class="fa-solid fa-circle-user fa-10x rounded-circle"></i>
                        <button type="button" class="rounded btn btn-transparent mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa-solid fa-camera"></i>
                        </button>

                    </div>
                    <h4 class="mt-3 text-white"><?= $_SESSION["nombre_virtual"]; ?></h4>

                </div>
            </div>
        </div>
    </div>




    <div class="row justify-content-center">
        <h1 class="text-center">información personal</h1>
        <div class="col-md-8 col-sm-11 col-11 mt-3">
            <div class="p-3 border rounded bg-transparent text-white">
                <h3 class="mb-3">Informacion basica</h3>
                <div class="row gx-3">
                    <div class="col-6">
                        <p class="p-2">Nombre</p>
                    </div>
                    <div class="col-6">
                        <p class="p-2 small"><?php echo $_SESSION['nombre_virtual']; ?></p>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-11 col-11 mt-3">
            <div class="p-3 border rounded bg-transparent text-white">
                <h3 class="mb-3">Informacion de contacto</h3>
                <div class="row gx-3">
                    <div class="col-6">
                        <h5 class="p-2">Correo</h5>
                    </div>
                    <div class="col-2">
                        <p class="p-2 small"><?= $_SESSION["correo_virtual"]; ?></p>
                    </div>
                    <span class="border border-bottom"></span>
                </div>
                <div class="row gx-3">
                    <div class="col-6">
                        <p class="p-2">Telefono</p>
                    </div>
                    <div class="col-6">
                        <p class="p-2 small"><?= $_SESSION["telefono_virtual"]; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-11 col-11 mt-3">
            <div class="p-3 border rounded bg-transparent text-white">
                <h3 class="mb-3">Administrador</h3>
                <div class="row gx-3">
                    <div class="col-6">
                        <p class="p-2">Cargo</p>
                    </div>
                    <div class="col-6">
                        <p class="p-2 text-success small">
                            <?php $rol_virtual = $_SESSION["rol_virtual"];
                            if ($rol_virtual == 1) {
                                echo "Administrador principal";
                            } elseif ($rol_virtual == 2) {
                                echo "Cajero";
                            } else {
                                echo "Otro rol";
                            }
                            ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php require_once 'model/mainModel.php'; { ?>
        <div class="mt-3 mb-5 text-center">
            <a href="<?php echo SERVERURL . DASHBOARD . "/actualizar-usuario/" . $lc->encryption($_SESSION['id_virtual']) . "/"; ?>" class="btn btn-dark font-weight-bold">Actualizar información de perfil</a>


        </div>
    <?php } ?>
</div>