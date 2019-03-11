<?php
	// UTF-8
	header('Content-Type: text/html; charset=utf-8');
	
	// Check for empty fields
	if (empty($_POST['name'])      ||
	   empty($_POST['email'])     ||
	   empty($_POST['phone'])     ||
	   empty($_POST['message'])   ||
	   empty($_POST['politics'])   ||
	   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
	   echo "No arguments Provided!";
	   return false;
	}
	
	$name = strip_tags(htmlspecialchars($_POST['name']));
	$email_address = strip_tags(htmlspecialchars($_POST['email']));
	$phone = strip_tags(htmlspecialchars($_POST['phone']));
	$message = strip_tags(htmlspecialchars($_POST['message']));
	   
	// Create the email and send the message
	$to = 'andres@pavimpresostalavera.es'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
	$email_subject = "Contacto desde formulario Web:  $name";
	$email_body = "Has recibido un nuevo mensaje desde el formulario de contacto de www.pavimpresostalavera.es.\n\n <br /><br />"."Aqu&iacute; est&aacute;n los detalles: <br /><br /> Nombre: $name  <br /><br /> Email: $email_address <br /><br /> Tel&eacute;fono: $phone <br /><br /> Mensaje: <br />$message";
	$headers = "Content-type: text/html; charset=UTF-8 <br />";
	$headers .= "From: $email_address <br />"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
	$headers .= "Reply-To: $email_address";   
	@mail($to, $email_subject, $email_body, $headers);
	return true;
?>