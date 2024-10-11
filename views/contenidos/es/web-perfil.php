<div class="container">
    <div class="conta-per">
        <div class="row justify-content-center">
            <div class="col-md-3 col-sm-3 col-8 text-center">

                <div class="im-per">
                    <?php if ($_SESSION['imagen_virtual'] > 0) { ?>
                        <img src="<?php echo $_SESSION['imagen_virtual'] . '?' . time(); ?>" alt="<?= $_SESSION['nombre_virtual']; ?>" class="im-imp img-fluid rounded-circle">
                    <?php } else { ?>
                        <i class="fa-solid fa-circle-user fa-10x rounded-circle"></i>
                    <?php } ?>
                    <button type="button" class="rounded btn btn-transparent mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fa-solid fa-camera"></i>
                    </button>

                </div>
                <h4 class="mt-3 text-white"><?= $_SESSION["nombre_virtual"]; ?></h4>
            </div>
        </div>
    </div>

    <h1 class="text-center">información personal</h1>

    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-6 col-12 mt-3">
            <div class="p-3 border rounded bg-transparent text-white">
                <h3 class="mb-3">Informacion basica</h3>
                <div class="row gx-3">
                    <div class="col-6">
                        <p class="p-2">Nombre</p>
                    </div>
                    <div class="col-6">
                        <p class="p-2 small"><?php echo $_SESSION['nombre_virtual']; ?></p>
                    </div>
                    <span class="border border-bottom"></span>
                </div>
                <div class="row gx-3">
                    <div class="col-6">
                        <p class="p-2">Fecha de nacimiento</p>
                    </div>
                    <div class="col-6">
                        <p class="p-2  small"><?= $_SESSION["fechaNacimiento_virtual"]; ?></p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-6 col-12 mt-3">
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
        <div class="col-md-8 col-sm-12 col-12 mt-3">
            <div class="p-3 border rounded bg-transparent text-white">
                <h3 class="mb-3">Dirección</h3>
                <div class="row gx-3">
                    <div class="col-6">
                        <p class="p-2">Departamento</p>
                    </div>
                    <div class="col-6">
                        <p class="p-2 small"><?= $_SESSION["departamento_virtual"]; ?></p>
                    </div>
                    <span class="border border-bottom"></span>
                </div>
                <div class="row gx-3">
                    <div class="col-6">
                        <p class="p-2">Ciudad</p>
                    </div>
                    <div class="col-6">
                        <p class="p-2  small"><?= $_SESSION["ciudad_virtual"]; ?></p>
                        </p>
                    </div>
                    <span class="border border-bottom"></span>
                </div>
                <div class="row gx-3">
                    <div class="col-6">
                        <p class="p-2">Direccion de domicilio</p>
                    </div>
                    <div class="col-6">
                        <p class="p-2  small"><?= $_SESSION["direccion_virtual"]; ?></p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-4 text-center">
        <?php

        $modelo = new mainModel(); // Crea una instancia de mainModel

        $idEncriptado = urlencode($modelo->encryption($_SESSION['id_virtual']));

        $updateUrl = SERVERURL . 'actualizar-datos-cliente/' . $idEncriptado;
        ?>


        <a class="btn btn-dark font-weight-bold"  href="<?php echo $updateUrl; ?>">Actualizar datos</a>
    </div>
</div>