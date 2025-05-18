# Subida de un fichero en PHP

## Consideraciones
- El formulario tiene que tener enctype="multipart/form-data"
- El input de tipo *file* tiene que tener el atributo *multiple* y el nombre tiene que tener []

```html
<html>
	<body>
	  <h1>Subida de múltiples ficheros</h1>
		<form action="subir.php" method="post" enctype="multipart/form-data">
			<input type="file" name="fotos[]" multiple>
			<input type="submit" value="Subir foto">
		</form>
	</body>
</html>
```

## Configuración de PHP

Es importante comprobar que el *php.ini* tiene la opción *file_uploads=On*. También
comprobar otras opciones como *upload_max_filesize*, *max_file_uploads* y *upload_tmp_dir*

```
;;;;;;;;;;;;;;;;
; File Uploads ;
;;;;;;;;;;;;;;;;

; Whether to allow HTTP file uploads.
; http://php.net/file-uploads
file_uploads=On

; Temporary directory for HTTP uploaded files (will use system default if not
; specified).
; http://php.net/upload-tmp-dir
upload_tmp_dir="/opt/lampp/temp/"

; Maximum allowed size for uploaded files.
; http://php.net/upload-max-filesize
upload_max_filesize=40M

; Maximum number of files that can be uploaded via a single request
max_file_uploads=20
```
