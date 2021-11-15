$(document).ready(function(){
 $('.FormularioAjax').submit(function(e){
        e.preventDefault();

        var form=$(this);
        //contiene el tipo de formulario data-form, ejemplo data-form="save"
        var tipo=form.attr('data-form');
        //selecciona el action del formulario, para enviarlo mediante una ruta
        var accion=form.attr('action');
        //method del formulario, ejemplo en el formulario. method="POST"
        var metodo=form.attr('method');
        //RESPUESTA Q TRAE EL ENVIO DEL FORMULARIO, si se hizo con exito, o no, y asi etc   
        var respuesta=form.children('.RespuestaAjax');

        var msjError="<script>swal('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
        var formdata = new FormData(this);
 

        var textoAlerta;
        if(tipo==="save"){
            textoAlerta="Los datos que enviaras quedaran almacenados en el sistema";
        }else if(tipo==="delete"){
            textoAlerta="Los datos serán eliminados completamente del sistema";
        }else if(tipo==="update"){
        	textoAlerta="Los datos del sistema serán actualizados";
        }else if(tipo==="login"){
        	textoAlerta="Iniciar Sesión";
        }else{
            textoAlerta="Quieres realizar la operación solicitada";
        }


        swal({
            title: "¿Estás seguro?",   
            text: textoAlerta,   
            type: "question",   
            showCancelButton: true,     
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then(function () {
            $.ajax({
                type: metodo,
                url: accion,
                data: formdata ? formdata : form.serialize(),
                //
                cache: false,
                contentType: false,
                processData: false,
                // para mostrar la carga el porcentaje si fuera el caso de un archivo grande 
                //que estamos subiendo
                xhr: function(){
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        if(percentComplete<100){
                        	respuesta.html('<p class="text-center">Procesado... ('+percentComplete+'%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: '+percentComplete+'%;"></div></div>');
                      	}else{
                      		respuesta.html('<p class="text-center"></p>');
                      	}
                      }
                    }, false);
                    return xhr;
                },
// si el envio del formulario fue satisfactorio se muestra la respuesta 
                success: function (data) {
                    respuesta.html(data);

                 $("#RespuestaAjax").append(data);
                },
                // o si hay error manda error
                error: function(data) {
                 $("#RespuestaAjax").append(msjError);
                }
            });
            return false;
        });
    });

});