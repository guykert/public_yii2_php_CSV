<?php

    if($asistencia == 0){

        ?>
            <button type="button" class="btn btnrojo1 asistencia_presente_botton" asistencia="0" id ="<?php echo 'asistencia_presente' . $usuario_id; ?>" usuario_id = "<?php echo $usuario_id; ?>" value = "0" style="color:#fff;" >Ausente <i class="fa fa-times"></i></button>
        <?php

    }

    if($asistencia == 1){

        ?>
            <button type="button" class="btn btnverde1 asistencia_presente_botton" asistencia="1"  id ="<?php echo 'asistencia_presente'.$usuario_id; ?>" usuario_id = "<?php echo $usuario_id; ?>" value = "1" style="color:#fff;" >Presente <i class="fa fa-check"></i></button>
        <?php

    }

    if($asistencia == 2){

        ?>
            <button type="button" class="btn btnamarillo1 asistencia_presente_botton" asistencia="2"  id ="<?php echo 'asistencia_atrasado'.$usuario_id; ?>" usuario_id = "<?php echo $usuario_id; ?>" value = "2" style="color:#fff;" >Atraso <i class="fa fa-clock-o"></i></button>
        <?php

    }

?>

<?php 



    $this->registerJs("

        $('.asistencia_presente_botton').click(function(e){
            e.preventDefault();

            

            var boton = $(this);

            var usuario_id = $(this).attr( \"usuario_id\");

            var asistencia = $(this).attr( \"asistencia\");
            

            var resultado_ajax = boton.parent();

            $.ajax({
                url: 'actualizar-asistencia',
                type: 'get',
                data: {'id':" . $asignatura_curso_id . ",'fecha':'"  . $fecha . "','asistencia':asistencia,'usuario_id':usuario_id},
                dataType:'html',
                success: function (response) {
                    // do something with response

                    resultado_ajax.html('');
                    resultado_ajax.fadeOut().empty();
                    resultado_ajax.append(response).fadeIn();

                    


                }
            });
            return false;
        
        });

    ");
?> 