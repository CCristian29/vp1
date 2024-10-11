<?php if (isset($_SESSION['id_virtual']) && $_SESSION['id_virtual'] == true) { ?>
    <div class="container productos">
            <div class="row py-5">
                <div class="col-md-7">
                    <h2 class="mb-4">Elige la forma de entrega</h2>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <input type="radio" id="domicilio" name="delivery" checked>
                                    <label for="domicilio" class="form-label mb-0">Enviar a domicilio</label>
                                </div>
                                <span class="text-success">Gratis</span>
                            </div>
                            <p id="direccionDisplay" class="mt-2">La plata Huila - calle-5 #36</p>
                            <span id="editBtn" class="edit-link">Editar o elegir otro domicilio</span>
                        </div>
                    </div>
                    <button id="continueBtn" class="btn btn-primary">Continuar</button>

                    <form id="edit-form" class="mt-4" style="display: none;">
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" placeholder="Carrera carrera 4 #10-86" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
 
            <div class="col-md-5">
                <h2 class="mb-4">Resumen de compra</h2>
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Producto
                                <span>$1.449.900</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Envío
                                <span>Gratis</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total
                                <span>$1.449.900</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
    </div>

<?php } else { ?>
    <div class="container-login py-5">
        <div class="for-alert bg-transparent col-11 col-sm-9 col-md-9 col-lg-6 py-5" action="" method="POST" autocomplete="off">
            <div class="">
                <h2>Para continuar con tu compra debes iniciar sesion</h2>
                <a href="<?= SERVERURL . 'singin/'; ?>" class="btn btn-primary">ir a inicio de sesion</a>
            </div>

        </div>
    </div>

<?php } ?>