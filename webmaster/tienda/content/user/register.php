<?php
	if ($_SESSION['user'] != "") { // Usuario logueado	
		header('Location: '.$_SERVER['HTTP_REFERER']); // Url anterior
	} // End else
	
	include ("./includes/registerTop.php");
?>
                    <table id='cabecera2' class='cabecera2'>
                        <tr>
                            <td>
                                REGISTRO DE DATOS DE CLIENTES
                            </td>
                        </tr>
                    </table>
                    
                    <br />
                    
                    <form method='post' name='reg' action='./dao/addUserDAO.php' target='_parent' onSubmit='return addUser();'>
                        <table id='registro' class='registro'>
                            <tr>
                                <td style='text-align: right;'>
                                    <br />
                                    Usuario:
                                </td>
                                <td style='text-align: left;'>
                                    <br />
                                    <input type='text' maxlength='20' size='12' name='usuario' class='texto' />
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: right;'>
                                    Contrase&ntilde;a:
                                </td>
                                <td style='text-align: left;'>
                                    <input type='password' maxlength='20' size='15' name='pass' class='texto' />
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: right;'>
                                    Nombre y Apellidos:
                                </td>
                                <td style='text-align: left;'>
                                    <input type='text' size='40' maxlength='40' name='nombre' class='texto' />
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: right;'>
                                    Correo electr&oacute;nico:
                                </td>
                                <td style='text-align: left;'>
                                    <input type='text' size='30' maxlength='30' name='mail' class='texto' />
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: right;'>
                                    Calle:
                                </td>
                                <td style='text-align: left;'>
                                    <input type='text' size='30' maxlength='40' name='calle' class='texto' />
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: right;'>
                                    Poblaci&oacute;n:
                                </td>
                                <td style='text-align: left;'>
                                    <input type='text' size='30' maxlength='35' name='poblacion' class='texto' />
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: right;'>
                                    Provincia:
                                </td>
                                <td style='text-align: left;'>
                                    <input type='text' size='25' maxlength='35' name='provincia' class='texto' />
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: right;'>
                                    Pa&iacute;s:
                                </td>
                                <td style='text-align: left;'>
                                    <input type='text' size='20' maxlength='25' name='pais' class='texto' />
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: right;'>
                                    <br />
                                    <input type='submit' name='alta' value='Darse de alta' class='boton' title='Validar registro' />
                                </td>
                                <td align='left'>
                                    <br />
                                    <input type='reset' name='reset' value='Restablecer' class='boton' title='Resetear todos los campos del formulario' />
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2' style='text-align: center;'>
                                    <br />
                                    <span id='obligatorio'>(Todos los campos son obligatorios)</span>
                                </td>
                            </tr>
                            <!--tr>
                                <td colspan='2' style='text-align: center;'>
                                    <br />
                                    <input type='button' name='entrada' value='Pantalla de entrada' onClick='window.location="../../index.php"' class='boton' title='Volver a la pantalla principal' />
                                </td>
                            </tr-->
                        </table>
                    </form> 
				
                <br />
                
                <table id='menu_admin' class='menu_admin'>
                    <tr>
                        <td>
                            <a href='../../index.php' title='Volver a la pantalla principal'>
                            	<div>
                                	Pantalla de entrada
                                </div>
                            </a>
                        </td>
                    </tr>
                </table>
<?php
	include ("./includes/bottom.php");
?>