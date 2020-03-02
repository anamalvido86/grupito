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
      <h1 class="display-3">Detalles del pedido</h1>
      <p><a class="btn btn-info btn-lg"  href="misPedidos.php" role="button">Volver a mis pedidos</a></p>
    </div>
  </div>
  <?php
	$idPedido=recoge('id');
	if ($idPedido=="") {
		header("Location:misPedidos.php");
	}
	
	$pedido=seleccionarPedido($idPedido);
	
	$fecha=$pedido['fecha'];
	$estado=$pedido['estado'];
	$total=$pedido['total'];
	
	$detallePedido=seleccionarDetallePedido($idPedido);
  ?>
  <div class="container">
		<div class="row px-5">
			<dl class="row">
			  <dt class="col-sm-3">Nº Pedido</dt>
			  <dd class="col-sm-9"><?php echo $idPedido; ?></dd>

			  <dt class="col-sm-3">Fecha</dt>
			  <dd class="col-sm-9"><?php echo $fecha; ?></dd>

			  <dt class="col-sm-3">Estado</dt>
			  <dd class="col-sm-9"><?php echo $estado; ?></dd>

			</dl>
			
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
					foreach ($detallePedido as $detalle) {
						$idProducto=$detalle['idProducto'];
						$producto=seleccionarProducto($idProducto);
						$nombre=$producto['nombre'];
						
						$cantidad=$detalle['cantidad'];
						$precio=$detalle['precio'];
						$subtotal=$precio*$cantidad;
				?>
						<tr>
						  <th scope="row"><a href="producto.php?id=<?php echo "$idProducto"; ?>" class="text-info"> <?php echo "$nombre"; ?> </a> </th>
						  <td class="text-center"> <?php echo "$cantidad"; ?> </td>
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
			
		</div>
	</div>
</main>

<?php require_once("inc/pie.php"); ?>