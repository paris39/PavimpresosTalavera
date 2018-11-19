<?php
	
	session_start();
	
	// Includes
	include ("./includes/security.php");
	
	$producto[ID] = $_POST[ID];
	
	
	$salir = false;
	for ($i = 1; $i <= count($_SESSION['carrito']) && !$salir; $i++) {
		if ($_SESSION['carrito'][$i][ID] === $producto[ID]) {
			$producto[OK] = false; // El producto se borra de forma lógica
			$_SESSION['carrito'][$i] = null;
			$_SESSION['cantidadProductosCarrito'] --; // Se disminuye una cantidad al número de productos que había en el carrito
			
			productoEliminado();
			
			$salir = true; // No necesita seguir buscando más productos
		} // End if
	} // End for
	
	
	// El producto se ha eliminado del carrito satisfactoriamente
	function productoEliminado () {
		echo "<!doctype html>
				<html xmlns='http://www.w3.org/1999/xhtml'>
					<head>
						<meta http-equiv='refresh' content='2; url=../trolley.php' />
						<title>Producto eliminado del carrito - Tienda</title>
						<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
						<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
					</head>
					<body>
			
						<table id='contenedor' class='contenedor'>
							<tr>
								<td>
									<h2>&iexcl;EL PRODUCTO SE HA ELIMINADO DEL CARRITO!</b></h2> Redirigiendo a la p&aacute;gina principal...	
								</td>
							</tr>
						</table>
			
					</body>
				</html>";
	} // End productoEliminado
	
	//mysql_close(); 
?>