// JavaScript Document

/*** Comprueba cada campo del formulario de Añadir un nuevo producto ***/
function addProduct() {
	// Valido la descripción
	if (document.addForm.descripcion.value == '') {
		alert('Tiene que escribir una descripción');
		document.addForm.descripcion.focus();
		return false;
	}
	if (document.addForm.precio.value == '') {
		alert('Tiene que escribir un precio');
		document.addForm.precio.focus();
		return false;
	} else {
		if (!isDecimal(document.addForm.precio.value)) { // ¿Es decimal el valor introducido?
			alert('Tiene que escribir el precio correctamente. Separador decimal el punto (.)');
			document.addForm.precio.focus();
			return false;
		}
	}
	if (document.addForm.existencias.value == '') {
		alert('Tiene que indicar las existencias');
		document.addForm.existencias.focus();
		return false;
	} else {
		if (!isNumeric(document.addForm.existencias.value)) { // ¿Es numérico el valor introducido?
			alert('Tiene que escribir las existencias correctamente. Valor numérico');
			document.addForm.existencias.focus();
			return false;
		}
	}
	if (document.addForm.categoria.value == '-1') {
		alert('Tiene que indicar la categoría');
		document.addForm.categoria.focus();
		return false;
	}
	return true;
} // Fin addProduct()


