<?php
	session_start();
	
	// Conexión a la base de datos
	$conexion=mysql_connect("localhost", "root", "root");
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	// Nº de clientes registrados
	$resul = mysql_query("SELECT count(*) as NUMERO
						  FROM CLIENTES", $conexion) or die ("No funciona");	  
	$fila = mysql_fetch_array($resul);
	
	// Cliente que más ha comprado
	$resul2 = mysql_query("SELECT v.LOGIN, c.NOMBRE as NOMBRE, count(v.IDVENTA) AS CONTADOR
							FROM CLIENTES c, VENTAS v
							WHERE v.LOGIN = c.LOGIN
							AND v.LOGIN = (SELECT LOGIN
											FROM VENTAS
											ORDER BY count(IDVENTA) DESC 
											LIMIT 0,1)
							ORDER BY contador DESC", $conexion) or die ("No funciona 2");
	$fila2 = mysql_fetch_array($resul2);
	
	// Nº de productos
	$resul3 = mysql_query("SELECT count(*) as NUMERO
						   FROM PRODUCTOS", $conexion) or die ("No funciona 3");
	$fila3 = mysql_fetch_array($resul3);
	
	// Producto más vendido
	$resul4 = mysql_query("SELECT vd.IDPRODUCTO, p.DESCRIPCION, sum(vd.CANTIDAD) as TOTAL
							FROM PRODUCTOS p, VENTAS v, VENTAS_DETALLE vd
							WHERE vd.IDPRODUCTO = p.IDPRODUCTO
							AND vd.IDVENTA = v.IDVENTA
							GROUP BY vd.IDPRODUCTO, p.DESCRIPCION
							ORDER BY vd.CANTIDAD DESC
							LIMIT 0,1;", $conexion) or die ("No funciona 4");
	$fila4 = mysql_fetch_array($resul4);
	
	// Producto menos vendido
	$resul5 = mysql_query("SELECT vd.IDPRODUCTO, p.DESCRIPCION, sum(vd.CANTIDAD) as TOTAL
							FROM PRODUCTOS p, VENTAS v, VENTAS_DETALLE vd
							WHERE vd.IDVENTA = v.IDVENTA
							AND vd.IDPRODUCTO = p.IDPRODUCTO
							GROUP BY vd.IDPRODUCTO, p.DESCRIPCION
							ORDER BY vd.CANTIDAD ASC
							LIMIT 0,1;", $conexion) or die ("No funciona 5");
	$fila5 = mysql_fetch_array($resul5);
	
	// Algunos productos no vendidos
	$resul6 = mysql_query("SELECT IDPRODUCTO, DESCRIPCION
						   FROM PRODUCTOS
						   WHERE IDPRODUCTO not in (SELECT IDPRODUCTO
						                            FROM VENTAS_DETALLE)
						   LIMIT 0,5", $conexion) or die ("No funciona 6");
	$fila6 = mysql_fetch_array($resul6);
	
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
					ESTAD&Iacute;STICAS DE CLIENTES
				</td>
			</tr>
		</table>

		<br />
	
		<table id='estad_clientes' class='result2'>
			<tr style='text-align: center;'>
				<td>
					Nº de clientes registrados: <span style='font-weight: normal';>".$fila[NUMERO]."</span> <span style='font-size: 10px;'>(Usuarios Administradores incluidos)</span>
				</td>
			</tr>
			<tr style='text-align: center;'>
				<td>";
	
	if ($fila2 != 0) {
		echo "		Cliente que m&aacute;s ha comprado: <a href='./shoppingDetails.php?LOGIN=".$fila2[LOGIN]."'><span  class='enlaceSinNegrita'>".$fila2[NOMBRE]."</span></a>, Nº de compras: <a href='./shoppingDetails.php?LOGIN=".$fila2[LOGIN]."'><span  class='enlaceSinNegrita'>".$fila2[CONTADOR]."</span></a>";
	} else {
		echo "		Cliente que m&aacute;s ha comprado: <span class='enlaceSinNegrita'>- (No hay ventas)</span>, Nº de compras: <span class='enlaceSinNegrita'>- (No hay ventas)</span>";
	} // End else
	
	echo "		</td>
			</tr>
			<tr style='text-align: center;'>
				<td>
					<span style='font-weight: normal; font-size: 10pt; color: red;'>(*Nota. Si hay varios s&oacute;lo visualizar&aacute; uno)</span>
				</td>
			</tr>
		</table>
	
		<br />
		<br />
	
		<table id='cabecera3' class='cabecera3'>
			<tr>
				<td>
					ESTAD&Iacute;STICAS DE PRODUCTOS
				</td>
			</tr>
		</table>

		<br />
	
		<table id='estad_productos' class='result2'>
			<tr style='text-align: center;'>
				<td>
					Nº de productos en el almac&eacute;n: <a href='./allDataProducts.php'><span class='enlaceSinNegrita'>".$fila3[NUMERO]."</span></a>
				</td>
			</tr>
			<tr style='text-align: center;'>
				<td>";
	
	if ($fila4 != 0) {
		echo "		Producto m&aacute;s vendido: <a href='./modifyProduct.php?ID=".$fila4[IDPRODUCTO]."'><span class='enlaceSinNegrita'>".$fila4[DESCRIPCION]." (".$fila4[TOTAL]." ventas)</span></a>";
	} else {
		echo "		Producto m&aacute;s vendido: <span style='font-weight: normal';>- (No hay ventas)</span>";
	} // End else
	
	echo "		</td>
			</tr>
			<tr style='text-align: center;'>
				<td>";
	
	if ($fila5 != 0) {
		echo "		Producto menos vendido: <a href='./modifyProduct.php?ID=".$fila5[IDPRODUCTO]."'><span  class='enlaceSinNegrita'>".$fila5[DESCRIPCION]." (".$fila5[TOTAL]." ventas)</span></a>";
	} else {
		echo "			Producto menos vendido: <span style='font-weight: normal';>- (No hay ventas)</span>";
	} // End else
	
	echo "		</td>
			</tr>
			<tr style='text-align: center;'>
				<td>
					<span style='font-weight: normal; font-size: 10pt; color: red;'>(*Nota. Si hay varios s&oacute;lo visualizar&aacute; uno)</span>
				</td>
			</tr>
			<tr style='text-align: center;'>
				<td>
					<br />
					Algunos productos que no se han vendido nunca:
				</td>
			</tr>";	
	
	if ($fila6 != 0) {
		// Algunos productos no vendidos
		$resul6 = mysql_query("SELECT IDPRODUCTO, DESCRIPCION
						       FROM PRODUCTOS
						  	   WHERE IDPRODUCTO not in (SELECT IDPRODUCTO
						                            	FROM VENTAS_DETALLE)
						   	   LIMIT 0,5", $conexion) or die ("No funciona 6,5");
		while ($fila6 = mysql_fetch_array($resul6)) {
			echo "	<tr style='text-align: center;'>
						<td>
							<a href='./modifyProduct.php?ID=".$fila6[IDPRODUCTO]."'><span style='font-weight: normal';>".$fila6[DESCRIPCION]."</span></a>
						</td>
					</tr>";
		} //Fin while
	} else {
			echo "	<tr style='text-align: center;'>
						<td>
							<span style='font-weight: normal';>-</span>
						</td>
					</tr>";
	} // End else
	
	echo "</table>
	
		<br />
	
		<table id='menu_admin' class='menu_admin'>
			<tr>
				<td>
					<a href='../admin.php'><div>Volver al Men&uacute; de Administrador</div></a>
				</td>
			</tr>
		</table>";
	
	include ("./includes/bottom.php");
	
	mysql_close($conexion);
?>