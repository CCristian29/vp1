<?php
if (empty($pagina[1]) || $pagina[1] == "") {
    $pagina[1] = "all";
}

if (empty($pagina[3]) || $pagina[3] == "") {
    $pagina[3] = 1;
}

if (empty($pagina[2]) || $pagina[2] == "") {
    $pagina[2] = "ASC";
}
?>
<div class="productos bg-white full-box">
    <div class="container py-3 container-web-page">
        <?php
        $nombre_categoria = $lc->datos_tabla("Unico", "categoria", "categoria_id", $lc->encryption($pagina[1]));

        if ($pagina[1] != "all" && $nombre_categoria->rowCount() == 1) {
            $nombre_categoria = $nombre_categoria->fetch();
        ?>
            <h3 class="font-weight-bold poppins-regular text-uppercase"><?php echo $nombre_categoria['categoria_nombre']; ?></h3>
            <p class="text-justify"><?php echo $nombre_categoria['categoria_descripcion']; ?></p>
        <?php } else { ?>
            <h1 class="font-weight-bold poppins-regular text-uppercase">Productos disponibles</h1>
        <?php } ?>

        <div class="container-fluid" style="border-top: 1px solid #E1E1E1; padding: 20px;">
            <div class="row align-items-center">
                <div class="col-12 col-sm-4 text-center text-sm-start">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-tags fa-fw"></i> &nbsp; CATEGORÍAS
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <!-- Opción de "Ver todas las categorías" -->
                            <a class="dropdown-item" href="<?php echo SERVERURL . $pagina[0] . '/0/ASC/1/'; ?>">Ver todas las categorías</a>

                            <?php
                            $datos_categoria = $lc->datos_tabla("Normal", "categoria WHERE categoria_estado='Habilitada'", "categoria_id, categoria_nombre,categoria_estado", 0);
                            while ($campos_categoria = $datos_categoria->fetch()) {
                                echo '<a class="dropdown-item" href="' . SERVERURL . $pagina[0] . '/' . $campos_categoria['categoria_id'] . '/ASC/1/">' . $campos_categoria['categoria_nombre'] . '</a>';
                            }
                            ?>
                        </ul>
                    </div>

                </div>

                <div class="col-12 col-sm-4 text-center">
                    <button type="button" class="btn btn-link" data-mdb-toggle="modal" data-mdb-target="#saucerModal">
                     
                    </button>
                </div>

            </div>
        </div>


        <?php
        if (isset($_SESSION['busqueda_tienda']) && !empty($_SESSION['busqueda_tienda'])) {
        ?>
            <div class="container-fluid" style="padding: 20px 0;">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <p class="text-left lead"><i class="fas fa-search fa-fw"></i> &nbsp; Resultados de la búsqueda: <span class="font-weight-bold poppins-regular text-uppercase"><?php echo $_SESSION['busqueda_tienda']; ?></span></p>
                    </div>
                    <div class="col-12 col-md-4">
                        <form class="mb-4 FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="search" data-lang="<?php echo LANG; ?>" method="POST">
                            <input type="hidden" name="modulo" value="tienda">
                            <input type="hidden" name="eliminar_busqueda" value="eliminar">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times fa-fw"></i> &nbsp; Eliminar busqueda
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        } else {
            $_SESSION['busqueda_tienda'] = "";
        }


        require_once "./controller/productoControlador.php";
        $ins_producto = new productoControlador();

        echo $ins_producto->cliente_paginador_producto_controlador($pagina[3], 20, $pagina[0], $pagina[2], $pagina[1], $_SESSION['busqueda_tienda']);
        ?>
    </div>
</div>