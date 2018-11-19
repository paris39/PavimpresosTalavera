<?
	session_start();

	// Conexión a la base de datos
	$conexion = mysql_connect("localhost", "root", "root");
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	if (($_POST[ID] != '') || ($_POST[ID] != null)) {
		$id = $_POST[ID];
	} else if (($_GET[ID] != '') || ($_GET[ID] != null)) {
		$id = $_GET[ID];
	} // End if
	
	$resul = mysql_query("SELECT * FROM CATEGORIAS ORDER BY NOMBRE", $conexion) or die ("No funciona");
	$resul2 = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION AS 'DESCRIP', PRECIO, EXISTENCIAS, IMAGEN, NOMBRE, DESCATALOGADO
						  FROM PRODUCTOS, CATEGORIAS
						  WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
	 					  AND IDPRODUCTO = ".$id, $conexion) or die ("No funciona2");
	$fila2 = mysql_fetch_array($resul2);
	
	// Fecha del sistema
	date_default_timezone_set("Europe/Madrid");
	$today = date("d/m/Y");
	
	// Includes
	include ("./includes/security.php");
	include ("./includes/top.php");
	
	echo "<table id='cabecera2' class='cabecera2'>
			<tr'>
				<td>
					TIENDA VIRTUAL
				</td>
			</tr>
		</table>
	
		<br />
	
		<table id='cabecera3' class='cabecera3'>
			<tr>
				<td>
					MODIFICACI&Oacute;N DEL PRODUCTO
				</td>
			</tr>
		</table>
		
		<br />
	
		<form method='post' name='modif' id='modif' onsubmit='return modifyProduct();' action='./dao/modifyProductDAO.php'>
			<input type='hidden' name='ident' value='".$fila2[IDPRODUCTO]."' />
			<table id='modificar_producto' class='productos'  style='padding-top: 15px;'>
				<tr>
					<td colspan='2'>
			 			<table id='modifyImage' class='modifyImage'>
							<tr>
								<td>
									<img src='../images/".$fila2[IMAGEN]."' alt='Imagen no disponible' title='".$fila2[DESCRIP]."' id='imageProduct' />
								</td>
							</tr>
						</table>
					</td>
				<tr>
					<td style='text-align: right; width: 35%;'>
						(*) Descripci&oacute;n del producto:
					</td>
					<td style='text-align: left;'>
						<input type='text' name='descripcion' value='".$fila2[DESCRIP]."' size='70' class='texto' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right; width: 35%;'>
						(*) Precio:
					</td>
					<td style='text-align: left;'>
						<input type='text' name='precio' value='".$fila2[PRECIO]."' size='7' class='texto' id='numerico' /> &euro;uros
					</td>
				</tr>
				<tr>
					<td style='text-align: right; width: 35%;'>
						(*) Existencias:
					</td>
					<td style='text-align: left;'>
						<input type='text' name='existencias' value='".$fila2[EXISTENCIAS]."' size='5' class='texto' id='numerico' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right; width: 35%;'>
						(*) Categor&iacute;a:
					</td>
					<td style='text-align: left;'>
						<select name='categoria' class='combo'>
							<option value='-1'>&lt;Seleccionar categor&iacute;a&gt;</option>";
	
	while($fila = mysql_fetch_array($resul)) {
		if ($fila[NOMBRE] == $fila2[NOMBRE]) {
			echo"					<option value='".$fila[IDCATEGORIA]."' selected>".$fila[NOMBRE]."</option>";
		} else {
			echo"					<option value='".$fila[IDCATEGORIA]."'>".$fila[NOMBRE]."</option>";
		} // End else
	} // Fin while
	
	echo "				</select>
					</td>
				</tr>
				<tr>
					<td style='text-align: right; width: 35%;'>
						Producto descatalogado:
					</td>
					<td style='text-align: left;'>";
	if ($fila2[DESCATALOGADO] != null && $fila2[DESCATALOGADO] != "") {
		$date = new DateTime($fila2[DESCATALOGADO], timezone_open('Europe/Madrid')); // Formato de fecha
		echo "			<input type='checkbox' name='discontinuedYesNo' id='discontinuedYesNo' value='Descatalogado' onClick='discontinuedProduct();' title='Seleccionar si el producto está descatalogado' checked /> <input type='text' disabled='disabled' id='discontinuedDate' name='discontinuedDate' class='texto' style='visibility: visible;' title='Fecha de la descatalogación (No modificable)' value='".$date->format('d/m/Y')."' />";
	} else {
		echo "			<input type='checkbox' name='discontinuedYesNo' id='discontinuedYesNo' value='Descatalogado' onClick='discontinuedProduct();' title='Seleccionar si el producto está descatalogado' /> <input type='text' disabled='disabled' id='discontinuedDate' name='discontinuedDate' class='texto' style='visibility: hidden;' title='Fecha de la descatalogación (No modificable)' value='".$today."' />";
	}
	echo "			</td>
				</tr>
				<tr>
					<td style='text-align: right; width: 35%;'>
						Imagen (m&aacute;ximo 200 Kbytes):
					</td>
					<td style='text-align: left;'>
						<script language='JavaScript' type='text/javascript'>
							function modifyEnabled() {
								if (document.modif.modifyYesNo.checked) {
									document.modif.examinar.disabled = false;
								} else {
									document.modif.examinar.value = '';
									document.modif.examinar.disabled = true;
									// Cambiar imagen
									document.getElementById('imageProduct').src = '../images/".$fila2[IMAGEN]."'; // Imagen por defecto \n
								}
							} // Fin modifyEnabled()
						</script>
						<input type='file' name='examinar' id='examinar' size='50' value='".$fila2[IMAGEN]."' disabled onChange='modifyImage();' />
						<span title='Habilitar para modificar la imagen del producto'>
							<input type='checkbox' name='modifyYesNo' id='modifyYesNo' value='Modificar' onClick='modifyEnabled();' /><span style='font-size: 11px; cursor: default;' onClick='habilitarModificacion();'>Modificar imagen (S/N)</span>
						</span>
					</td>
				</tr>
				<tr>
					<td colspan='2' style='padding-top: 5px; padding-bottom: 6px;'>
						<span style='color: red; font-size: 12px'>(*) Datos obligatorios</span>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<input type='submit' name='enviar' value='Modificar producto' class='boton' />
						<br />
						<br />
					</td>
				</tr>
			</table>
		</form>
		
		<br />
	
		<table id='menu_admin' class='menu_admin'>
			<tr>
				<td>
					<a href='../admin.php'><div>Volver al Men&uacute; de Administrador</div></a>
				</td>
			</tr>
			<tr>
				<td>
					<a href='./allDataProducts.php'><div>Volver a los Productos</div></a>
				</td>
			</tr>
		</table>";
	
	include ("./includes/bottom.php");
	
	mysql_close($conexion);
?>