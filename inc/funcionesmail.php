<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/Exception.php';
	require 'PHPMailer/PHPMailer.php';
	require 'PHPMailer/SMTP.php';
?>

<?php
// FUNCIÓN DE RECOGIDA DE DATOS
function recoge($var, $m = "")
{
    if (!isset($_REQUEST[$var])) {
        $tmp = (is_array($m)) ? [] : "";
    } elseif (!is_array($_REQUEST[$var])) {
        $tmp = trim(htmlspecialchars($_REQUEST[$var], ENT_QUOTES, "UTF-8"));
    } else {
        $tmp = $_REQUEST[$var];
        array_walk_recursive($tmp, function (&$valor) {
            $valor = trim(htmlspecialchars($valor, ENT_QUOTES, "UTF-8"));
        });
    }
    return $tmp;
} //Fin funcion recogida datos

function mostrarProductos ($productos) { 
?>
	<!-- Example row of columns -->
	<div class="row row-cols-1 row-cols-md-3">
<?php
		foreach($productos as $producto) {
?>
			<div class="col mb-4">
				<div class="card">
					<img src="imagenes/<?php echo $producto["imagen"]; ?>" class="card-img-top" alt="<?php echo $producto["nombre"]; ?>">
						<div class="card-body">
							<h5 class="card-title"><?php echo $producto["nombre"]; ?></h5>
							<p class="card-text"><?php echo $producto["introDescripcion"]; ?></p>
							<a href="producto.php?id=<?php echo $producto["idProducto"]; ?>" class="btn btn-success"><?php echo $producto["precioOferta"]; ?> €</a>
							<span class="card-text text-danger float-right"> <del> <?php echo $producto["precio"]; ?> €</span>
						</div>
				</div>
			</div>
 <?php
		} //Fin del foreach
?>
	</div> <!-- col rows -->
<?php
} //Fin de la funcion mostrarProductos

function mostrarMensaje ($mensaje) {
?>
	<div class="jumbotron bg-transparent">
    <div class="container">
      <h3><?php echo $mensaje; ?></h3>
    </div>
  </div>
<?php
}

//Enviar email
function enviarEmail ($email, $nombre, $asunto, $contenido) {
	// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

	try {
		//Server settings
		$mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;                      // Enable verbose debug output
		$mail->isSMTP();                                            // Send using SMTP
		$mail->SMTPOptions =array (
		'ssl'=> array(
			'verify_peer' => true,
			'verify_depth' => 3,
			'cafile' => '/etc/ssl/certs/mail.sri.pem'
			)
		);
		
		$mail->Host       = 'mail.ana.sri';                    // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'ana@ana.sri';                     // SMTP username
		$mail->Password   = 'abc123.';                               // SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
		$mail->Port       = 143;                                    // TCP port to connect to

		//Recipients
		$mail->setFrom($email, $nombre);
		//$mail->addAddress('ana.malvido86@gmail.com', 'Joe User');     // Add a recipient
		//$mail->addAddress('ana.malvido86@gmail.com');               // Name is optional
		//$mail->addReplyTo($email, $nombre);
		//$mail->addCC('cc@example.com');
		$mail->addBCC('ana.malvido86@gmail.com');

		// Attachments
		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $asunto;
		$mail->Body    = $contenido;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		$mail->send();
	} catch (Exception $e) {
		echo "El mensaje no se pudo enviar. Mailer Error: {$mail->ErrorInfo}";
	}
	return "Mensaje enviado";
}
?>