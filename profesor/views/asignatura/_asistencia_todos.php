<div class="row mb-3 mt-3">
    <div class="col-md-9 mt-2"><h6><?php echo 'Cambiar Todos' ?></h6></div>
    <div class="col-md-3 alineartodo pl-0">

    <?php

        if($asistencia_botton == 0){

            ?>
                
                <button type="button" class="btn btnverde1"  id ="asistencia_presente_todos" value = "1" style="color:#fff;" >Presente <i class="fa fa-check"></i></button>

            <?php

        }

        if($asistencia_botton == 1){

            ?>
                <button type="button" class="btn btnrojo1"  id ="asistencia_presente_todos" value = "0" style="color:#fff;" >Ausente <i class="fa fa-times"></i></button>
            <?php

        }

    ?>

    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="table-responsive-lg">
            <table class="table table-sm">
                <thead>
                    <tr>
                    <th class="cabeceratablamorada" scope="col">#</th>
                    <th class="cabeceratablamorada" scope="col">Rut</th>
                    <th class="cabeceratablamorada" scope="col">Nombre</th>
                    <th class="cabeceratablamorada" scope="col">Apellido Paterno</th>
                    <th class="cabeceratablamorada" scope="col">Apellido Materno</th>
                    <th class="cabeceratablamorada" scope="col">Asistencia</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                    
                        $i = 1 ;

                        foreach ($Alumnos as $key => $Alumno) {
                            
                            ?>

                                <tr>
                                    <th scope="row"><?php echo $i;?></th>
                                    <td><?php echo $Alumno['rut'];?></td>
                                    <td><?php echo $Alumno['nombre'];?></td>
                                    <td><?php echo $Alumno['apellido_paterno'];?></td>
                                    <td><?php echo $Alumno['apellido_materno'];?></td>
                                    <td id="resultado_ajax_botton">


                                        <?= $this->render('_asistencia_botton', [
                                            'asistencia' => $Alumno['asistencia'],
                                            'usuario_id' => $Alumno['usuario_id'],
                                            'asignatura_curso_id' => $model["id"],
                                            'fecha' => $fecha,

                                        ]) ?>
                                        



                                        

                                        <!-- <button type="button" class="btn btn-success btnpresente"  id ="<?php echo 'asistencia_presente'.$i ?>" value = "1" style="color:#fff;" >Presente <i class="fa fa-check"></i></button>
                                        <button type="button" class="btn btn-danger btnpresente"   id ="<?php echo 'asistencia_ausente'.$i ?>" value = "2" style="color:#fff; display: none;" >Ausente <i class="fa fa-times"></i></button>
                                        <button type="button" class="btn btn-warning btnpresente"  id ="<?php echo 'asistencia_atrasado'.$i ?>" value = "3" style="color:#fff; display: none;" >Atraso <i class="fa fa-clock-o"></i></button>
                                        -->

                                    </td>



                                </tr>

                            <?php 
                        }

                    ?>

                </tbody>
            </table>
        </div>
    </div>

</div>
<?php 

          

    $this->registerJs("

        $('#asistencia_presente_todos').click(function(e){
            e.preventDefault();

            var boton = $(this);
            

            var resultado_ajax = boton.parent().parent().parent();



            $.ajax({
                url: 'actualizar-todos',
                type: 'get',
                data: {'id':" . $model["id"] . ",'fecha':'"  . $fecha . "','asistencia':"  . $asistencia_botton . "},
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