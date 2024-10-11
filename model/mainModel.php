<?php
	// Verifica si la variable está definida
	if (!isset($peticionAjax)) {
		die("La variable 'peticionAjax' no está definida.");
	}

	if ($peticionAjax) {
		require_once "../config/SERVER.php";
	} else {
		require_once "./config/SERVER.php";
	}

	class mainModel{
		/*--------- Funcion conectar a BD ---------*/
		protected static function conectar(){
			try {
				$conexion = new PDO(SGBD, USER, PASS);
				$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$conexion->exec("SET CHARACTER SET utf8");
				return $conexion;
			} catch (PDOException $e) {
				echo "Error de conexión: ".$e->getMessage();
				return null;
			}
		}
		// funcion desconectar BD
		public function desconectar($consulta){
			global $conexion, $consulta;
			$consulta = null;
			$conexion = null;
			return $consulta;
		}


		/*--------- Funcion ejecutar consultas simples ---------*/
		protected static function ejecutar_consulta_simple($consulta){
			$sql=self::conectar()->prepare($consulta);
			$sql->execute();
			return $sql;
		}

		// consulta preparada INSERT
		protected static function guardar_datos($tabla, $datos){
		$query = "INSERT INTO $tabla (";
		$C = 0;
		foreach ($datos as $campo => $indice) {
			if ($C <= 0) {
				$query .= $campo;
			} else {
				$query .= "," . $campo;
			}
			$C++;
		}

		$query .= ") VALUES(";
		$Z = 0;
		foreach ($datos as $campo => $indice) {
			if ($Z <= 0) {
				$query .= $indice["campo_marcador"];
			} else {
				$query .= "," . $indice["campo_marcador"];
			}
			$Z++;
		}

		$query .= ")";
		$sql = self::conectar()->prepare($query);

		foreach ($datos as $campo => $indice) {
			$sql->bindParam($indice["campo_marcador"], $indice["campo_valor"]);
		}

		$sql->execute();

		return $sql;
		}

		// funcion datos de tabla
		public function datos_tabla($tipo, $tabla, $campo, $id){
			$tipo = self::limpiar_cadena($tipo);
			$tabla = self::limpiar_cadena($tabla);
			$campo = self::limpiar_cadena($campo);
		
			$id = self::decryption($id);
			$id = self::limpiar_cadena($id);
		
			if ($tipo == "Unico") {
				$sql = self::conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
				$sql->bindParam(":ID", $id);
			} elseif ($tipo == "Normal") {
				$sql = self::conectar()->prepare("SELECT $campo FROM $tabla");
			}
			$sql->execute();
		
			return $sql;
		}

		// actualizar registros
		protected static function actualizar_datos($tabla, $datos, $condicion){
			$query = "UPDATE $tabla SET ";

			$C = 0;
			foreach ($datos as $campo => $indice) {
				if ($C <= 0) {
					$query .= $campo . "=" . $indice["campo_marcador"];
				} else {
					$query .= "," . $campo . "=" . $indice["campo_marcador"];
				}
				$C++;
			}

			$query .= " WHERE " . $condicion["condicion_campo"] . "=" . $condicion["condicion_marcador"];

			$sql = self::conectar()->prepare($query);

			foreach ($datos as $campo => $indice) {
				$sql->bindParam($indice["campo_marcador"], $indice["campo_valor"]);
			}

			$sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);

			$sql->execute();

			return $sql;
		}

		// eliminar registros
		protected static function eliminar_registro($tabla, $campo, $id)
		{
			$sql = self::conectar()->prepare("DELETE FROM $tabla WHERE $campo=:ID");

			$sql->bindParam(":ID", $id);
			$sql->execute();

			return $sql;
		}

		// funcion para limitar cadena
		public function limitar_cadena($cadena, $limite, $sufijo)
		{
			if (strlen($cadena) > $limite) {
				return substr($cadena, 0, $limite) . $sufijo;
			} else {
				return $cadena;
			}
		} 

		/*--------- Encriptar cadenas ---------*/
		public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

		/*--------- Desencriptar cadenas ---------*/
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

		/*--------- funcion generar codigos aleatorios ---------*/
		protected static function generar_codigo_aleatorio($letra,$longitud,$numero){
			for($i=1; $i<=$longitud; $i++){
				$aleatorio= rand(0,9);
				$letra.=$aleatorio;
			}
			return $letra."-".$numero;
		}

	/*--------- Funcion limpiar cadenas ---------*/
	protected static function limpiar_cadena($cadena){
		$cadena = trim($cadena);
		$cadena = stripslashes($cadena);
		$cadena = str_ireplace("<script>", "", $cadena);
		$cadena = str_ireplace("</script>", "", $cadena);
		$cadena = str_ireplace("<script src", "", $cadena);
		$cadena = str_ireplace("<script type=", "", $cadena);
		$cadena = str_ireplace("SELECT * FROM", "", $cadena);
		$cadena = str_ireplace("DELETE FROM", "", $cadena);
		$cadena = str_ireplace("INSERT INTO", "", $cadena);
		$cadena = str_ireplace("DROP TABLE", "", $cadena);
		$cadena = str_ireplace("DROP DATABASE", "", $cadena);
		$cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
		$cadena = str_ireplace("SHOW TABLES", "", $cadena);
		$cadena = str_ireplace("SHOW DATABASES", "", $cadena);
		$cadena = str_ireplace("<?php", "", $cadena);
		$cadena = str_ireplace("?>", "", $cadena);
		$cadena = str_ireplace("--", "", $cadena);
		$cadena = str_ireplace(">", "", $cadena);
		$cadena = str_ireplace("<", "", $cadena);
		$cadena = str_ireplace("[", "", $cadena);
		$cadena = str_ireplace("]", "", $cadena);
		$cadena = str_ireplace("^", "", $cadena);
		$cadena = str_ireplace("==", "", $cadena);
		$cadena = str_ireplace(";", "", $cadena);
		$cadena = str_ireplace("::", "", $cadena);
		$cadena = stripslashes($cadena);
		$cadena = trim($cadena);
		return $cadena;
	}


	/*--------- Funcion verificar datos ---------*/
	protected static function verificar_datos($filtro, $cadena)
	{
		if (preg_match("/^".$filtro."$/", $cadena)) {
			return false;
		} else {
			return true;
		}
	}
	/*--------- Funcion verificar fechas ---------*/
	protected static function verificar_fecha($fecha)
	{
		$valores = explode('/', $fecha);
		if (count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])) {
			return false; // La fecha es válida
		} else {
			return true; // La fecha no es válida
		}
	}
	/*--------- Funcion paginador ---------*/

	protected static function paginador_tablas($pagina, $Npaginas, $url, $botones, $idioma)
	{
		if ($idioma == "es") {
			$txt_anterior = "Anterior";
			$txt_siguiente = "Siguiente";
		} else {
			$txt_anterior = "Previous";
			$txt_siguiente = "Next";
		}
		$tabla = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

		if ($pagina == 1) {
			$tabla .= '<li class="page-item disabled" ><a class="page-link" ><i class="fas fa-angle-double-left"></i></a></li>';
		} else {
			$tabla .= '
				<li class="page-item" ><a class="page-link" href="' . $url . '1/"><i class="fas fa-angle-double-left"></i></a></li>
				<li class="page-item" ><a class="page-link" href="' . $url . ($pagina - 1) . '/">' . $txt_anterior . '</a></li>
				';
		}

		$ci = 0;
		for ($i = $pagina; $i <= $Npaginas;
			$i++
		) {
			if ($ci >= $botones) {
				break;
			}
			if ($pagina == $i) {
				$tabla .= '<li class="page-item active" ><a class="page-link" href="' . $url . $i . '/">' . $i . '</a></li>';
			} else {
				$tabla .= '<li class="page-item" ><a class="page-link" href="' . $url . $i . '/">' . $i . '</a></li>';
			}
			$ci++;
		}

		if ($pagina == $Npaginas) {
			$tabla .= '<li class="page-item disabled" ><a class="page-link" ><i class="fas fa-angle-double-right"></i></a></li>';
		} else {
			$tabla .= '
				<li class="page-item" ><a class="page-link" href="' . $url . ($pagina + 1) . '/">' . $txt_siguiente . '</a></li>
				<li class="page-item" ><a class="page-link" href="' . $url . $Npaginas . '/"><i class="fas fa-angle-double-right"></i></a></li>
				';
		}

		$tabla .= '</ul></nav>';
		return $tabla;
	}


	public static function cambiar_estado_pqrs_model($idpqrs, $nuevo_estado) {
        $sql = self::conectar()->prepare("UPDATE pqrs SET Estado = :nuevo_estado WHERE idpqrs = :idpqrs");
        $sql->bindParam(":nuevo_estado", $nuevo_estado);
        $sql->bindParam(":idpqrs", $idpqrs);
        $sql->execute();
        return $sql;
    }

	// funcion para generar token de recuperar contraseña
	public static function generar_token_verificacion($userId)
	{
		$token = bin2hex(random_bytes(16));
		$query = "UPDATE usuarios SET verificacion_token = :token WHERE idUsu = :id";
		$sql = self::conectar()->prepare($query);
		$sql->bindParam(":token", $token);
		$sql->bindParam(":id", $userId);
		$sql->execute();
		return $token;
	}

	// Función para verificar el token
	public static function verificar_token($token)
	{
		$query = "SELECT idUsu FROM usuarios WHERE verificacion_token = :token AND verificado = 0";
		$sql = self::conectar()->prepare($query);
		$sql->bindParam(":token", $token);
		$sql->execute();
		$user = $sql->fetch();
		if ($user) {
			$query = "UPDATE usuarios SET verificado = 1, verificacion_token = NULL WHERE idUsu = :id";
			$sql = self::conectar()->prepare($query);
			$sql->bindParam(":id", $user['idUsu']);
			$sql->execute();
			return true;
		}
		return false;
	}

	public function generar_select($datos, $campo_db)
	{
		$check_select = '';
		$text_select = '';
		$count_select = 1;
		$select = '';
		foreach ($datos as $row) {

			if ($campo_db == $row) {
				$check_select = 'selected=""';
				$text_select = ' (Actual)';
			}

			$select .= '<option value="' . $row . '" ' . $check_select . '>' . $count_select . ' - ' . $row . $text_select . '</option>';

			$check_select = '';
			$text_select = '';
			$count_select++;
		}
		return $select;
	}

}