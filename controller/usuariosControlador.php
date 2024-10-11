<?php

    if ($peticionAjax) {
        require_once "../model/mainModel.php";
    } else {
        require_once "./model/mainModel.php";
    }

    class usuariosControlador extends mainModel{

        // /*--- controlador agregar usuario---*/
        public function agregar_usuario_controlador(){
            $nombre = mainModel::limpiar_cadena($_POST['nomUsu']);
            $tipoDocumento = mainModel::limpiar_cadena($_POST['tipIdeUsu']);
            $documento = mainModel::limpiar_cadena($_POST['docIdeUsu']);
            $departamento = mainModel::limpiar_cadena($_POST['depUsu']);
            $direccion = mainModel::limpiar_cadena($_POST['dirResUsu']);
            $fechaNacimiento = mainModel::limpiar_cadena($_POST['fecNacUsu']);
            $correo = mainModel::limpiar_cadena($_POST['corEleUsu']);
            $telefono = mainModel::limpiar_cadena($_POST['telUsu']);
            $clave = mainModel::limpiar_cadena($_POST['conSegUsu']);
            $terminos_condiciones = mainModel::limpiar_cadena($_POST['terConUsu']);


            /*---comprobar campos vacios---*/
            if (empty($nombre) || empty($tipoDocumento) || empty($documento) || empty($departamento) || empty($direccion) || empty($fechaNacimiento) || empty($correo) || empty($telefono) || empty($clave) || empty($terminos_condiciones)){
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

                if (mainModel::verificar_datos("^(Cedula de Ciudadania|cedula de extranjería|Pasaporte)$", $tipoDocumento)) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "El tipo de documento seleccionado no es válido.",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                if (mainModel::verificar_datos("[0-9]{10,15}", $documento)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El documento de identidad no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{5,190}", $direccion)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El apellido no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $fecha_converted = date('Y-m-d', strtotime($fechaNacimiento));
            if (mainModel::verificar_fecha($fecha_converted)){
                $alerta=[
                    "Alerta" => "simple",
                    "Titulo" => "Error",
                    "Texto" => "La fecha de nacimiento no es válida.",
                    "Tipo" => "error"
                ];
            }
            if (mainModel::verificar_datos("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}", $correo)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El Correo no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModel::verificar_datos("[0-9()+]{10,15}", $telefono)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El Numero no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_dni = mainModel::ejecutar_consulta_simple("SELECT docIdeUsu FROM usuarios WHERE docIdeUsu='$documento'");
            if ($check_dni->rowCount() > 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El documento ingresado ya se encuentra registrado en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*== Comprobando email ==*/
            if ($correo != "") {
                if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                    $check_email = mainModel::ejecutar_consulta_simple("SELECT corEleUsu FROM usuarios WHERE corEleUsu='$correo'");
                    if ($check_email->rowCount() > 0) {
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Ocurrió un error inesperado",
                            "Texto" => "El EMAIL ingresado ya se encuentra registrado en el sistema",
                            "Tipo" => "error"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                } else {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "Ha ingresado un correo no valido",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                }
            if ($terminos_condiciones != 1) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "Debe aceptar los terminos y condiciones",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
    

            if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La contraseña no coinciden con el formato solicitado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $clavee = mainModel::encryption($clave);
            
     
            $datos_cliente_reg = [
                "nomUsu" => [
                    "campo_marcador" => ":Nombre",
                    "campo_valor" => $nombre
                ],
                "tipIdeUsu" => [
                    "campo_marcador" => ":TipoDocumetno",
                    "campo_valor" => $tipoDocumento
                ],
                "docIdeUsu" => [
                    "campo_marcador" => ":Documento",
                    "campo_valor" => $documento
                ],
                "depUsu" => [
                    "campo_marcador" => ":Departamento",
                    "campo_valor" => $departamento
                ],
                "ciuUsu" => [
                    "campo_marcador" => ":Direccion",
                    "campo_valor" => $direccion
                ],
                "fecNacUsu" => [
                    "campo_marcador" => ":fechaNacimiento",
                    "campo_valor" => $fecha_converted
                ],
                "corEleUsu" => [
                    "campo_marcador" => ":Correo",
                    "campo_valor" => $correo
                ],
                "telUsu" => [
                    "campo_marcador" => ":Telefono",
                    "campo_valor" => $telefono
                ],
                "conSegUsu" => [
                    "campo_marcador" => ":Clave",
                    "campo_valor" => $clavee
                ],
                "rolUsu" => [
                    "campo_marcador" => ":Rol",
                    "campo_valor" => 3
                ],
                "terConUsu" => [
                    "campo_marcador" => ":Terminos_condiciones",
                    "campo_valor" => $terminos_condiciones
                ]
            ];

            // Guardando datos del cliente 
            $agregar_cliente = mainModel::guardar_datos("usuarios", $datos_cliente_reg);

            if ($agregar_cliente->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "¡Registro Exitoso!",
                "Texto" => "Te has registrado exitosamente, ya puedes iniciar sesión con los datos registrados",
                "Tipo" => "success"
            ];
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos podido registrar los datos, por favor intente nuevamente",
                    "Icon" => "error",
                    "TxtBtn" => "Aceptar"
                ];
            }

            $agregar_cliente->closeCursor();
            $agregar_cliente = mainModel::desconectar($agregar_cliente);

            echo json_encode($alerta);
        } 
        // eliminar usuario
        public function eliminar_usuario_controlador(){
            $id =mainModel::decryption($_POST['usuario_id_del']);
            $id=mainModel::limpiar_cadena($id);

            if ($id==1){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No se puede eliminar el usuario del sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            // comprobar usuario
            $check_usuario=mainModel::ejecutar_consulta_simple("SELECT idUsu FROM usuarios WHERE idUsu='$id'");
            if ($check_usuario->rowCount() <= 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos encontrado el usuario en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            $check_usuario->closeCursor();
            $check_usuario = mainModel::desconectar($check_usuario);
            }
            // comprabar si usuario tiene una compra
            // $check_compras = mainModel::ejecutar_consulta_simple("SELECT idUsu FROM ventas WHERE idUsu='$id' LIMIT 1"); 
            // if ($check_usuario->rowCount() > 0) {
            //     $alerta = [
            //         "Alerta" => "simple",
            //         "Titulo" => "Ocurrió un error inesperado",
            //         "Texto" => "No se puede eliminar este usuario debido a que tiene una compra pendiente",
            //         "Tipo" => "error"
            //     ];
            //     echo json_encode($alerta);
            //     exit();
            // }
            session_start(['name' => 'virtual']);
            if ($_SESSION['rol_virtual'] != 1) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No tienes los permisos necesarios para realizar esta operacion",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $eliminar_cliente = mainModel::eliminar_registro("usuarios","idUsu", $id);
            if($eliminar_cliente->rowCount()==1){
                $alerta = [
                    "Alerta" => "recargar",
                    "Titulo" => "Usuario eliminado",
                    "Texto" => "El usuario ha sido eliminado con exito",
                    "Tipo" => "success"
                ];
            }else{
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos podido eliminar el usuario",
                    "Tipo" => "error"
                ];
            }
            $eliminar_cliente->closeCursor();
            $eliminar_cliente = mainModel::desconectar($eliminar_cliente);

            echo json_encode($alerta);
        }
        public function actualizar_datos_cliente_controlador(){
            if ($_SESSION['rol_virtual'] != 1 && $_SESSION['rol_virtual'] != 3) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Acceso no permitido ",
                    "Texto" => "No tienes los permisos necesarios para realizazr esta operacion en el sistema",
                    "Tipo" => "error"
                ];
                return json_encode($alerta);
            }
            $id = mainModel::decryption($_POST['cliente_id_up']);
            $id = mainModel::limpiar_cadena($id);


            $check_cliente = mainModel::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE idUsu='$id'");
            if ($check_cliente->rowCount() <= 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Usuario no encontrado",
                    "Texto" => "El usuario que intenta actualizar no existe en el sistema",
                    "Tipo" => "error",
                ];
                echo json_encode($alerta);
                exit();
            } else {
                $campos = $check_cliente->fetch();
            }
            $check_cliente->closeCursor();
            $check_cliente = mainModel::desconectar($check_cliente);

            $nombre = mainModel::limpiar_cadena($_POST['nombre_usuario_up']);
            $tipoDocumento = mainModel::limpiar_cadena($_POST['tipo_documento_usuario_up']);
            $documento = mainModel::limpiar_cadena($_POST['numero_documento_usuario_up']);
            $correo = mainModel::limpiar_cadena($_POST['correo_electronico_usuario_up']);
            $telefono = mainModel::limpiar_cadena($_POST['telefono_usu_up']);
            $departamento = mainModel::limpiar_cadena($_POST['departamento_usuario_up']);
            $ciudad = mainModel::limpiar_cadena($_POST['ciudad_usuario_up']);
            $direccion_residencia = mainModel::limpiar_cadena($_POST['direccion_recidencia_up']);


            if (empty($nombre)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "Algunos campos obligatorios estan vacios",
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

            if (mainModel::verificar_datos("[0-9]{10,15}", $documento)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El Numero de documento no cumple con el tipo de dato solicitado",
                    "Tipo" => "error"

                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModel::verificar_datos("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}", $correo)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El Correo no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModel::verificar_datos("[0-9()+]{10,15}",
                $telefono
            )) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El Número no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚ,\ ]{4,60}", $departamento)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El departamento seleccionado no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚ\ ]{4,60}", $ciudad)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La ciudad seleccionada no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if (mainModel::verificar_datos("[a-zA-Z0-9 #-]{6,60}", $direccion_residencia)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La direccion de recidencia seleccionada no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $datos_usuario_up = [
                "nomUsu" => [
                    "campo_marcador" => ":nombre",
                    "campo_valor" => $nombre
                ],
                "tipIdeUsu" => [
                    "campo_marcador" => ":Tipo_Documento",
                    "campo_valor" => $tipoDocumento
                ],
                "docIdeUsu" => [
                    "campo_marcador" => ":documento",
                    "campo_valor" => $documento

                ],
                "corEleUsu" => [
                    "campo_marcador" => ":correo",
                    "campo_valor" => $correo
                ],
                "telUsu" => [
                    "campo_marcador" => ":telefono",
                    "campo_valor" => $telefono
                ],
                "depUsu" => [
                    "campo_marcador" => ":departamento",
                    "campo_valor" => $departamento
                ],
                "ciuUsu" => [
                    "campo_marcador" => ":ciudad",
                    "campo_valor" => $ciudad
                ],
                "dirResUsu" => [
                    "campo_marcador" => ":direccion_residencia",
                    "campo_valor" => $direccion_residencia
                ]

            ];
            $condicion = [
                "condicion_campo" => "idUsu",
                "condicion_marcador" => ":ID",
                "condicion_valor" => $id
            ];

            if (mainModel::actualizar_datos("usuarios", $datos_usuario_up, $condicion)) {
                $alerta = [
                    "Alerta" => "recargar",
                    "Titulo" => "Usuario actualizado",
                    "Texto" => "Los datos del Usuario ha sido actualizado con éxito",
                    "Tipo" => "success"
                ];
                echo json_encode($alerta);
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos podido actualizar los datos del usuario en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }

        public function paginador_cliente_controlador($pagina, $registros, $url, $busqueda){
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE (nomUsu LIKE '%$busqueda%' OR corEleUsu LIKE '%$busqueda%' OR depUsu LIKE '%$busqueda%' OR dirUsu LIKE '%$busqueda%') ORDER BY nomUsu ASC LIMIT $inicio,$registros";
            } else {
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE rolUsu='3' ORDER BY nomUsu ASC LIMIT $inicio,$registros";
            }

            $conexion = mainModel::conectar();

            $datos = $conexion->query($consulta);

            $datos = $datos->fetchAll();

            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();

            $Npaginas = ceil($total / $registros);

            //  Encabezado de la tabla - Table header
            $tabla .= '
                <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr class="text-center font-weight-bold">
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
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
                                <td>' . $rows['nomUsu'] .'</td>
                                <td>' . $rows['corEleUsu'] . '</td>
                                <td>' . $rows['telUsu'] . '</td>
                                <td>
                                    <a class="dropdown-item text-success" href="' . SERVERURL . DASHBOARD . '/actualizar-clientes/' . mainModel::encryption($rows['idUsu']) . '/"><i class="fas fa-sync-alt"></i></a>
                                    </a>
                                </td>
                                <td>
                                    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/usuariosAjax.php" method="POST" data-form="delete">
                                        <input type="hidden" name="modulo_cliente" value="eliminar">    
                                        <input type="hidden" name="usuario_id_del" value="' . mainModel::encryption($rows['idUsu']) . '">
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
                $tabla .= mainModel::paginador_tablas($pagina,$Npaginas,$url,10,LANG);
            }

            return $tabla;
        }

        // funcion para restablecer clave
        public function restablecer_clave_controlador(){
            $email = mainModel::limpiar_cadena($_POST['email']);

            if ($email != "") {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $check_email = mainModel::ejecutar_consulta_simple("SELECT corEleUsu FROM usuarios WHERE corEleUsu='$email'");
                    if ($check_email->rowCount() > 0) {
                        $code = rand(100000, 999999); // Generar un código de 6 dígitos
                        $expire = date("Y-m-d H:i:s", strtotime("+10 minutes")); // Código válido por 10 minutos

                        // Guardar el código y su expiración en la base de datos
                        $query = mainModel::ejecutar_consulta_simple("UPDATE usuarios SET reset_token='$code', reset_token_expire='$expire' WHERE corEleUsu='$email'");

                        if ($query) {
                            // Enviar el correo
                            $subject = "Código de restablecimiento de contraseña";
                            $message = "Tu código de restablecimiento de contraseña es: $code";
                            $headers = "From: scuadfive64@gmail.com";

                            if (mail($email, $subject, $message,
                                $headers
                            )) {
                                $alerta = [
                                    "Alerta" => "redireccionar",
                                    "URL" => SERVERURL . "verificarCodigo/"
                                ];
                            } else {
                                $alerta = [
                                    "Alerta" => "simple",
                                    "Titulo" => "Ocurrió un error inesperado",
                                    "Texto" => "No se pudo enviar el correo.",
                                    "Tipo" => "error"
                                ];
                            }
                        } else {
                            $alerta = [
                                    "Alerta" => "simple",
                                    "Titulo" => "Ocurrió un error inesperado",
                                    "Texto" => "No se pudo generar el código de restablecimiento.",
                                    "Tipo" => "error"
                                ];
                        }
                    } else {
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Ocurrió un error inesperado",
                            "Texto" => "No se encontró un usuario con el correo $email",
                            "Tipo" => "error"
                        ];
                    }
                } else {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "Ha ingresado un correo no válido",
                        "Tipo" => "error"
                    ];
                }
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "Debe ingresar un correo",
                    "Tipo" => "error"
                ];
            }

            echo json_encode($alerta);
            exit();
        }

    public function verificar_codigo_controlador()
    {
        $code = mainModel::limpiar_cadena($_POST['code']);
        $email = mainModel::limpiar_cadena($_POST['email']);

        $check_code = mainModel::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE reset_token='$code' AND corEleUsu='$email' AND reset_token_expire > NOW()");

        if ($check_code->rowCount() > 0) {
            $alerta = [
                "Alerta" => "redireccionar",
                "URL" => SERVERURL . "restablecerClave/?email=" . urlencode($email)
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El código es inválido o ha expirado.",
                "Tipo" => "error"
            ];
        }

        echo json_encode($alerta);
        exit();
    }



        public function cambiar_clave_controlador(){
            $email = mainModel::limpiar_cadena($_POST['email']);
            $new_password = mainModel::limpiar_cadena($_POST['password']);

            $new_password = mainModel::encryption($new_password);

            $datos_up_clave = [
                "conSegUsu" => [
                    "campo_marcador" => ":password",
                    "campo_valor" => $new_password
                ]
            ];
            $condicion = [
                "condicion_campo" => "corEleUsu",
                "condicion_marcador" => ":email",
                "condicion_valor" => $email
            ];

            if (mainModel::actualizar_datos("usuarios", $datos_up_clave, $condicion)) {
                $alerta = [
                    "Alerta" => "redireccionar",
                    "URL" => SERVERURL . "singin/"
                ];
                echo json_encode($alerta);
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos podido actualizar los datos del usuario en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }

    
}