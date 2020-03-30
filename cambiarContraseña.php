<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="cambiarContraseña";
	  $titulo="Cambiar contraseña";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>

<?php
	if (!isset($_SESSION['usuario'])) {
		header('Location:index.php');
	}
?>

<?php
function imprimirFormulario($email) {
?>
	<form>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" readonly="readonly" value="<?php echo $email; ?>"/>
		</div>
		<div class="form-group">
			<label for="password">Password anterior:</label>
			<input type="password" class="form-control" id="password" name="password" />
		</div>
		<div class="form-group">
			<label for="newPassword1">Nueva password:</label>
			<input type="password" class="form-control" id="newPassword1" name="newPassword1" />
		</div>
		<div class="form-group">
			<label for="newPassword2">Repite la password nueva:</label>
			<input type="password" class="form-control" id="newPassword2" name="newPassword2" />
		</div>
		
		<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
		<button type="submit" class="btn btn-primary" name="guardar" value="guardar">Guardar</button>
		<a href='index.php' class='btn btn-danger'>Cancelar</a>
	</form>
<?php
}
?>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
		<h1 class="display-3">Cambiar contraseña</h1>
		<p >
		<?php
			if (!isset($_REQUEST['guardar'])) {
				$email=$_SESSION['email'];
				imprimirFormulario($email);
			}
			else {
				$email=recoge("email");
				$password=recoge("password");
				$newPassword1=recoge("newPassword1");
				$newPassword2=recoge("newPassword2");
				
				$usuario=seleccionarUsuario($email);
				$hash=$usuario['password'];
				
				$errores="";
				
				if (!password_verify($password, $hash)) {
					$errores=$errores."<li>La contraseña anterior no es correcta</li>";
				}
				if ($newPassword2!=$newPassword1 or $newPassword1=="") {
					$errores=$errores."<li>La nueva contraseña no coincide</li>";
				}

				if ($errores!="") {
					echo "<h2>Errores:</h2> <ul>$errores</ul>";
					imprimirFormulario($email);
				}
				else {
					$ok=actualizarContraseña($email, $newPassword1);
					if ($ok!=0) {
						echo "<div class='alert alert-success' role='alert'> La contraseña ha sido modificada correctamente </div>";
						echo "<p><a href='misDatos.php' class='btn btn-primary'>Volver a mis datos</a></p>";
					} 
					else {
						echo '<div class="alert alert-danger" role="alert"> ERROR: Contraseña no actualizada </div>';
						imprimirFormulario($email);
					}
				}
			}
		?>
		</p>
    </div>
  </div>
</main>

<?php require_once("inc/pie.php"); ?>