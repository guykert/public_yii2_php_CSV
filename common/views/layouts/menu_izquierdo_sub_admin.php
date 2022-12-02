<li class="nav-title">
      Menú Sub Administrador
</li>


<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Mantenedores</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Alumno', 'icon' => 'user', 'url' => ['/alumno']],
                  ['label' => 'Empresa', 'icon' => 'user', 'url' => ['/empresa']],
                  ['label' => 'Usuarios', 'icon' => 'user', 'url' => ['/usuario']],
                  ['label' => 'Profesor', 'icon' => 'user', 'url' => ['/profesor']],
                  ['label' => 'Asignaturas Curriculares', 'icon' => 'user', 'url' => ['/sub-ramo']],
                  ['label' => 'Curso', 'icon' => 'user', 'url' => ['/curso']],
                  ['label' => 'Pruebas', 'icon' => 'user', 'url' => ['/prueba']],
                  ['label' => 'Pruebas Clonar', 'icon' => 'user', 'url' => ['/prueba-clonar']],
                  ['label' => 'Pruebas Tabla Conversión', 'icon' => 'user', 'url' => ['/prueba-tabla-conversion']],
                  ['label' => 'Pruebas Alumno', 'icon' => 'user', 'url' => ['/prueba-alumno']],
                  ['label' => 'Ejes Tematicos', 'icon' => 'user', 'url' => ['/prueba-eje-tematico']],
                  ['label' => 'Pruebas Sub Ejes Temáticos', 'icon' => 'user', 'url' => ['/prueba-sub-eje-tematico']],
                  ['label' => 'Habilidades', 'icon' => 'user', 'url' => ['/prueba-habilidad']],
                  
                  
            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Informes</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Estadisticas por Pregunta', 'icon' => 'user', 'url' => ['/informe-estadisticas-x-pregunta']],

            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-title">
      Procesos Desglosados
</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Iniciar Colegio</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => '1 - Seleccionar Colegio', 'icon' => 'user', 'url' => ['/procesos-paso-paso/colegios-seleccion-colegio']],
                  ['label' => '2 - Asignaturas Curriculares', 'icon' => 'file-code-o', 'url' => ['/procesos-paso-paso/colegios-seleccion-asignatura']],
                  ['label' => '3 - Carga de alumnos', 'icon' => 'file-code-o', 'url' => ['/procesos-paso-paso/carga-alumnos']],
                  ['label' => '4 - Crear Horario Cursos', 'icon' => 'file-code-o', 'url' => ['/procesos-paso-paso/crear-horario-curso-grid']],
                  ['label' => '5 - Cargar profesores', 'icon' => 'file-code-o', 'url' => ['/profesor']],
                  ['label' => '6 - Asignar carga horaria Profesor', 'icon' => 'file-code-o', 'url' => ['/profesor']],
            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>




