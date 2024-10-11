<?php

if ($peticionAjax) {
    require_once "../model/pqrsModelo.php";
} else {
    require_once "./model/pqrsModelo.php";
}

class pqrsControlador extends pqrsModelo
{
    public function agregar_pqrs_controlador()
    {
        $nombreP = mainModel::limpiar_cadena($_POST['Nombre']);
        $correoP = mainModel::limpiar_cadena($_POST['Correo']);
        $tipoP = mainModel::limpiar_cadena($_POST['Tipo']);
        $descripcionP = mainModel::limpiar_cadena($_POST['Descripcion']);
        $archivoP = $_FILES['Archivo'];

        if (empty($nombreP) || empty($correoP) || empty($tipoP) || empty($descripcionP) || empty($archivoP)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "Debe llenar todos los campos del formulario",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\ ]{4,45}", $nombreP)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El nombre no coincide con el formato indicado",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Verificación de archivo
        $tamanoMaximo = 5 * 1024 * 1024; // 5 MB
        $tiposPermitidos = array('pdf', 'doc', 'docx');

        if (isset($archivoP['name']) && $archivoP['error'] === 0) {
            $archivo_nombre = $archivoP['name'];
            $archivo_extension = pathinfo($archivo_nombre, PATHINFO_EXTENSION);

            if (!in_array(strtolower($archivo_extension), $tiposPermitidos)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "Solo se permiten archivos PDF, DOC y DOCX",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if ($archivoP['size'] > $tamanoMaximo) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El tamaño del archivo excede el límite permitido",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $nombreArchivo = uniqid('archivo_') . '.' . $archivo_extension;
            $rutaDestino = "../views/assets/archivos_adjuntos/" . $nombreArchivo;

            // Crear el directorio si no existe
            if (!file_exists(dirname($rutaDestino))) {
                mkdir(dirname($rutaDestino), 0777, true);
            }

            if (!move_uploaded_file($archivoP['tmp_name'], $rutaDestino)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No se pudo subir el archivo al servidor",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "Debe seleccionar un archivo",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Verificación de correo
        if (!filter_var($correoP, FILTER_VALIDATE_EMAIL)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El correo no coincide con el formato indicado",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Verificar que el tipo seleccionado sea uno de los valores permitidos
        $valores_permitidos = array("peticion", "queja", "reclamo", "sugerencia");
        if (!in_array($tipoP, $valores_permitidos)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error",
                "Texto" => "Debe seleccionar una opción válida",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Datos para registro de PQRS
        $datos_registro_pqrs = [
            "Nombre" => $nombreP,
            "Correo" => $correoP,
            "Tipo" => $tipoP,
            "Descripcion" => $descripcionP,
            "Archivo" => $nombreArchivo
        ];

        $agregar_pqrs = pqrsModelo::agregar_pqrs_model($datos_registro_pqrs);

        if ($agregar_pqrs->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "Usuario registrado",
                "Texto" => "La PQRS ha sido registrada con éxito",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido registrar la PQRS",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }
    ///cambiar estado de pqrs
    public function cambiar_estado_pqrs_controlador() {
        $idpqrs = mainModel::decryption($_POST['idpqrs']);
        $nuevo_estado = mainModel::limpiar_cadena($_POST['nuevo_estado']);
        
        $resultado = pqrsModelo::cambiar_estado_pqrs_model($idpqrs, $nuevo_estado);
    
        if ($resultado) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Éxito",
                "Texto" => "El estado de la PQRS se ha cambiado exitosamente.",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error",
                "Texto" => "No se pudo cambiar el estado de la PQRS.",
                "Tipo" => "error"
            ];
        }
    
        // Enviar respuesta JSON con la alerta
        echo json_encode($alerta);
    }
    

    // Función paginador de PQRS
    public function paginador_pqrs_controlador($pagina, $registros, $url, $busqueda)
    {
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $url = mainModel::limpiar_cadena($url);
        $url = SERVERURL . DASHBOARD . "/" . $url . "/";
        $busqueda = mainModel::limpiar_cadena($busqueda);

        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda) && $busqueda != "") {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM pqrs WHERE (Nombre LIKE '%$busqueda%' OR correo LIKE '%$busqueda%' OR tipo LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' OR archivo LIKE '%$busqueda%') ORDER BY idpqrs ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM pqrs ORDER BY idpqrs ASC LIMIT $inicio, $registros";
        }

        $conexion = mainModel::conectar();
        $datos = $conexion->query($consulta)->fetchAll();
        $total = (int) $conexion->query("SELECT FOUND_ROWS()")->fetchColumn();
        $Npaginas = ceil($total / $registros);

        $tabla .= '
        <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr class="text-center font-weight-bold">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Archivo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody class="bg-white">
        ';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            $pag_inicio = $inicio + 1;
            foreach ($datos as $fila) {
                $rutaArchivo = SERVERURL . "views/assets/archivos_adjuntos/" . $fila['archivo'];
                $tabla .= '
                    <tr class="text-center">
                        <td>' . $fila['idPqrs'] . '</td>
                        <td>' . $fila['nombre'] . '</td>
                        <td>' . $fila['correo'] . '</td>
                        <td>' . $fila['tipo'] . '</td>
                        <td>' . $fila['descripcion'] . '</td>
                       <td>' . $fila['Estado'] . '</td>
                        <td><a href="' . $rutaArchivo . '" class="btn btn-info btn-sm" download>Descargar</a></td>
                        <td>
                        <form class="FormularioAjax" action="' . SERVERURL . 'ajax/pqrsAjax.php" method="POST" data-form="update">
                        <input type="hidden" name="idpqrs" value="' . mainModel::encryption($fila['idPqrs']) . '">
                        <input type="hidden" name="nuevo_estado" value="' . ($fila['Estado'] == 'pendiente' ? 'resuelto' : 'pendiente') . '">
                        <button type="submit" class="btn btn-link">' . ($fila['Estado'] == 'pendiente' ? 'Marcar como Resuelto' : 'Marcar como Pendiente') . '</button>
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
                            <a href="' . $url . '" class="btn btn-primary btn-sm">Recargar</a>
                        </td>
                    </tr>
                ';
            } else {
                $tabla .= '
                    <tr class="text-center">
                        <td colspan="8">No hay PQRS registradas.</td>
                    </tr>
                ';
            }
        }

        $tabla .= '</tbody></table></div>';

        if ($total > 0 && $pagina <= $Npaginas) {
            $tabla .= '<p class="text-end">Mostrando PQRS <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
        }

        if ($total >= 1 && $pagina <= $Npaginas) {
            $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 10, LANG);
        }

        return $tabla;
    }
}
?>