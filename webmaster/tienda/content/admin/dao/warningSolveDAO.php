<?php
	session_start();
	
	// Includes
	include ("./includes/security.php");
	
	// Conexión a la base de datos
	$conexion = mysql_connect("localhost", "root", "root") or die ('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	// Update
	$resul=mysql_query("UPDATE AVISOS
						SET ESTADO = 0
						WHERE IDAVISO = ".$_POST[IDAVISO], $conexion) or die ("No funciona");
	
	// Comprobar tipo de aviso
	switch ($_POST[TIPO]) {
		case 1:
			if (($_POST[IDPRODUCTO] == '') || ($_POST[IDPRODUCTO] == null)) {
				// Enlace a todos los productos
				echo "<!doctype html>
					<html xmlns='http://www.w3.org/1999/xhtml'>
						<head>
							<meta http-equiv='refresh' content='1; url=../allDataProduct.php />
							<title>Cargando producto... - Tienda</title>
							<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
							<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
						</head>
						<body>
				
							<table align='center' id='contenedor' class='contenedor'>
								<tr align='center'>
									<td valign='middle'>
										<h2>Cargando...</h2>
									</td>
								</tr>
							</table>
				
						</body>
					</html>";
			} else {
				// Enlace al producto en concreto
				echo "<!doctype html>
					<html xmlns='http://www.w3.org/1999/xhtml'>
						<head>
							<meta http-equiv='refresh' content='1; url=../modifyProduct.php?ID=".$_POST[IDPRODUCTO]."' />
							<title>Cargando producto... - Tienda</title>
							<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
							<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
						</head>
						<body>
				
							<table align='center' id='contenedor' class='contenedor'>
								<tr align='center'>
									<td valign='middle'>
										<h2>Cargando...</h2>
									</td>
								</tr>
							</table>
				
						</body>
					</html>";
			} // End if
			break;
		case 2:
			if (($_POST[CLIENTE] == '') || ($_POST[CLIENTE] == null)) {
				// Enlace a mail sin cliente
				$asuntoMensaje = "Datos bancarios para proceder a la venta #".$_POST[IDVENTA];
				$cuerpoMensaje = "
					Estimado/a cliente.
					
					\t Le informamos de los siguientes datos para proceder a la venta #".$_POST[IDVENTA].".
					\n Cuenta Bancaria: ------
					\n Cantidad: -----
					\n\n Reciba un cordial saludo.
					\n Administrador de la Tienda.
				";
				echo "<!doctype html>
					<html xmlns='http://www.w3.org/1999/xhtml'>
						<head>
							<meta http-equiv='refresh' content='1; url=mailto:&subject=".$asuntoMensaje."&CC=root@tienda.es&body=".$cuerpoMensaje."' />
							<title>Cargando cliente... - Tienda</title>
							<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
							<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
						</head>
						<body>
				
							<table align='center' id='contenedor' class='contenedor'>
								<tr align='center'>
									<td valign='middle'>
										<h2>Cargando...</h2>
									</td>
								</tr>
								<tr align='center'>
								<td>
									<table id='menu_admin' class='menu_admin'>
										<tr>
											<td>
												<a href='../warningsList.php'><div>Volver a los avisos</div></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							</table>
				
						</body>
					</html>";
			} else {
				// Enlace a mail para cliente concreto
				$asuntoMensaje = "Datos bancarios para proceder a la venta #".$_POST[IDVENTA];
				$cuerpoMensaje = "
					Estimado se&ntilde;or/a.
					
					\t Le informamos de los siguientes datos para proceder a la venta #".$_POST[IDVENTA].".
					\n Cuenta Bancaria: ------
					\n Cantidad: -----
					\n\n Reciba un cordial saludo.
					\n Administrador de la Tienda.
				";
				echo "<!doctype html>
					<html xmlns='http://www.w3.org/1999/xhtml'>
						<head>
							<meta http-equiv='refresh' content='1; url=mailto:".$_POST[EMAIL]."&subject=".$asuntoMensaje."&CC=root@tienda.es&body=".$cuerpoMensaje."' />
							<title>Cargando cliente... - Tienda</title>
							<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
							<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
						</head>
						<body>
				
							<table align='center' id='contenedor' class='contenedor'>
								<tr align='center'>
									<td valign='middle'>
										<h2>Cargando...</h2>
									</td>
								</tr>
								<tr align='center'>
								<td>
									<table id='menu_admin' class='menu_admin'>
										<tr>
											<td>
												<a href='../warningsList.php'><div>Volver a los avisos</div></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							</table>
				
						</body>
					</html>";
			} // End if
			break;
			
		default:
			break;
	} // End switch
	
	mysql_close(); 
?>