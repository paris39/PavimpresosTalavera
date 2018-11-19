<?php
	echo "	<br />
	
			<table id='menu_user' class='menu_user'>
				<tr align='center'>
					<td valign='middle' style='width: 270px;'>
						<span class='bienvenido'>BIENVENIDO/A:</span> <span class='usuario'>".$_SESSION['userName']."</span>
					</td>
					<td valign='middle' style='width: 180px;'>
						<a href='./user/userData.php' title='Ver mis datos de usuario'>Ver mis datos</a>
					</td>
					<td valign='middle' style='width: 180px;'>
						<a href='../index.php?Option=Exit' title='Cerrar la sesi&oacute;n actual'>Salir</a>
					</td>
					<td valign='middle' style='width: 180px;'>
						<a href='./user/shopping.php' title='Historial de compras realizadas por ".$_SESSION['userName']."'>Historial de compras</a>
					</td>
					<td valign='middle' style='width: 180px;'>
						<a href='./user/trolley.php' title='Ver mi carrito \nProductos: ".$_SESSION['cantidadProductosCarrito']."'>Ver mi carrito</a> (".$_SESSION['cantidadProductosCarrito'].")
					</td>
				</tr>
			</table>
	
			<br />";
?>