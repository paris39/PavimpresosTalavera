<?php
	session_start();
	
	$order = $_GET[Order]; // Variable de ordenación de columnas de tablas
	
	// Id ascendente por defecto
	if ($order == "" || $order == null) {
		$order = "ID_A";	
	}
	
	// Conexiones a la base de datos
	$conexion = mysql_connect("localhost", "root", "root");
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	$resul = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE, DESCATALOGADO
						  FROM PRODUCTOS, CATEGORIAS
						  WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
						  ORDER BY IDPRODUCTO", $conexion) or die ("No funciona");
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
					DATOS DE TODOS LOS PRODUCTOS
				</td>
			</tr>
		</table>
		
		<br />
	
		<table id='menu_admin' class='menu_admin'>
			<tr>
				<td>
					<a href='../admin.php'>
						<div>
							Volver al Men&uacute; de Administrador
						</div>
					</a>
				</td>
			</tr>
		</table>
	
		<br />
	
		<table id='productos2' class='productos2'>";

	if ($fila != 0) { // HAY productos
		// Query para extraer los productos de la base de datos
		$query = "SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE, DESCATALOGADO
				  FROM PRODUCTOS, CATEGORIAS
				  WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA";
		
		switch ($order) {
			case "ID_A": 
				$orderBy = "ORDER BY IDPRODUCTO ASC";
				break;
			case "ID_D":
				$orderBy = "ORDER BY IDPRODUCTO DESC";
				break;
			case "DESC_A":
				$orderBy = "ORDER BY PRODUCTOS.DESCRIPCION ASC";
				break;
			case "DESC_D":
				$orderBy = "ORDER BY PRODUCTOS.DESCRIPCION DESC";
				break;
			case "STOCK_A":
				$orderBy = "ORDER BY EXISTENCIAS ASC";
				break;
			case "STOCK_D":
				$orderBy = "ORDER BY EXISTENCIAS DESC";
				break;
			case "NAME_A":
				$orderBy = "ORDER BY NOMBRE ASC";
				break;
			case "NAME_D":
				$orderBy = "ORDER BY NOMBRE DESC";
				break;
			case "PRICE_A":
				$orderBy = "ORDER BY PRECIO ASC";
				break;
			case "PRICE_D":
				$orderBy = "ORDER BY PRECIO DESC";
				break;
			case "DISC_A":
				$orderBy = "ORDER BY DESCATALOGADO ASC";
				break;
			case "DISC_D":
				$orderBy = "ORDER BY DESCATALOGADO DESC";
				break;
			default: 
				$orderBy = "ORDER BY IDPRODUCTO ASC"; // Ordenación por defecto, IDPRODUCTO ASC
				break;
		} // End switch
		
		
		$resul = mysql_query($query." ".$orderBy, $conexion) or die ("No funciona");
		
		// Fila cabecera, primeraLínea
		echo "<tr class='firstLine'>	
				<td>
				</td>
				<td>
					<table style='text-align: center; width: 100%;'>
						<tr>";
		// ID
		if ($order == "ID_A") { // ↑
			echo "			<td>
								<span title='ID Producto \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
									<a href='./allDataProducts.php?Order=ID_D'>ID</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
								</span>
							</td>";
		} else if ($order == "ID_D") { // ↓
			echo "			<td>
								<span title='ID Producto \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
									<a href='./allDataProducts.php?Order=ID_A'>ID</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
								</span>
							</td>";
		} else { // Sin flechas de ordenación
			echo "			<td>
								<span title='ID Producto \nClick para ordenación ascendente'>
									<a href='./allDataProducts.php?Order=ID_A'>ID</a>
								</span>
							</td>";
		}
		// DESCRIPCIÓN
		if ($order == "DESC_A") { // ↑
			echo "			<td>
								<span title='Descripci&oacute;n \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
									<a href='./allDataProducts.php?Order=DESC_D'>DESCRIPCI&Oacute;N</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
								</span>
							</td>";
		} else if ($order == "DESC_D") { // ↓
			echo "			<td>
								<span title='Descripci&oacute;n \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
									<a href='./allDataProducts.php?Order=DESC_A'>DESCRIPCI&Oacute;N</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
								</span>
							</td>";
		} else { // Sin flechas de ordenación
			echo "			<td>
								<span title='Descripci&oacute;n \nClick para ordenación ascendente'>
									<a href='./allDataProducts.php?Order=DESC_A'>DESCRIPCI&Oacute;N</a>
								</span>
							</td>";
		}
		echo "			</tr>
					</table>							
				</td>";
		// STOCK
		if ($order == "STOCK_A") { // ↑
			echo "<td>
					<span title='Stock \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
						<a href='./allDataProducts.php?Order=STOCK_D'>STOCK</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
					</span>
				</td>";
		} else if ($order == "STOCK_D") { // ↓
			echo "<td>
					<span title='Stock \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
						<a href='./allDataProducts.php?Order=STOCK_A'>STOCK</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
					</span>
				</td>";
		} else { // Sin flechas de ordenación
			echo "<td>
					<span title='Stock \nClick para ordenación ascendente'>
						<a href='./allDataProducts.php?Order=STOCK_A'>STOCK</a>
					</span>
				</td>";
		}
		// P.V.P.
		if ($order == "PRICE_A") { // ↑
			echo "<td>
					<span title='P.V.P. \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
						<a href='./allDataProducts.php?Order=PRICE_D'>P.V.P.</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
					</span>
				</td>";
		} else if ($order == "PRICE_D") { // ↓
			echo "<td>
					<span title='P.V.P. \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
						<a href='./allDataProducts.php?Order=PRICE_A'>P.V.P.</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
					</span>
				</td>";
		} else { // Sin flechas de ordenación
			echo "<td>
					<span title='P.V.P. \nClick para ordenación ascendente'>
						<a href='./allDataProducts.php?Order=PRICE_A'>P.V.P.</a>
					</span>
				</td>";
		}
		// CATEGORÍA
		if ($order == "NAME_A") { // ↑
			echo "<td>
					<span title='Categor&iacute;a \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
						<a href='./allDataProducts.php?Order=NAME_D'>CATEGOR&Iacute;A</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
					</span>
				</td>";
		} else if ($order == "NAME_D") { // ↓
			echo "<td>
					<span title='Categor&iacute;a \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
						<a href='./allDataProducts.php?Order=NAME_A'>CATEGOR&Iacute;A</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
					</span>
				</td>";
		} else { // Sin flechas de ordenación
			echo "<td>
					<span title='Categor&iacute;a \nClick para ordenación ascendente'>
						<a href='./allDataProducts.php?Order=NAME_A'>CATEGOR&Iacute;A</a>
					</span>
				</td>";
		}
		// DESCATALOGADO
		if ($order == "DISC_A") { // ↑
			echo "<td>
					<span title='Descatalogado \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
						<a href='./allDataProducts.php?Order=DISC_D'>DESCATALOGADO</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
					</span>
				</td>";
		} else if ($order == "DISC_D") { // ↓
			echo "<td>
					<span title='Descatalogado \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
						<a href='./allDataProducts.php?Order=DISC_A'>DESCATALOGADO</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
					</span>
				</td>";
		} else { // Sin flechas de ordenación
			echo "<td>
					<span title='Descatalogado \nClick para ordenación ascendente'>
						<a href='./allDataProducts.php?Order=DISC_A'>DESCATALOGADO</a>
					</span>
				</td>";
		}
		echo "	<td>
				</td>
			</tr>";

		while ($fila = mysql_fetch_array($resul)) { // Recorriendo los productos
			echo"<tr class='lineaProducto'>
					<td style='background-color: white; width: 180px;'>
						<a href='../images/".$fila[IMAGEN]."' style='text-decoration: none;' target='_blank'>
							<img src='../images/".$fila[IMAGEN]."' alt='Imagen no disponible' title='Pulsar para ampliar (".$fila[DESCRIPCION].")' />
						</a>
					</td>
					<td style='text-align: left; padding-left: 5px; width: 260px;'>
						<span style='color: red; font-size: 8pt;'>
							ID: ".$fila[IDPRODUCTO]."
						</span>
						<br />
						".$fila[DESCRIPCION]."
					</td>
					<td style='width: 70px;'>";
			if ($fila[EXISTENCIAS] == 0) {
				echo "<span class='existencias' title='Producto agotado'>".$fila[EXISTENCIAS]."</span>";
			} else {
				echo "	".$fila[EXISTENCIAS];
			}
			echo " 	</td>
					<td style='width: 58px;'>
						".$fila[PRECIO]." &euro;
					</td>
					<td style='width: 144px;'>
						".$fila[NOMBRE]."
					</td>
					<td style='width: 170px;'>";
					
			$date = new DateTime($fila[DESCATALOGADO], timezone_open('Europe/Madrid')); // Formato de fecha
			
			if ($fila[DESCATALOGADO] != "" && $fila[DESCATALOGADO] != null) {
				echo "	<span class='existencias' title='Producto descatalogado'>S&Iacute;</span>
						<br />
						<span class='existencias' title='Fecha de descatalogación'>".$date->format('d/m/Y')."</span>";
			} else {
				echo "	NO";	
			}
			echo "	</td>
					<td style='width: 130px;'>
						<form method='post' name='modifyCall' action='./modifyProduct.php'>
							<input type='hidden' name='ID' id='ID' value='".$fila[IDPRODUCTO]."' />
							<input type='submit' name='modificar' id='modificar' value='Modificar' title='Modificar producto: ".$fila[DESCRIPCION]."' />
						</form>
						<br />
						<form method='post' name='deleteCall' onsubmit='return deleteConfirm(\"".$fila[DESCRIPCION]."\");' action='./dao/deleteProductDAO.php'>
							<input type='hidden' name='ID' id='ID' value='".$fila[IDPRODUCTO]."' />
							<input type='hidden' name='DESCRIPCION' id='DESCRIPCION' value='".$fila[DESCRIPCION]."' />
							<input type='submit' name='eliminar' id='eliminar' value='Eliminar' title='Eliminar producto: ".$fila[DESCRIPCION]."' />
						</form>
					</td>
				</tr>";
		} //Fin while
		
		$numero = mysql_num_rows($resul); // Contador de productos
		
		echo "<tr class='numProduct'>
				<td colspan='7'>
					<br />
					N&uacute;mero total de Productos: ".$numero."
				</td>
			</tr>";
	} else { // NO hay productos
		echo "<tr style='text-align: center; font-size: 12pt; background-color: white;'>
				<td>
					NO HAY PRODUCTOS
				</td>
			</tr>";
	} // End else
	
	echo "</table>";
	
	include ("./includes/bottom.php");
	
	mysql_close();
?>