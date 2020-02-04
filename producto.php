<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>
<?php require_once("bbdd/bbdd.php"); ?>

<?php
	$idProducto=recoge("id");
	$producto=seleccionarProducto($idProducto);
	$nombre=$producto['nombre'];
	$introDescripcion=$producto['introDescripcion'];
	$descripcion=$producto['descripcion'];
	$imagen=$producto['imagen'];
	$precio=$producto['precio'];
	$precioOferta=$producto['precioOferta'];
?>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3"><?php echo $nombre ?></h1>
    </div>
  </div>

  <div class="container">
	<div class="row col-10 mx-auto">
		<div class="col-6">
			<p><?php echo $descripcion; ?></p>
			<div class="col-12 mx-auto d-flex justify-content-center">
				<a href="carrito.php" class="btn btn-success text-justify">Añadir al carrito</a>
			</div>
		</div>
		<div class="col-6">
			<img src="imagenes/<?php echo $imagen; ?>" class="card-img-top rounded" alt="<?php echo $nombre; ?>"/>
			<div class="row mt-2 mx-auto">
				<span class="text-danger col-6 text-justify display-4">
					Antes <del><?php echo $precio; ?>
				</span>
				<span class="text-success col-6 text-right display-4">
					Ahora <?php echo $precioOferta; ?>
				</span>
			</div>
		</div>
	</div>

    <hr>

  </div> <!-- /container -->

</main>

<?php require_once("inc/pie.php"); ?>