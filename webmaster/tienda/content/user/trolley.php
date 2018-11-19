<?php
	session_start();
	
	$criterio = $_GET['criterio'];
	$categoria = $_GET['categoria'];
	$usuario = $_SESSION['user'];
	
	$order = $_GET[Order]; // Variable de ordenación de columnas de tablas
	
	// Id ascendente por defecto
	if ($order == "" || $order == null) {
		$order = "ID_A";	
	}
	
	// Conexión a base de datos
	$conexion=mysql_connect("localhost", "root", "root") or die('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	/*
	$resul=mysql_query("SELECT *
				   		FROM VENTAS
				   		WHERE LOGIN = '".$usuario."'", $conexion)  or die ("No funciona");
	$fila = mysql_fetch_array($resul);
	*/
	
	// Includes
	include ("./includes/security.php");
	include ("./includes/top.php");
	include ("./includes/cabecera.php");	
	include ("./includes/user.php");
	
	//echo "<form method='post' name='reg' action='./alta_user.php' target='_parent' onsubmit='return alta_user();'>
	echo "	<table id='compras' class='compras' align='center'>
				<tr>
					<th colspan='7'>
						LISTADO DE LOS PRODUCTOS DE MI CARRITO
					</th>
				</tr>";
	
	/*** CARRITO ***/
	if ($_SESSION['cantidadProductosCarrito'] != 0) { // Si hay productos en el carrito
		echo "	<tr>
					<td style='background-color: hotpink; width: 8px;'>
						&nbsp;
					</td>
					<td style='font-weight: bold; background-color: hotpink; text-align: right;'>
						ID
					</td>
					<td style='font-weight: bold; background-color: hotpink; text-align: center;'>
						Descripci&oacute;n (Categor&iacute;a)
					</td>
					<td style='font-weight: bold; background-color: hotpink; text-align: right;'>
						Cantidad
					</td>
					<td style='font-weight: bold; background-color: hotpink; text-align: right;'>
						Precio (&euro;)
					</td>
					<td style='font-weight: bold; background-color: hotpink; text-align: right;'>
						Importe (&euro;)
					</td>
					<td style='background-color: hotpink; width: 180px;'>
						
					</td>
				</tr>";
		
		$id = 0; // "Contador de productos disponibles del carrito (no eliminados de forma lógica)"
		$total = 0; // Importe total de todo el carrito
		for ($i = 1; $i <= count($_SESSION['carrito']); $i++) {
			if ($_SESSION['carrito'][$i] != null) {
				$id ++;
				
				echo "<tr class='lineaVenta'>
						<td>
							&raquo; <!-- comillas -->
						</td>
						<td style='text-align: right;'>
							".$id."
						</td>
						<td style='text-align: center;'>
							<a href='javascript:abrir(".$_SESSION['carrito'][$i][ID].")' title='Ver detalle de producto: ".$_SESSION['carrito'][$i][DESCRIPCION]."'>
								<span>".$_SESSION['carrito'][$i][DESCRIPCION]." (".$_SESSION['carrito'][$i][CATEGORIA].")</span>
							</a>
						</td>
						<td style='text-align: right;'>
							".$_SESSION['carrito'][$i][CANTIDAD]."
						</td>
						<td style='text-align: right;'>
							".$_SESSION['carrito'][$i][PRECIO]."
						</td>
						<td style='text-align: right;'>
							".number_format($_SESSION['carrito'][$i][PRECIO] * $_SESSION['carrito'][$i][CANTIDAD], 2)."
						</td>
						<td style='text-align: center; width: 180px;'>
							<form method='post' name='deleteCall' action='./dao/deleteTrolleyProductDAO.php' onSubmit='return deleteProductConfirm(\"".$_SESSION['carrito'][$i][DESCRIPCION]."\");' >
								<input type='hidden' name='ID' value='".$_SESSION['carrito'][$i][ID]."' />
								<input type='submit' name='eliminar' value='Eliminar del carrito' title='Elimina del carrito el producto: ".$_SESSION['carrito'][$i][DESCRIPCION]."' />
							</form>
						</td>
					</tr>";
					
				$total = $total + number_format($_SESSION['carrito'][$i][PRECIO] * $_SESSION['carrito'][$i][CANTIDAD], 2);
			} // End if
		} // Fin FOR
		
		echo " <tr class='numProduct'>
					<td style='text-align: right;' colspan='5'>
						Importe Total:
					</td>
					<td style='text-align: right;'>
						".number_format($total, 2)." &euro;
					</td>
					<td>
						(I.V.A. incluido)
					</td>
				</tr>";
		
	} else {
		echo "	<tr>
					<td colspan='7' style='font-weight: bold; text-align: center;'>
						<br />
						NO HAY PRODUCTOS
					</td>
				</tr>";
	} // End else
	
	echo "	</table>
		
			<br />
			
			<form name='validarCarrito' action='./dao/validateTrolleyDAO.php' onsubmit='return validateTrolley();'>
				<table id='enlace_atras' class='enlace_atras'>";
	if ($_SESSION['cantidadProductosCarrito'] != 0) { // Si hay productos en el carrito			
		echo "		<tr>
						<td>
							<input type='submit' name='validar' id='validar' value='Validar carrito (OK)' title='Validar carrito. Se procesa la compra' />
						</td>
					</tr>";
	} // End if
	echo "			<tr>
						<td>
							<a href='../user.php'>
								<div title='Ir a la lista de productos'>
									Seguir comprando
								</div>
							</a>
						</td>
					</tr>
				</table>
			</form>";

	include ("./includes/bottom.php");
	
	mysql_close();
?>