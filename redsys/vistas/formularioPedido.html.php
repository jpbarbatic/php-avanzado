<div style="width: 300px; margin: 0 auto; text-align: center; margin-top:100px;">
<h1>Realizar pedido</h1>

<form action="realizarPago.php" method="post">
	<input type="hidden" name="id_pedido" value="<?php echo time(); ?>">
	<label>Concepto</label>
	<input class="form-control mb-3" type="text" name="concepto">
	<label>Importe</label>			
	<input class="form-control mb-3" type="text" name="importe">
	<input class="btn btn-primary" type="submit" name="realizar_pedido" value="Realizar pedido">
</form>

</div>
