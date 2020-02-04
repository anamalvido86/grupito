<?php
// FUNCIÓN DE RECOGIDA DE DATOS
function recoge($var, $m = "")
{
    if (!isset($_REQUEST[$var])) {
        $tmp = (is_array($m)) ? [] : "";
    } elseif (!is_array($_REQUEST[$var])) {
        $tmp = trim(htmlspecialchars($_REQUEST[$var], ENT_QUOTES, "UTF-8"));
    } else {
        $tmp = $_REQUEST[$var];
        array_walk_recursive($tmp, function (&$valor) {
            $valor = trim(htmlspecialchars($valor, ENT_QUOTES, "UTF-8"));
        });
    }
    return $tmp;
} //Fin funcion recogida datos

function mostrarProductos ($productos) { 
?>
	<!-- Example row of columns -->
	<div class="row row-cols-1 row-cols-md-3">
<?php
		foreach($productos as $producto) {
?>
			<div class="col mb-4">
				<div class="card">
					<img src="imagenes/<?php echo $producto["imagen"]; ?>" class="card-img-top" alt="<?php echo $producto["nombre"]; ?>">
						<div class="card-body">
							<h5 class="card-title"><?php echo $producto["nombre"]; ?></h5>
							<p class="card-text"><?php echo $producto["introDescripcion"]; ?></p>
							<a href="producto.php?id=<?php echo $producto["idProducto"]; ?>" class="btn btn-success"><?php echo $producto["precioOferta"]; ?> €</a>
							<span class="card-text text-danger float-right"> <del> <?php echo $producto["precio"]; ?> €</span>
						</div>
				</div>
			</div>
 <?php
		} //Fin del foreach
?>
	</div> <!-- col rows -->
<?php
} //Fin de la funcion mostrarProductos
?>