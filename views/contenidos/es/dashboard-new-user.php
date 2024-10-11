<div class="container-form-admin">
    <form class="formulario mx-auto col-11 col-sm-8 col-md-8 col-lg-6 FormularioAjax" action="<?= SERVERURL; ?>ajax/admAjax.php" method="POST" data-form="save" autocomplete="on">
        <input type="hidden" name="modulo_administrador" value="registrar">

        <h1 class="registrar-titulo">Nuevo administrador</h1>
        <input type="text" name="nomAdm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{6,45}" placeholder="Nombre completo" maxlength="40">
        <div class="row mx-0 bg-transparent justify-content-center mt-1">
            <div class="col-6">
                <select name="tipDocAdm">
                    <option value="">Tipo de identificación</option>
                    <option value="Cedula de Ciudadania">Cedula de Ciudadania</option>
                    <option value="Pasaporte">Pasaporte</option>
                    <option value="cedula de extranjería">Cedula de extranjería</option>
                </select>
            </div>
            <div class="col-6">
                <input type="text" name="docAdm" pattern="[0-9]{10,15}" maxlength="10" placeholder="numero de documento">
            </div>
        </div>
        <input type="text" class="mt-1" name="telAdm" pattern="[0-9()+]{8,20}" maxlength="10" placeholder="Numero de telefono">

        <div class="row mx-0 bg-transparent justify-content-center mt-1">
            <div class="col-6">
                <select id="departamento" name="depAdm" onchange="getCiudades()">
                    <option value="" disabled selected>Selecciona un departamento</option>
                </select>
            </div>
            <div class="col-6">
                <select id="ciudad" name="ciudadAdm">
                    <option value="" disabled selected>Selecciona un departamento primero</option>
                </select>
            </div>
        </div>
        <input class="mt-1" type="email" name="corEleAdm" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" placeholder="Correo">

        <input class="mt-2" type="password" name="conSegAdm" pattern="[a-zA-Z0-9$@.-]{7,100}" placeholder="Contraseña">
        <div class="col-13 mx-0 mt-2">
            <select name="cargo_admin">
                <option value="">Selecione un cargo</option>
                <option value="1">Administrador principal</option>
                <option value="2">Cajero</option>
            </select>
        </div>

        <input type="submit" class="mt-3" value="Registro">
    </form>
</div>