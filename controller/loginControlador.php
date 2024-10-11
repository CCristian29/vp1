<?php
if ($peticionAjax) {
	require_once "../model/mainModel.php";
} else {
	require_once "./model/mainModel.php";
}

class loginControlador extends mainModel
{
	public function iniciar_sesion_controlador()
	{
		$correo = mainModel::limpiar_cadena($_POST['correo']);
		$clave = mainModel::limpiar_cadena($_POST['clave']);

		// Verificar si el usuario está bloqueado
		$query = mainModel::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE corEleUsu='$correo'");
		$user = $query->fetch();

		if ($user) {
			if ($user['bloqueo_activo']) {
				$tiempo_bloqueo = new DateTime($user['tiempo_bloqueo']);
				$tiempo_actual = new DateTime();
				$diferencia = $tiempo_actual->diff($tiempo_bloqueo);

				if ($diferencia->i < 30) {
					$_SESSION['error_message'] = "Tu cuenta está bloqueada. Intenta de nuevo en 30 minutos.";
					header("Location: " . SERVERURL . "singin/");
					exit();
				} else {
					// Resetear el estado de bloqueo
					$datos = [
						"bloqueo_activo" => [
							"campo_marcador" => ":bloqueo_activo",
							"campo_valor" => 0
						],
						"intentos_fallidos" => [
							"campo_marcador" => ":intentos_fallidos",
							"campo_valor" => 0
						],
						"tiempo_bloqueo" => [
							"campo_marcador" => ":tiempo_bloqueo",
							"campo_valor" => null
						]
					];
					$condicion = [
						"condicion_campo" => "corEleUsu",
						"condicion_marcador" => ":corEleUsu",
						"condicion_valor" => $correo
					];
					mainModel::actualizar_datos("usuarios", $datos, $condicion);
				}
			}
		}

		if (empty($correo) || empty($clave)) {
			$_SESSION['error_message'] = "No has llenado todos los campos que son requeridos";
			header("Location: " . SERVERURL . "singin/");
			exit();
		}

		if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['error_message'] = "El correo ingresado no coincide con el formato solicitado";
			header("Location: " . SERVERURL . "singin/");
			exit();
		}

		if (!preg_match('/^[a-zA-Z0-9$@.-]{7,100}$/', $clave)) {
			$_SESSION['error_message'] = "La clave no coincide con el formato solicitado";
			header("Location: " . SERVERURL . "singin/");
			exit();
		}

		$clave = mainModel::encryption($clave);

		$datos_ingresar = mainModel::datos_tabla(
			"Normal",
			"usuarios WHERE corEleUsu='$correo' AND conSegUsu='$clave'",
			"*",
			0
		);

		if ($datos_ingresar->rowCount() == 1) {
			$row = $datos_ingresar->fetch();

			session_start(['name' => 'virtual']);

			$_SESSION['id_virtual'] = $row['idUsu'];
			$_SESSION['nombre_virtual'] = $row['nomUsu'];
			$_SESSION['correo_virtual'] = $row['corEleUsu'];
			$_SESSION['fechaNacimiento_virtual'] = $row['fecNacUsu'];
			$_SESSION['departamento_virtual'] = $row['depUsu'];
			$_SESSION['ciudad_virtual'] = $row['ciuUsu'];
			$_SESSION['direccion_virtual'] = $row['dirResUsu'];
			$_SESSION['telefono_virtual'] = $row['telUsu'];
			$_SESSION['rol_virtual'] = $row['rolUsu'];
			$_SESSION['imagen_virtual'] = $row['imgUsu'];
			$_SESSION['token_virtual'] = md5(uniqid(mt_rand(), true));

			$datos = [
				"intentos_fallidos" => [
					"campo_marcador" => ":intentos_fallidos",
					"campo_valor" => 0
				]
			];
			$condicion = [
				"condicion_campo" => "corEleUsu",
				"condicion_marcador" => ":corEleUsu",
				"condicion_valor" => $correo
			];
			mainModel::actualizar_datos("usuarios", $datos, $condicion);

			switch ($row['rolUsu']) {
				case 1:
				case 2:
					header("Location: " . SERVERURL . DASHBOARD . "/home/");
					break;
				case 3:
					header("Location: " . SERVERURL . "index/");
					break;
				default:
					$_SESSION['error_message'] = "No se pudo determinar el rol del usuario";
					session_destroy();
					header("Location: " . SERVERURL . "singin/");
					exit();
			}
		} else {
			// Incrementar el conteo de intentos fallidos
			if ($user) {
				$intentos = $user['intentos_fallidos'] + 1;

				if ($intentos >= 5) {
					$datos = [
						"bloqueo_activo" => [
							"campo_marcador" => ":bloqueo_activo",
							"campo_valor" => 1
						],
						"tiempo_bloqueo" => [
							"campo_marcador" => ":tiempo_bloqueo",
							"campo_valor" => (new DateTime())->format('Y-m-d H:i:s')
						]
					];
					$condicion = [
						"condicion_campo" => "corEleUsu",
						"condicion_marcador" => ":corEleUsu",
						"condicion_valor" => $correo
					];
					mainModel::actualizar_datos("usuarios", $datos, $condicion);
					$_SESSION['error_message'] = "Tu cuenta ha sido bloqueada. Intenta de nuevo en 30 minutos.";
				} else {
					$datos = [
						"intentos_fallidos" => [
							"campo_marcador" => ":intentos_fallidos",
							"campo_valor" => $intentos
						]
					];
					$condicion = [
						"condicion_campo" => "corEleUsu",
						"condicion_marcador" => ":corEleUsu",
						"condicion_valor" => $correo
					];
					mainModel::actualizar_datos("usuarios", $datos, $condicion);
					$_SESSION['error_message'] = "El correo o la clave son incorrectos. Intento $intentos de 5.";
				}
			} else {
				$_SESSION['error_message'] = "El correo o la clave son incorrectos.";
			}
			header("Location: " . SERVERURL . "singin/");
			exit();
		}
	}

	public function forzar_cierre_administrador_sesion_controlador()
	{
		session_unset();
		session_destroy();
		if (headers_sent()) {
			echo "<script>
                window.location.href = '" . SERVERURL . DASHBOARD . "/';
            </script>";
		} else {
			header("Location: " . SERVERURL . DASHBOARD . "/");
		}
	}

	public function forzar_cierre_cliente_sesion_controlador()
	{
		session_unset();
		session_destroy();
		if (headers_sent()) {
			echo "<script>
                window.location.href = '" . SERVERURL . "singin/" . "';
            </script>";
		} else {
			header("Location: " . SERVERURL . "singin/");
		}
	}

	// Cerrar sesión administrador
	public function cerrar_sesion_usuario_controlador()
	{
		session_start(['name' => 'virtual']);
		$token = mainModel::decryption($_POST['token']);
		$correo = mainModel::decryption($_POST['correo']);

		if ($token == $_SESSION['token_virtual'] && $correo == $_SESSION['correo_virtual']) {
			session_unset();
			session_destroy();
			$alerta = [
				"Alerta" => "redireccionar",
				"URL" => SERVERURL . "singin/"
			];
		} else {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Ocurrió un error inesperado",
				"Texto" => "No se pudo cerrar la sesión en el sistema",
				"Tipo" => "error"
			];
		}
		echo json_encode($alerta);
	}
}
