
<div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 95vh;">
        <div class="col-lg-8">
            <h2 class="tps text-center">Formulario de PQRS</h2>
            <form class="FormularioAjax" method="post" action="<?= SERVERURL; ?>ajax/pqrsAjax.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre" class="tp">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="Nombre" required>
                </div>
                <div class="form-group">
                    <label for="correo" class="tp">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="Correo" required>
                </div>
                <div class="form-group">
                    <label for="tipo" class="tp">Tipo de PQRS:</label>
                    <select class="form-control" id="tipo" name="Tipo" required>
                        <option value="peticion" class="tp">Petición</option>
                        <option value="queja" class="tp">Queja</option>
                        <option value="reclamo" class="tp">Reclamo</option>
                        <option value="sugerencia" class="tp">Sugerencia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="descripcion" class="tp">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="Descripcion" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="archivo" class="tp">Adjuntar Archivo:</label>
                    <input type="file" class="form-control-file" id="archivo" name="Archivo" accept=".pdf,.doc,.docx">
                </div>
                <button type="submit" class="btn btn-primary tp">Enviar PQRS</button>
            </form>
        </div>
    </div>