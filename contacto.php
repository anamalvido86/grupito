<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="contacto";
	  $titulo="Contacta con nosotros";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>
<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/Exception.php';
	require 'PHPMailer/PHPMailer.php';
	require 'PHPMailer/SMTP.php';
?>
<?php
function imprimirFormulario () {
?>
	<form>
	  <div class="form-group">
		<label for="email">Email:</label>
		<input type="email" class="form-control" id="email" value="<?php if (isset($_SESSION['email'])) {echo $_SESSION['email'];} ?>">
	  </div>
	  <div class="form-group">
	  <label for="nombre">Nombre:</label>
		<input type="text" class="form-control" id="nombre" value="<?php if (isset($_SESSION['usuario'])) {echo $_SESSION['usuario'];} ?>">
	  </div>
	  <div class="form-group">
		<label for="asunto">Asunto</label>
		<input type="text" class="form-control" id="asunto"></input>
	  </div>
	  <div class="form-group">
		<label for="contenido">Contenido</label>
		<textarea class="form-control" id="contenido" rows="3"></textarea>
	  </div>
	  <p><button type="submit" class="btn btn-primary" name="enviar" value="enviar">Enviar</button></p>
	</form>
<?php
}
?>
<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Contacto</h1>
      <p >Formulario de contacto</p>
    </div>
  </div>
   <div class="container">
   <?php
	imprimirFormulario();
   ?>
   </div>
</main>

<?php require_once("inc/pie.php"); ?>