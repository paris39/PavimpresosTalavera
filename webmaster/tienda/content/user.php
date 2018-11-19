<?php
	session_start();

	// A la hora de refrescar la página con alguna búsqueda
	$criterio = $_POST['criterio'];
	$categoria = $_POST['categoria'];
	$categoriaOrdenacion = $_POST['categoriaOrdenacion'];
	$categoriaOrden = $_POST['categoriaOrden'];

	// Conexión a base de datos
	$conexion = mysql_connect("localhost", "root", "root") or die('NO PUDO CONECTARSE');
   	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");

	// Consulta de Usuario
   	$resul = mysql_query("SELECT NOMBRE
					   	  FROM CLIENTES
					   	  WHERE LOGIN = '".$usuario."'", $conexion)  or die ("No funciona");
	// Consulta de categorías
	$resul2 = mysql_query("SELECT *
					   	   FROM CATEGORIAS
					   	   ORDER BY NOMBRE", $conexion)  or die ("No funciona");
	$resul22 = mysql_query("SELECT *
					   	    FROM CATEGORIAS
					   	    ORDER BY NOMBRE", $conexion)  or die ("No funciona");

	$_SESSION['userInfo'] = mysql_fetch_array($resul);
	
	// Criterios de ordenación
	
	
	// Includes
	include ("./includes/security.php");
	include ("./includes/top.php");
	include ("./includes/cabecera.php");
	include ("./includes/user.php");
?>
					<!-- MENÚ DE BÚSQUEDA DE PRODUCTOS Y ORDENACIÓN -->
                    <form method='post' name='busqueda' id='busqueda' action='#' target='_parent'>
                        <table name='menu_busqueda' id='menu_busqueda' class='menu_busqueda'>
                            <tr>
                                <th>
                                    B&uacute;squeda de productos
                                </th>
                            </tr>
                            <tr>
                                <td>
<?php
	if ($criterio != "" && $criterio != null) {
		echo "						B&uacute;squeda: <input type='text' name='criterio' size='70' title='Indicar criterio de b&uacute;squeda de producto' class='texto' value='".$criterio."' />";
	} else {
		echo "						B&uacute;squeda: <input type='text' name='criterio' size='70' title='Indicar criterio de b&uacute;squeda de producto' class='texto' />";
	} // End if
?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Categor&iacute;a: 
                                    <select id='categoria' name='categoria' title='Indicar categor&iacute;a como criterio de b&uacute;squeda de producto' class='combo'>
                                        <option value='-1'>&lt;Seleccione una categor&iacute;a&gt;</option>
<?php
	while ($fila2 = mysql_fetch_array($resul2)) { // Bucle para rellenar el desplegable de categorías
		if ($categoria == $fila2[IDCATEGORIA]) {
			echo"						<option value='".$fila2[IDCATEGORIA]."' selected>".$fila2['NOMBRE']."</option>";
		} else {
			echo"						<option value='".$fila2[IDCATEGORIA]."'>".$fila2['NOMBRE']."</option>";
		}
	} // Fin while
?>
									</select> &nbsp;&nbsp;
									<input type='submit' name='buscar' id='buscar' value='Buscar Productos' title='Buscar productos seg&uacute;n criterios indicados \nSin indicar criterios se mostrar&aacute;n todos los productos (b&uacute;squeda m&aacute;s lenta)' class='boton' />
								</td>
							</tr>
						</table>
                        
                        <br />
                        
                        <table name='menu_busqueda' id='menu_busqueda' class='menu_busqueda'>
                            <tr>
                                <th>
                                    Ordenaci&oacute;n de productos
                                </th>
                            </tr>
                            <tr>
                            	<td>
                                    Categor&iacute;a: 
                                    <select id='categoriaOrdenacion' name='categoriaOrdenacion' title='Indicar categor&iacute;a como criterio de ordenaci&oacute;n de producto' class='combo' onchange='enviarFormulario()' >
                                        <option value='-1'>&lt;Seleccione una categor&iacute;a&gt;</option>
										<option value='0'>Descripci&oacute;n</option>
                                        <option value='1'>Categor&iacute;a</option>
                                        <option value='2'>Precio</option>
									</select> &nbsp;&nbsp;
                                    Orden: 
                                    <select id='categoriaOrden' name='categoriaOrden' title='Indicar categor&iacute;a como criterio de ordenaci&oacute;n de producto' class='combo' onchange='enviarFormulario()' >
                                        <option value='0'>Ascendente</option>
                                        <option value='1'>Descendente</option>
                                    </select> &nbsp;&nbsp;
                                </td>
                            </tr>
                        </table>
                        
					</form>
				
					<br />

<?php
	if ($criterio == '') { // No hay nada en el campo de criterio
		if ($categoria == '' or $categoria == '-1') { // Mostrar todos los resultados
			$resul3 = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION AS DESCRIP, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE
								   FROM PRODUCTOS, CATEGORIAS
								   WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
								   AND DESCATALOGADO IS NULL
								   ORDER BY IDPRODUCTO", $conexion) or die ("No funciona");
			$fila3 = mysql_fetch_array($resul3);
			if ($fila3 != 0) { // HAY productos
				$resul3 = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION AS DESCRIP, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE
									   FROM PRODUCTOS, CATEGORIAS
									   WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
									   AND DESCATALOGADO IS NULL
									   ORDER BY IDPRODUCTO", $conexion) or die ("No funciona"); // ¿Por qué la misma query? Si se elimina no muestra todos los productos, ¿será porque lo recorre una vez el fetch anterior?
				
				//echo "<form method='post' name='resultados' id='resultados' onsubmit='return valida();'>
				echo "	<table name='result' id='result' class='result'>
							<tr>
								<th colspan='2'>
									Listado de todos los productos
								</th>
							</tr>";
				
				while ($fila3 = mysql_fetch_array($resul3)) { // Recorriendo los productos
					echo "	<tr>
								<td class='images' rowspan='2' width='32%'>
									<a href='./images/".$fila3['IMAGEN']."' target='_blank'><img src='./images/".$fila3['IMAGEN']."' title='Ampliar imagen (".$fila3['DESCRIP'].")' alt='Imagen no disponible' /></a>
								</td>
								<td class='details'>
									<span class='descripcion'>".$fila3['DESCRIP']."</span>";
					if ($fila3[EXISTENCIAS] == 0) {
						echo " 		<span class='existencias'>&#42; Producto agotado</span> <!-- &#42; Asterisco -->";
					}
					echo "			<br />
									<br />
									Precio: <span class='mini_detalle'>".$fila3['PRECIO']." &euro;</span>
									<br />
									Categor&iacute;a: <span class='mini_detalle'>".$fila3['NOMBRE']."</span>
								</td>
							</tr>
							<tr style='text-align: right;'>
								<td class='quantity' colspan='2'>
									<form method='post' name='carritoProducto' action='./user/dao/addTrolleyProductDAO.php'>
										<input type='hidden' name='ID' value='".$fila3[IDPRODUCTO]."' />";
					if ($fila3[EXISTENCIAS] == 0) {
						echo " 			Cantidad: <input type='text' name='cantidad' maxlength='3' size='2' class='inputTypeText' title='* Producto agotado' disabled /> <input type='submit' name='aniadir' value='A&ntilde;adir al carrito' title='* Producto agotado' class='botonDisabled' disabled />";
					} else {
						echo "			Cantidad: <input type='text' name='cantidad' maxlength='3' size='2' class='inputTypeText' title='Indicar cantidad del producto a añadir al carrito' /> <input type='submit' name='aniadir' value='A&ntilde;adir al carrito' title='A&ntilde;adir producto al carrito con la cantidad indicada' class='boton' />";
					}					
					echo "			</form>
								</td>
							</tr>";
				} // Fin while
				
				$numero = mysql_num_rows($resul3); // Contador de productos
				
				echo " <tr class='numProduct'>
							<td colspan='7'>
								<br />
								N&uacute;mero total de Productos: ".$numero."
							</td>
						</tr>
					</table>";
			} else { // No hay productos
				echo "	<table name='result' id='result' class='result'>
							<tr>
								<th colspan='2'>
									NO SE HAN ENCONTRADO PRODUCTOS
								</th>
							</tr>
						</table>";
			} // Fin if
		} else { // criterio vacio, pero con alguna categoria
			$resul3 = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE
								   FROM PRODUCTOS, CATEGORIAS
								   WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
								   AND CATEGORIAS.IDCATEGORIA = '".$categoria."'
								   AND DESCATALOGADO IS NULL
								   ORDER BY IDPRODUCTO", $conexion) or die ("No funciona");
			$fila3 = mysql_fetch_array($resul3);
			if ($fila3 != 0) { // HAY productos
				$resul3 = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION AS DESCRIP, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE
									   FROM PRODUCTOS, CATEGORIAS
									   WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
									   AND CATEGORIAS.IDCATEGORIA = '".$categoria."'
									   AND DESCATALOGADO IS NULL
									   ORDER BY IDPRODUCTO", $conexion) or die ("No funciona");
				
				//echo "<form method='post' name='resultados' id='resultados'>
				echo "	<table name='result' id='result' class='result'>
							<tr>
								<th colspan='2'>
									Listado de los productos de la categor&iacute;a ".strtoupper($fila3['NOMBRE'])."
								</th>
							</tr>";
				
				while ($fila3 = mysql_fetch_array($resul3)) { // Recorriendo los productos
					echo "	<tr>
								<td class='images' rowspan='2' style='width: 32%;'>
									<a href='./images/".$fila3['IMAGEN']."' target='_blank'><img src='./images/".$fila3['IMAGEN']."' title='Ampliar imagen (".$fila3['DESCRIP'].")' alt='Imagen no disponible' /></a>
								</td>
								<td class='details'>
									<span class='descripcion'>".$fila3['DESCRIP']."</span>";
					if ($fila3[EXISTENCIAS] == 0) {
						echo " 		<span class='existencias'>&#42; Producto agotado</span> <!-- &#42; Asterisco -->";
					}
					echo "			<br />
									<br />
									Precio: <span class='mini_detalle'>".$fila3['PRECIO']." &euro;</span>
									<br />
									Categor&iacute;a: <span class='mini_detalle'>".$fila3['NOMBRE']."</span>
								</td>
							</tr>
							<tr style='text-align: right;'>
								<td class='quantity' colspan='2'>
									<form method='post' name='carritoProducto' action='./user/dao/addTrolleyProductDAO.php'>
										<input type='hidden' name='ID' value='".$fila3[IDPRODUCTO]."' />";
					if ($fila3[EXISTENCIAS] == 0) {
						echo " 			Cantidad: <input type='text' name='cantidad' maxlength='3' size='2' class='inputTypeText' title='Indicar cantidad del producto a añadir al carrito' disabled /> <input type='submit' name='aniadir' value='A&ntilde;adir al carrito' title='A&ntilde;adir producto al carrito con la cantidad indicada' class='boton' disabled />";
					} else {
						echo "			Cantidad: <input type='text' name='cantidad' maxlength='3' size='2' class='inputTypeText' title='Indicar cantidad del producto a añadir al carrito' /> <input type='submit' name='aniadir' value='A&ntilde;adir al carrito' title='A&ntilde;adir producto al carrito con la cantidad indicada' class='boton' />";
					}			
					echo "			</form>
								</td>
							</tr>";
				} // Fin while
				
				$numero = mysql_num_rows($resul3); // Contador de registros
				
				echo " 		<tr class='numProduct'>
						 		<td colspan='7'>
						 			<br />
					 	 			N&uacute;mero total de Productos: ".$numero."
					 	 		</td>
							</tr>
					 	</table>";
			} else { // No hay productos
				echo "	<table name='result' id='result' class='result'>
							<tr>
								<th colspan='2'>
									NO SE HAN ENCONTRADO PRODUCTOS
								</th>
							</tr>
						</table>";
			} // Fin if
		} // Fin if
	} else {
		if ($categoria == '' or $categoria == '-1') { // Algo de criterio pero sin categoría
			$resul3 = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE
								  FROM PRODUCTOS, CATEGORIAS
								  WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
								  AND PRODUCTOS.DESCRIPCION LIKE '%".$criterio."%'
								  AND DESCATALOGADO IS NULL
								  ORDER BY IDPRODUCTO", $conexion) or die ("No funciona");
			$fila3 = mysql_fetch_array($resul3);
			if ($fila3 != 0) { // HAY productos
				$resul3 = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION AS DESCRIP, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE
									  FROM PRODUCTOS, CATEGORIAS
									  WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
									  AND PRODUCTOS.DESCRIPCION LIKE '%".$criterio."%'
									  AND DESCATALOGADO IS NULL
									  ORDER BY IDPRODUCTO", $conexion) or die ("No funciona");
				
				//echo "<form method='post' name='resultados' id='resultados'>
				echo "	<table name='result' id='result' class='result'>
							<tr>
								<th colspan='2'>
									Listado de los productos filtrados
								</th>
							</tr>";
				
				while ($fila3 = mysql_fetch_array($resul3)) { // Recorriendo los pruductos
					echo "	<tr>
								<td class='images' rowspan='2' style='width: 32%;'>
									<a href='./images/".$fila3['IMAGEN']."' target='_blank'>
										<img src='./images/".$fila3['IMAGEN']."' title='Ampliar imagen (".$fila3['DESCRIP'].")' alt='Imagen no disponible' />
									</a>
								</td>
								<td class='details'>
									<span class='descripcion'>".$fila3['DESCRIP']."</span>";
					if ($fila3[EXISTENCIAS] == 0) {
						echo " 		<span class='existencias'>&#42; Producto agotado</span> <!-- &#42; Asterisco -->";
					}
					echo "			<br />
									<br />
									Precio: <span class='mini_detalle'>".$fila3['PRECIO']." &euro;</span>
									<br />
									Categor&iacute;a: <span class='mini_detalle'>".$fila3['NOMBRE']."</span>
								</td>
							</tr>
							<tr style='text-align: right;'>
								<td class='quantity' colspan='2'>
									<form method='post' name='carritoProducto' action='./user/dao/addTrolleyProductDAO.php'>
										<input type='hidden' name='ID' value='".$fila3[IDPRODUCTO]."' />";
					if ($fila3[EXISTENCIAS] == 0) {
						echo " 			Cantidad: <input type='text' name='cantidad' maxlength='3' size='2' class='inputTypeText' title='Indicar cantidad del producto a añadir al carrito' disabled /> <input type='submit' name='aniadir' value='A&ntilde;adir al carrito' title='A&ntilde;adir producto al carrito con la cantidad indicada' class='boton' disabled />";
					} else {
						echo "			Cantidad: <input type='text' name='cantidad' maxlength='3' size='2' class='inputTypeText' title='Indicar cantidad del producto a añadir al carrito' /> <input type='submit' name='aniadir' value='A&ntilde;adir al carrito' title='A&ntilde;adir producto al carrito con la cantidad indicada' class='boton' />";
					}				
					echo "			</form>
								</td>
							</tr>";
				} // Fin while
				
				$numero = mysql_num_rows($resul3); // Contador de registros
				
				echo " 		<tr class='numProduct'>
						 		<td colspan='7'>
						 			<br />
					 	 			N&uacute;mero total de Productos: ".$numero."
					 	 		</td>
					 		</tr>
						</table>";
			} else { // No hay productos
				echo "	<table name='result' id='result' class='result'>
							<tr>
								<th colspan='2'>
									NO SE HAN ENCONTRADO PRODUCTOS
								</th>
							</tr>
					 	</table>";
			} // Fin if
		} else { // Criterio y categoría
			$resul3 = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE
								  FROM PRODUCTOS, CATEGORIAS
								  WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
								  AND PRODUCTOS.DESCRIPCION LIKE '%".$criterio."%'
								  AND CATEGORIAS.IDCATEGORIA = '".$categoria."'
								  AND DESCATALOGADO IS NULL
								  ORDER BY IDPRODUCTO", $conexion) or die ("No funciona");
			$fila3 = mysql_fetch_array($resul3);
			if ($fila3 != 0) { // HAY productos
				$resul3 = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION AS DESCRIP, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE
									  FROM PRODUCTOS, CATEGORIAS
									  WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
									  AND PRODUCTOS.DESCRIPCION LIKE '%".$criterio."%'
									  AND CATEGORIAS.IDCATEGORIA = ".$categoria."
									  AND DESCATALOGADO IS NULL
									  ORDER BY IDPRODUCTO", $conexion) or die ("No funciona");
				
				//echo "<form method='post' name='resultados' id='resultados'>";
				echo " <table name='result' id='result' class='result'>
							<tr>
								<th colspan='2'>
									Listado de los productos de la categor&iacute;a ".strtoupper($fila3['NOMBRE'])."
								</th>
							</tr>";
				
				while ($fila3 = mysql_fetch_array($resul3)) { // Recorriendo los productos
					echo "	<tr>
								<td class='images' rowspan='2' style='width: 20%;'>
									<a href='./images/".$fila3['IMAGEN']."' target='_blank'>
										<img src='./images/".$fila3['IMAGEN']."' title='Ampliar imagen (".$fila3['DESCRIP'].")' alt='Imagen no disponible' />
									</a>
								</td>
								<td class='details'>
									<span class='descripcion'>".$fila3['DESCRIP']."</span>";
					if ($fila3[EXISTENCIAS] == 0) {
						echo " 		<span class='existencias'>&#42; Producto agotado</span> <!-- &#42; Asterisco -->";
					}
					echo "			<br />
									<br />
									Precio: <span class='mini_detalle'>".$fila3['PRECIO']." &euro;</span>
									<br />
									Categor&iacute;a: <span class='mini_detalle'>".$fila3['NOMBRE']."</span>
								</td>
							</tr>
							<tr style='text-align: right;'>
								<td class='quantity' colspan='2'>
									<form method='post' name='carritoProducto' action='./user/dao/addTrolleyProductDAO.php'>
										<input type='hidden' name='ID' value='".$fila3[IDPRODUCTO]."' />";
					if ($fila3[EXISTENCIAS] == 0) {
						echo " 			Cantidad: <input type='text' name='cantidad' maxlength='3' size='2' class='inputTypeText' title='Indicar cantidad del producto a añadir al carrito' disabled /> <input type='submit' name='aniadir' value='A&ntilde;adir al carrito' title='A&ntilde;adir producto al carrito con la cantidad indicada' class='boton' disabled />";
					} else {
						echo "			Cantidad: <input type='text' name='cantidad' maxlength='3' size='2' class='inputTypeText' title='Indicar cantidad del producto a añadir al carrito' /> <input type='submit' name='aniadir' value='A&ntilde;adir al carrito' title='A&ntilde;adir producto al carrito con la cantidad indicada' class='boton' />";
					}				
					echo "			</form>
								</td>
							</tr>";
				} // Fin while
				
				$numero = mysql_num_rows($resul3); // Contador de registros
				
				echo " 		<tr class='numProduct'>
						 		<td colspan='7'>
						 			<br />
					 	 			N&uacute;mero total de Productos: ".$numero."
					 	 		</td>
					 		</tr>
						</table>";
			} else { // No hay productos
				echo "	<table name='result' id='result' class='result'>
							<tr>
								<th colspan='2'>
									NO SE HAN ENCONTRADO PRODUCTOS
								</th>
							</tr>
						</table>";
			} // Fin if
		} // Fin if
	} // Fin if

	//echo "			</form>";

	include ("./includes/bottom.php");

	mysql_close();
?>