<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="registro";
	  $titulo="Registrate";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>


<?php
function imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono) {
?>
	<form>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>"/>
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" class="form-control" id="password" name="password"/>
		</div>
		<div class="form-group">
			<label for="nombre">Nombre:</label>
			<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>"/>
		</div>
		<div class="form-group">
			<label for="apellidos">Apellidos:</label>
			<input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>"/>
		</div>
		<div class="form-group">
			<label for="direccion">Direccion:</label>
			<input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>"/>
		</div>
		<div class="form-group">
			<label for="telefono">Telefono:</label>
			<input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>"/>
		</div>
		<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
		<button type="submit" class="btn btn-primary" name="guardar" value="guardar">Guardar</button>
		<a href='index.php' class='btn btn-danger'>Cancelar</a>
	</form>
<?php
}
?>

<?php
	if (isset($_SESSION['usuario'])) {
		header('Location:index.php');
	}
?>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
		<h1 class="display-3">Registrate</h1>
		<p >
		<?php
			if (!isset($_REQUEST['guardar'])) {
				$email="";
				$nombre="";
				$apellidos="";
				$direccion="";
				$telefono="";
				imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono);
			}
			else {
				$email=recoge("email");
				$password=recoge("password");
				$nombre=recoge("nombre");
				$apellidos=recoge("apellidos");
				$direccion=recoge("direccion");
				$telefono=recoge("telefono");
				
				$errores="";
				
				//Validar recaptcha
				$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
				$recaptcha_secret = CLAVE_SECRETA; 
				$recaptcha_response = recoge('recaptcha_response'); 
				$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
				$recaptcha = json_decode($recaptcha); 

				if($recaptcha->score <= 0.7){
					$errores=$errores."<li>Detectado robot</li>";
				}

				$usuario=seleccionarUsuario($email);
				
				if (!empty($usuario)) {
					$errores=$errores."<li>El usuario ya existe</li>";
				}
	
				if ($email=="") {
					$errores=$errores."<li>El campo email no puede estar vacío</li>";
				}
				if ($password=="") {
					$errores=$errores."<li>El campo password no puede estar vacío</li>";
				}
				if ($nombre=="") {
					$errores=$errores."<li>El campo nombre no puede estar vacío</li>";
				}
				if ($apellidos=="") {
					$errores=$errores."<li>El campo apellidos no puede estar vacío</li>";
				}
				if ($direccion=="") {
					$errores=$errores."<li>El campo direccion no puede estar vacío</li>";
				}
				if ($telefono=="") {
					$errores=$errores."<li>El campo telefono no puede estar vacío</li>";
				}

				if ($errores!="") {
					echo "<h2>Errores:</h2> <ul>$errores</ul>";
					imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono);
				}
				else {
					$usuario=insertarUsuario($email, $password, $nombre, $apellidos, $direccion, $telefono);
					if ($usuario!=0) {
						echo "<div class='alert alert-success' role='alert'> El usuario $usuario ha sido creado correctamente </div>";
						header('Location:index.php');
					} 
					else {
						echo '<div class="alert alert-danger" role="alert"> ERROR: Usuario no insertado </div>';
						imprimirFormulario($email, $nombre, $apellidos, $direccion, $telefono);
					}
				}
			}
		?>
		</p>
    </div>
  </div>
</main>

<?php require_once("inc/pie.php"); ?>