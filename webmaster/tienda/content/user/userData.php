<?php
	session_start();
	
	$criterio = $_GET['criterio'];
	$categoria = $_GET['categoria'];
	$usuario = $_SESSION['user'];
	
	// Conexión a la base de datos
	$conexion=mysql_connect("localhost", "root", "root") or die ('NO PUDO CONECTARSE');
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");
	
	// Recupera todos los datos del usuario registrado
	$resul=mysql_query("SELECT *
				   		FROM CLIENTES
				   		WHERE LOGIN = '".$usuario."'", $conexion)  or die ("No funciona");
	$fila = mysql_fetch_array($resul);
	
	$date = new DateTime($fila[FECHAALTA], timezone_open('Europe/Madrid'));
	
	// Includes
	include ("./includes/security.php");
	include ("./includes/top.php");
	include ("./includes/cabecera.php");
	include ("./includes/user.php");
	
	echo "<form method='post' name='userData' action='./modifyUser.php' target='_parent' onSubmit='return validateUser();'>
			<table id='datos' class='datos' style='text-align: center;'>
				<tr>
					<th colspan='2'>
						DATOS DE MI CUENTA
					</th>
				</tr>
				<tr>
					<td style='text-align: right;'>
						<br />
						Usuario:
					</td>
					<td style='text-align: left;'>
						<br />
						<input type='hidden' name='login' value='".$fila[LOGIN]."' />
						<input type='text' size='12' name='usuario' disabled value='".$fila[LOGIN]."' class='texto' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>
						Contrase&ntilde;a:
					</td>
					<td style='text-align: left;'>
						<input type='password' size='12' name='pass' disabled value='".$fila[PASSWORD]."' class='texto' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right;''>
						Nombre y Apellidos:
					</td>
					<td style='text-align: left;'>
						<input type='text' size='40' name='nombre' disabled value='".$fila[NOMBRE]."' class='texto' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>
						Correo electr&oacute;nico:
					</td>
					<td style='text-align: left;''>
						<input type='text' size='35' name='mail' disabled value='".$fila[EMAIL]."' class='texto' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>
						Calle:
					</td>
					<td style='text-align: left;'>
						<input type='text' size='35' name='calle' disabled value='".$fila[CALLE]."' class='texto' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>
						Poblaci&oacute;n:
					</td>
					<td style='text-align: left;'>
						<input type='text' size='30' name='poblacion' disabled value='".$fila[POBLACION]."' class='texto' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right;''>
						Provincia:
					</td>
					<td style='text-align: left;'>
						<input type='text' size='25' name='provincia' disabled value='".$fila[PROVINCIA]."' class='texto' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right;''>
						Pa&iacute;s:
					</td>
					<td style='text-align: left;'>
						<input type='text' size='20' name='pais' disabled value='".$fila[PAIS]."' class='texto' />
					</td>
				</tr>
				<tr>
					<td style='text-align: right;'>
						Fecha de alta:
						<br />
						<br />
					</td>
					<td style='text-align: left;'>
						<input type='text' id='fechaAlta' size='10' name='fecha' disabled value='".$date->format('d/m/Y')."' class='texto' />
						<br />
						<br />
					</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align: center;'>
						<input type='submit' name='validar' id='val_button' value='Aceptar' style='visibility: hidden;' title='Aceptar cambios' class='boton' />
						<input type='button' name='modificar' id='mod_button' value='Modificar' onClick='modifyUser()' title='Modificar datos de usuario' class='boton' />
						<a href='#' style='text-decoration: none;'>
							<input type='button' name='cancelar' id='can_button' value='Cancelar' style='visibility: hidden;' onClick='modifyUser()' title='Cancelar modificación' class='boton' />
						</a>
					</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align: center;'>
						<br />
					</td>
				</tr>
			</table>
		</form>
	
		<br />
	
		<table id='enlace_atras' class='enlace_atras'>
			<tr>
				<td>
					<a href='../user.php'><div>Volver atr&aacute;s</div></a>
				</td>
			</tr>
		</table>";
	
	// Includes
	include ("./includes/bottom.php");
	
	mysql_close();
?>