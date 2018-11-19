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
	
	// Selección de todos los avisos
	$resul = mysql_query("SELECT * 
						  FROM AVISOS 
						  ORDER BY IDAVISO", $conexion) or die ("No funciona");
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
					LISTADO DE LOS AVISOS
				</td>
			</tr>
		</table>

		<br />
	
		<form method='post' name='listado'>
			<table id='productos3' class='productos3'>";
			
	if ($fila != 0) { // HAY ventas
		$query = "SELECT IDAVISO, FECHA, COMENTARIOS, ESTADO, TIPO FROM AVISOS";
		
		switch ($order) {
			case "ID_A": 
				$orderBy = "ORDER BY IDAVISO ASC";
				break;
			case "ID_D":
				$orderBy = "ORDER BY IDAVISO DESC";
				break;
			case "DATE_A":
				$orderBy = "ORDER BY FECHA ASC";
				break;
			case "DATE_D":
				$orderBy = "ORDER BY FECHA DESC";
				break;
			case "COMMENTS_A":
				$orderBy = "ORDER BY COMENTARIOS ASC";
				break;
			case "COMMENTS_D":
				$orderBy = "ORDER BY COMENTARIOS DESC";
				break;
			case "STATE_A":
				$orderBy = "ORDER BY ESTADO ASC";
				break;
			case "STATE_D":
				$orderBy = "ORDER BY ESTADO DESC";
				break;
			default: 
				$orderBy = "ORDER BY IDAVISO ASC"; // Ordenación por defecto, IDAVISO ASC
				break;
		}
	
		$resul = mysql_query($query." ".$orderBy, $conexion) or die ("No funciona");
		
		$avisosSinResolver = 0;
		
		// Fila cabecera, primeraLínea
		echo "	<tr class='firstLine'>";
		// ID
		if ($order == "ID_A") { // ↑
			echo "	<td>
						<span title='ID Aviso \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./warningsList.php?Order=ID_D'>ID</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "ID_D") { // ↓
			echo "	<td>
						<span title='ID Aviso \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./warningsList.php?Order=ID_A'>ID</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td>
						<span title='ID Aviso \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./warningsList.php?Order=ID_A'>ID</a>
						</span>
					</td>";
		}
		// FECHA
		if ($order == "DATE_A") { // ↑
			echo "	<td>
						<span title='Fecha del aviso \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./warningsList.php?Order=DATE_D'>FECHA</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "DATE_D") { // ↓
			echo "	<td>
						<span title='Fecha del aviso \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./warningsList.php?Order=DATE_A'>FECHA</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td>
						<span title='Fecha del aviso \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./warningsList.php?Order=DATE_A'>FECHA</a>
						</span>
					</td>";
		}
		// COMENTARIOS
		if ($order == "COMMENTS_A") { // ↑
			echo "	<td>
						<span title='Comentarios \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./warningsList.php?Order=COMMENTS_D'>COMENTARIOS</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "COMMENTS_D") { // ↓
			echo "	<td>
						<span title='Comentarios \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./warningsList.php?Order=COMMENTS_A'>COMENTARIOS</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td>
						<span title='Comentarios \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./warningsList.php?Order=COMMENTS_A'>COMENTARIOS</a>
						</span>
					</td>";
		}
		// ESTADO
		if ($order == "STATE_A") { // ↑
			echo "	<td>
						<span title='Estado del aviso \n(Ordenado de forma ascendente) \nClick para ordenación descendente'>
							<a href='./warningsList.php?Order=STATE_D'>ESTADO</a><span class='arrow' title='Ordenación ascendente'> &uarr;</span>
						</span>
					</td>";
		} else if ($order == "STATE_D") { // ↓
			echo "	<td>
						<span title='Comentarios \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./warningsList.php?Order=STATE_A'>ESTADO</a><span class='arrow' title='Ordenación descendente'> &darr;</span>
						</span>
					</td>";
		} else { // Sin flechas de ordenación
			echo "	<td>
						<span title='Comentarios \n(Ordenado de forma descendente) \nClick para ordenación ascendente'>
							<a href='./warningsList.php?Order=STATE_A'>ESTADO</a>
						</span>
					</td>";
		}
		echo "	</tr>";

		while ($fila = mysql_fetch_array($resul)) {
			$date = new DateTime($fila[FECHA], timezone_open('Europe/Madrid'));
			echo "<tr class='lineaAviso'>
					<td style='text-align: right; width: 4%;'>
						".$fila[IDAVISO]."
					</td>
					<td style='text-align: center; width: 11%;'>
						".$date->format('d/m/Y')."<br />".$date->format('H:m')."
					</td>
					<td>
						".$fila[COMENTARIOS]."
					</td>
					<td style='text-align: center; width: 12%;'> \n";
						if ($fila[ESTADO] == 1) {
							echo "<form method='post' name='resolverAviso' action='./DAO/warningSolveDAO.php'>
								<input type='hidden' name='IDAVISO' id='IDAVISO' value='".$fila[IDAVISO]."' />
								<input type='hidden' name='TIPO' id='TIPO' value='".$fila[TIPO]."' />";
								
							switch ($fila[TIPO]) {
								case 1: // Aviso sobre PRODUCTO
									$idproducto = strchr($fila[COMENTARIOS], '#'); // Subcadena a partir de "#"
									$idproducto = substr($idproducto, 1, strrpos($idproducto, '-') - 1); // Subcadena desde "#" hasta "-"
									$idproducto = trim($idproducto); // Quitando los posibles espacios en blanco a la izquierda y la derecha
									// Selección del producto relacionado con el aviso
									$resul2 = mysql_query("SELECT * 
														  FROM PRODUCTOS 
														  WHERE IDPRODUCTO = $idproducto", $conexion) or die ("No funciona");
									$fila2 = mysql_fetch_array($resul2);
									// Comprobar errores
									if (mysql_errno($conexion) == 0) { // No ha habido problema con la consulta
										echo "<input type='hidden' name='IDPRODUCTO' id='IDPRODUCTO' value='".$idproducto."' />";	
									} // End if
									echo "<input type='submit' name='resolver' id='resolver' value='Resolver' title='Resolver aviso #".$fila[IDAVISO]."' />";
									$avisosSinResolver = $avisosSinResolver + 1;
									break;
								case 2: // Aviso sobre CLIENTE
									$idcliente = substr($fila[COMENTARIOS], 1, strrpos($fila[COMENTARIOS], ':') - 1);
									$idcliente = trim($idcliente);
									// Selección del producto relacionado con el aviso
									$resul2 = mysql_query("SELECT * 
														  FROM CLIENTES 
														  WHERE LOGIN LIKE '$idcliente'", $conexion) or die ("No funciona");
									$fila2 = mysql_fetch_array($resul2);
									// Comprobar errores
									if (mysql_errno($conexion) == 0) { // No ha habido problema con la consulta
										echo "<input type='hidden' name='CLIENTE' id='CLIENTE' value='".$fila2[LOGIN]."' />
											<input type='hidden' name='EMAIL' id='EMAIL' value='".$fila2[EMAIL]."' />";
											$idventa = substr($fila[COMENTARIOS], strrpos($fila[COMENTARIOS], '#'));
											$idventa = substr($idventa, 1);
										echo "<input type='hidden' name='EMAIL' id='EMAIL' value='".$fila2[EMAIL]."' />
											<input type='hidden' name='IDVENTA' id='IDVENTA' value='".$idventa."' />
											<input type='submit' name='resolver' id='resolver' value='Resolver' title='Resolver aviso #".$fila[IDAVISO]." \nEnviar Email: ".$fila2[EMAIL]."' />";
									} else {
										echo "<span style='color: red; cursor: default;' title='El aviso #".$fila[IDAVISO]." no se puede resolver autom&aacute;ticamente'>&raquo; NO resuelto</span>";
									} // End else
									$avisosSinResolver = $avisosSinResolver + 1;
									break;
								default: 
									break;
							} // End switch
							
							echo "</form>";
						} else {
							echo "<span style='color: green; cursor: default; font-weight: bold;' title='Aviso resuelto'>&raquo; Resuelto</span>";
						} // End if
			echo "	</td>
				</tr>";
		} //Fin while
		
		$numero = mysql_num_rows($resul); // Contador de registros
		
		echo "<tr class='numProduct'>
				<td colspan='4'>
					<br />
					Avisos sin resolver: ".$avisosSinResolver."
					<br />
					N&uacute;mero total de Avisos: ".$numero."
				</td>
			</tr>";
	} else { //NO hay productos
		echo "	<tr style='text-align: center; font-size: 15; background-color: white;'>
					<td>
						NO HAY AVISOS
					</td>";
	} // END else
	
	echo "		</tr>
			</table>
		</form>
		
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