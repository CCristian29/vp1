<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="row w-100 py-5">
        <div class="col-md-7 offset-md-3">
            <div id="reset-password" class="card bg-transparent text-white mb-3">
                <div class="card-header text-center bg-transparent">
                    <h3>Restablecer tu contraseña</h3>
                </div>
                <div class="card-body">
                    <form method="post" class="FormularioAjax" action="<?= SERVERURL ?>ajax/usuariosAjax.php">
                        <input type="hidden" name="modulo_cliente" value="cambiar_clave">
                        <input type="hidden" name="email" id="reset-email" value="<?= isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '' ?>">
                        <div class="form-group">
                            <label for="password">Nueva Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nueva Contraseña" required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="Cambiar Contraseña">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>