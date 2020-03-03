<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="contacto";
	  $titulo="Contacta con nosotros";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>

<?php
function imprimirFormulario () {
?>
	<form>
	  <div class="form-group">
		<label for="email">Email:</label>
		<input type="email" class="form-control" id="email" name="email" value="<?php if (isset($_SESSION['email'])) {echo $_SESSION['email'];} ?>">
	  </div>
	  <div class="form-group">
	  <label for="nombre">Nombre:</label>
		<input type="text" class="form-control" id="nombre" name="nombre" value="<?php if (isset($_SESSION['usuario'])) {echo $_SESSION['usuario'];} ?>">
	  </div>
	  <div class="form-group">
		<label for="asunto">Asunto</label>
		<input type="text" class="form-control" id="asunto" name="asunto"></input>
	  </div>
	  <div class="form-group">
		<label for="contenido">Contenido</label>
		<textarea class="form-control" id="contenido" name="contenido" rows="3"></textarea>
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
		if(!isset($_REQUEST['enviar'])) {
			imprimirFormulario();
		}
		else {
			$email=recoge('email');
			$nombre=recoge('nombre');
			$asunto=recoge('asunto');
			$contenido=recoge('contenido');
			
			$errores="";
				
			if ($email=="") {
				$errores=$errores."<li>El campo email no puede estar vacío</li>";
			}
			if ($nombre=="") {
				$errores=$errores."<li>El campo nombre no puede estar vacío</li>";
			}
			if ($asunto=="") {
				$errores=$errores."<li>El campo asunto no puede estar vacío</li>";
			}
			if ($contenido=="") {
				$errores=$errores."<li>El campo contenido no puede estar vacío</li>";
			}			
			if ($errores!="") {
				echo "<h2>Errores:</h2> <ul>$errores</ul>";
				imprimirFormulario();
			}
			else {
				$mensaje=enviarEmail ($email, $nombre, $asunto, $contenido);
				if ($mensaje!="") {
					echo "<div class='alert alert-success' role='alert'> Mensaje enviado correctamente </div>";
					echo "<p><a href='index.php' class='btn btn-primary'>Volver a la pagina principal</a></p>";
				} 
				else {
					echo '<div class="alert alert-danger" role="alert"> ERROR: Mensaje no enviado </div>';
					echo "<p><a href='index.php' class='btn btn-primary'>Volver a la pagina principal</a></p>";
				}
			}
		}
   ?>
   </div>
</main>

<?php require_once("inc/pie.php"); ?>