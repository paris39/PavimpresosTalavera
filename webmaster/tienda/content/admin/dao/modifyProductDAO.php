<?php
	session_start();
	
	// Includes
	include ("./includes/security.php");
	
	// Conexión a la base de datos
	$conexion = mysql_connect("localhost", "root", "root") or die ('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	if ($_POST[discontinuedYesNo] != "" && $_POST[discontinuedYesNo] != null) {
		$descatalogado = "curdate()"; // Fecha del sistema
	} else {
		$descatalogado = "NULL";
	}
	
	// Update
	if ($_POST[examinar] == '') {
		$resul=mysql_query("UPDATE PRODUCTOS
							SET DESCRIPCION = '".$_POST[descripcion]."',
								PRECIO = ".$_POST[precio].",
								EXISTENCIAS = ".$_POST[existencias].",
								IDCATEGORIA = ".$_POST[categoria].", 
								DESCATALOGADO = ".$descatalogado."  
							WHERE IDPRODUCTO = ".$_POST[ident], $conexion) or die ("No funciona 1");
	} else {
		$resul=mysql_query("UPDATE PRODUCTOS
							SET DESCRIPCION = '".$_POST[descripcion]."',
								PRECIO = ".$_POST[precio].",
								EXISTENCIAS = ".$_POST[existencias].",
								IDCATEGORIA = ".$_POST[categoria].", 
								DESCATALOGADO = ".$descatalogado.", 
								IMAGEN = '".$_POST[examinar]."'
							WHERE IDPRODUCTO = ".$_POST[ident], $conexion) or die ("No funciona 2");
	} // End else
						   
	if (mysql_errno($conexion) == 0) {	
		echo "<!doctype html>
			<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
					<meta http-equiv='refresh' content='2; url=../allDataProducts.php' />
					<title>Registro modificado - Tienda</title>
					<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
					<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
				</head>
				<body>
		
					<table align='center' id='contenedor' class='contenedor'>
						<tr align='center'>
							<td valign='middle'>
								<h2>&iexcl;PRODUCTO MODIFICADO!</h2>"; // &iexcl; > ¡
		echo "					<h2>Redirigiendo...</h2>
							</td>
						</tr>
			  		</table>
		
				</body>
			</html>"; 
	} else {
		if (mysql_errno($conexion) == 1022) {
			echo "<h2>CLAVE DUPLICADA, No se ha podido insertar</h2>".$idfila[ident];
		} else {
			$numeroERROR = mysql_errno($conexion); 
			$descripcionERROR = mysql_error($conexion);
			echo "<h2>Nº de error: ".$numeroERROR." * Descripci&oacute;n: ".$descripcionERROR."</h2>";
		} // End else
	}  // End else
	
	mysql_close(); 
?>