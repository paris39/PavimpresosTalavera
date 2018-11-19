<?php
	
	session_start();
	
	// Includes
	include ("./includes/security.php");
	
	// Conexión a base de datos
	$conexion = mysql_connect("localhost", "root", "root") or die('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	
	// INSERT  mysql_insert_id();
	$resul = mysql_query("INSERT INTO VENTAS (LOGIN, FECHA) 
						  VALUES('".$_SESSION['user']."', curdate())", $conexion);
	$idventa = mysql_insert_id(); // idventa de la insercción hecha inmediatamente
	$arrayErrors; // Array que almacenará los posibles errores que se vayan dando en las operaciones
	
						   
	if (mysql_errno($conexion) == 0) {
		for ($i = 1; $i <= count($_SESSION['carrito']); $i++) { // INSERT(S)
			if ($_SESSION['carrito'][$i] != null) {
				$resul = mysql_query("INSERT INTO VENTAS_DETALLE 
						  			  VALUES ($idventa, ".$_SESSION['carrito'][$i][ID].", ".$_SESSION['carrito'][$i][CANTIDAD].", ".$_SESSION['carrito'][$i][PRECIO].")", $conexion);
				if (mysql_errno($conexion) == 0) {
					/* VENTA REALIZADA CORRECTAMENTE (mensaje) (avisos...) */
					// ACTUALIZAR EXISTENCIAS en base de datos (Update) [Podría obviarse con un Trigger en base de datos]
					$existencias = $_SESSION['carrito'][$i][EXISTENCIAS];
					$cantidad = $_SESSION['carrito'][$i][CANTIDAD];
					$existencias = $existencias - $cantidad;
					$resul=mysql_query("UPDATE PRODUCTOS
					   					SET EXISTENCIAS = ".$existencias."
					  					WHERE IDPRODUCTO = ".$_SESSION['carrito'][$i][ID], $conexion) or die ("No funciona 30");
					if (mysql_errno($conexion) == 0) { // Se han actualizado las EXISTENCIAS correctamente
						// GENERAR AVISOS correspondientes
						$mensaje = "@".$_SESSION['user'].": Enviar e-mail con los datos bancarios donde debe hacer el ingreso para validar la venta #".$idventa; // &#64; > @
						$resul=mysql_query("INSERT INTO AVISOS (fecha, comentarios, estado, tipo)
					   						VALUES (curdate(), '$mensaje', 1, 2)", $conexion) or die ("No funciona 35");
						if (mysql_errno($conexion) == 0) { // Se ha generado el AVISO correctamente
							// COMPROBAR EXISTENCIAS restantes del producto vendido
							if ($existencias == 0) {
								$mensaje = "Agotadas todas las existencias para el siguiente producto: #".$_SESSION['carrito'][$i][ID]." - ".$_SESSION['carrito'][$i][DESCRIPCION];
								$resul=mysql_query("INSERT INTO AVISOS (fecha, comentarios, estado, tipo)
					   								VALUES (curdate(), '$mensaje', 1, 1)", $conexion) or die ("No funciona 41");
								if (!mysql_errno($conexion) == 0) { // NO se ha generado el AVISO correctamente
									$error[ID] = mysql_errno($conexion);
									$error[MESSAGE] = mysql_error($conexion);
									$arrayErrors[$i] = $error;
								} // End (comprobando error al generar AVISO)
							} else {
								if ($existencias == 1) {
									$mensaje = "Existencias bajo mínimos para el siguiente producto: #".$_SESSION['carrito'][$i][ID]." - ".$_SESSION['carrito'][$i][DESCRIPCION];
									$resul=mysql_query("INSERT INTO AVISOS (fecha, comentarios, estado, tipo)
					   									VALUES (curdate(), '$mensaje', 1, 1)", $conexion) or die ("No funciona 51");
									if (!mysql_errno($conexion) == 0) { // NO se ha generado el AVISO correctamente
										$error[ID] = mysql_errno($conexion);
										$error[MESSAGE] = mysql_error($conexion);
										$arrayErrors[$i] = $error;
									} // End (comprobando error al generar AVISO)
								} // End if
							} // End else EXISTENCIAS = 0
						} else {
							$error[ID] = mysql_errno($conexion);
							$error[MESSAGE] = mysql_error($conexion);
							$arrayErrors[$i] = $error;
						} // End else (comprobando error al generar AVISO)
					} else {
						$error[ID] = mysql_errno($conexion);
						$error[MESSAGE] = mysql_error($conexion);
						$arrayErrors[$i] = $error;
					} // End else (comprobando error al actualizar EXISTENCIAS)
					
					// ACTUALIZAR EL CARRITO
					$_SESSION['carrito'][$i] = null; // Se elimina el producto del carrito
					$_SESSION['cantidadProductosCarrito'] --; // Se resta un producto a la variable contadora
				} else {
					// Utilizar un array de posibles ERRORES para informar de ellos
					$error[ID] = mysql_errno($conexion);
					$error[MESSAGE] = mysql_error($conexion);
					$arrayErrors[$i] = $error;
				} // End else
			} // End if
		} // End for
	} else {		
		// Control de posibles errores
		$error[ID] = mysql_errno($conexion);
		$error[MESSAGE] = mysql_error($conexion);
		$arrayErrors[0] = $error;
	} // End else
	
	// Informe de errores
	if (count($arrayErrors) === 0) {
		echo "<!doctype html>
				<html xmlns='http://www.w3.org/1999/xhtml'>
					<head>
						<meta http-equiv='refresh' content='2; url=../shopping.php' />
						<title>Venta realizada - Tienda</title>
						<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
						<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
					</head>
					<body>
			
						<table id='contenedor' class='contenedor'>
							<tr>
								<td>
									<h2>&iexcl;VENTA REALIZADA CORRECTAMENTE!</b></h2> Redirigiendo a la p&aacute;gina principal...
								</td>
							</tr>
						</table>
			
					</body>
				</html>";		
	} else {
		// Han ocurrido errores durante las inserciones y/o actualizaciones
		echo "<!doctype html>
				<html xmlns='http://www.w3.org/1999/xhtml'>
					<head>
						<title>Ventas - Tienda</title>
						<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
						<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
					</head>
					<body>
			
						<table id='contenedor' class='contenedor'>
							<tr>
								<td>
									<h2>Han ocurrido los siguientes errores durante el procedimiento de la venta</h2>
								</td>
							</tr>
							<tr>
								<td>";
									for ($i = 0; $i < count($arrayErrors); $i++) { // ERROR(ES)
										echo "<i>Error</i>: ".$arrayErrors[$i][ID]."
											<br />
											<i>Descripci&oacute;n</i>: ".$arrayErrors[$i][MESSAGE]."
											<br />
											<br />";
									} // End for
		echo "					</td>
							</tr>
							<tr>
								<td>
									<table id='menu_admin' class='menu_admin'>
										<tr>
											<td>
												<a href='../trolley.php'><div>Volver al carrito</div></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</body>
				</html>";
		
	} // End if
	
	mysql_close(); 
?>