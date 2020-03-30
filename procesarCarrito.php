<?php session_start(); ?>
<?php require_once("bbdd/bbdd.php"); ?>
<?php require_once("inc/funciones.php"); ?>

<?php
	if (!isset($_SESSION['usuario'])) {
		header('Location:index.php');
	}
	
$idProducto=recoge('id');
$op=recoge("op");

if ($idProducto=="" or $op=="") {
	header("Location: index.php");
}

$producto=seleccionarProducto($idProducto);

if (empty($producto)) {
	header("Location: index.php");
}

if (empty($_SESSION['carrito'])) {
	$_SESSION['numProductos']=0;
}

switch ($op) {
	case "add":
		if (isset($_SESSION['carrito'][$idProducto])) {
			$_SESSION['carrito'][$idProducto]++;
		}
		else {
			$_SESSION['carrito'][$idProducto]=1;
		}
		$_SESSION['numProductos']++;
		break;
		
	case "remove":
		if (isset($_SESSION['carrito'][$idProducto])) {
			$_SESSION['carrito'][$idProducto]--;
			if ($_SESSION['carrito'][$idProducto]<=0) {
				unset($_SESSION['carrito'][$idProducto]);
			}
			$_SESSION['numProductos']--;
		}
		break;
		
	case "empty":
		unset($_SESSION['carrito']);
		unset($_SESSION['total']);
		unset($_SESSION['numProductos']);
		break;
		
	default:
		header("Location: index.php");
		
} //Fin del switch
header("Location: carrito.php");
?>