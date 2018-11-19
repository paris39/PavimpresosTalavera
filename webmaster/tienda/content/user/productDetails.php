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
	$resul2 = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION AS 'DESCRIP', PRECIO, EXISTENCIAS, IMAGEN, NOMBRE
						  FROM PRODUCTOS, CATEGORIAS
						  WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
	 					  AND IDPRODUCTO = ".$id, $conexion) or die ("No funciona2");
	$fila2 = mysql_fetch_array($resul2);
	
	// Includes
	include ("./includes/security.php");
	include ("./includes/productTop.php");
	
	/*
	echo "<table id='cabecera2' class='cabecera2'>
			<tr align='center'>
				<td valign='middle'>
					TIENDA VIRTUAL
				</td>
			</tr>
		</table>
	
		<br />
	*/
	echo "<table id='cabecera3Product' class='cabecera3Product'>
			<tr>
				<td>
					DETALLES DE PRODUCTO
				</td>
			</tr>
		</table>
		
		<br />
		
		<table name='result' id='resultProduct' class='resultProduct'>
			<tr>
				<td class='images' rowspan='1' style='width: 32%;'>
					<a href='../images/".$fila2['IMAGEN']."' target='_blank'><img src='../images/".$fila2['IMAGEN']."' title='Ampliar imagen (".$fila2['DESCRIP'].")' alt='Imagen no disponible' /></a>
				</td>
				<td class='details'>
					<span class='descripcion'>".$fila2['DESCRIP']."</span>";
	if ($fila2[EXISTENCIAS] == 0) {
		echo " 		<span class='existencias'>&#42; Producto agotado</span> <!-- &#42; Asterisco -->";
	}
	echo "			<br />
					<br />
					Precio: <span class='mini_detalle'>".$fila2['PRECIO']." &euro;</span> <span style='font-size: 10px;'>(I.V.A inclu&iacute;do)</span>
					<br />
					Categor&iacute;a: <span class='mini_detalle'>".$fila2['NOMBRE']."</span>
				</td>
			</tr>
		</table>";
		
	
	include ("./includes/bottom.php");
	
	mysql_close($conexion);
?>