<?php
	session_start();
	
	include ("./includes/security.php");
	
	$descripcion = $_POST['descripcion'];
	$precio = $_POST[precio]; // Numérico, no lleva comillas
	$existencias = $_POST[existencias];
	$categoria = $_POST[categoria];
	$examinar = $_POST['examinar'];
	
	// Conexiones a la base de datos
	$conexion = mysql_connect("localhost", "root", "root") or die('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	$resul=mysql_query("INSERT INTO productos (DESCRIPCION, PRECIO, EXISTENCIAS, IDCATEGORIA, IMAGEN)
					   VALUES('".$descripcion."', ".$precio.", ".$existencias.", ".$categoria.", '".$examinar."')", $conexion)  or die ("No funciona");
						   
	if (mysql_errno($conexion) == 0) {
		echo "<!doctype html>
			<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
					<meta http-equiv='refresh' content='2; url=../allDataProducts.php' />
					<title>Registro insertado - Tienda</title>
					<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
					<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
				</head>
				<body>
		
					<table align='center' id='contenedor' class='contenedor'>
						<tr align='center'>
							<td valign='middle'>
								<h2>&iexcl;PRODUCTO INSERTADO&#33;</h2>"; // &iexcl; > ¡ $#33; > !
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
	} // End else
	
	mysql_close(); 
?>