<div class="container-fluid bg-white mt-3">
    <div class="row bg-white">

        <!-- Earnings (Monthly) Card Example -->
        <?php if ($_SESSION['rol_virtual'] == 1) {
            $total_usuarios = $lc->datos_tabla("Normal", "usuarios WHERE idUsu", "idUsu", 0);
        ?>
            <div class="col-xl-3 col-md-6 mb-4 bg-white">
                <div class="card border-left-success shadow h-100 py-2 ">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center bg-white">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Clientes registrados</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_usuarios->rowCount(); ?> Registrados</div>
                            </div>
                            <div class="col-auto">
                                <a href="<?= SERVERURL . DASHBOARD; ?>/lista-clientes/"><i class="fa-solid fa-users fa-2x text-gray-300"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $total_usuarios->closeCursor();
                    $total_usuarios = $lc->desconectar($total_usuarios);
                    ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($_SESSION['rol_virtual'] == 1 || $_SESSION['rol_virtual'] == 2) {
            $total_productos = $lc->datos_tabla("Normal", "producto WHERE idPro", "idPro", 0);
        ?>
            <div class="col-xl-3 col-md-6 mb-4 bg-white">
                <div class="card border-left-success shadow h-100 py-2 ">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center bg-white">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Productos registrados</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_productos->rowCount(); ?> Registrados</div>
                            </div>
                            <div class="col-auto">
                                <a href="<?= SERVERURL . DASHBOARD; ?>/ver-producto/"> <i class="fa-solid fa-cart-shopping fa-2x text-gray-300"></i></a>
                            </div>
                        </div>
                        </a>
                    </div>
                    <?php
                    $total_productos->closeCursor();
                    $total_productos = $lc->desconectar($total_productos);
                    ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($_SESSION['rol_virtual'] == 1) {
            $total_admini = $lc->datos_tabla("Normal", "usuarios WHERE idUsu", "idUsu", 0);
        ?>
            <div class="col-xl-3 col-md-6 mb-4 bg-white">
                <div class="card border-left-success shadow h-100 py-2 ">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center bg-white">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Administradores</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_admini->rowCount(); ?> Registrados</div>
                            </div>
                            <div class="col-auto">
                                <a href="<?= SERVERURL . DASHBOARD; ?>/lista-administradores/"><i class=" fas fa-user-secret fa-fw fa-2x text-gray-300"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $total_admini->closeCursor();
                    $total_admini = $lc->desconectar($total_admini);
                    ?>
                </div>

            </div>
        <?php } ?>


        <?php if ($_SESSION['rol_virtual'] == 1) {
            $total_pqrs = $lc->datos_tabla("Normal", "pqrs WHERE idPqrs", "idPqrs", 0);
        ?>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center bg-white">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    PQRS</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_pqrs->rowCount(); ?> Registradas</div>
                            </div>
                            <div class="col-auto">
                                <a href="<?= SERVERURL . DASHBOARD; ?>/ver-pqrs/"><i class=" fas fa-comments fa-2x text-gray-300"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $total_pqrs->closeCursor();
            $total_pqrs = $lc->desconectar($total_pqrs);
            ?>
    </div>

</div>
<?php } ?>
</div>
