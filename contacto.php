<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="contacto";
	  $titulo="Contacta con nosotros";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Contacto</h1>
      <p >Formulario de contacto</p>
      <p><a class="btn btn-primary btn-lg" href="productos.php" role="button">Nuestras ofertas »</a></p>
    </div>
  </div>
  
</main>

<?php require_once("inc/pie.php"); ?>