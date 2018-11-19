<?php
	
	session_start();
	
	// Includes
	include ("./includes/security.php");	
	
	$usuario = $_POST['usuario'];
	$pass = $_POST['pass'];
	$nombre = $_POST['nombre'];
	$mail = $_POST['mail'];
	$calle = $_POST['calle'];
	$poblacion = $_POST['poblacion'];
	$provincia = $_POST['provincia'];
	$pais = $_POST['pais'];
	
	// Conexión a base de datos
	$conexion = mysql_connect("localhost", "root", "root") or die('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	
	// INSERT
	$resul = mysql_query("INSERT INTO CLIENTES
						  VALUES('$usuario', '$nombre', '$pass', '$mail', '$calle', '$poblacion', '$provincia', '$pais', curdate())", $conexion);
						   
	if (mysql_errno($conexion) == 0) {
		$_SESSION['user'] = $usuario; // Se loguea el usuario que se acaba de dar de alta
		echo "<!doctype html>
			<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
					<meta http-equiv='refresh' content='2; url=../../../index.php' />
					<title>Cliente dado de alta - Tienda</title>
					<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
					<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
				</head>
				<body>
		
					<table id='contenedor' class='contenedor'>
						<tr>
							<td>
								<h2>&iexcl;CLIENTE DADO DE ALTA!</b></h2> Redirigiendo a la p&aacute;gina principal...	
							</td>
						</tr>
			  		</table>
		
				</body>
			</html>";
	 
	} else {
		if (mysql_errno($conexion) == 1062) {
			echo "<!doctype html>
				<html xmlns='http://www.w3.org/1999/xhtml'>
					<head>
						<meta http-equiv='refresh' content='4; url=../register.php' />
						<title>Cliente dado de alta - Tienda</title>
						<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
						<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
					</head>
					<body>
			
						<table id='contenedor' class='contenedor'>
							<tr>
								<td>
									<h2>NOMBRE DE USUARIO NO DISPONIBLE.
										<br />No se ha podido insertar porque ya existe ese nombre de usuario".$idfila[ident]."
										<br />
										<br />
										<br />Redirigiendo autom&aacute;ticamente...
									</h2>
									<a href='../register.php'>Click aqu&iacute;</a> si no redirige autom&aacute;ticamente
								</td>
							</tr>
						</table>
			
					</body>
				</html>";
		} else {
			$numeroERROR = mysql_errno($conexion); 
			$descripcionERROR = mysql_error($conexion);
			echo "<h2>Nº de error: ".$numeroERROR." * Descripci&oacute;n: ".$descripcionERROR."</h2>";
		} // End else
	} // End else
	
	mysql_close(); 
?>