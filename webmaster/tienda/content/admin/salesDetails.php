<?php
	session_start();
	
	// Conexión a la base de datos
	$conexion=mysql_connect("localhost", "root", "root");
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	$order = $_GET[Order]; // Variable de ordenación de columnas de tablas
	
	// Id ascendente por defecto
	if ($order == "" || $order == null) {
		$order = "ID_A";	
	}
	
	if (($_POST[ID] != '') || ($_POST[ID] != null)) {
		$id = $_POST[ID];
	} else if (($_GET[ID] != '') || ($_GET[ID] != null)) {
		$id = $_GET[ID];
	} // End if
	
	// SELECT
	$resul = mysql_query("SELECT v.IDVENTA, v.FECHA, v.LOGIN, c.NOMBRE, c.EMAIL, vd.IDPRODUCTO, p.DESCRIPCION, p.IDCATEGORIA, g.NOMBRE as CATEGORIA, vd.PRECIO, vd.CANTIDAD
							FROM VENTAS v, VENTAS_DETALLE vd, CLIENTES c, PRODUCTOS p, CATEGORIAS g
							WHERE v.LOGIN = c.LOGIN 
							AND vd.IDVENTA = v.IDVENTA
							AND p.IDPRODUCTO = vd.IDPRODUCTO
							AND p.IDCATEGORIA = g.IDCATEGORIA
							AND v.IDVENTA = ".$id, $conexion) or die ("No funciona");
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
					DETALLE DE LA VENTA #".$id."
				</td>
			</tr>
		</table>

		<br />
	
		<form method='post' name='listado'>
			<table id='compras' class='compras' style='border-bottom-style: none;'>";

	if ($fila != 0) { // HAY ventas
		switch ($order) {
			case "ID_A": 
				$orderBy = "ORDER BY vd.IDPRODUCTO ASC";
				break;
			case "ID_D":
				$orderBy = "ORDER BY vd.IDPRODUCTO DESC";
				break;
			case "DESC_A":
				$orderBy = "ORDER BY p.DESCRIPCION ASC";
				break;
			case "DESC_D":
				$orderBy = "ORDER BY p.DESCRIPCION DESC";
				break;
			case "IDCAT_A": 
				$orderBy = "ORDER BY p.IDCATEGORIA ASC";
				break;
			case "IDCAT_D":
				$orderBy = "ORDER BY p.IDCATEGORIA DESC";
				break;
			case "NAME_A":
				$orderBy = "ORDER BY g.NOMBRE ASC";
				break;
			case "NAME_D":
				$orderBy = "ORDER BY g.NOMBRE DESC";
				break;
			case "QUANTITY_A":
				$orderBy = "ORDER BY vd.CANTIDAD ASC";
				break;
			case "QUANTITY_D":
				$orderBy = "ORDER BY vd.CANTIDAD DESC";
				break;
			case "PRICE_A":
				$orderBy = "ORDER BY vd.PRECIO ASC";
				break;
			case "PRICE_D":
				$orderBy = "ORDER BY vd.PRECIO DESC";
				break;
			case "AMOUNT_A":
				$orderBy = "ORDER BY IMPORTE ASC";
				break;
			case "AMOUNT_D":
				$orderBy = "ORDER BY IMPORTE DESC";
				break;
			default: 
				$orderBy = "ORDER BY vd.IDPRODUCTO ASC"; // Ordenación por defecto, IDPRODUCTO ASC
				break;
		} // End switch
		
		$query = "SELECT v.IDVENTA, v.FECHA, v.LOGIN, c.NOMBRE, c.EMAIL, vd.IDPRODUCTO, p.DESCRIPCION, p.IDCATEGORIA, g.NOMBRE as CATEGORIA, vd.PRECIO, vd.CANTIDAD, vd.PRECIO * vd.CANTIDAD as IMPORTE
				  FROM VENTAS v, VENTAS_DETALLE vd, CLIENTES c, PRODUCTOS p, CATEGORIAS g
				  WHERE v.LOGIN = c.LOGIN 
				  AND vd.IDVENTA = v.IDVENTA
				  AND p.IDPRODUCTO = vd.IDPRODUCTO
				  AND p.IDCATEGORIA = g.IDCATEGORIA
				  AND v.IDVENTA = ".$id;
		
		$resul = mysql_query($query." ".$orderBy, $conexion) or die ("No funciona 2");
		$importeTotal = 0;
		
		$date = new DateTime($fila[FECHA], timezone_open('Europe/Madrid')); // Formato de fecha
		
		echo " <tr style='border-bottom-style: none;'>
					<th style='text-align: center; border-style: none; border-right-style: solid;'>
						FECHA: <span style='font-weight: normal;'>".$date->format('d/m/Y')."</span> - <span style='font-weight: normal;'>".$date->format('H:m')."</span>
					</th>
					<th style='text-align: center; border-style: solid; border-bottom-style: none; border-top-style: none;' colspan='2'>
						LOGIN: <span style='font-weight: normal;'>".$fila[LOGIN]."</span>
					</th>
					<th style='text-align: center; border-style: solid; border-bottom-style: none; border-top-style: none;' colspan='2'>
						NOMBRE: <span style='font-weight: normal;'>".$fila[NOMBRE]."</span>
					</th>
					<th style='text-align: center; border-style: none; border-left-style: solid;' colspan='2'>
						E-MAIL: <a href='mailto:".$fila[EMAIL]."'><span style='font-weight: normal;'>".$fila[EMAIL]."</span></a>
					</th>
				</tr>
			</table>
			<table id='compras' class='compras'>
				<tr class='firstLine'>";
		// ID
		if ($order == "ID_A") {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='ID Producto \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=ID_D'>ID Producto</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "ID_D") {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='ID Producto \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=ID_A'>ID Producto</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='ID Producto \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=ID_A'>ID Producto</a>
						</span>
					</td>";
		}
		// DESCRIPCIÓN
		if ($order == "DESC_A") {
			echo "	<td style='text-align: left;'>
						<span title='Descripci&oacute;n \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=DESC_D'>Descripci&oacute;n</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "DESC_D") {
			echo " <td style='text-align: left;'>
						<span title='Descripci&oacute;n \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=DESC_A'>Descripci&oacute;n</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else {
			echo " <td style='text-align: left;'>
						<span title='Descripci&oacute;n \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=DESC_A'>Descripci&oacute;n</a>
						</span>
					</td>";
		}
		// IDCATEGORÍA
		if ($order == "IDCAT_A") {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='ID Categor&iacute;a \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=IDCAT_D'>ID Categor&iacute;a</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "IDCAT_D") {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='ID Categor&iacute;a \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=IDCAT_A'>ID Categor&iacute;a</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='ID Categor&iacute;a \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=IDCAT_A'>ID Categor&iacute;a</a>
						</span>
					</td>";
		}
		// CATEGORÍA
		if ($order == "NAME_A") {
			echo "	<td style='text-align: left;'>
						<span title='Categor&iacute;a \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=NAME_D'>Categor&iacute;a</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "NAME_D") {
			echo " <td style='text-align: left;'>
						<span title='Categor&iacute;a \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=NAME_A'>Categor&iacute;a</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else {
			echo " <td style='text-align: left;'>
						<span title='Categor&iacute;a \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=NAME_A'>Categor&iacute;a</a>
						</span>
					</td>";
		}
		// CANTIDAD
		if ($order == "QUANTITY_A") {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Cantidad \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=QUANTITY_D'>ID Categor&iacute;a</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "QUANTITY_D") {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Cantidad \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=QUANTITY_A'>Cantidad</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Cantidad \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=QUANTITY_A'>Cantidad</a>
						</span>
					</td>";
		}
		// PRECIO
		if ($order == "PRICE_A") {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Precio \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=PRICE_D'>Precio (&euro;)</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "PRICE_D") {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Precio \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=PRICE_A'>Precio (&euro;)</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Precio \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=PRICE_A'>Precio (&euro;)</a>
						</span>
					</td>";
		}
		// IMPORTE
		if ($order == "AMOUNT_A") {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Importe \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=AMOUNT_D'>Importe (&euro;)</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
				
		} else if ($order == "AMOUNT_D") {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Importe \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=AMOUNT_A'>Importe (&euro;)</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else {
			echo "	<td style='text-align: right; padding-right: 5px;'>
						<span title='Importe \nClick para ordenación ascendente'>
							<a href='./salesDetails.php?ID=".$id."&Order=AMOUNT_A'>Importe (&euro;)</a>
						</span>
					</td>";
		}
		echo "	</tr>";

		while ($fila = mysql_fetch_array($resul)) {
			echo"<tr class='lineaVenta'>
					<td style='text-align: right; padding-right: 5px;'>
						<a href='./modifyProduct.php?ID=".$fila[IDPRODUCTO]."'><span class='enlaceSinNegrita'>".$fila[IDPRODUCTO]."</span></a>
					</td>
					<td style='text-align: left;'>
						<a href='./modifyProduct.php?ID=".$fila[IDPRODUCTO]."'><span class='enlaceSinNegrita'>".$fila[DESCRIPCION]."</span></a>
					</td>
					<td style='text-align: right; padding-right: 5px;'>
						".$fila[IDCATEGORIA]."
					</td>
					<td style='text-align: left;'>
						".$fila[CATEGORIA]."
					</td>
					<td style='text-align: right; padding-right: 5px;'>
						".$fila[CANTIDAD]."
					</td>
					<td style='text-align: right; padding-right: 5px;'>
						".number_format($fila[PRECIO], 2, '.', '')." &euro;
					</td>
					<td style='text-align: right;'>
						".number_format($fila[IMPORTE], 2, '.', '')." &euro;
					</td>
				</tr>";
			$importeTotal = $importeTotal + ($fila[CANTIDAD] * $fila[PRECIO]);
		} // Fin while
		$numero = mysql_num_rows($resul);
		echo "<tr class='numProduct' style='border-bottom-style: none; text-align: right;'>
				<td colspan='6'>
					Importe Total:
				</td>
				<td colspan='1'>
					".number_format($importeTotal, 2, '.', '')." &euro;
				</td>
			</tr>
			<tr class='numProduct' style='border-top-style: none;'>
				<td colspan='7'>
					N&uacute;mero total de Productos: ".$numero."
				</td>
			</tr>";
	} else { // NO hay productos
		echo "	<tr style='text-align: center; font-size: 15; background-color: white;'>
					<td>
						NO HAY VENTAS
					</td>";
	} // End else
	
	echo "		</tr>
			</table>
		</form>
		
		<br />
	
		<table id='menu_admin' class='menu_admin'>
			<tr>
				<td>
					<a href='./salesList.php'><div>Volver al Listado de las ventas</div></a>
				</td>
			</tr>
		</table>";
	
	include ("./includes/bottom.php");
	
	mysql_close();
?>