
function crearCampos(cantidad){
        var table = document.getElementById("tablaUsuarios");
        while(table.firstChild)table.removeChild(table.firstChild); // remover elementos;
         for(var i = 1, cantidad = Number(cantidad); i <= cantidad; i++){
         var posicionCampo=i;
        nuevaFila = document.getElementById("tablaUsuarios").insertRow(-1)
        nuevaFila.id=posicionCampo;
        
       
        nuevaCelda=nuevaFila.insertCell(-1);
        nuevaCelda.innerHTML="<p style='color:blue' class='grid-header'>Item "+posicionCampo+" </p><div class='form-group'><label for='inputEmail1'>Descripción de Producto</label><input  name='descripcion[]' type='text' class='form-control'  placeholder='Ejemplo: Baras de acero de 1/2 '></div><div class='form-group'><label>Cantidad</label><input name='cantidad[]' type='text' class='form-control'  placeholder='Ejemplo: 2'></div><div class='form-group'> <select name='unidad[]' class='custom-select'><option selected value='Unidad'>Unidad</option><option  value='2'>...</option><option value='3'>...</option></select></div>";

     }
}
function crearCamposCliente(cantidad){
        var table = document.getElementById("detalleCotizacion");
        while(table.firstChild)table.removeChild(table.firstChild); // remover elementos;
         for(var i = 1, cantidad = Number(cantidad); i <= cantidad; i++){
         var posicionCampo=i;
        nuevaFila = document.getElementById("detalleCotizacion").insertRow(-1)
        nuevaFila.id=posicionCampo;
        
       
        nuevaCelda=nuevaFila.insertCell(-1);
        nuevaCelda.innerHTML="<p style='color:blue' class='grid-header'>Item "+posicionCampo+" </p><div class='form-group'><label for='inputEmail1'>Descripcion de Item</label><textarea required class='form-control' name='descripcion[]' id='inputType9' cols='12' rows='5'></textarea></div><div class='form-group'><label>Cantidad</label><input onkeyup='operacionCalamiento();' name='cantidad[]' type='text' class='form-control'  placeholder='Ejemplo: 2'></div><div class='form-group'><label for='inputEmail1'>Precio</label><input  onkeyup='operacionCalamiento();'  name='precio[]' type='text' class='form-control'  placeholder='Ejemplo: S/ 100.00 '></div><div class='form-group'><label for='inputEmail1'>Unidad</label><br><select name='unidad[]' class='custom-select'><option selected value='KG'>KG</option><option  value='MT'>MT</option><option value='C/U'>C/U</option></select></div>";

     }
}