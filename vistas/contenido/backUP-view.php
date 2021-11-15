<body>
    <div  style="padding-bottom: 600px;" class="error_page error_2">
      <div class="container inner-wrapper">
        <h2 class="error-code">Guardar Datos</h2>
        <p class="error-message">Realizar un back up para posteriormente restaurar el sistema hasta este punto</p>
        <a  class="btn btn-success" href="<?php echo SERVERURL;?>vistas/contenido/Backup.php">Realizar copia de seguridad</a>
		<br>
        <form action="./Restore.php" method="POST">
			<label>Selecciona un punto de restauración</label><br>
			<select name="restorePoint">
				<option value="" disabled="" selected="">Selecciona un punto de restauración</option>
				<?php
					include_once 'Connet.php';
					$ruta=BACKUP_PATH;
					if(is_dir($ruta)){
						if($aux=opendir($ruta)){
							while(($archivo = readdir($aux)) !== false){
								if($archivo!="."&&$archivo!=".."){
									$nombrearchivo=str_replace(".sql", "", $archivo);
									$nombrearchivo=str_replace("-", ":", $nombrearchivo);
									$ruta_completa=$ruta.$archivo;
									if(is_dir($ruta_completa)){
									}else{
										echo '<option value="'.$ruta_completa.'">'.$nombrearchivo.'</option>';
									}
								}
							}
							closedir($aux);
						}
					}else{
						echo $ruta." No es ruta válida";
					}
				?>
			</select>
			<button  class="btn-primary" type="submit" >Restaurar</button>
		</form>
      </div>
    </div>
</body>