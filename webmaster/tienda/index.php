<?php
	session_start();

	// Cerrando sesión
	if ($_GET['Option'] == 'Exit') {
		$_SESSION['user'] = "";
		$_SESSION['pass'] = "";
		$_SESSION['carrito'] = "";
		$_GET['Option'] = "";
	} // End if
	
	if ($_SESSION['user'] == "") { // Usuario no logueado en el sistema
		include ("./includes/top.php");
?>	
                <table align='center' id='saludo' class='saludo'>
                    <tr>
                        <td>
                            TIENDA VIRTUAL - ENTRADA
                        </td>
                    </tr>
                </table>
                
                <br />
                
                <form method='post' name='loginForm' action='./content/check.php' onSubmit='return validate();'>					
                    <table id='login' class='login'>
                        <tr>
                            <td style='text-align: right;'>
                                Usuario:
                            </td>
                            <td style='text-align: left;'>
                                <input type='text' size='10' name='usuario' title='Usuario' class='texto' id='userText' />
                            </td>
                        </tr>
                        <tr>
                            <td style='text-align: right;'>
                                Contrase&ntilde;a:
                            </td>
                            <td style='text-align: left;'>
                                <input type='password' size='10' name='clave' value='' title='Contrase&ntilde;a' class='texto' id='passText' />
                                <input type='hidden' name='criterio' value='' />
                                <input type='hidden' name='categoria' value='-1' />
                            </td>
                        </tr>
                        <tr>
                            <td style='text-align: right;'>
                                <input type='submit' name='aceptar' value='Aceptar' class='boton' /> <!-- Espacios para cuadrar el ancho del botón al del 'Nuevo usuario' -->
                            </td>
                            <td style='text-align: left;'>
                                <input type='button' name='nuevo' value='Nuevo usuario' class='boton' onClick='window.location="./content/user/register.php"' title='Registro de un nuevo usuario' />
                            </td>
                        </tr>
                    </table>
                </form>
<?php		
		include ("./includes/bottom.php");
	
	} else { // Usuario logueado en el sistema, redirigir a su respectiva página
		if ($_SESSION['user'] == "root") {
?>
            <!doctype html>
            <html xmlns='http://www.w3.org/1999/xhtml'>
                <head>
                    <meta http-equiv='refresh' content='1; url=./content/admin.php' />
                    <title>Comprobando usuario... - Tienda</title>
                    <link rel='STYLESHEET' type='text/css' href='./styles.css' />
                </head>
                <body>
                    <table id='contenedor' class='contenedor'>
                        <tr>
                            <td style='font-weight: bold;'>
                                Cargando...
                            </td>
                        </tr>
                    </table>
                </body>
            </html>
<?php
		} else { // Usuario normal (no root)
			$_SESSION['carrito']; // Se habilita el carrito
			// $_SESSION['usuario'] = $usuario;
?>
            <!doctype html>
            <html xmlns='http://www.w3.org/1999/xhtml'>
                <head>
                    <meta http-equiv='refresh' content='1; url=./content/user.php' />
                    <title>Comprobando usuario... - Tienda</title>
                    <link rel='STYLESHEET' type='text/css' href='./styles.css' />
                </head>
                <body>
                    <table id='contenedor' class='contenedor'>
                        <tr>
                            <td style='font-weight: bold;'>
                                Cargando...
                            </td>
                        </tr>
                    </table>
                </body>
            </html>
<?php
		} // End if
	} // End if
	
//	mysql_close();
?>