<?php
	session_start();
	
	$order = $_GET[Order]; // Variable de ordenación de columnas de tablas
	
	// Login ascendente por defecto
	if ($order == "" || $order == null) {
		$order = "LOGIN_A";	
	}
	
	// Conexión a la base de datos
	$conexion=mysql_connect("localhost", "root", "root");
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	// Selección de todas las ventas
	$resul = mysql_query("SELECT v.LOGIN as LOG, c.NOMBRE, COUNT(DISTINCT v.IDVenta) as CONTADOR, sum(vd.CANTIDAD * vd.PRECIO) as IMPORTE, c.EMAIL
						  FROM VENTAS v, CLIENTES c, VENTAS_DETALLE vd
						  WHERE v.LOGIN = c.LOGIN
						  AND v.IDVENTA = vd.IDVENTA
						  GROUP BY v.LOGIN", $conexion) or die ("No funciona");
	$fila = mysql_fetch_array($resul);
	
	// Includes
	include ("./includes/security.php");
	include ("./includes/top.php");
	
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
					LISTADO DE LAS COMPRAS REALIZADAS POR LOS CLIENTES
				</td>
			</tr>
		</table>

		<br />
	
		<!--form method='post' name='listado'-->
		<table id='productos3' class='productos3'>";
	
	$ventas = 0;
	$total = 0;

	if ($fila != 0) { // HAY ventas		
		switch ($order) {
			case "LOGIN_A": 
				$orderBy = "ORDER BY v.LOGIN ASC";
				break;
			case "LOGIN_D":
				$orderBy = "ORDER BY v.LOGIN DESC";
				break;
			case "NAME_A":
				$orderBy = "ORDER BY c.NOMBRE ASC";
				break;
			case "NAME_D":
				$orderBy = "ORDER BY c.NOMBRE DESC";
				break;
			case "SALES_A":
				$orderBy = "ORDER BY COUNT(DISTINCT v.IDVenta) ASC";
				break;
			case "SALES_D":
				$orderBy = "ORDER BY COUNT(DISTINCT v.IDVenta) DESC";
				break;
			case "AMOUNT_A":
				$orderBy = "ORDER BY sum(vd.CANTIDAD * vd.PRECIO) ASC";
				break;
			case "AMOUNT_D":
				$orderBy = "ORDER BY sum(vd.CANTIDAD * vd.PRECIO) DESC";
				break;
			case "EMAIL_A":
				$orderBy = "ORDER BY c.EMAIL ASC";
				break;
			case "EMAIL_D":
				$orderBy = "ORDER BY c.EMAIL DESC";
				break;
			default: 
				$orderBy = "ORDER BY v.LOGIN ASC"; // Ordenación por defecto, LOGIN ASC
				break;
		}
		
		$resul = mysql_query("SELECT v.LOGIN as LOG, c.NOMBRE, COUNT(DISTINCT v.IDVenta) as CONTADOR, sum(vd.CANTIDAD * vd.PRECIO) as IMPORTE, c.EMAIL
						  FROM VENTAS v, CLIENTES c, VENTAS_DETALLE vd
						  WHERE v.LOGIN = c.LOGIN
						  AND v.IDVENTA = vd.IDVENTA
						  GROUP BY v.LOGIN 
						  ".$orderBy, $conexion) or die ("No funciona");
		
		// Fila cabecera, primeraLínea
		echo "	<tr class='firstLine'>";
		// LOGIN
		if ($order == "LOGIN_A") { // ↑
			echo "	<td>
						<span title='Login de usuario \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesSummary.php?Order=LOGIN_D'>LOGIN</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "LOGIN_D") { // ↓
			echo "	<td>
						<span title='Login de usuario \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesSummary.php?Order=LOGIN_A'>LOGIN</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td>
						<span title='Login de usuario \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesSummary.php?Order=LOGIN_A'>LOGIN</a>
						</span>
					</td>";
		}
		// NOMBRE Y APELLIDOS
		if ($order == "NAME_A") { // ↑
			echo "	<td>
						<span title='Nombre del usuario \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesSummary.php?Order=NAME_D'>NOMBRE Y APELLIDOS</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "NAME_D") { // ↓
			echo "	<td>
						<span title='Nombre del usuario \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesSummary.php?Order=NAME_A'>NOMBRE Y APELLIDOS</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td>
						<span title='Nombre del usuario \nClick para ordenación ascendente'>
							<a href='./salesSummary.php?Order=NAME_A'>NOMBRE Y APELLIDOS</a>
						</span>
					</td>";
		}
		// Nº VENTAS
		if ($order == "SALES_A") { // ↑
			echo "	<td style='text-align: right;'>
						<span title='Número de ventas del usuario \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesSummary.php?Order=SALES_D'>Nº VENTAS</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "SALES_D") { // ↓
			echo "	<td style='text-align: right;'>
						<span title='Número de ventas del usuario \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesSummary.php?Order=SALES_A'>Nº VENTAS</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td style='text-align: right;'>
						<span title='Número de ventas del usuario \nClick para ordenación ascendente'>
							<a href='./salesSummary.php?Order=SALES_A'>Nº VENTAS</a>
						</span>
					</td>";
		}
		// IMPORTE
		if ($order == "AMOUNT_A") { // ↑
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Importe de la venta \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesSummary.php?Order=AMOUNT_D'>IMPORTE</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "AMOUNT_D") { // ↓
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Importe de la venta \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesSummary.php?Order=AMOUNT_A'>IMPORTE</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Importe de la venta \nClick para ordenación ascendente'>
							<a href='./salesSummary.php?Order=AMOUNT_A'>IMPORTE</a>
						</span>
					</td>";
		}
		// EMAIL
		if ($order == "EMAIL_A") { // ↑
			echo "	<td style='text-align: center;'>
						<span title='Email del usuario \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesSummary.php?Order=EMAIL_D'>E-MAIL</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "EMAIL_D") { // ↓
			echo "	<td style='text-align: center;'>
						<span title='Email del usuario \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesSummary.php?Order=EMAIL_A'>E-MAIL</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td style='text-align: center;'>
						<span title='Email del usuario \nClick para ordenación ascendente'>
							<a href='./salesSummary.php?Order=EMAIL_A'>E-MAIL</a>
						</span>
					</td>";
		}
		echo "		<td>
					</td>
				</tr>";

		while ($fila = mysql_fetch_array($resul)) {
			echo"<tr class='lineaAviso'>
					<td>
						<a name='".$fila[LOG]."' /></a>
						".$fila[LOG]."
					</td>
					<td style='text-align: left;'>
						".$fila[NOMBRE]."
					</td>
					<td style='text-align: right;'>".
						$fila[CONTADOR];
			$ventas = $ventas + $fila[CONTADOR];
			echo"	</td>
					<td style='text-align: right;'>
						".number_format($fila[IMPORTE], 2, '.', '')." &euro;";
			$total = $total + $fila[IMPORTE];
			echo"	</td>
					<td style='text-align: center;'>
						<a href='mailto:".$fila[EMAIL]."' style='cursor: pointer; font-weight: normal;'>".$fila[EMAIL]."</a>
					</td>
					<td style='text-align: center;'>
						<form method='post' name='detalle' action='./shoppingDetails.php'>
							<input type='hidden' name='LOGIN' id='LOGIN' value='".$fila[LOG]."' />
							<input type='submit' name='detalle' id='detalle' value='Ver detalle' title='Ver detalle de Ventas de ".$fila[LOG]."' />
						</form>
					</td>
				</tr>";
		} // Fin while
		
		$numero = mysql_num_rows($resul);
		echo "<tr class='numProduct'>
				<td colspan='2'>
					<br />
					TOTALES: ".$numero."
				</td>
				<td style='text-align: right;'>
					<br />
					".$ventas."
				</td>
				<td style='text-align: right;'>
					<br />
					".number_format($total, 2, '.', '')." &euro;
				</td>
				<td>
					<br />
				</td>
				<td>
				</td>
			</tr>";
	} else { // NO hay productos
		echo "	<tr style='text-align: center; font-size: 15; background-color: white;'>
					<td>
						NO HAY VENTAS
					</td>
				</tr>";
	} // END else
	
	echo "</table>
		<!--/form-->
		
		<br />
		
		<table id='menu_admin' class='menu_admin'>
			<tr>
				<td>
					<a href='../admin.php'><div>Volver al Men&uacute; de Administrador</div></a>
				</td>
			</tr>
		</table>";
	
	include ("./includes/bottom.php");
	
	mysql_close();
?>