<div class="full-box page-header bg-white">
    <h3 class="text-start roboto-condensed-regular text-secondary text-uppercase">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de productos
    </h3>
</div>

<div class="container-fluid mt-3">
    <div class="dashboard-container">
        <?php
        require_once "./controller/productoControlador.php";
        $ins_producto = new productoControlador();

        echo $ins_producto->paginador_ver_productos_controlador($pagina[2], 10, $pagina[1], "");
        ?>
    </div>
</div>