<div style="width: 300px; margin: 0 auto; text-align: center;">
<h1>Realizar pago</h1>

<form id="realizarPago" action="<?php echo TPV_URL; ?>" method="post">
    <input type='hidden' name='Ds_SignatureVersion' value='<?php echo DS_SIGNATURE_VERSION; ?>'> 
    <input type='hidden' name='Ds_MerchantParameters' value='<?php echo $res['params']; ?>'> 
    <input type='hidden' name='Ds_Signature' value='<?php echo $res['signature']; ?>'> 
    <input class="btn btn-lg btn-primary btn-block" type="submit" value="PAGO SEGURO CON TARJETA" />
</form>

</div>
