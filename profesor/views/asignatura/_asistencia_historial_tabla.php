<table class="table">
    <thead>
        <tr>
            <th colspan="20" class="cabeceratablamorada text-center"><i class="fa fa-calendar" aria-hidden="true"></i> <?= $nombre_mes?></th>
        </tr>
    </thead>



    <thead>
        <tr>
            <th  rowspan="3" class="cabeceratablamorada text-center">Rut</th>
            <th  rowspan="3" class="cabeceratablamorada text-center">Nombre</th>
        </tr>
        
        <tr>
            <?php

                if(count($Alumnos > 0)){
                    foreach ($Alumnos[0]['asistencia'] as $key => $asistencia) {

                        echo "<td class=\"cabeceratablamorada text-center\"> " . $asistencia['fecha'] . " </td>";
                        
                    }
                }
            ?>
        </tr>
    </thead>
    <tbody >

        <?php

            foreach ($Alumnos as $key => $Alumno) {

                ?>

                    <tr>
                    <td  class="text-center tipotablacontenido"><?php echo $Alumno['rut'];?></td>
                    <td><?php echo $Alumno['nombre'] . " " . $Alumno['apellido_paterno'] . " " . $Alumno['apellido_materno'];?></td>
                    <?php

                        foreach ($Alumno['asistencia'] as $key => $asistencia) {

                            if($asistencia['estado_asistencia_id'] == 1){
                                echo "<td class=\"cajadiames text-center\"><i class=\"fa fa-circle\" style=\"color:green;\" aria-hidden=\"true\"></i></td>";
                            }

                            if($asistencia['estado_asistencia_id'] == 0){
                                echo "<td class=\"cajadiames text-center\"><i class=\"fa fa-times\" style=\"color:red;\" aria-hidden=\"true\"></i></td>";
                            }
                           
                            if($asistencia['estado_asistencia_id'] == 2){
                                echo "<td class=\"cajadiames text-center\"><i class=\"fa fa-clock-o\" style=\"color:#E9C302;\" aria-hidden=\"true\"></i></td>";
                            }

                        }

                    ?>

                    </tr>
                    
                <?php
                
            }
        ?>

    </tbody>

</table>