<?php
	session_start();

	include ("./includes/security.php");
	
	// Conexión a la base de datos
  	$conexion = mysql_connect("localhost", "root", "root") or die('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
    
	// Delete
	$resul = mysql_query("DELETE FROM PRODUCTOS WHERE IDPRODUCTO = ".$_POST[ID], $conexion); 
	$filas = mysql_affected_rows($conexion);
	
	if (mysql_errno($conexion) == 0) { // Si no se produce ningún error al borrar
		echo "<!doctype html>
			<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
					<meta http-equiv='refresh' content='2; url=../allDataProducts.php' />
					<title>Registro eliminado - Tienda</title>
					<link rel='STYLESHEET' type='text/css' href='../../../styles.css' />
					<script src='../../../scripts.js' language='JavaScript' type='text/javascript'></script>
				</head>
				<body>
		
					<table align='center' id='contenedor' class='contenedor'>
						<tr align='center'>
							<td valign='middle' style='text-align: center'>
								<h2>&iexcl;SE HA ELIMINADO EL PRODUCTO!</h2>"; // &iexcl; > ¡
		echo "					<h2>Redirigiendo...</h2>
							</td>
						</tr>
			  		</table>
				</body>
			</html>";
	} else { // Se ha producido algún error al borrar el registro
		$numeroERROR = mysql_errno($conexion); 
		$descripcionERROR = mysql_error($conexion);
		echo "<h2>Nº de error: ".$numeroERROR." * Descripci&oacute;n: ".$descripcionERROR."</h2>";
	} // End if
	
	mysql_close();
?>