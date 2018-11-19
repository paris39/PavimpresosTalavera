<?php
	session_start();
	
	$order = $_GET[Order]; // Variable de ordenación de columnas de tablas
	
	// Id ascendente por defecto
	if ($order == "" || $order == null) {
		$order = "ID_A";	
	}
	
	// Conexión a la base de datos
	$conexion=mysql_connect("localhost", "root", "root");
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	// Selección de todos las ventas
	$resul = mysql_query("SELECT IDVENTA, VENTAS.LOGIN, NOMBRE, EMAIL 
							FROM VENTAS, CLIENTES 
							WHERE VENTAS.LOGIN = CLIENTES.LOGIN 
							ORDER BY IDVENTA", $conexion) or die ("No funciona");
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
					LISTADO DE LAS VENTAS
				</td>
			</tr>
		</table>

		<br />
		
		<table id='productos3' class='productos3'>";

	if ($fila != 0) { // HAY ventas
		$query = "SELECT v.IDVENTA, v.FECHA, v.LOGIN, sum(CANTIDAD * PRECIO) as IMPORTE, c.NOMBRE, c.EMAIL 
								FROM VENTAS v, CLIENTES c, VENTAS_DETALLE vd 
								WHERE v.LOGIN = c.LOGIN 
								AND vd.IDVENTA = v.IDVENTA
								GROUP BY vd.IDVENTA";
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
			case "AMOUNT_A":
				$orderBy = "ORDER BY sum(CANTIDAD * PRECIO) ASC";
				break;
			case "AMOUNT_D":
				$orderBy = "ORDER BY sum(CANTIDAD * PRECIO) DESC";
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
		
		$resul = mysql_query($query." ".$orderBy, $conexion) or die ("No funciona 2");
		
		$importeTotal = 0;
		
		// Fila cabecera, primeraLínea
		echo "<tr class='firstLine'>";
		// ID
		if ($order == "ID_A") { // ↑
			echo "<td>
					<span title='ID Venta \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
						<a href='./salesList.php?Order=ID_D'>ID</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
					</span>
				</td>";
		} else if ($order == "ID_D") { // ↓
			echo "<td>
					<span title='ID Venta \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=ID_A'>ID</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
					</span>
				</td>";
		} else { // Sin flechas de ordenación
			echo "<td>
					<span title='ID Venta \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=ID_A'>ID</a>
					</span>
				</td>";
		}
		// FECHA
		if ($order == "DATE_A") { // ↑
			echo "<td>
					<span title='Fecha de Venta \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
						<a href='./salesList.php?Order=DATE_D'>FECHA</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
					</span>
				</td>";
		} else if ($order == "DATE_D") { // ↓
			echo "<td>
					<span title='Fecha de Venta \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=DATE_A'>FECHA</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
					</span>
				</td>";
		} else { // Sin flechas de ordenación
			echo "<td>
					<span title='Fecha de Venta \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=DATE_A'>FECHA</a>
					</span>
				</td>";	
		}
		// LOGIN
		if ($order == "LOGIN_A") { // ↑
			echo "<td style='text-align: left;'>
					<span title='Login de usuario \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
						<a href='./salesList.php?Order=LOGIN_D'>LOGIN</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
					</span>
				</td>";
		} else if ($order == "LOGIN_D") { // ↓
			echo "<td style='text-align: left;'>
					<span title='Login de usuario \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=LOGIN_A'>LOGIN</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
					</span>
				</td>";
		} else { // Sin flechas de ordenación
			echo "<td style='text-align: left;'>
					<span title='Login de usuario \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=LOGIN_A'>LOGIN</a>
					</span>
				</td>";
		}
		// NOMBRE
		if ($order == "NAME_A") { // ↑
			echo "<td style='text-align: left;'>
					<span title='Nombre del usuario \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
						<a href='./salesList.php?Order=NAME_D'>NOMBRE</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
					</span>
				</td>";
		} else if ($order == "NAME_D") { // ↓
			echo "<td style='text-align: left;'>
					<span title='Nombre del usuario \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=NAME_A'>NOMBRE</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
					</span>
				</td>";
		} else { // Sin flechas de ordenación
			echo "<td style='text-align: left;'>
					<span title='Nombre del usuario \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=NAME_A'>NOMBRE</a>
					</span>
				</td>";
		}
		// IMPORTE
		if ($order == "AMOUNT_A") { // ↑
			echo "<td style='text-align: right; padding-right: 5px;'>
					<span title='Importe de la venta \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
						<a href='./salesList.php?Order=AMOUNT_D'>IMPORTE</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
					</span>
				</td>";
		} else if ($order == "AMOUNT_D") { // ↓
			echo "<td style='text-align: right; padding-right: 5px;'>
					<span title='Importe de la venta \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=AMOUNT_A'>IMPORTE</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
					</span>
				</td>";
		} else { // Sin flechas de ordenación
			echo "<td style='text-align: right; padding-right: 5px;'>
					<span title='Importe de la venta \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=AMOUNT_A'>IMPORTE</a>
					</span>
				</td>";
		}
		// EMAIL
		if ($order == "EMAIL_A") { // ↑
			echo "<td>
					<span title='Email del usuario \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
						<a href='./salesList.php?Order=EMAIL_D'>E-MAIL</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
					</span>
				</td>";
		} else if ($order == "EMAIL_D") { // ↓
			echo "<td>
					<span title='Email del usuario \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=EMAIL_A'>E-MAIL</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
					</span>
				</td>";
		} else { // Sin flechas de ordenación
			echo "<td>
					<span title='Email del usuario \nClick para ordenación ascendente'>
						<a href='./salesList.php?Order=EMAIL_A'>E-MAIL</a>
					</span>
				</td>";
		}
			echo "<td>
				</td>
			</tr>";
		
		// Filas de datos
		while ($fila = mysql_fetch_array($resul)) {
			$date = new DateTime($fila[FECHA], timezone_open('Europe/Madrid')); // Formato de fecha
			
			echo"<tr class='lineaAviso'>
				<td>
					".$fila[IDVENTA]."
				</td>
				<td>
					".$date->format('d/m/Y')."
				</td>
				<td style='text-align: left;'>
					".$fila[LOGIN]."
				</td>
				<td style='text-align: left;'>
					".$fila[NOMBRE]."
				</td>
				<td style='text-align: right; padding-right: 5px;'>
					".number_format($fila[IMPORTE], 2, '.', '')." &euro;
				</td>
				<td>
					<a href='mailto:".$fila[EMAIL]."' style='cursor: pointer; font-weight: normal;'>".$fila[EMAIL]."</a>
				</td>
				<td>
					<form method='post' name='detalle' action='./salesDetails.php'>
						<input type='hidden' name='ID' id='ID' value='".$fila[IDVENTA]."' />
						<input type='submit' name='detalle' id='detalle' value='Ver detalle' title='Ver detalle de Venta #".$fila[IDVENTA]."' />
					</form>
				</td>
			</tr>";
			$importeTotal = $importeTotal + $fila[IMPORTE];
		} // Fin while
		$numero = mysql_num_rows($resul);
		echo "<tr class='numProduct'>
				<td colspan='7'>
					<br />
					Importe total: ".number_format($importeTotal, 2, '.', '')." &euro;
					<br />
					N&uacute;mero total de Ventas: ".$numero."
				</td>
			</tr>";
	} else { // NO hay productos
		echo "<tr style='text-align: center; font-size: 15; background-color: white;'>
				<td>
					NO HAY VENTAS
				</td>";
	} // End else
	
	echo "	</tr>
		</table>
		
		
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