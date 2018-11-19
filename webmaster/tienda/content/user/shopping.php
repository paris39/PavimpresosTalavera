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
	$conexion = mysql_connect("localhost", "root", "root") or die ('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	// SELECT
	$resul=mysql_query("SELECT *
						FROM VENTAS
						WHERE LOGIN = '".$usuario."'
						ORDER BY IDVENTA", $conexion) or die ("No funciona");
	$fila = mysql_fetch_array($resul);
	
	
	// Includes
	include ("./includes/security.php");
	include ("./includes/top.php");
	include ("./includes/cabecera.php");	
	include ("./includes/user.php");
	
	echo "	<table id='compras' class='compras' align='center'>
				<tr>
					<th colspan='8'>
						LISTADO DE TODAS MIS COMPRAS
					</th>
				</tr>";
	
	switch ($order) {
		case "ID_A": 
			$orderBy = "ORDER BY v.IDVENTA ASC";
			break;
		case "ID_D":
			$orderBy = "ORDER BY v.IDVENTA DESC";
			break;
		case "DATE_A":
			$orderBy = "ORDER BY v.FECHA ASC";
			break;
		case "DATE_D":
			$orderBy = "ORDER BY v.FECHA DESC";
			break;
		case "NAME_A":
			$orderBy = "ORDER BY c.NOMBRE ASC";
			break;
		case "NAME_D":
			$orderBy = "ORDER BY c.NOMBRE DESC";
			break;
		case "TOTAL_A":
			$orderBy = "ORDER BY TOTAL ASC";
			break;
		case "TOTAL_D":
			$orderBy = "ORDER BY TOTAL DESC";
			break;
		case "EMAIL_A":
			$orderBy = "ORDER BY c.EMAIL ASC";
			break;
		case "EMAIL_D":
			$orderBy = "ORDER BY c.EMAIL DESC";
			break;
		default: 
			$orderBy = "ORDER BY v.IDVENTA ASC"; // Ordenación por defecto, IDVENTA ASC
			break;
	} // End switch
	
	if ($fila != 0) { // Hay ventas
		if ($order == 'ID_A' || $order == 'ID_D' || $order == 'DATE_A' || $order == 'DATE_D' || $order == 'TOTAL_A' || $order == 'TOTAL_D') {
			$query = "SELECT *, (SELECT SUM(vd2.CANTIDAD * vd2.PRECIO) 
								 FROM VENTAS_DETALLE vd2 
								 WHERE vd2.IDVENTA = v.IDVENTA
								 GROUP BY vd2.IDVENTA) as TOTAL
					  FROM VENTAS v
					  WHERE v.LOGIN = '".$usuario."'";
			$resul = mysql_query($query." ".$orderBy, $conexion) or die ("No funciona con Order By");
		} else {
			$resul = mysql_query("SELECT *
								  FROM VENTAS
								  WHERE LOGIN = '".$usuario."'
								  ORDER BY IDVENTA", $conexion) or die ("No funciona");
		}
		
		//$fila = mysql_fetch_array($resul);
		// Fila cabecera, primeraLínea
		echo "	<tr class='firstLine'>";
		// ID
		if ($order == "ID_A") { // ↑
			echo "	<td colspan='2' style='text-align: right;'>
						<span title='ID Venta \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./shopping.php?Order=ID_D'>IDVenta</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "ID_D") { // ↓
			echo "	<td colspan='2' style='text-align: right;'>
						<span title='ID Venta \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./shopping.php?Order=ID_A'>IDVenta</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td colspan='2' style='text-align: right;'>
						<span title='ID Venta \nClick para ordenación ascendente'>
							<a href='./shopping.php?Order=ID_A'>IDVenta</a>
						</span>
					</td>";
		}
		// FECHA
		if ($order == "DATE_A") { // ↑
			echo "	<td style='text-align: center; width: 100px;'>
						<span title='Fecha de venta \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./shopping.php?Order=DATE_D'>Fecha</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "DATE_D") { // ↓
			echo "	<td style='text-align: center; width: 90px;'>
						<span title='Fecha de venta \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./shopping.php?Order=DATE_A'>Fecha</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td style='text-align: center; width: 90px;'>
						<span title='Fecha de venta \nClick para ordenación ascendente'>
							<a href='./shopping.php?Order=DATE_A'>Fecha</a>
						</span>
					</td>";
		}
		echo "		<td style='text-align: center; width: 50px;'>
						Hora
					</td>
					<td align='left'>
						Descripci&oacute;n (Categor&iacute;a)
					</td>
					<td style='text-align: right; width: 75px;'>
						Cantidad
					</td>
					<td style='text-align: right;'>
						Precio (&euro;)
					</td>";
		// IMPORTE TOTAL
		if ($order == "TOTAL_A") { // ↑
			echo "	<td style='text-align: right;'>
						<span title='Importe total de la compra \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./shopping.php?Order=TOTAL_D'>Importe (&euro;)</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "TOTAL_D") { // ↓
			echo "  <td style='text-align: right;'>
						<span title='Importe total de la compra \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./shopping.php?Order=TOTAL_A'>Importe (&euro;)</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "  <td style='text-align: right;'>
						<span title='Importe total de la compra \nClick para ordenación ascendente'>
							<a href='./shopping.php?Order=TOTAL_A'>Importe (&euro;)</a>
						</span>
					</td>";
		}
		echo "	</tr>";
		
		$resul1 = $resul;
		$importeTotal = 0; // Va almacenando el importe total de todas las ventas del usuario
		while ($fila2 = mysql_fetch_array($resul1)) {
			// CONSULTA DE GRUPO (importe total)
			$resul2=mysql_query("SELECT IDVENTA, p.IDPRODUCTO, p.DESCRIPCION, c.NOMBRE as CATEGORIA, CANTIDAD, p.precio as PRECIO, CANTIDAD * p.precio as IMPORTE
								FROM VENTAS_DETALLE vd, PRODUCTOS p, CATEGORIAS c
								WHERE IDVENTA = ".$fila2[IDVENTA]."
								AND vd.IDPRODUCTO = p.IDPRODUCTO
								AND p.IDCATEGORIA = c.IDCATEGORIA
								ORDER BY IDVENTA", $conexion) or die ("No funciona");
			/*
			$resul2=mysql_query("SELECT IDVENTA, DESCRIPCION, SUM(CANTIDAD * VD.PRECIO) as IMPORTETOTAL
								FROM VENTAS_DETALLE VD, PRODUCTOS P
								WHERE IDVENTA = ".$fila[IDVENTA]."
								AND VD.IDPRODUCTO = P.IDPRODUCTO
								GROUP BY IDVENTA", $conexion) or die ("No funciona");
			*/
			
			$date = new DateTime($fila2[FECHA], timezone_open('Europe/Madrid')); // Formato de fecha
			echo "<tr class='lineaVenta'>
					<td>
						&raquo; <!-- comillas -->
					</td>
					<td style='text-align: right; width: 45px;'>
						".$fila2[IDVENTA]."
					</td>
					<td style='text-align: center; width: 100px;'>
						".$date->format('d/m/Y')."
					</td>
					<td style='text-align: center; width: 60px;'>
						".$date->format('H:m')."
					</td>";
					
			$resul3 = $resul2;
			$contador = 0; // Cuenta los productos de la venta
			$importe = 0; // Va almacenando el importe total de la venta
			while ($fila3 = mysql_fetch_array($resul3)) {
				if ($contador != 0) { // Más de un producto en la venta
					echo "<tr class='lineaVenta'>
					<td></td>
					<td></td>
					<td></td>
					<td></td>";
				}
				echo "<td style='text-align: left;'>
						<a  href='javascript:abrir(".$fila3[IDPRODUCTO].")' title='Ver detalle de producto: ".$fila3[DESCRIPCION]."'>
							".$fila3[DESCRIPCION]." (".$fila3[CATEGORIA].")
						</a>
					</td>
					<td style='text-align: right; width: 75px;'>
						".$fila3[CANTIDAD]."
					</td>
					<td style='text-align: right;'>
						".$fila3[PRECIO]."
					</td>
					<td style='text-align: right;'>
						".$fila3[IMPORTE]."
					</td>
				</tr>";
				$contador = $contador + 1;
				$importe = $importe + $fila3[IMPORTE];
			} // End while			
			
			echo "	</td>
				</tr>
				<tr class='numProduct'>
					<td colspan='7' style='text-align: right;'>
						Total: 
					</td>
					<td style='text-align: right;'>
						".number_format($importe, 2, '.', '')." &euro;
					</td>
				</tr>";
			$importeTotal = $importeTotal + $importe;
		} // Fin while
		
		$numero = mysql_num_rows($resul); // Contador de compras
		
		echo "<tr class='numProduct'>
				<td colspan='6'>
					<br />
					N&uacute;mero total de Compras: ".$numero."
				</td>
				<td style='text-align: right;'>
					 Importe total:
				</td>
				<td style='text-align: right;'>
					 ".number_format($importeTotal, 2, '.', '')." &euro;
				</td>
			</tr>";
	} else {
		echo "	<tr>
					<td colspan='5' style='font-weight: bold;'>
						<br />
						NO HAY COMPRAS
					</td>
				</tr>";
	} // End else
	
	echo "	</table>
		
			<br />
		
			<table id='enlace_atras' class='enlace_atras'>
				<tr>
					<td>
						<a href='../user.php'>
							<div>
								Seguir comprando
							</div>
						</a>
					</td>
				</tr>
			</table>";

	include ("./includes/bottom.php");
	
	mysql_close();
?>