/*** Comprueba cada campo del formulario de registro de un nuevo usuario ***/
function addUser() {
	// Valido el registro
	var usu = /^[A-Za-z][0-9A-Za-z_\-]{1,}[A-Za-z0-9]$/;
	var pass = /^[\w]{4,15}$/;
	var nom = /^[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+$/;
	var dir = /^[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ\-\º\.\s]+$/;
	var correo = /^[^0-9][a-z0-9_\.]+@[a-z]+\.*[a-z]*[a-z]+\.[a-z]{2,3}$/;

	// Usuario
	if (!usu.test(document.reg.usuario.value)) {
		alert('Debe escribir su usuario correctamente. No se permiten espacios, y tampoco que el caracter inicial no sea alfanumérico. No puede acabar por ningún caracter que no sea alfanumérico');
		document.reg.usuario.focus();
		return false;
	}
	// Contraseña
	if (!pass.test(document.reg.pass.value)) {
		alert('Debe introducir una contraseña válida. Sólo caracteres alfanuméricos. Mínimo 4 caracteres y un máximo de 15');
		document.reg.pass.focus();
		return false;
	}
	// Nombre
	if (!nom.test(document.reg.nombre.value)) {
		alert('Debe escribir su nombre correctamente');
		document.reg.nombre.focus();
		return false;
	}
	// E-Mail
	if (!correo.test(document.reg.mail.value)) {
		alert('Debe escribir un correo electrónico válido. Ej. usuario@proveedor.com');
		document.reg.mail.focus();
		return false;
	}
	// Calle
	if (!dir.test(document.reg.calle.value)) {
		alert('Debe indicar la calle correctamente');
		document.reg.calle.focus();
		return false;
	}
	// Población
	if (!nom.test(document.reg.poblacion.value)) {
		alert('Debe indicar una población correctamente');
		document.reg.poblacion.focus();
		return false;
	}
	// Provincia
	if (!nom.test(document.reg.provincia.value)) {
		alert('Debe indicar una provincia correctamente');
		document.reg.provincia.focus();
		return false;
	}
	// País
	if (!nom.test(document.reg.pais.value)) {
		alert('Debe indicar un país correctamente');
		document.reg.pais.focus();
		return false;
	}
	return true;
} // End function altaUser()


/*** Confirmar la eliminación del producto ***/
function deleteConfirm(producto) {
	return confirm('¿Desea eliminar el producto: ' + producto + ' ?');	// Mensaje para confirmar la eliminación		
} // End deleteConfirm


/*** Confirmar la eliminación del producto del carrito ***/
function deleteProductConfirm (producto) {
	var AlertBox = confirm('Se va a eliminar el producto [' + producto + '] del carrito. ¿Desea continuar?');
	
	return AlertBox;
} // End ComfirmCancelOrder


/*** Comprueba si un número es decimal ***/
function isDecimal(number) {
	return (String(number).search(/^\d+(\.\d+)?$/) != -1);
} // End isDecimal


/*** Comprueba si una cadena de texto es numérico ***/
function isNumeric(number) {
	return (String(number).search(/^\d+$/) != -1);
} // End isNumeric

/*
function modifyEnabled() {
	if (document.modif.modifyYesNo.checked) {
		document.modif.examinar.disabled = false;
	} else {
		document.modif.examinar.value = '';
		document.modif.examinar.disabled = true;
		// Cambiar imagen
		<?php
			echo "document.getElementById('imageProduct').src = '../images/".$fila2[IMAGEN]."'; // Imagen por defecto \n"
		?>
	}
} // Fin modifyEnabled()
*/

/*** Confirmar la modificación del producto ***/
function validateModifyProduct () {
	var AlertBox = confirm("¿Desea modificar el producto?"); // Mensaje para confirmar la eliminación	
	
	return AlertBox;
} // End validateModifyProduct


/*** Cambia la imagen del producto, con el botón Examinar ***/
function modifyImage() {
	var url = document.modif.examinar.value;
	url = url.substring(url.lastIndexOf("\\") + 1);
	
	//document.getElementById('imageProduct').src = '../images/' + document.modif.examinar.value;
	/*var url = document.modif.examinar.value;
	url = url.replace('\\', '/');*/
	document.getElementById('imageProduct').src = '../images/' + url;
} // Fin modifyImage()


/*** Habilita la modiciación de la imagen, como si se hicera click en el checkbox ***/
function habilitarModificacion() {
	if (document.getElementById('modifyYesNo').checked == '') {
		document.getElementById('modifyYesNo').checked = 'checked';
	} else {
		document.getElementById('modifyYesNo').checked = '';
	}
	modifyEnabled(); // Llamada al método de habilitar el botón Examinar
}

/*** Comprueba cada campo del producto antes de ser modificado ***/
function modifyProduct() {
	// Valido la descripcion
	if (document.modif.descripcion.value == '') {
		alert('Tiene que escribir una descripción');
		document.modif.descripcion.focus();
		return false;
	}
	if (document.modif.precio.value == '') {
		alert('Tiene que escribir un precio');
		document.modif.precio.focus();
		return false;
	} else {
		if (!isDecimal(document.modif.precio.value)) { // Es decimal el valor introducido?
			alert('Tiene que escribir el precio correctamente. Separador decimal el punto (.)');
			document.modif.precio.focus();
			return false;
		}
	}
	if (document.modif.existencias.value == '') {
		alert('Tiene que indicar las existencias');
		document.modif.existencias.focus();
		return false;
	} else {
		if (!isNumeric(document.modif.existencias.value)) { // ¿Es numérico el valor introducido?
			alert('Tiene que escribir las existencias correctamente. Valor numérico');
			document.modif.existencias.focus();
			return false;
		}
	}
	if (document.modif.categoria.value == '-1') {
		alert('Tiene que indicar la categoría');
		document.modif.categoria.focus();
		return false;
	}
	if ((document.modif.examinar.value == '') && (modif.modifyYesNo.checked)) {
		if (document.getElementById('imageProduct').src == '') {
			alert('Debe introducirse una imagen');
			document.modif.examinar.focus();
			return false;
		}
	}
	if (document.modif.modifyYesNo.checked) {
		if (document.modif.examinar.value == '') { // Si se chequea la imagen pero está vacía
			alert('Tiene que introducir una imagen');
			document.modif.examinar.focus();
			return false;
		}
		// Value actual
	} else {
		//document.modif.examinar.value = '".$fila2[IMAGEN]."';
	}
	//return true;
		
	return validateModifyProduct();
	
} // Fin modifyProduct()


/*** Muestra u oculta la fecha de descatalogación del producto ***/
function discontinuedProduct () {
	if (document.modif.discontinuedYesNo.checked) {
		document.getElementById('discontinuedDate').style.visibility = 'visible';
	} else {
		document.getElementById('discontinuedDate').style.visibility = 'hidden';
	}
} // Fin discontinuedProduct()

/*** Comprueba si está habilitada la opción de modificar los datos de usuario ***/
function modifyUser () {
	if (document.userData.nombre.disabled) {
		document.userData.nombre.disabled = false; // Nombre y apellidos
		document.userData.mail.disabled = false; // Correo electrónico
		document.userData.calle.disabled = false; // Calle
		document.userData.poblacion.disabled = false; // Población
		document.userData.provincia.disabled = false; // Provincia
		document.userData.pais.disabled = false; // Pas
		
		document.getElementById('mod_button').style.visibility = 'hidden'; // Modificar
		document.getElementById('val_button').style.visibility = 'visible'; // Validar
		document.getElementById('can_button').style.visibility = 'visible'; // Cancelar
	} else {
		document.userData.nombre.disabled = true; // Nombre y apellidos
		document.userData.mail.disabled = true; // Correo electrónico
		document.userData.calle.disabled = true; // Calle
		document.userData.poblacion.disabled = true; // Población
		document.userData.provincia.disabled = true; // Provincia
		document.userData.pais.disabled = true; // Pas
		
		document.getElementById('mod_button').style.visibility = 'visible'; // Modificar
		document.getElementById('val_button').style.visibility = 'hidden'; // Validar
		document.getElementById('can_button').style.visibility = 'hidden'; // Cancelar
	} // End if
} // End function modifyUser()


/***  ***/
function validarCarrito(formulario) {
	var valor = /^[0-9]{1,3}$/;
	if (document.formulario.cantidad.value != '') {
		if (!valor.test(document.formulario.cantidad.value)) {
			alert('Debe Debe introducir una cantidad numérica correcta');
			document.formulario.cantidad.focus();
			return false;
		} else {
			// Comprobar existencias...
		}
	} else {
		alert('Debe Debe introducir una cantidad numérica');
		document.formulario.cantidad.focus();
		return false;
	}
	return false;
} // Fin onChangeCantidad


/*** Comprueba los campos del formulario de Login, pantalla de bienvenida ***/
function validate() {
	// Usuario
	if (document.loginForm.usuario.value == '') {
		alert('Debe escribir un Usuario');
		document.loginForm.usuario.focus();
		return false;
	}
	// Contraseña
	if (document.loginForm.clave.value == '') {
		alert('Debe escribir una Contraseña');
		document.loginForm.clave.focus();
		return false;
	}
	return true;
} // End validate()


/*** Confirmar la compra con los productos del carrito ***/
function validateTrolley () {
	var AlertBox = confirm("Se va a proceder la compra. ¿Desea continuar?");
	
	return AlertBox;
} // End validateTrolley


/*** Comprueba cada campo de los datos de usuario tras ser modificado ***/
function validateUser() {
	// Valido el registro
	var usu = /^[A-Za-z][0-9A-Za-z_\-]{1,}[A-Za-z0-9]$/; // No se usa en esta función
	var pass = /^[\w]{4,15}$/; // No se usa en esta función
	var nom = /^[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+$/;
	var dir = /^[A-Za-z0-9\-\\.\s]+$/;
	var correo = /^[^0-9][a-z0-9_\.]+@[a-z]+\.*[a-z]*[a-z]+\.[a-z]{2,3}$/;

	// Nombre
	if (!nom.test(document.userData.nombre.value)) {
		alert('Debe escribir su nombre correctamente');
		document.userData.nombre.focus();
		return false;
	}
	// E-Mail
	if (!correo.test(document.userData.mail.value)) {
		alert('Debe escribir un correo electr&oacute;nico v&aacute;lido. Ej. usuario@proveedor.com');
		document.userData.mail.focus();
		return false;
	}
	// Calle
	if (!dir.test(document.userData.calle.value)) {
		alert('Debe indicar la calle correctamente');
		document.userData.calle.focus();
		return false;
	}
	// Población
	if (!nom.test(document.userData.poblacion.value)) {
		alert('Debe indicar una población correctamente');
		document.userData.poblacion.focus();
		return false;
	}
	// Provincia
	if (!nom.test(document.userData.provincia.value)) {
		alert('Debe indicar una provincia correctamente');
		document.userData.provincia.focus();
		return false;
	}
	// Pas
	if (!nom.test(document.userData.pais.value)) {
		alert('Debe indicar un pa&iacute;s correctamente');
		document.userData.pais.focus();
		return false;
	}
	return true;
} // End validateUser()


/*** Abre ventana de detalle de producto, en el carrito ***/
function abrir (id) {
	open('./productDetails.php?ID=' + id, '', 'top=300, left=300, width=675, height=215, resizable=no, menubar=no, titlebar=no, toolbar=no');
} // End abrir


/*** Envía de forma externa el formulario (submit) ***/
function enviarFormulario () {
	document.getElementById("busqueda").submit();
} // End enviarFormulario