<?php
require('../config.php');
require('../lib/pago.php');

if($_SERVER['REQUEST_METHOD']=='GET')
{
  if(comprobar_pago())
  {
	  echo "OK";
  }else{
	  echo "KO";
  }
}
