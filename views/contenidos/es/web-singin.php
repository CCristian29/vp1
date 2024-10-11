<?php include "./views/inc/" . LANG . "/header-login.php"; ?>
<div class="container-login sign-up">
    <form class="formulario-login col-11 col-sm-9 col-md-9 col-lg-6" action="" method="POST" autocomplete="off">
        <h2 class="registrar-titulo">Iniciar Sesión</h2>

        <!-- Mostrar mensajes de error -->
        <?php if (isset($_SESSION['error_message'])) : ?>
            <div id="error-message" class="mt-3" style="color: red;">
                <?php
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']); // Limpiar el mensaje después de mostrarlo
                ?>
            </div>
        <?php endif; ?>

        <div class="input-gr mt-2">
            <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" class="pl-5" name="correo" placeholder="Correo" required>
        </div>
        <div class="input-gr mt-2 mb-2">
            <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
            <input type="password" class="pl-5" name="clave" placeholder="Contraseña" required>
        </div>
        <a href="<?= SERVERURL . "formRestablecerClave/"; ?>" class="mt-2 p-2">¿Olvidó su contraseña?</a>
        <input type="submit" class="btn btn-primary mt-3" value="Acceder">
    </form>
</div>


<?php
if (isset($_POST['correo']) && isset($_POST['clave'])) {
    require_once "./controller/loginControlador.php";
    $ins_login = new LoginControlador();
    echo $ins_login->iniciar_sesion_controlador();
}
?>