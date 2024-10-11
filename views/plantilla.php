<?php
/*---------- Iniciando sesion ----------*/
include "./views/inc/session-start.php";
?>
<!DOCTYPE html>
<html lang="<?php echo LANG; ?>">

<head>
    <?php include "./views/inc/head.php"; ?>
</head>

<body class="scroll">
    <?php
    $peticionAjax = false;

    if (isset($_GET['views'])) {
        $pagina = explode("/", $_GET['views']);
    } else {
        $pagina = [];
    }

    require_once "./controller/vistasControlador.php";
    $ins_vistas = new vistasControlador();

    require_once "./controller/loginControlador.php";
    $lc = new loginControlador();

    if (isset($pagina[0]) && DASHBOARD == $pagina[0]) {

        /*---------- Dashboard ----------*/
        $vistas = $ins_vistas->obtener_vistas_controlador("dashboard", LANG);
        if ($vistas == "login" || $vistas == "404") {
            require_once "./views/contenidos/" . LANG . "/" . "web-" . $vistas.".php";
        } else {
            if (!isset($_SESSION['id_virtual']) || !isset($_SESSION['token_virtual']) || !isset($_SESSION['correo_virtual'])) {
                echo $lc->forzar_cierre_administrador_sesion_controlador();
                exit();
            }
    ?>
            <!--contenido de la pagina-->
            <main class="box-full main-container" id="page-top">
                <?php if($_SESSION['rol_virtual']==1 || $_SESSION['rol_virtual']==2){ ?>
                
                <div id="wrapper">
                    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                        <?php include "./views/inc/" . LANG . "/navbar-lateral.php"; ?>
                    </ul>
                    <div id="content-wrapper" class="d-flex flex-column">
                        <!-- Main Content -->
                        <div id="content">
                            <?php include "./views/inc/" . LANG . "/navbar-admin.php"; ?>
                            <div id="content-wrapper" class="d-flex flex-column">
                                <?php require_once $vistas; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include "./views/inc/" . LANG . "/lout-modal.php"; ?>

            </main>

        <?php }else{ ?>
            <div class="container">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6 text-center">
                        <h1 class="display-1">404</h1>
                        <p class="lead">¡Oops! La página que estás buscando no fue encontrada.</p>
                        <p>Lo sentimos, pero la página que estás buscando no existe, ha sido eliminada o ha cambiado de dirección.</p>
                        <a href="<?= SERVERURL;?>index/" class="btn btn-primary">Ir a la página principal</a>
                    </div>
                </div>
            </div>
        <?php
            }
           include "./views/inc/logOut.php";
           include "./views/inc/carrito.php";
        }
    } else {
        /*---------- Web ----------*/
        $vistas = $ins_vistas->obtener_vistas_controlador("web", LANG);


        if ($vistas == "404" || $vistas == "registro" || $vistas == "singin") {
            require_once  "./views/contenidos/" . LANG . "/" . "web-" . $vistas . ".php";
        } else {
        ?>
            <!---------- Header ---------->
            <main>
                <?php include "./views/inc/" . LANG . "/navbar.php"; ?>
                <section>
                    <?php require_once $vistas; ?>
                </section>
                <?php include "./views/inc/es/footer.php"; ?>
            </main>
            
    <?php include "./views/inc/logOut.php";
        include "./views/inc/carrito.php"; }
    }
    include "./views/inc/script.php";
    ?>
</body>

</html>