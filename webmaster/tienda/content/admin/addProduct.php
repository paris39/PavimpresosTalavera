<?php
	session_start();

	// Conexiones a la base de datos
	$conexion = mysql_connect("localhost", "root", "root");
	mysql_select_db("tienda", $conexion);
	mysql_query("SET NAMES 'utf8'");

	$resul = mysql_query("SELECT * FROM CATEGORIAS ORDER BY NOMBRE", $conexion) or die ("No funciona");

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
                    <tr'>
                        <td>
                            ALTA DE PRODUCTOS
                        </td>
                    </tr>
                </table>
                    
                <br />
                
                <form method='post' name='addForm' id='addForm' onsubmit='return addProduct();' action='./dao/addProductDAO.php'>
                    <table id='alta_producto' class='productos' style='padding-top: 20px;'>
                        <tr>
                            <td style='text-align: right; width: 35%;'>
                                (*) Descripci&oacute;n del producto:
                            </td>
                            <td style='text-align: left;'>
                                <input type='text' name='descripcion' size='70' class='texto' />
                            </td>	
                        </tr>
                        <tr>
                            <td style='text-align: right; width: 35%;'>
                                (*) Precio:
                            </td>
                            <td style='text-align: left;'>
                                <input type='text' name='precio' size='7' class='texto' id='numerico' /> &euro;uros
                            </td>
                        </tr>
                        <tr>
                            <td style='text-align: right; width: 35%;'>
                                (*) Existencias:
                            </td>
                            <td style='text-align: left;'>
                                <input type='text' name='existencias' size='5' class='texto' id='numerico' />
                            </td>
                        </tr>
                        <tr>
                            <td style='text-align: right; width: 35%;''>
                                (*) Categor&iacute;a:
                            </td>
                            <td style='text-align: left;'>
                                <select name='categoria' class='combo'>
                                    <option value='-1'>&lt;Seleccionar categor&iacute;a&gt;</option>
<?php	
	while ($fila = mysql_fetch_array($resul)) {
		// Pintando las categorías
		echo"						<option value='".$fila[IDCATEGORIA]."'>".$fila[NOMBRE]."</option>";
	} // Fin while
?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style='text-align: right; width: 35%;'>
                                (*) Imagen (m&aacute;ximo 200 Kbytes):
                            </td>
                            <td style='text-align: left;'>
                                <input type='file' name='examinar' size='70' class='fichero' title='Cargar imagen desde archivo' />
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2'>
                            	<br />
                                <span style='color: red; font-size: 12;'>
                                	(*) Datos obligatorios
                                </span>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan='2'>
                            	<br />
                                <input type='submit' name='enviar' value='Alta del producto' class='boton' title='Dar de alta el producto' />
                                <input type='reset' name='restablecer' value='Restablecer' class='boton' title='Resetear todos los campos del formulario' />
                               	<br />
                                <br />
                            </td>
                        </tr>
                    </table>
                </form>
                
                <br />
                
                <table id='menu_admin' class='menu_admin'>
                    <tr>
                        <td>
                            <a href='../admin.php'>
                            	<div>
                                	Volver al Men&uacute; de Administrador
                                </div>
                            </a>
                        </td>
                    </tr>
                </table>
                
<?php	
	include ("./includes/bottom.php");
	
	//mysql_close();
?>