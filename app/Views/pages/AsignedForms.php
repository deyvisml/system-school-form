
<nav class="navbar justify-content-between">
  <p class="navbar-brand">Formularios Asignados</p>
</nav>

<ul class="d-flex gap-3 flex-wrap list-unstyled" id="forms-list">
  <?php foreach ($forms as $form) : ?>
    <li class="card border-2 shadow col-12 col-md-4">
        <div class="card-body d-flex flex-column justify-content-between p-3">
          <div class="d-flex justify-content-between align-items-start gap-1">
            <h5 class="card-title d-block " style="min-height: 40px;"><?php echo strlen($form->name) <= 70 ? $form->name : (substr($form->name, 0, 70) . "..."); ?></h5>
          </div>

          <div class="">
            <div class="btn-group w-100 mb-2" role="group">
              <?php if ($form->sent): ?>
                <button type="button" class="btn btn-danger" disabled >
                  <i class="ti-eye"></i> Enviado
                </button>
              <?php elseif ($form->started): ?>
                <button type="button" class="btn btn-primary"
                onClick='cargarFuncion("<?php echo "/instituciones/".$institucion_id."/formularios-asignados/".$form->id."/show"; ?>", "Formularios", "Completar formulario", "rol descripton")'>
                <i class="ti-eye"></i> En progreso</button>
              <?php else: ?>
                <button type="button" class="btn btn-secondary"
                onClick='cargarFuncion("<?php echo "/instituciones/".$institucion_id."/formularios-asignados/".$form->id."/show"; ?>", "Formularios", "Completar formulario", "rol descripton")'>
                <i class="ti-eye"></i> Iniciar</button>
              <?php endif; ?>
            </div>

            <p class="card-text text-end"><span class="fw-semibold  ">Asignado:</span> <?php echo $form->asigned_at; ?></p>
          </div>
        </div>
    </li>
  <?php endforeach; ?>
</ul>


