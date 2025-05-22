<div style="text-align:center; margin-top:100px;">
  <?php if ($transaccion['estado']): ?>
    <h1>Pago realizado correctamente</h1>
  <?php else: ?>
    <h1>Pago anulado</h1>
  <?php endif; ?>
  <a href=".">Hacer otro pedido</a>
</div>