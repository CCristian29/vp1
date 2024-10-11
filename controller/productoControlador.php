
 <?php

    if ($peticionAjax) {
        require_once "../model/mainModel.php";
    } else {
        require_once "./model/mainModel.php";
    }

    class productoControlador extends mainModel
    {
        // agregar nuevos productos
        public function agregar_producto_controlador(){
            $codigo = mainModel::limpiar_cadena($_POST['codigo_pro']);
            $nombre = mainModel::limpiar_cadena($_POST['nombre_pro']);
            $fabricante = mainModel::limpiar_cadena($_POST['fabricante_pro']);
            $fecha_elaboracion = mainModel::limpiar_cadena($_POST['fecha_elaboracion_pro']);
            $precio = mainModel::limpiar_cadena($_POST['precio_pro']);
            $cantidad = mainModel::limpiar_cadena($_POST['cantidad_disponible_pro']);
            $nivel_alcohol = mainModel::limpiar_cadena($_POST['nivel_alcohol_pro']);
            $volumen = mainModel::limpiar_cadena($_POST['volumen_pro']);
            $categoria = mainModel::limpiar_cadena($_POST['producto_categoria_reg']);
            $estado = mainModel::limpiar_cadena($_POST['producto_estado_reg']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion_pro']);

            /*---comprobar campos vacios---*/
            if (empty($codigo) || empty($nombre) || empty($descripcion) || empty($precio)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "Debe llenar todos los campos del formulario",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*== Verificando integridad de los datos ==*/

            if (mainModel::verificar_datos("[0-9]{10,11}", $codigo)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El codigo del producto no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\ ]{4,60}", $nombre)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El nombre no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\ ]{4,60}", $fabricante)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El nombre no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            // Validación del formato de la fecha
            if (mainModel::verificar_datos("[0-9]{4}-[0-9]{2}-[0-9]{2}", $fecha_elaboracion)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La fecha de elaboración no es válida. Debe estar en formato YYYY-MM-DD",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $precio = number_format($precio, COIN_DECIMALS, '.', '');
            if ($precio < 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El precio de venta no puede ser menor a cero",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModel::verificar_datos("[0-9]{0,7}", $cantidad)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La cantidad disponible no puede ser menor a cero y debe ser un número entero",
                    "Tipo" => "error"
                ];

                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-Z%0-9]{1,8}", $nivel_alcohol)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El nivel de alcohol no puede ser menor a cero",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }


            if (mainModel::verificar_datos("[a-zA-Z0-9]{3,10}", $volumen)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El volumen del producto no puede ser menor a cero",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if ($estado != "Habilitado" && $estado != "Deshabilitado") {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Opción no valida",
                    "Texto" => "Ha seleccionado un ESTADO de producto no valido",
                    "Icon" => "error",
                    "TxtBtn" => "Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }

            $check_categoria = mainModel::ejecutar_consulta_simple("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria' AND categoria_estado='Habilitada'");
            if ($check_categoria->rowCount() <= 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La CATEGORÍA que ha seleccionado no existe o se encuentra deshabilitada.",
                    "Icon" => "error",
                    "TxtBtn" => "Aceptar"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_categoria->closeCursor();
            $check_categoria = mainModel::desconectar($check_categoria);


            if ($_FILES['imagen_pro']['tmp_name']) {
                // Ruta de destino en el servidor donde se guardará la imagen
                $rutaDestino = '../views/assets/img/img-productos/';

                // Generar un nombre único para la imagen
                $nombreImagen = uniqid() . '_' . $_FILES['imagen_pro']['name'];

                // Ruta completa de la imagen en el servidor
                $rutaImagen = $rutaDestino . $nombreImagen;

                // Mover la imagen cargada a la ruta de destino en el servidor
                if (move_uploaded_file($_FILES['imagen_pro']['tmp_name'], $rutaImagen)) {
                    // La imagen se ha cargado correctamente
                    $rutabd = $nombreImagen;
                    // Agrega la ruta de la imagen al array de datos del producto
                    $datos_registro_producto['imagen'] = $rutabd;
                } else {
                    // Ocurrió un error al cargar la imagen
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Error al subir la imagen",
                        "Texto" => "Ocurrió un error al subir la imagen del producto.",
                        "Tipo" => "error"
                    ];
                    return json_encode($alerta);
                }
            }

            if (mainModel::verificar_datos("[a-zA-Z0-9%áéíóúÁÉÍÓÚñÑ\ ]{4,250}", $descripcion)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La descripcion del producto no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }


            $check_dni = mainModel::ejecutar_consulta_simple("SELECT codPro FROM producto WHERE codPro='$codigo'");
            if ($check_dni->rowCount() > 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El codigo del producto ingresado ya se encuentra registrado" . $codigo,
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $check_dni = mainModel::ejecutar_consulta_simple("SELECT nomPro FROM producto WHERE nomPro='$nombre'");
            if ($check_dni->rowCount() > 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El producto ingresado ya se encuentra registrado" . $nombre,
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $datos_registro_producto = [
                "codPro" => [
                    "campo_marcador" => ":Codigo",
                    "campo_valor" => $codigo
                ],
                "nomPro" => [
                    "campo_marcador" => ":Nombre",
                    "campo_valor" => $nombre
                ],
                "fabPro" => [
                    "campo_marcador" => ":Fabricante",
                    "campo_valor" => $fabricante
                ],
                "fecElaPro" => [
                    "campo_marcador" => ":Fecha",
                    "campo_valor" => $fecha_elaboracion
                ],
                "prePro" => [
                    "campo_marcador" => ":Precio",
                    "campo_valor" => $precio
                ],
                "nivAlcPro" => [
                    "campo_marcador" => ":Nivel",
                    "campo_valor" => $nivel_alcohol
                ],
                "volPro" => [
                    "campo_marcador" => ":Volumen",
                    "campo_valor" => $volumen
                ],
                "producto_stock" => [
                    "campo_marcador" => ":Cantidad",
                    "campo_valor" => $cantidad
                ],
                "categoria_id" => [
                    "campo_marcador" => ":Categoria",
                    "campo_valor" => $categoria
                ],
                "producto_estado" => [
                    "campo_marcador" => ":Estado",
                    "campo_valor" => $estado
                ],
                "imgPro" => [
                    "campo_marcador" => ":Imagen",
                    "campo_valor" => $rutabd
                ],
                "desPro" => [
                    "campo_marcador" => ":Descripcion",
                    "campo_valor" => $descripcion
                ]

            ];
            $agregar_producto = mainModel::guardar_datos("producto", $datos_registro_producto);
            if ($agregar_producto->rowCount() == 1) {
                $alerta = [
                    "Alerta" => "limpiar",
                    "Titulo" => "usuario registrado",
                    "Texto" => "El producto han sido agregado con exito",
                    "Tipo" => "success"
                ];
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos podido registrar el producto",
                    "Tipo" => "error"
                ];
            }
            $agregar_producto->closeCursor();
            $agregar_producto = mainModel::desconectar($agregar_producto);

            echo json_encode($alerta);
        }
        // mostrar lista de productos
        public function paginador_ver_productos_controlador($pagina, $registros, $url, $busqueda){
            $pagina = mainModel::limpiar_cadena($pagina);
            $registros = mainModel::limpiar_cadena($registros);

            $url = mainModel::limpiar_cadena($url);
            $url = SERVERURL . DASHBOARD . "/" . $url . "/";

            $busqueda = mainModel::limpiar_cadena($busqueda);
            $id = 1;
            $tabla = "";

            $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
            $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

            if (isset($busqueda) && $busqueda != "") {
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM producto WHERE (nomPro LIKE '%$busqueda%' OR desPro LIKE '%$busqueda%' OR prroducto_stock LIKE '%$busqueda%' OR imgPro LIKE '%$busqueda%' OR prePro LIKE '%$busqueda%') ORDER BY nomPro ASC LIMIT $inicio,$registros";
            } else {
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM producto ORDER BY nomPro ASC LIMIT $inicio,$registros";
            }

            $conexion = mainModel::conectar();

            $datos = $conexion->query($consulta);

            $datos = $datos->fetchAll();

            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();

            $Npaginas = ceil($total / $registros);

            //  Encabezado de la tabla -
            $tabla .= '
            <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr class="text-center font-weight-bold">
                        <th>N</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
            ';

            if ($total >= 1 && $pagina <= $Npaginas) {
                $contador = $inicio + 1;
                $pag_inicio = $inicio + 1;
                foreach ($datos as $rows) {
                    $tabla .= '
						<tr class="text-center" >
							<td>' . $contador . '</td>
							<td>' . $rows['nomPro'] . '</td>
							<td>' . $rows['desPro'] . '</td>
							<td>' . $rows['producto_stock'] . '</td>
							<td>' . $rows['categoria_id']. '</td>

							<td>' . $rows['prePro'] . '</td>
							<td>
                                <a class="btn btn-link text-success" href="' . SERVERURL . DASHBOARD . '/actualizar-producto/' . mainModel::encryption($rows['idPro']) . '/"><i class="fas fa-sync-alt"></i></a>
                            
							<td>
                                <form class="FormularioAjax" action="' . SERVERURL . 'ajax/productoAjax.php" method="POST" data-form="delete">
                                    <input type="hidden" name="modulo_producto" value="eliminar">
                                    <input type="hidden" name="producto_id_del" value="' . mainModel::encryption($rows['idPro']) . '">
                                    <button type="submit" class="btn btn-link text-danger"><i class="far fa-trash-alt"></i></button>
                                </form>
							</td>
						</tr>
					';
                    $contador++;
                }
                $pag_final = $contador - 1;
            } else {
                if ($total >= 1) {
                    $tabla .= '
						<tr class="text-center" >
							<td colspan="7">
								<a href="' . $url . '" class="btn btn-primary btn-sm">
									Haga clic acá para recargar el listado
								</a>
							</td>
						</tr>
					';
                } else {
                    $tabla .= '
						<tr class="text-center" >
							<td colspan="7">
								No hay registros en el sistema
							</td>
						</tr>
					';
                }
            }

            $tabla .= '</tbody></table></div>';

            if ($total > 0 && $pagina <= $Npaginas) {
                $tabla .= '<p class="text-end">Mostrando clientes <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
            }

            /*--Paginacion  --*/
            if ($total >= 1 && $pagina <= $Npaginas) {
                $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 10, LANG);
            }

            return $tabla;
        }
        public function cliente_paginador_producto_controlador($pagina, $registros, $url, $orden, $categoria, $busqueda){
            $pagina = mainModel::limpiar_cadena($pagina);
            $registros = mainModel::limpiar_cadena($registros);

            $url = mainModel::limpiar_cadena($url);
            $orden = mainModel::limpiar_cadena($orden);
            $categoria = mainModel::limpiar_cadena($categoria);
            $busqueda = mainModel::limpiar_cadena($busqueda);
            $url = SERVERURL . $url . "/" . $categoria . "/" . $orden . "/";
            $tabla = "";


            /*-- Lista blanca para orden de busqueda - Whitelist for search order --*/
            $orden_lista = ["ASC", "DESC", "MAX", "MIN"];

            if (!in_array($orden, $orden_lista)) {
                return '
                    <div class="alert alert-danger text-center" role="alert" data-mdb-color="danger">
                        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                        <p class="mb-0">Lo sentimos, no podemos realizar la búsqueda de productos ya que al parecer a ingresado un dato incorrecto.</p>
                    </div>
				';
                exit();
            }

            // Estableciendo orden de busqueda 
            if ($orden == "ASC" || $orden == "DESC") {
                $campo_orden = "nomPro $orden";
            } elseif ($orden == "MAX" || $orden == "MIN") {
                if ($orden == "MAX") {
                    $campo_orden = "producto_precio_venta DESC";
                } else {
                    $campo_orden = "producto_precio_venta ASC";
                }
            } else {
                $campo_orden = "nomPro ASC";
            }

            /*-- Comprobando categoria - Checking category --*/
            if ($categoria != "all") {
                $check_categoria = mainModel::ejecutar_consulta_simple("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria' AND categoria_estado='Habilitada'");
                if ($check_categoria->rowCount() <= 0) {
                    return '
                        <div class="alert alert-danger text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                            <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                            <p class="mb-0">Lo sentimos, no podemos realizar la búsqueda de productos ya que al parecer a ingresado una categoría incorrecta.</p>
                        </div>
                    ';
                    exit();
                }
                $check_categoria->closeCursor();
                $check_categoria = mainModel::desconectar($check_categoria);
            }


            $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
            $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;


            $campos = "*";

            if (isset($busqueda) && $busqueda != ""
            ) {
                if ($categoria != "all") {
                    $condicion_busqueda = "categoria_id='$categoria' AND";
                } else {
                    $condicion_busqueda = "";
                }
                $consulta = "SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE $condicion_busqueda producto_estado='Habilitado' AND producto_stock>0 AND nomPro LIKE '%$busqueda%' ORDER BY $campo_orden LIMIT $inicio,$registros";
            } elseif ($categoria != "all") {
                $consulta = "SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE producto_estado='Habilitado' AND categoria_id='$categoria' AND producto_stock>0 ORDER BY $campo_orden LIMIT $inicio,$registros";
            } else {
                $consulta = "SELECT SQL_CALC_FOUND_ROWS $campos FROM producto WHERE producto_estado='Habilitado' AND producto_stock>0 ORDER BY $campo_orden LIMIT $inicio,$registros";
            }

            $conexion = mainModel::conectar();

            $datos = $conexion->query($consulta);

            $datos = $datos->fetchAll();

            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();

            $Npaginas = ceil($total / $registros);

            $tabla .= '<div class="container-cards full-box">';

            if ($total >= 1 && $pagina <= $Npaginas
            ) {
                $contador = $inicio + 1;
                $pag_inicio = $inicio + 1;
                $tabla .= '<div class="container px-4 px-lg-5 mt-5">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';

                foreach ($datos as $rows) {
                    $total_price = $rows['prePro'];

                    $tabla .= '<div class="col mb-5 card-product-pro">
                        <div class="card h-100">
                            <!-- Product image-->
                            <figure class="card-product-img">';
                    if (is_file("./views/assets/img/img-productos/" . $rows['imgPro'])) {
                        $tabla .= '<img src="' . SERVERURL . 'views/assets/img/img-productos/' . $rows['imgPro'] . '" class="card-img-top" alt="' . $rows['nomPro'] . '" />';
                    } else {
                        $tabla .= '<img src="' . SERVERURL . 'views/assets/img/img-productos/default.jpg" class="card-img-top" alt="' . $rows['nomPro'] . '" />';
                    }
                    $tabla .= '</figure>
                            <!-- Product details-->
                            <div class="card-product-body">
                                <h5 class="text-center fw-bolder">' . mainModel::limitar_cadena($rows['nomPro'], 70, "...") . '</h5>
                                <p class="card-product-price text-center fw-bolder">' . COIN_SYMBOL . number_format($total_price, COIN_DECIMALS, COIN_SEPARATOR_DECIMAL, COIN_SEPARATOR_THOUSAND) . ' ' . COIN_NAME . '</p>
                            </div>
                            <div class="text-center card-product-options" style="padding: 5px 0;">
                                <a href="' . SERVERURL . 'details/' . mainModel::encryption($rows['idPro']) . '/" type="button" class="badge badge-light btn-rounded text-success"><i class="fas fa-shopping-bag fa-fw"></i> &nbsp; comprar</a>
                                &nbsp; &nbsp;
                                <a href="' . SERVERURL . 'details/' . mainModel::encryption($rows['idPro']) . '/" class=" badge badge-light btn-sm btn-rounded"><i class="fas fa-box-open fa-fw"></i> &nbsp; Detalles</a>
                                &nbsp; &nbsp;  
                                
                                <form id="form-agregar-carrito-' . $rows['idPro'] . '" method="post">
                                    <input type="hidden" name="modulo_carrito" value="agregar">                          
                                    <input type="hidden" name="idProducto" value="' . mainModel::encryption($rows['idPro']) . '">
                                </form>

                                <button class="btn btn-success agregar-carrito" data-id="' . $rows['idPro'] . '">
                                    <i class="fas fa-cart-plus"></i> Agregar al carrito
                                </button>
                            </div>
    
                        </div>
                    </div>';
                    $contador++;
                }

                $pag_final = $contador - 1;
            } else {
                if ($total >= 1) {
                    $tabla .= '
                        <div class="alert alert-default text-center" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-boxes fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">Haga clic en el botón para listar nuevamente los productos que están registrados en la tienda.</h4>
                            <a href="' . $url . '" class="btn btn-primary btn-rounded btn-lg" data-mdb-ripple-color="dark">Haga clic acá para recargar el listado</a>
                        </div>
					';
                } else {
                    $tabla .= '
                        <div class="alert alert-default text-center p-5" role="alert" data-mdb-color="danger">
                            <p><i class="fas fa-broadcast-tower fa-fw fa-5x"></i></p>
                            <h4 class="alert-heading">¡Lo sentimos, no hay productos agregados en el inventario!</h4>
                            <p class="mb-0">No hemos encontrado productos registrados en la tienda.</p>
                        </div>
					';
                }
            }

            $tabla .= '</div>';

            if ($total > 0 && $pagina <= $Npaginas) {
                $tabla .= '<p class="text-end">Mostrando productos <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
            }

            /*--Paginacion - Pagination --*/
            if ($total >= 1 && $pagina <= $Npaginas) {
                $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 6, LANG);
            }

            return $tabla;
        } 
        // actualizar producto
        public function actualizar_datos_producto_controlador(){
            if ($_SESSION['rol_virtual']!= 1 && $_SESSION['rol_virtual']!= 2) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Acceso no permitido",
                    "Texto" => "No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $id = mainModel::decryption($_POST['producto_id_up']);
            $id = mainModel::limpiar_cadena($id);

            // comprobacion de producto
            $check_producto = mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE idPro='$id'");
            if ($check_producto->rowCount() <= 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Producto no encontrado",
                    "Texto" => "El producto que intenta actualizar no existe en el sistema",
                    "Tipo" => "error",
                ];
                echo json_encode($alerta);
                exit();
            } else {
                $campos = $check_producto->fetch();
            }
            $check_producto->closeCursor();
            $check_producto = mainModel::desconectar($check_producto);

            
            $codigo = mainModel::limpiar_cadena($_POST['producto_codigo_up']);
            $nombre = mainModel::limpiar_cadena($_POST['producto_nombre_up']);
            $fabricante = mainModel::limpiar_cadena($_POST['producto_fabricante_up']);
            $fecha_elaboracion = mainModel::limpiar_cadena($_POST['producto_fecha_elaboracion_up']);
            $precio = mainModel::limpiar_cadena($_POST['precio_up']);
            $can_disponible = mainModel::limpiar_cadena($_POST['cantidad_disponible_up']);
            $nivel_alcohol = mainModel::limpiar_cadena($_POST['nivel_alcohol_up']);
            $volumen = mainModel::limpiar_cadena($_POST['volumen_up']);
            $descripcion_producto = mainModel::limpiar_cadena($_POST['producto_descripcion_up']);


            // comprobacion de campos obligatorios vacios
            if (empty($codigo) || empty($fabricante)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "Algunos campos obligatorios estan vacios",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[0-9]{10,15}", $codigo)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El código del producto no cumple con el tipo de dato solicitado",
                    "Tipo" => "error"

                ];
                echo json_encode($alerta);
                exit();
            }
            
            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\ ]{4,60}", $nombre)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El nombre no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            if (mainModel::verificar_datos("[a-zA-Z]{4,30}", $fabricante)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El nombre del fabricante no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            // Validación del formato de la fecha
            if (mainModel::verificar_datos("[0-9]{4}-[0-9]{2}-[0-9]{2}", $fecha_elaboracion)) {
                $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "La fecha de elaboración no es válida. Debe estar en formato YYYY-MM-DD",
                        "Tipo" => "error"
                    ];
                echo json_encode($alerta);
                exit();
            }


            $precio = number_format($precio, COIN_DECIMALS, '.', '');
            if ($precio < 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El precio de venta no puede ser menor a cero",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModel::verificar_datos("[0-9]{0,7}", $can_disponible)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La cantidad disponible no puede ser menor a cero y debe ser un número entero",
                    "Tipo" => "error"
                ];

                echo json_encode($alerta);
                exit();
            }
        
            if (mainModel::verificar_datos("[a-zA-Z%0-9]{1,8}", $nivel_alcohol)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El nivel de alcohol no puede ser menor a cero",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            
            if (mainModel::verificar_datos("[a-zA-Z0-9]{3,10}",$volumen)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El volumen del producto no puede ser menor a cero",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\ ]{4,240}", $descripcion_producto)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La descripcion no cumple con el tipo de dato requerido",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
                        
            if($campos['codPro']!=$codigo){
                $check_codigo=mainModel::ejecutar_consulta_simple("SELECT codPro FROM producto WHERE codPro = '$nombre' AND codPro='$codigo'");
                if($check_codigo->rowCount()>0){
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "El nombre del producto ya existe",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();

                }
                $check_codigo->closeCursor();
                $check_codigo = mainModel::desconectar($check_codigo);
            }
          
            if($campos['nomPro']!=$nombre){
                $check_nombre=mainModel::ejecutar_consulta_simple("SELECT nomPro FROM producto WHERE nomPro='$nombre' AND nomPro='$nombre'");
                if($check_nombre->rowCount()>0){
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "El nombre del producto ya existe",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_nombre->closeCursor();
                $check_nombre = mainModel::desconectar($check_nombre);
            }
        
            $datos_producto_up=[
                "codPro"=>[
                    "campo_marcador"=>":Codigo",
                    "campo_valor"=>$codigo
                ],
                "nomPro"=>[
                    "campo_marcador"=>":Nombre",
                    "campo_valor"=>$nombre
                ],
                "fabPro"=>[
                    "campo_marcador"=>":Fabricante",
                    "campo_valor"=>$fabricante
                ],
                "fecElaPro"=>[
                    "campo_marcador"=>":Fecha",
                    "campo_valor"=>$fecha_elaboracion
                ],
                "prePro"=>[
                    "campo_marcador"=>":Precio",
                    "campo_valor"=>$precio
                ],
                "canDisPro"=>[
                    "campo_marcador"=>":Cantidad",
                    "campo_valor"=>$can_disponible
                ],
                "nivAlcPro"=>[
                    "campo_marcador"=>":Nivel",
                    "campo_valor"=>$nivel_alcohol
                ],
                "volPro"=>[
                    "campo_marcador"=>":Volumen",
                    "campo_valor"=>$volumen
                ],
                "desPro"=>[
                    "campo_marcador"=>":Descripcion",
                    "campo_valor"=>$descripcion_producto
                ]
            ];
            $condicion=[
                "condicion_campo"=>"idPro",
                "condicion_marcador"=>":ID",
                "condicion_valor"=>$id
            ];

            if(mainModel::actualizar_datos("producto",$datos_producto_up,$condicion)){
                $alerta = [
                    "Alerta" => "recargar",
                    "Titulo" => "Producto actualizado",
                    "Texto" => "El producto ha sido actualizado con éxito",
                    "Tipo" => "success"
                ];
                echo json_encode($alerta);
            }else{
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos podido actualizar el producto en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }
        // eliminar productos
        public function eliminar_producto_controlador(){
            $id = mainModel::decryption($_POST['producto_id_del']);
            $id = mainModel::limpiar_cadena($id);

            // comprobar usuario
            $check_producto = mainModel::ejecutar_consulta_simple("SELECT idPro FROM producto WHERE idPro='$id'");
            if ($check_producto->rowCount() <= 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos encontrado el producto en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $eliminar_producto = mainModel::eliminar_registro("producto", "idPro", $id);
            if ($eliminar_producto->rowCount() == 1) {
                $alerta = [
                    "Alerta" => "recargar",
                    "Titulo" => "Usuario eliminado",
                    "Texto" => "El producto ha sido eliminado con exito",
                    "Tipo" => "success"
                ];
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos podido eliminar el producto",
                    "Tipo" => "error"
                ];
            }
            $eliminar_producto->closeCursor();
            $eliminar_producto = mainModel::desconectar($eliminar_producto);

            echo json_encode($alerta);
        }

        // carrito de compras


    }
