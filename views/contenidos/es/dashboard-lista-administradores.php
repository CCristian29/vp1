<div class="full-box page-header bg-white">
    <h3 class="text-start roboto-condensed-regular text-uppercase">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de administradores
    </h3>
</div>

<div class="container-fluid">
    <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link text-secondary" href="<?php echo SERVERURL . DASHBOARD; ?>/new-user/"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo administrador</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="<?php echo SERVERURL . DASHBOARD; ?>/client-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de adminsitradores</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <div class="dashboard-container">
        <?php
        require_once "./controller/adminiControlador.php";
        $ins_administrador = new adminiControlador();

        echo $ins_administrador->paginador_administrador_controlador($pagina[2], 10, $pagina[1], "");
        ?>
    </div>
</div>