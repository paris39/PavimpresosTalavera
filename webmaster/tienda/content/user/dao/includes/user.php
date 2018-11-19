<?php
	
	echo "<br />";
	
	echo "<table id='menu_user' class='menu_user'>";
	echo "	<tr align='center'>";
	echo "		<td valign='middle' style='width: 270px;'>";
	echo "			<span class='bienvenido'>BIENVENIDO/A:</span> <span class='usuario'>".strtoupper($_SESSION['nombreUsuario'])."</span>";
	echo "		</td>";
	echo "		<td valign='middle' style='width: 180px;'>";
	echo "			<a href='./datos.php'>Ver mis datos</a>";
	echo "		</td>";
	echo "		<td valign='middle' style='width: 180px;'>";
	echo "			<a href='../../index.php'>Salir</a>";
	echo "		</td>";
	echo "		<td valign='middle' style='width: 180px;'>";
	echo "			<a href='./compras.php'>Historial de compras</a>";
	echo "		</td>";
	echo "		<td valign='middle' style='width: 180px;'>";
	echo "			<a href='#'>Ver mi carrito</a> (".$_SESSION['cantidadProductosCarrito'].")";
	echo "		</td>";
	echo "	</tr>";
	echo "</table>";
	
	echo "<br />";
?>