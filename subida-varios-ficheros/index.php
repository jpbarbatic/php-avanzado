<html>
	<body>
	  <h1>Subida de múltiples ficheros</h1>
		<form action="subir.php" method="post" enctype="multipart/form-data">
			<input type="file" name="fotos[]" multiple>
			<input type="submit" value="Subir foto">
		</form>
	</body>
</html>
