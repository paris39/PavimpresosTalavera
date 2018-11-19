<?php
	
	session_start();
	
	// Includes
	include ("./includes/security.php");
	
	$producto[ID] = $_POST[ID];
	$cantidad = $_POST['cantidad'];
	
	/*
	$usuario = $_POST['usuario'];
	$pass = $_POST['pass'];
	$nombre = $_POST['nombre'];
	$mail = $_POST['mail'];
	$calle = $_POST['calle'];
	$poblacion = $_POST['poblacion'];
	$provincia = $_POST['provincia'];
	$pais = $_POST['pais'];
	*/
	
	// Conexión a base de datos
	$conexion = mysql_connect("localhost", "root", "root") or die('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	
	// Consulta del producto seleccionado
	$resul = mysql_query("SELECT IDPRODUCTO, PRODUCTOS.DESCRIPCION AS DESCRIP, PRECIO, EXISTENCIAS, IMAGEN, NOMBRE
							FROM PRODUCTOS, CATEGORIAS
							WHERE PRODUCTOS.IDCATEGORIA = CATEGORIAS.IDCATEGORIA
							AND IDPRODUCTO = ".$producto[ID], $conexion) or die ("No funciona: ".mysql_errno($conexion));
	$fila = mysql_fetch_array($resul);
		   
	if (mysql_errno($conexion) == 0) {
		// Comprobar el dato recibido 'cantidad'
		$patron = "/^[0-9]{1,3}$/"; // 1, 2 ó 3 caracteres numéricos
		if (preg_match($patron, $cantidad)) {
			if ($cantidad > 0) { // Si es mayor que 0 (cero)
				// Comprobar existencias
				if ($cantidad <= $fila[EXISTENCIAS]) {
					// Comprobar si el producto ya estaba en el carrito, si es así actualizar la cantidad, no añadir una línea nueva
					$salir = false;
					for ($i = 1; $i <= count($_SESSION['carrito']) && !$salir; $i++) {
						if ($_SESSION['carrito'][$i] != null) {
							if ($_SESSION['carrito'][$i][ID] === $producto[ID]) { // El producto ya existía en el carrito
								if (($_SESSION['carrito'][$i][CANTIDAD] + $cantidad) <= $fila[EXISTENCIAS]) { // La nueva cantidad introducida, más la anterior no supera a las existencias de ese producto en base de datos
									$_SESSION['carrito'][$i][CANTIDAD] += $cantidad; // Se actualiza la cantidad
									productoAgregado();
								} else {
									cantidadIncorrecta("La cantidad recibida excede de las existencias disponibles para el producto seleccionado");
								} // End else (existencias)
								$salir = true; // No necesita seguir buscando más productos
							} // End if
						} // End if null
					} // End for
					
					if (!$salir) { // El producto agregado no estaba en el carrito, introducirlo nuevo
						// Echar las cosas al carro
						$producto[DESCRIPCION] = $fila[DESCRIP];
						$producto[CATEGORIA] = $fila[NOMBRE];
						$producto[CANTIDAD] = $cantidad;
						$producto[EXISTENCIAS] = $fila[EXISTENCIAS];
						$producto[PRECIO] = $fila[PRECIO];
						$producto[OK] = true; // Variable que controlará los productos que son borrados y los que no (borrado lógico)
						// Actualizar carrito
						$_SESSION['cantidadProductosCarrito'] ++;
						$_SESSION['carrito'][$_SESSION['cantidadProductosCarrito']] = $producto;
						
						productoAgregado();
					} // End if
				} else {
					cantidadIncorrecta("La cantidad recibida excede de las existencias disponibles para el producto seleccionado");
				} // End else existencias
			} else { // Valor introducido 0 ó menor que 0 (cero)
				cantidadIncorrecta("Debe indicarse una cantidad numérica mayor a 0");
			}
		} else { // Cantidad recibida incorrecta
			cantidadIncorrecta("Debe indicarse una cantidad numérica mayor a 0");
		} // End else comprobación
	} else {
		/*
		if (mysql_errno($conexion) == 1062) {
			echo "<h2>NOMBRE DE USUARIO NO DISPONIBLE, No se ha podido insertar porque ya existe ese nombre de usuario</h2>".$idfila[ident];
		} else {
			$numeroERROR = mysql_errno($conexion); 
			$descripcionERROR = mysql_error($conexion);
			echo "<h2>Nº de error: ".$numeroERROR." * Descripci&oacute;n: ".$descripcionERROR."</h2>";
		} // End else
		*/
	} // End else
	
	
	// El producto se ha agregado al carrito satisfactoriamente
	function productoAgregado () {
		echo "<!doctype html>
				<html xmlns='http://www.w3.org/1999/xhtml'>
					<head>
						<meta http-equiv='refresh' content='1; url=../../user.php' />
						<title>Producto agregado al carrito - Tienda</title>
						<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
						<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
					</head>
					<body>
			
						<table id='contenedor' class='contenedor'>
							<tr>
								<td>
									<h2>&iexcl;PRODUCTO AGREGADO AL CARRITO!</b></h2> Redirigiendo a la p&aacute;gina principal...	
								</td>
							</tr>
						</table>
			
					</body>
				</html>";
	} // End productoAgregado
	
	// Si se introduce una cantidad incorrecta o menor que 0 (cero)
	function cantidadIncorrecta ($mensaje) {
		echo "<!doctype html>
				<html xmlns='http://www.w3.org/1999/xhtml'>
					<head>
						<meta http-equiv='refresh' content='1; url=../../user.php' />
						<title>Cantidad recibida incorrecta - Tienda</title>
						<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
						<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
					</head>
					<body>
						<table id='contenedor' class='contenedor'>
							<tr>
								<td>
									<h2>La cantidad que se ha recibido es incorrecta</h2> Redirigiendo autom&aacute;ticamente a la p&aacute;gina principal...
									<script language='JavaScript'>
										var mensaje = '".$mensaje."';
										alert(mensaje);
									</script>
									<noscript>Your browser does not support JavaScript!</noscript> 
								</td>
							</tr>
						</table>
			
					</body>
				</html>";
	} // End cantidadIncorrecta
	
	mysql_close(); 
?>