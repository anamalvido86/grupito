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
		<h1 class="mt-5">Listado de Productos</h1>
	
		<p><a href="insertarProductos.php" class="btn btn-success">Nuevo Producto</a></p>
	
	<?php
		$productos=seleccionarTodosProductos();
		$numProductos=count($productos);
		
		$productosPagina=2;
		$paginas=ceil($numProductos/$productosPagina);
		
		$pagina=recoge('pagina');
		if ($pagina==false or $pagina<=0 or $pagina>$paginas) {
			$pagina=1;
		}
		$inicio=($pagina-1)*$productosPagina;
		
		$productos=seleccionarProductoPagina($inicio, $productosPagina);
	?>
	
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Nombre</th>
					<th scope="col">Pequeña Descripcion</th>
					<th scope="col">Descripción</th>
					<th scope="col">Imagen</th>
					<th scope="col">Precio</th>
					<th scope="col">Oferta</th>
					<th scope="col">Online</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
				foreach ($productos as $producto) {
					$idProducto=$producto['idProducto'];
					$nombre=$producto['nombre'];
					$introDescripcion=$producto['introDescripcion'];
					$descripcion=$producto['descripcion'];
					$imagen=$producto['imagen'];
					$precio=$producto['precio'];
					$oferta=$producto['precioOferta'];
					$online=$producto['online'];
				?>
				
					<tr>
						<th scope="row"><?php echo "$idProducto"; ?></th>
						<td><?php echo "$nombre"; ?></td>
						<td><?php echo "$introDescripcion"; ?></td>
						<td><?php echo "$descripcion"; ?></td>
						<td><img src="img/<?php echo "$imagen"; ?>" alt="..." class="img-thumbnail"></td>
						<td><?php echo "$precio"; ?></td>
						<td><?php echo "$oferta"; ?></td>
						<td><?php echo "$online"; ?></td>
						<td><a href="actualizarProductos.php?idProducto=<?php echo "$idProducto"; ?>" class="btn btn-info">Editar</a> 
							<a href="borrarProductos.php?idProducto=<?php echo "$idProducto"; ?>" onClick="return Confirmar('¿Realmente quieres borrar el producto?');" class="btn btn-danger">Borrar</a></td>
					</tr>
					
				<?php
				}	//Fin foreach tareas
				echo "<p><a href='menu.php' class='btn btn-primary'>Volver al menú principal</a></p>";
				?>

	
			
			</tbody>
		</table>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
				<li class="page-item <?php if ($pagina==1){echo 'disabled';} ?>"><a class="page-link" href="gestionarProductos.php?pagina=<?php echo $pagina-1; ?>">Anterior</a></li>
				<?php
					for ($i=1;$i<=$paginas;$i++) {
				?>
					<li class="page-item <?php if ($i==$pagina){echo 'active';} ?>"><a class="page-link" href="gestionarProductos.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				<?php
					}
				?>
				<li class="page-item <?php if ($pagina==$paginas){echo 'disabled';} ?>"><a class="page-link" href="gestionarProductos.php?pagina=<?php echo $pagina+1; ?>">Siguiente</a></li>
			</ul>
		</nav>

</main>
<script>
	function Confirmar(Mensaje){
		return (confirm(Mensaje))?true:false;
	}
</script>
<?php require_once "inc/pie.php"; ?>