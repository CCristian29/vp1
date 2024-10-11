 <?php

    if ($peticionAjax) {
        require_once "../model/mainModel.php";
    } else {
        require_once "./model/mainModel.php";
    }

    class adminiControlador extends mainModel{
        public function agregar_administrador_controlador(){
            $nombre = mainModel::limpiar_cadena($_POST['nomAdm']);
            $tipo = mainModel::limpiar_cadena($_POST['tipDocAdm']);
            $documento = mainModel::limpiar_cadena($_POST['docAdm']);
            $telefono = mainModel::limpiar_cadena($_POST['telAdm']);
            $departamento = mainModel::limpiar_cadena($_POST['depAdm']);
            $direccion = mainModel::limpiar_cadena($_POST['ciudadAdm']);
            $correo = mainModel::limpiar_cadena($_POST['corEleAdm']);
            $clave = mainModel::limpiar_cadena($_POST['conSegAdm']);
            $cargo = mainModel::limpiar_cadena($_POST['cargo_admin']);

            /*---comprobar campos vacios---*/
            if (empty($nombre) || empty($tipo)|| empty($documento)|| empty($telefono)|| empty($departamento)|| empty($direccion) || empty($correo) || empty($clave) || empty($cargo)){
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
            if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\ ]{4,45}", $nombre)) {
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
                    "Texto" => "El documento de identidad no coincide con el formato indicado",
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
            if (mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{5,190}", $direccion)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El la dirección no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if ($cargo < 1 || $cargo > 2) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El cargo seleccionado no es valido",
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
            $claveadm = mainModel::encryption($clave);
            if ($_SESSION['rol_virtual'] != 1) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No tienes los permisos necesarios para registrar un usuario",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $datos_registro_admini = [
                "nomUsu"=> [
                    "campo_marcador" => ":Nombre",
                    "campo_valor" => $nombre
                ],
                "tipIdeUsu"=> [
                    "campo_marcador" => ":Tipo",
                    "campo_valor" => $tipo
                ],
                "docIdeUsu"=> [
                    "campo_marcador" => ":Documento",
                    "campo_valor" => $documento
                ],
                "telUsu"=> [
                    "campo_marcador" => ":Telefono",
                    "campo_valor" => $telefono
                ],
                
                "depUsu"=>[
                    "campo_marcador" => ":Departamento",
                    "campo_valor" => $departamento
                ],
                "ciuUsu" => [
                    "campo_marcador" => ":Direccion",
                    "campo_valor" => $direccion
                ],
                "corEleUsu"=>[
                    "campo_marcador" => ":Correo",
                    "campo_valor" => $correo
                ],
                "conSegUsu"=>[
                    "campo_marcador" => ":Clave",
                    "campo_valor" => $claveadm
                ],
                "rolUsu" => [
                    "campo_marcador" => ":Cargo",
                    "campo_valor" => $cargo
                ]
            ];
            $agregar_admini = mainModel::guardar_datos("usuarios", $datos_registro_admini);
            if ($agregar_admini->rowCount() == 1) {
                $alerta = [
                    "Alerta" => "limpiar",
                    "Titulo" => "usuario registrado",
                    "Texto" => "Los datos del administrador han sido registrados con exito",
                    "Tipo" => "success"
                ];
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos podido registrar el administrador",
                    "Tipo" => "error"
                ];
            }
            $agregar_admini->closeCursor();
            $agregar_admini = mainModel::desconectar($agregar_admini);

            echo json_encode($alerta);
        }
        public function paginador_administrador_controlador($pagina, $registros, $url, $busqueda){
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE rolUsu='1' or rolUsu='2' ORDER BY nomUsu ASC LIMIT $inicio,$registros";
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
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Fecha de registro</th>
                        <th>Cargo</th>
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
                    $cargo_virtual = $rows['rolUsu'];
                    $cargo_text = "";
                    if ($cargo_virtual == 1) {
                        $cargo_text = "Administrador principal";
                    } elseif ($cargo_virtual == 2) {
                        $cargo_text = "Cajero";
                    } else {
                        $cargo_text = "Otro rol";
                    }

                    $tabla .= '
                <tr class="text-center">
                    <td>' . $contador . '</td>
                    <td>' . $rows['nomUsu'] . '</td>
                    <td>' . $rows['corEleUsu'] . '</td>
                    <td>' . $rows['telUsu'] . '</td>
                    <td>' . $rows['fecRegUsu'] . '</td>
                    <td>' . $cargo_text . '</td>
                    <td><a class="btn btn-link text-success" href="' . SERVERURL . DASHBOARD . '/actualizar-usuario/' . mainModel::encryption($rows['idUsu']) . '/"><i class="fas fa-sync-alt"></i></a></td>
                    <td>
                        <form class="FormularioAjax" action="' . SERVERURL . 'ajax/admAjax.php" method="POST" data-form="delete">
                            <input type="hidden" name="modulo_administrador" value="eliminar">
                            <input type="hidden" name="admini_id_del" value="' . mainModel::encryption($rows['idUsu']) . '">
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
                <tr class="text-center">
                    <td colspan="8">
                        <a href="' . $url . '" class="btn btn-primary btn-sm">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
                } else {
                    $tabla .= '
                <tr class="text-center">
                    <td colspan="8">
                        No hay registros en el sistema
                    </td>
                </tr>
            ';
                }
            }

            $tabla .= '</tbody></table></div>';

            if ($total > 0 && $pagina <= $Npaginas) {
                $tabla .= '<p class="text-end"> Administradores <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
            }

            /*--Paginacion  --*/
            if ($total >= 1 && $pagina <= $Npaginas) {
                $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 10, LANG);
            }

            return $tabla;
        }


        // funcion para actualizar datos de los administradores
        public function actualizar_datos_admini_controlador(){
            if ($_SESSION['rol_virtual'] != 1 && $_SESSION['rol_virtual']!=2) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Acceso no permitido",
                    "Texto" => "No tienes los permisos necesarios para realizar esta operación en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();

            }
            $id = mainModel::decryption($_POST['usuario_id_up']);
            $id = mainModel::limpiar_cadena($id);
            $check_administrador=mainModel::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE idUsu='$id'");
            if ($check_administrador->rowCount() <= 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos encontrado el usuario en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos = $check_administrador->fetch();
            }
            $check_administrador->closeCursor();
            $check_administrador=mainModel::desconectar($check_administrador);

            $nombre =mainModel::limpiar_cadena(($_POST['usuario_nombre_up']));
            $telefono =mainModel::limpiar_cadena(($_POST['usuario_telefono_up']));
            if (isset($_POST['usuario_cargo_up'])) {
                $cargo = mainModel::limpiar_cadena($_POST['usuario_cargo_up']);
            } else {
                $cargo = $campos['rolUsu'];
            }

            $correo =mainModel::limpiar_cadena(($_POST['usuario_correo_up']));
            $clave_1 =mainModel::limpiar_cadena(($_POST['usuario_nueva_clave_1_up']));
            $clave_2 =mainModel::limpiar_cadena(($_POST['usuario_nueva_clave_2_up']));
            $administrador_usuario =mainModel::limpiar_cadena(($_POST['administrador_usuario_up']));
            $administrador_clave =mainModel::limpiar_cadena(($_POST['administrador_clave_up']));


            if (empty($nombre) || empty($telefono)) {
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
            if (mainModel::verificar_datos("[0-9]{1,2}", $cargo)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El cargo no coincide con el formato indicado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if ($cargo != 1 && $cargo != 2) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Opción no valida",
                    "Texto" => "Ha seleccionado un CARGO no valido",
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

            if ($clave_1 != "" || $clave_2 != "") {

                if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_2)) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Formato no valido",
                        "Texto" => "Las NUEVAS CONTRASEÑAS no coincide con el formato solicitado",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                } else {
                    if ($clave_1 != $clave_2) {
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Ocurrió un error inesperado",
                            "Texto" => "Las NUEVAS CONTRASEÑAS que acaba de ingresar no coinciden",
                            "Tipo" => "error"
                        ];
                        echo json_encode($alerta);
                        exit();
                    } else {
                        $clave = mainModel::encryption($clave_1);
                    }
                }
            } else {
                $clave = $campos['conSegUsu'];
            }

            if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $administrador_clave)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Formato no valido",
                    "Texto" => "La CONTRASEÑA de TU CUENTA no coincide con el formato solicitado",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $administrador_clave = mainModel::encryption($administrador_clave);

            if ($_SESSION['id_virtual'] != $id) {

                /*-- Comprobando privilegios */
                if ($_SESSION['rol_virtual'] != 1 && $_SESSION['rol_virtual'] != 2) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Acceso no permitido",
                        "Texto" => "No tienes los permisos necesarios para realizar esta operación en el sistema",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }

                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT idUsu FROM usuarios WHERE corEleUsu='$administrador_usuario' AND conSegUsu='$administrador_clave'");
            } else {
                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT idUsu FROM usuarios WHERE corEleUsu='$administrador_usuario' AND conSegUsu='$administrador_clave' AND idUsu='$id'");
            }


            if ($check_cuenta->rowCount() != 1) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Datos incorrectos",
                    "Texto" => "El correo y contraseña ingresados no coinciden con los de su cuenta",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_cuenta->closeCursor();
            $check_cuenta = mainModel::desconectar($check_cuenta);


            $datos_usuario_up = [
                "nomUsu" => [
                    "campo_marcador" => ":nombre",
                    "campo_valor" => $nombre
                ],
                "telUsu" => [
                    "campo_marcador" => ":telefono",
                    "campo_valor" => $telefono
                ],
                "rolUsu" => [
                    "campo_marcador" => ":Cargo",
                    "campo_valor" => $cargo
                ],
                "corEleUsu" => [
                    "campo_marcador" => ":correo",
                    "campo_valor" => $correo
                ],
                "conSegUsu" => [
                    "campo_marcador" => ":clave",
                    "campo_valor" => $clave
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
                    "Titulo" => "Datos actualizados",
                    "Texto" => "Sus datos ha sido actualizado con éxito",
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
        
        // funcion eliminar administrador
        public function eliminar_admini_controlador(){
            $id = mainModel::decryption($_POST['admini_id_del']);
            $id = mainModel::limpiar_cadena($id);

            if ($id==1) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No se puede eliminar el administrador principal del sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            // comprobar usuario
            $check_usuario = mainModel::ejecutar_consulta_simple("SELECT idUsu FROM usuarios WHERE idUsu='$id'");
            if ($check_usuario->rowCount() <= 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos encontrado el usuario en el sistema",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

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
            $eliminar_admini = mainModel::eliminar_registro("usuarios", "idUsu", $id);
            if ($eliminar_admini->rowCount() == 1) {
                $alerta = [
                    "Alerta" => "recargar",
                    "Titulo" => "Usuario eliminado",
                    "Texto" => "El usuario ha sido eliminado con exito",
                    "Tipo" => "success"
                ];
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No hemos podido eliminar el usuario",
                    "Tipo" => "error"
                ];
            }
            $eliminar_admini->closeCursor();
            $eliminar_admini = mainModel::desconectar($eliminar_admini);

            echo json_encode($alerta);
        }

    }