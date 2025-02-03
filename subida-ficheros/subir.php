<?php

if(isset($_FILES['foto'])){
	copy($_FILES['foto']['tmp_name'], 'imagenes/'.$_FILES['foto']['name']);
}