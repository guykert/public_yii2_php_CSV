<li class="nav-title">
      Menú Administrador
</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Generales</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Configuración', 'icon' => 'user', 'url' => ['/configuracion']],
                  ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Pruebas</a>
            
      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Pruebas', 'icon' => 'user', 'url' => ['/prueba']],
                  ['label' => 'Pruebas Categoría', 'icon' => 'user', 'url' => ['/prueba-categoria']],
                  ['label' => 'Pruebas Ejes Temáticos', 'icon' => 'user', 'url' => ['/prueba-eje-tematico']],
                  ['label' => 'Pruebas Sub Ejes Temáticos', 'icon' => 'user', 'url' => ['/prueba-sub-eje-tematico']],
                  ['label' => 'Pruebas Habilidades', 'icon' => 'user', 'url' => ['/prueba-habilidad']],
                  ['label' => 'Pruebas Alumno', 'icon' => 'user', 'url' => ['/prueba-alumno']],
                  ['label' => 'Pruebas Sincronizar', 'icon' => 'user', 'url' => ['/prueba-sincronizar']],
                  ['label' => 'Pruebas Formula', 'icon' => 'user', 'url' => ['/prueba-formula-nota']],
                  ['label' => 'Pruebas Clonar', 'icon' => 'user', 'url' => ['/prueba-clonar']],
                  ['label' => 'Tipo de Pruebas', 'icon' => 'user', 'url' => ['/tipo-prueba']],
                  ['label' => 'Pruebas Tabla Conversión', 'icon' => 'user', 'url' => ['/prueba-tabla-conversion']],
                  

            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Roles</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Roles', 'icon' => 'user', 'url' => ['/rol']],
                  ['label' => 'Tipo de Rol', 'icon' => 'user', 'url' => ['/rol-tipo']],
            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Horarios</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Horario Colegios', 'icon' => 'user', 'url' => ['/malla-horaria-colegio']],
                  ['label' => 'Malla Horaria Clonar', 'icon' => 'user', 'url' => ['/malla-horaria-clonar']],
                  ['label' => 'Bloque', 'icon' => 'user', 'url' => ['/bloque']],
            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Perfiles</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [

                  ['label' => 'Usuarios', 'icon' => 'user', 'url' => ['/usuario']],
                  ['label' => 'Alumno', 'icon' => 'user', 'url' => ['/alumno']],
                  ['label' => 'Profesor', 'icon' => 'user', 'url' => ['/profesor']],


            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Mantenedores</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Empresa', 'icon' => 'user', 'url' => ['/empresa']],
                  ['label' => 'Tipo de Empresa', 'icon' => 'user', 'url' => ['/empresa-tipo']],
                  ['label' => 'Tipo de Alumno', 'icon' => 'user', 'url' => ['/tipo-alumno']],
                  ['label' => 'Dia', 'icon' => 'user', 'url' => ['/dia']],
                  ['label' => 'Ramo', 'icon' => 'user', 'url' => ['/ramo']],
                  ['label' => 'Asignaturas Curriculares', 'icon' => 'user', 'url' => ['/sub-ramo']],
                  ['label' => 'Curso', 'icon' => 'user', 'url' => ['/curso']],
                  ['label' => 'Sexo', 'icon' => 'user', 'url' => ['/sexo']],
                  ['label' => 'Nivel', 'icon' => 'user', 'url' => ['/nivel']],
                  ['label' => 'Letra', 'icon' => 'user', 'url' => ['/letra']],

            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Procesos</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Subir Archivos Drive', 'icon' => 'user', 'url' => ['/google-drive']],
                  ['label' => 'Claves QA', 'icon' => 'user', 'url' => ['/procesos/claves-qa']],
                  ['label' => 'Limpiar año predeterminado', 'icon' => 'user', 'url' => ['/procesos-logeado/limpiar-anio-predeterminado']],


            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Localización</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Región', 'icon' => 'user', 'url' => ['/region']],
                  ['label' => 'Ciudad', 'icon' => 'user', 'url' => ['/ciudad']],
                  ['label' => 'Comúna', 'icon' => 'user', 'url' => ['/comuna']],
                  ['label' => 'Provincia', 'icon' => 'user', 'url' => ['/provincia']],
            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Templates</a>

      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Template', 'icon' => 'user', 'url' => ['/template']],
                  ['label' => 'Template Region General', 'icon' => 'user', 'url' => ['/template-region-general']],
                  ['label' => 'Template Region', 'icon' => 'user', 'url' => ['/template-region']],
                  ['label' => 'Template Sub Region', 'icon' => 'user', 'url' => ['/template-sub-region']],
                  ['label' => 'Template Forluma', 'icon' => 'user', 'url' => ['/template-formula']],
            ],
            'linkTemplate' => '<a href="{url}"  class="nav-link"><i class="fa fa-angle-right"></i>{label}</a>',

      ]
      ) ?>

</li>

<li class="nav-item nav-dropdown">
      <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Páginas</a>
            
      <?= dmstr\widgets\Menu::widget(
            [
            'options' => ['class' => 'nav-dropdown-items', 'data-widget'=> 'tree'],
            'items' => [
                  ['label' => 'Página Alumno', 'icon' => 'user', 'url' => ['/pagina-alumno']],
                  ['label' => 'Página Alumno Area', 'icon' => 'user', 'url' => ['/pagina-alumno-area']],


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