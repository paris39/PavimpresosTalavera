<?php
	session_start();
	
	$criterio = $_GET['criterio'];
	$categoria = $_GET['categoria'];
	$usuario = $_SESSION['user'];
	
	//$login = $_POST['LOGIN'];
	if (($_POST[LOGIN] != '') || ($_POST[LOGIN] != null)) {
		$login = $_POST[LOGIN];
	} else if (($_GET[LOGIN] != '') || ($_GET[LOGIN] != null)) {
		$login = $_GET[LOGIN];
	} // End if
	
	$order = $_GET[Order]; // Variable de ordenación de columnas de tablas
	
	// Id ascendente por defecto
	if ($order == "" || $order == null) {
		$order = "ID_A";	
	}
	
	// Conexión a base de datos
	$conexion = mysql_connect("localhost", "root", "root") or die ('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	// SELECT (ventas)
	$resul=mysql_query("SELECT *
						FROM VENTAS
						WHERE LOGIN = '".$login."'
						ORDER BY IDVENTA", $conexion) or die ("No funciona");
	$fila = mysql_fetch_array($resul);
	
	// SELECT (datos de usuario)
	$resul4=mysql_query("SELECT * 
						 FROM CLIENTES 
						 WHERE LOGIN = '".$login."'", $conexion) or die ("No funciona usuario");
	$fila4 = mysql_fetch_array($resul4);
	
	// Includes
	include ("./includes/security.php");
	include ("./includes/top.php");
	//include ("./includes/cabecera.php");	
	//include ("./includes/user.php");
	
	echo "<table id='cabecera2' class='cabecera2'>
			<tr>
				<td>
					TIENDA VIRTUAL
				</td>
			</tr>
		</table>
	
		<br />

		<table id='cabecera3' class='cabecera3'>
			<tr>
				<td>
					DETALLE DE LA COMPRAS DEL USUARIO ".$login."
				</td>
			</tr>
		</table>

		<br />
	
		<form method='post' name='listado'>
			<table id='compras' class='compras' style='border-style: none;'>";
	
	// Ordenación
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
	
	$date = new DateTime($fila4[FECHAALTA], timezone_open('Europe/Madrid')); // Formato de fecha
	
	// Datos del usuario
	echo " 		<tr style='border-style: solid; border-bottom-style: none;'>
					<th style='text-align: center; border-right-style: solid;'>
						FECHA ALTA: <span style='font-weight: normal;'>".$date->format('d/m/Y')."</span><span style='font-weight: normal;'></span>
					</th>
					<th style='text-align: center; border-style: solid; border-bottom-style: none; border-top-style: none;'>
						LOGIN: <span style='font-weight: normal;'>".$fila4[LOGIN]."</span>
					</th>
					<th style='text-align: center; border-style: solid; border-bottom-style: none; border-top-style: none;'>
						NOMBRE: <span style='font-weight: normal;'>".$fila4[NOMBRE]."</span>
					</th>
					<th style='text-align: center; border-left-style: solid;'>
						E-MAIL: <a href='mailto:".$fila4[EMAIL]."'><span style='font-weight: normal;'>".$fila4[EMAIL]."</span></a>
					</th>
				</tr>
			</table>
			<table id='compras' class='compras' style='border-style: none;'>
				<tr style='border-style: solid; border-bottom-style: none; border-top-style: none;'>
					<th style='text-align: center; border-style: solid; border-bottom-style: none; border-left-style: none;'>
						DIRECCI&Oacute;N: <span style='font-weight: normal;'>".$fila4[CALLE]."</span>
					</th>
					<th style='text-align: center; border-style: solid; border-bottom-style: none;'>
						MUNICIPIO: <span style='font-weight: normal;'>".$fila4[POBLACION]."</span>
					</th>
					<th style='text-align: center; border-style: solid; border-bottom-style: none; border-right-style: none;'>
						PA&Iacute;S: <span style='font-weight: normal;'>".$fila4[PAIS]."</span>
					</th>
				</tr>
			</table>
			<table id='compras' class='compras'>";
	
	if ($fila != 0) { // Hay ventas
		if ($order == 'ID_A' || $order == 'ID_D' || $order == 'DATE_A' || $order == 'DATE_D' || $order == 'TOTAL_A' || $order == 'TOTAL_D') {
			$query = "SELECT *, (SELECT SUM(vd2.CANTIDAD * vd2.PRECIO) 
								 FROM VENTAS_DETALLE vd2 
								 WHERE vd2.IDVENTA = v.IDVENTA
								 GROUP BY vd2.IDVENTA) as TOTAL
					  			 FROM VENTAS v
					  			 WHERE v.LOGIN = '".$login."'";
			$resul = mysql_query($query." ".$orderBy, $conexion) or die ("No funciona con Order By");
		} else {
			$resul = mysql_query("SELECT *
								  FROM VENTAS
								  WHERE LOGIN = '".$login."'
								  ORDER BY IDVENTA", $conexion) or die ("No funciona");
		}
		
		//$fila = mysql_fetch_array($resul);
		// Fila cabecera, primeraLínea
		echo "	<tr class='firstLine'>";
		// ID
		if ($order == "ID_A") { // ↑
			echo "	<td colspan='2' style='text-align: right;'>
						<span title='ID Venta \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./shoppingDetails.php?LOGIN=".$login."&Order=ID_D'>IDVenta</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "ID_D") { // ↓
			echo "	<td colspan='2' style='text-align: right;'>
						<span title='ID Venta \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./shoppingDetails.php?LOGIN=".$login."&Order=ID_A'>IDVenta</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td colspan='2' style='text-align: right;'>
						<span title='ID Venta \nClick para ordenación ascendente'>
							<a href='./shoppingDetails.php?LOGIN=".$login."&Order=ID_A'>IDVenta</a>
						</span>
					</td>";
		}
		// FECHA
		if ($order == "DATE_A") { // ↑
			echo "	<td style='text-align: center;' width: 100px;'>
						<span title='Fecha de venta \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./shoppingDetails.php?LOGIN=".$login."&Order=DATE_D'>Fecha</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "DATE_D") { // ↓
			echo "	<td style='text-align: center;' width: 90px;'>
						<span title='Fecha de venta \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./shoppingDetails.php?LOGIN=".$login."&Order=DATE_A'>Fecha</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td style='text-align: center;' width: 90px;'>
						<span title='Fecha de venta \nClick para ordenación ascendente'>
							<a href='./shoppingDetails.php?LOGIN=".$login."&Order=DATE_A'>Fecha</a>
						</span>
					</td>";
		}
		echo "		<td style='text-align: center; width: 50px;'>
						Hora
					</td>
					<td style='text-align: left;'>
						Descripci&oacute;n (Categor&iacute;a)
					</td>
					<td style='text-align: right; width: 75px;'>
						Cantidad
					</td>
					<td  style='text-align: right;'>
						Precio (&euro;)
					</td>";
		// IMPORTE TOTAL
		if ($order == "TOTAL_A") { // ↑
			echo "	<td style='text-align: right;'>
						<span title='Importe total de la compra \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./shoppingDetails.php?LOGIN=".$login."&Order=TOTAL_D'>Importe (&euro;)</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "TOTAL_D") { // ↓
			echo "  <td style='text-align: right;'>
						<span title='Importe total de la compra \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./shoppingDetails.php?LOGIN=".$login."&Order=TOTAL_A'>Importe (&euro;)</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "  <td style='text-align: right;'>
						<span title='Importe total de la compra \nClick para ordenación ascendente'>
							<a href='./shoppingDetails.php?LOGIN=".$login."&Order=TOTAL_A'>Importe (&euro;)</a>
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
					<td colspan='5' style='font-weight: bold; text-align: center;'>
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
						<a href='./salesSummary.php'><div>Volver al Resumen de ventas por Cliente</div></a>
					</td>
				</tr>
			</table>";

	include ("./includes/bottom.php");
	
	mysql_close();
?>