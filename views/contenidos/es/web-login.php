<div class="container-admin">

    <form class="formulario-admin col-12 col-sm-10 col-md-9 col-lg-6" action="" method="POST" autocomplete="off">
        <h2 class="registrar-titulo">ADMINISTRADOR</h2>
        <div class="input-gr mt-2">
            <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" class="mt-2 pl-5" name="correo" placeholder="Email" required>
        </div>
        <div class="input-gr mt-2">
            <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
            <input type="password" class="mt-2 pl-5" name="clave" placeholder="Contraseña" required>
        </div>
        <input type="submit" class="mt-3" value=" Iniciar sesion">
    </form>
</div>

<?php
if (isset($_POST['correo']) && isset($_POST['clave'])) {
    require_once "./controller/loginControlador.php";

    $ins_login = new LoginControlador();

    echo $ins_login->iniciar_sesion_controlador();
}
?>