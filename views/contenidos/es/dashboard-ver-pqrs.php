<div class="container-fluid mt-2">
    <div class="dashboard-container">
        <?php
        require_once "./controller/pqrsControlador.php";
        $ins_pqrs = new pqrsControlador();

        echo $ins_pqrs->paginador_pqrs_controlador($pagina[2], 10, $pagina[1], "");
        ?>
    </div>
</div>