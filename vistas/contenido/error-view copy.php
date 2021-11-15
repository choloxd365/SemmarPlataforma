<body>
    <div class="error_page error_2">
      <div class="container inner-wrapper">
        <h1 class="display-1 error-heading">Descargar archivo de recuperación</h1>
        <h2 class="error-code">Back-UP</h2>
        <p class="error-message">Descargar un archivo para restaurar posteriormente hasta este punto.</p>
        <a href="<?php echo SERVERURL ?>" class="btn btn-primary">Descargar</a>
        <form action="<?php echo SERVERURL ?>ajax/sistemaAjax.php" method="post">
          <input type="text" name="back_up" value="1">  
      </form>
      </div>
    </div>
</body>