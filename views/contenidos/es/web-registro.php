<?php
include "./views/inc/" . LANG . "/header-login.php";
?>
<div class="container-form sign-up">
    <form class="formulario col-11 col-sm-8 col-md-8 col-lg-5 FormularioAjax" action="<?= SERVERURL ?>ajax/usuariosAjax.php" method="POST" data-form="save" autocomplete="on">
        <input type="hidden" name="modulo_cliente" value="agregar">
        <h1 class="registrar-titulo">REGISTRAR</h1>

        <input type="hidden" name="rol" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{6,45}" placeholder="Nombre completo" maxlength="40">
        <input type="text" name="nomUsu" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{6,45}" placeholder="Nombre completo" maxlength="40" required title="ingrese su numbre completo">
        <div class="row mx-0 bg-transparent justify-content-center mt-1">
            <div class="col-6">
                <select name="tipIdeUsu" id="tipoDocumento" required title="">
                    <option value="">Tipo de identificación</option>
                    <option value="Cedula de Ciudadania">Cedula de Ciudadania</option>
                    <option value="Pasaporte">Pasaporte</option>
                    <option value="cedula de extranjería">Cedula de extranjería</option>
                </select>
            </div>
            <div class="col-6">
                <input type="text" name="docIdeUsu" pattern="[0-9]{10,15}" maxlength="10" placeholder="numero de documento" required="">
            </div>
        </div>
        <input type="text" class="mt-1" name="telUsu" pattern="[0-9()+]{8,20}" maxlength="10" placeholder="Numero de telefono" required="">
        <div class="row mx-0 bg-transparent justify-content-center mt-1">
            <div class="col-6">
                <select id="departamento" name="depUsu" onchange="getCiudades()" required="">
                    <option value="" disabled selected>Selecciona un departamento</option>
                </select>
            </div>
            <div class="col-6">
                <select id="ciudad" name="dirResUsu" required="">
                    <option value="" disabled selected>Selecciona un departamento primero</option>
                </select>
            </div>
        </div>


        <div class="row mx-0 bg-transparent justify-content-center">
            <div class="col-5 align-items-center">
                <label class="text-white mt-3" for="fecNacUsu">Fecha de nacimiento</label>
            </div>
            <div class="col-7 mt-2">
                <input type="date" name="fecNacUsu" id="fecha_nacimiento" required="">
            </div>
        </div>

        <input class="mt-1" type="email" name="corEleUsu" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" placeholder="Correo" required="">


        <input class="mt-2" type="password" name="conSegUsu" pattern="[a-zA-Z0-9$@.-]{7,100}" placeholder="Contraseña" required="">

        <label for="terminos-condiciones" class="terminos-label mt-2">
            <input type="checkbox" value="1" name="terConUsu" required="">
            He leído y acepto los <a href="enlace_a_terminos" data-toggle="modal" data-target="#exampleModalLong">términos</a> y <a href="enlace_a_condiciones" data-toggle="modal" data-target="#exampleModalLong">condiciones</a>.
        </label>

        <input type="submit" class="mt-3" value="Registrar">
    </form>
</div>

<!-- Modal terminos y condiciones -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Términos y Condiciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-black">
                    <!-- Información de contacto -->
                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Información de contacto</h6>
                        <p>PEDCER CERVECERIA ARTESANAL</p>
                        <p>Calle 3A # 10 12 - Tesalia Huila</p>
                        <p>Correo: <a href="mailto:pedcerartesanal@gmail.com">pedcerartesanal@gmail.com</a></p>
                        <p>Teléfono: +57 310 276 5660</p>
                    </div>

                    <!-- Secciones principales -->
                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Descripción del Servicio</h6>
                        <p>PEDCER CERVECERIA ARTESANAL se dedica a la producción y venta de cervezas artesanales de alta calidad. Nuestros productos están disponibles para entrega únicamente dentro de Colombia.</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Requisitos de Edad</h6>
                        <p>La compra de nuestros productos está restringida a personas mayores de 18 años. Solicitamos verificación de edad al momento de la compra para cumplir con las leyes colombianas.</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Envío y Entrega</h6>
                        <p>Realizamos envíos a todo Colombia. El costo y el tiempo de entrega varían según la ubicación. No nos hacemos responsables por daños o pérdidas durante el envío, aunque tomamos medidas para asegurar una entrega segura.</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Política de Devoluciones y Reembolsos</h6>
                        <p>Aceptamos devoluciones dentro de los 14 días posteriores a la recepción del pedido, siempre que los productos estén sin abrir y en su empaque original. Para solicitar una devolución, contáctenos en <a href="mailto:pedcercerveceria@gmail.com">pedcercerveceria@gmail.com</a>.</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Responsabilidad y Exenciones</h6>
                        <p>PEDCER CERVECERIA ARTESANAL no se hace responsable por daños indirectos, incidentales o consecuentes relacionados con el uso de nuestros productos.</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Propiedad Intelectual</h6>
                        <p>Todo el contenido de este sitio web, incluidos logotipos, marcas registradas y texto, es propiedad de PEDCER CERVECERIA ARTESANAL y no puede ser utilizado sin nuestro permiso expreso por escrito.</p>
                    </div>

                    <!-- Política de privacidad -->
                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Política de Privacidad</h6>
                        <ol>
                            <li><strong>Recopilación de Información</strong>: Recopilamos información personal de nuestros usuarios para mejorar su experiencia de compra, como nombre, dirección, correo electrónico, número de teléfono y fecha de nacimiento.</li>
                            <li><strong>Uso de la Información</strong>: Utilizamos la información para mejorar nuestros productos, personalizar su experiencia y comunicarnos con usted.</li>
                            <li><strong>Compartir Información</strong>: No vendemos su información, pero podemos compartirla con proveedores de servicios y autoridades legales si es necesario.</li>
                            <li><strong>Seguridad de la Información</strong>: Implementamos medidas de seguridad para proteger sus datos personales mediante encriptación y otros métodos de seguridad.</li>
                            <li><strong>Sus Derechos</strong>: Usted tiene derecho a acceder, corregir y solicitar la eliminación de sus datos personales. Para ejercer estos derechos, puede contactarnos en <a href="mailto:pedcerartesanal@gmail.com">pedcerartesanal@gmail.com</a>.</li>
                        </ol>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Modificaciones a los Términos</h6>
                        <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Las modificaciones se publicarán en esta página y entrarán en vigor inmediatamente.</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-uppercase font-weight-bold">Legislación Aplicable y Jurisdicción</h6>
                        <p>Estos términos se rigen por las leyes de Colombia. Cualquier disputa será resuelta en los tribunales de Huila, Colombia.</p>
                    </div>

                    <div class="mb-4">
                        <p>Fecha de última actualización: 11/07/2024</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>