<?php
	session_start();

	// Envío del usuario y la clave a las variables de sesión
	$usuario = $_POST['usuario'];
	$clave = $_POST['clave'];

	$_SESSION['user'] = $usuario;
	$_SESSION['pass'] = $clave;

	// Conexión a la base de datos
	$conexion = mysql_connect("localhost", "root", "root");
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");

	// Seleccionar todos los datos del usuario a loguear en el sistema
	$resul = mysql_query("SELECT * FROM CLIENTES WHERE LOGIN=trim('".$usuario."')", $conexion) or die ("No funciona");
	$fila = mysql_fetch_array($resul);
	$_SESSION['userInfo'][] = $fila;
	$_SESSION['userName'] = $fila['NOMBRE'];

	include ("./includes/security.php");

	if ($fila != 0) { // Si devuelve alguna fila es que el usuario existe en el sistema
		if ($fila[LOGIN] == 'root') { // Si es el administrador...
			if ($fila[PASSWORD] == $clave) { // Si la clave del administrador coincide con la almacenada en BD
				echo "	<!doctype html>
						<html xmlns='http://www.w3.org/1999/xhtml'>
							<head>
								<meta http-equiv='refresh' content='1; url=./admin.php' />
								<title>Comprobando usuario... - Tienda</title>
								<link rel='STYLESHEET' type='text/css' href='../styles.css' />
								<script src='../scripts.js' language='JavaScript' type='text/javascript'></script>
							</head>
							<body>
								<tabl id='contenedor' class='contenedor'>
									<tr>
										<td style='font-weight: bold;'>
											Cargando...";
			} else { // Contraseña incorrecta del root
				resetSession();
				echo "	<!doctype html>
						<html xmlns='http://www.w3.org/1999/xhtml'>
							<head>
								<meta http-equiv='refresh' content='2; url=../index.php' />
								<title>Comprobando usuario... - Tienda</title>
								<link rel='STYLESHEET' type='text/css' href='../styles.css /'>
								<script src='../scripts.js' language='JavaScript' type='text/javascript'></script>
							</head>
							<body>
								<table id='contenedor' class='contenedor'>
									<tr>
										<td style='font-weight: bold;'>
											Contrase&ntilde;a incorrecta.
											<br />
											<br />
											Redirigiendo a la p&aacute;gina principal...";
			} // Fin clave
		} else { // No es el usuario administrador
			if ($fila[PASSWORD] == $clave) { // Coincide la clave del usuario con la almacenada en BD
				$_SESSION['carrito']; // Se habilita el carrito
				$_SESSION['cantidadProductosCarrito'] = 0;
				$_SESSION['user'] = $usuario;
				echo "	<!doctype html>
						<html xmlns='http://www.w3.org/1999/xhtml'>
							<head>
								<meta http-equiv='refresh' content='1; url=./user.php' />
								<title>Comprobando usuario... - Tienda</title>
								<link rel='STYLESHEET' type='text/css' href='../styles.css' />
								<script src='../scripts.js' language='JavaScript' type='text/javascript'></script>
							</head>
							<body>
								<table id='contenedor' class='contenedor'>
									<tr>
										<td style='font-weight: bold;'>
											Cargando...";
			} else { // Usuario existente (no root), contraseña incorrecta
				resetSession();
				echo "	<!doctype html>
						<html xmlns='http://www.w3.org/1999/xhtml'>
							<head>
								<meta http-equiv='refresh' content='2; url=../index.php' />
								<title>Comprobando usuario... - Tienda</title>
								<link rel='STYLESHEET' type='text/css' href='../styles.css' />
								<script src='../scripts.js' language='JavaScript' type='text/javascript'></script>
							</head>
							<body>
								<table id='contenedor' class='contenedor'>
									<tr>
										<td style='font-weight: bold;'>
											Password incorrecta.
											<br />
											<br />
											Redirigiendo a la p&aacute;gina principal...";
			} // Fin else (Usuario existente contraseña incorrecta)
		} // Fin usuario normal (no root)
	} else { // El usuario no existe en la base de datos
		resetSession();
		echo "			<!doctype html>
						<html xmlns='http://www.w3.org/1999/xhtml'>
							<head>
								<meta http-equiv='refresh' content='3; url=../index.php' />
								<title>Comprobando usuario... - Tienda</title>
								<link rel='STYLESHEET' type='text/css' href='../styles.css' />
								<script src='../scripts.js' language='JavaScript' type='text/javascript'></script>
							</head>
							<body>
								<table id='contenedor' class='contenedor'>
									<tr>
										<td style='font-weight: bold;'>
											El usuario no existe, debe registrarse.
											<br />
											<br />
											Redirigiendo a la p&aacute;gina principal...";
	} // End if
	
	// Función que resetea las variables de usuario de sesión cuando el logeo es incorrecto
	function resetSession(){
		$_SESSION['user'] = '';
		$_SESSION['pass'] = '';
		$_SESSION['carrito'] = '';
	} // End resetSession
	
	include ("./includes/checkBottom.php");
	
	mysql_close();
?>