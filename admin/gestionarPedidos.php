<?php session_start(); ?>
<?php require_once "inc/bbdd.php"; ?>
<?php require_once "inc/funciones.php"; ?>
<?php require_once "inc/encabezado.php"; ?>



<main role="main" class="container">

<?php
	if (!isset($_SESSION["nombre"])) {
		header("Location:index.php");
	}
?>
		<h1 class="mt-5">Listado de Pedidos</h1>
	
	<?php
		$pedidos=seleccionarTodosPedidos();
		$numPedidos=count($pedidos);
		
		$pedidosPagina=2;
		$paginas=ceil($numPedidos/$pedidosPagina);
		
		$pagina=recoge('pagina');
		if ($pagina==false or $pagina<=0 or $pagina>$paginas) {
			$pagina=1;
		}
		$inicio=($pagina-1)*$pedidosPagina;
		
		$pedidos=seleccionarPedidoPagina($inicio, $pedidosPagina);
	?>
	
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Usuario</th>
					<th scope="col">Fecha</th>
					<th scope="col">Total</th>
					<th scope="col">Estado</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
				foreach ($pedidos as $pedido) {
						$idPedido=$pedido['idPedido'];
						$usuario=$pedido['idUsuario'];
						$fecha=$pedido['fecha'];
						$total=$pedido['total'];
						$estado=$pedido['estado'];
				?>
				
					<tr>
						<th scope="row"><?php echo "$idPedido"; ?></th>
						<td><?php echo "$usuario"; ?></td>
						<td><?php echo "$fecha"; ?></td>
						<td><?php echo "$total"; ?></td>
						<td><?php echo "$estado"; ?></td>
						<td><a href="actualizarEstado.php?idPedido=<?php echo "$idPedido"; ?>" class="btn btn-info">Editar estado</a> 
						<a href="detallePedido.php?idPedido=<?php echo "$idPedido"; ?>" class="btn btn-success">Ver detalle</a></td> 
					</tr>
					
				<?php
				}	//Fin foreach tareas
				echo "<p><a href='menu.php' class='btn btn-primary'>Volver al menú principal</a></p>";
				?>

	
			
			</tbody>
		</table>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
				<li class="page-item <?php if ($pagina==1){echo 'disabled';} ?>"><a class="page-link" href="gestionarPedidos.php?pagina=<?php echo $pagina-1; ?>">Anterior</a></li>
				<?php
					for ($i=1;$i<=$paginas;$i++) {
				?>
					<li class="page-item <?php if ($i==$pagina){echo 'active';} ?>"><a class="page-link" href="gestionarPedidos.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				<?php
					}
				?>
				<li class="page-item <?php if ($pagina==$paginas){echo 'disabled';} ?>"><a class="page-link" href="gestionarPedidos.php?pagina=<?php echo $pagina+1; ?>">Siguiente</a></li>
			</ul>
		</nav>

</main>
<?php require_once "inc/pie.php"; ?>