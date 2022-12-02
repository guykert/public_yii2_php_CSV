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


