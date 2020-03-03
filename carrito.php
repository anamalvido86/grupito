<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php $pagina="carrito";
	  $titulo="Tu compra";
?>
<?php require_once("inc/encabezado.php"); ?>
<?php require_once("inc/funciones.php"); ?>

<main role="main">

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Tu carrito de la compra</h1>
      <p><a class="btn btn-info btn-lg" href="productos.php" role="button">Seguir comprando »</a></p>
    </div>
  </div>
  <?php
	if (empty($_SESSION['carrito'])) {
		$mensaje="Tu carrito de la compra está vacío";
		mostrarMensaje($mensaje);
	}
	else {
	
  ?>
  <div class="container">
		<div class="row px-5">
			<table class="table">
			  <thead class="thead-dark">
				<tr>
				  <th scope="col">Producto</th>
				  <th scope="col" class="text-center">Cantidad</th>
				  <th scope="col" class="text-center">Precio</th>
				   <th scope="col" class="text-center">Subtotal</th>
				</tr>
			  </thead>
			  <tbody>
				<?php
					$total=0;
					foreach ($_SESSION['carrito'] as $id => $cantidad ) {
						$producto=seleccionarProducto($id);
						$nombre=$producto['nombre'];
						$precio=$producto['precioOferta'];
						$subtotal=$cantidad*$precio;
						$total=$total+$subtotal;
				?>
						<tr>
						  <th scope="row"><a href="producto.php?id=<?php echo "$id"; ?>" class="text-info"> <?php echo "$nombre"; ?> </a> </th>
						  <td class="text-center"><a class="text-info" href="procesarCarrito.php?id=<?php echo $id; ?>&op=remove"><i class="fas fa-minus"></i></a> <?php echo "$cantidad"; ?> <a class="text-info" href="procesarCarrito.php?id=<?php echo $id; ?>&op=add"><i class="fas fa-plus"></i></a> </td>
						  <td class="text-center"><?php echo "$precio"; ?></td>
						  <td class="text-center"><?php echo "$subtotal"; ?></td>
						</tr>
				<?php
					}
				?>
			  </tbody>
			  <tfoot>
				<tr>
					<th scope="row" colspan="3" class="text-right">Total</th>
					<td class="text-center"><?php echo "$total"; ?></td>
				</tr>
			  </tfoot>
			</table>
			
			<p> <a class="btn btn-danger" href="procesarCarrito.php?id=<?php echo $id; ?>&op=empty">Vaciar carrito</a>
			<a href="confirmarPedido.php" class="btn btn-success ml-3"> Confirmar pedido </a></p>
			
		</div>
	</div>
	<?php
		$_SESSION['total']=$total;
	}
	?>
</main>

<?php require_once("inc/pie.php"); ?>