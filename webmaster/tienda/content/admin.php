<?php
	session_start();
	
	// Includes
	include ("./includes/security.php");
	include ("./includes/top.php");
?>	
		<table id='cabecera2' class='cabecera2'>
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
					ADMINISTRACI&Oacute;N DEL SISTEMA
				</td>
			</tr>
		</table>
		
		<br />
	
		<table id='menu_admin' class='menu_admin'>
			<tr>
				<td>
					<a href='./admin/addProduct.php' title='Alta de nuevos productos'>
                    	<div>
                        	Alta de productos
                        </div>
                    </a>
				</td>
			</tr>
			<tr>
				<td>
					<a href='./admin/allDataProducts.php' title='Baja y modificaci&oacute;n de productos existentes'>
                    	<div>
                        	Baja y modificaci&oacute;n de productos
                        </div>
                    </a>
				</td>
			</tr>
			<tr>
				<td>
					<a href='./admin/salesList.php' title='Listado de todas las ventas con su detalle'>
    					<div>
                        	Lista de datos de las ventas
                        </div>
                    </a>
				</td>
			</tr>
			<tr>
				<td>
					<a href='./admin/salesSummary.php' title='Resumen de ventas de todos los clientes con compras'>
                    	<div>
                        	Resumen de ventas de los clientes
                        </div>
                    </a>
				</td>
			</tr>
			<tr>
				<td>
					<a href='./admin/warningsList.php' title='Listado de todos los avisos producidos en el sistema'>
                    	<div>Listado de avisos</div>
                    </a>
				</td>
			</tr>
			<tr>
				<td>
					<a href='./admin/stats.php' title='Estad&iacute;sticas/resumen de los clientes y productos y sus ventas'>
                    	<div>
                        	Estad&iacute;sticas de clientes y productos
                        </div>
                    </a>
				</td>
			</tr>
			<tr>
				<td>
					<a href='../index.php?Option=Exit' title='Cerrar sesi&oacute;n del administrador del sistema'>
                    	<div>
                        	Cerrar sesi&oacute;n
                        </div>
                    </a>
				</td>
			</tr>
		</table>

<?php
	include ("./includes/bottom.php");
	//mysql_close();
?>