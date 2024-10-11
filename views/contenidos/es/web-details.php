<div class="full-box productos bg-white pb-5">
    <div class="container py-3 container-web-page">
        <?php include "./views/inc/" . LANG . "/boton_atras.php"; ?>
        <h3 class="font-weight-bold poppins-regular text-uppercase">Detalles del producto</h3>
        <hr>
        <div class="container-fluid">
            <div class="row">
                <?php

                $datos_producto = $lc->datos_tabla("Unico", "producto", "idPro", $pagina[1]);
                if ($datos_producto->rowCount() == 1) {
                    $campos = $datos_producto->fetch();
                    $total_price = $campos['prePro'];
                ?>
                    <div class="col-12 col-lg-5">
                        <figure class="full-box">
                            <?php if (is_file("./views/assets/img/img-productos/" . $campos['imgPro'])) { ?>
                                <img class="img-fluid" src="<?php echo SERVERURL . "views/assets/img/img-productos/" . $campos['imgPro']; ?>" alt="<?php echo $campos['nomPro']; ?>">
                            <?php } else { ?>
                                <img class="img-fluid" src="<?php echo SERVERURL; ?>views/assets/img/img-productos/default.jpg" alt="<?php echo $campos['nomPro']; ?>">
                            <?php } ?>
                        </figure>
                    </div>
                    <div class="col-12 col-lg-7">

                        <h4 class="font-weight-bold poppins-regular tittle-details"><?php echo $campos['nomPro']; ?></h4>

                        <div class="container-fluid" style="padding-top: 50px;">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-4">
                                    <strong class="text-uppercase"><i class="fas fa-box fa-fw"></i> Disponible:</strong> <?php echo $campos['producto_stock']; "Disponible" ?>
                                </div>
                                <div class="col-12 col-md-6 mb-4">
                                    <strong class="text-uppercase"><i class="far fa-registered fa-fw"></i> Fabricante: </strong><?php echo $campos['fabPro']; ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($campos['desPro'] != "") { ?>
                            <p class="text-justify lead" style="padding: 40px 0;">
                                <span class="lead text-uppercase font-weight-bold">Descripción:</span><br>
                                <?php echo $campos['desPro']; ?>
                            </p>
                        <?php } ?>

                        <p class="font-weight-bold text-uppercase" style="font-size: 22px;"><i class="far fa-credit-card fa-fw"></i> Precio: <span class="text-primary"><?php echo COIN_SYMBOL . number_format($total_price, COIN_DECIMALS, COIN_SEPARATOR_DECIMAL, COIN_SEPARATOR_THOUSAND) . ' ' . COIN_NAME; ?></span></p>

                        <!-- Agregar al carrito -->
                        <form action="" style="padding-top: 70px;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-outline mb-4">
                                            <input type="text" value="1" class="form-control text-center" id="product_cant" pattern="[0-9]{1,10}" maxlength="10">
                                            <label for="product_cant" class="form-label">Cantidad</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 text-center">
                                        <?php

                                        $modelo = new mainModel(); // Crea una instancia de mainModel

                                        $idProEncriptado = urlencode($modelo->encryption('idPro'));

                                        $updateUrl = SERVERURL . 'confirma-datos/' . $idProEncriptado;
                                        ?>
                                        <a class="btn btn-dark font-weight-bold" href="<?php echo $updateUrl; ?>"><i class="fas fa-shopping-bag fa-fw"></i> &nbsp;Comprar</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Actualizar el carrito -->
                        <!-- en construccion -->
                        <!-- <form action="" style="padding-top: 70px;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-outline mb-4">
                                            <input type="text" value="1" class="form-control text-center" id="product_cant" pattern="[0-9]{1,10}" maxlength="10">
                                            <label for="product_cant" class="form-label">Cantidad</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 text-center">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-sync fa-fw"></i> &nbsp; Actualizar carrito</button>
                                    </div>
                                </div>
                            </div>
                        </form> -->

                    </div>

                <?php
                    $datos_galeria = $lc->datos_tabla("Normal", "producto WHERE idPro='" . $campos['idPro'] . "'", "*", 0);
                } else {
                    include "./views/inc/" . LANG . "/error_alert.php";
                }
                ?>
            </div>
        </div>
    </div>
</div>