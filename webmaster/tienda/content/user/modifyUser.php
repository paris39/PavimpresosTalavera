<?php
	
	session_start();
	
	include ("./includes/security.php");
	
	$login = $_POST['login'];
	$pass = $_POST['pass']; // No se usa
	$nombre = $_POST['nombre'];
	$mail = $_POST['mail'];
	$calle = $_POST['calle'];
	$poblacion = $_POST['poblacion'];
	$provincia = $_POST['provincia'];
	$pais = $_POST['pais'];
	
	// Conexión a base de datos
	$conexion = mysql_connect("localhost", "root", "root") or die('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	// UPDATE
	$resul = mysql_query("UPDATE CLIENTES 
						  SET NOMBRE='".$nombre."', EMAIL='".$mail."', CALLE='".$calle."', POBLACION='".$poblacion."', PROVINCIA='".$provincia."', PAIS='".$pais."' 
						  WHERE LOGIN='".$login."'", $conexion)  or die ("No funciona");
						   
	if (mysql_errno($conexion) == 0) {
		$_SESSION['userName'] = $nombre; // Cambiamos en la variable de sesión el nuevo nombre del usuario
		// $_SESSION['nombre'] = $usuario; // En las modificaciones no es necesario loguearse después de modificar datos
		echo "<!doctype html>
			<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
					<meta http-equiv='refresh' content='2; url=../../index.php' />
					<title>Cliente modificado - Tienda</title>
					<link rel='STYLESHEET' type='text/css' href='../../styles.css' />
				</head>
				<body>
		
					<table id='contenedor' class='contenedor'>
						<tr>
							<td>
								<h2>&iexcl;CLIENTE MODIFICADO!</b></h2> Redirigiendo a la p&aacute;gina principal...		
							</td>
						</tr>
			  		</table>
		
				</body>
			</html>";
	 
	} else {
		if (mysql_errno($conexion) == 1062) {
			echo "<h2>NOMBRE DE USUARIO NO DISPONIBLE, No se ha podido insertar porque ya existe ese nombre de usuario</h2>".$idfila[ident];
		} else {
			$numeroERROR = mysql_errno($conexion); 
			$descripcionERROR = mysql_error($conexion);
			echo "<h2>Nº de error: ".$numeroERROR." * Descripci&oacute;n: ".$descripcionERROR."</h2>";
		} // End else
	} // End else
	
	mysql_close(); 
?>