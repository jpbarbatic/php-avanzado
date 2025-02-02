<div class="container-fluid">
    <h1>Envía un correo con PHP</h1>
	<div class="row">
		<div class="col-md-12">
			<form role="form" action="enviar.php" method="post">
				<div class="form-group">
					 
					<label for="exampleInputEmail1">
						Email destinatario
					</label>
					<input type="email" name="email" class="form-control" id="exampleInputEmail1" />
				</div>
				<div class="form-group">
					 
					<label for="exampleInputEmail1">
						Asunto
					</label>
					<input type="text" name="asunto" class="form-control" id="exampleInputEmail1" />
				</div>				
				<div class="form-group">
					 
					<label for="exampleInputPassword1">
						Mensaje
					</label>
                    <textarea id="mensaje" class="form-control" name="mensaje"></textarea>
				</div><?php /*
				<div class="form-group">
					 
					<label for="exampleInputFile">
						File input
					</label>
					<input type="file" class="form-control-file" id="exampleInputFile" />
					<p class="help-block">
						Example block-level help text here.
					</p>
				</div>*/?>

				<button type="submit" class="btn btn-primary">
					Enviar
				</button>
			</form>
		</div>
	</div>
</div>
