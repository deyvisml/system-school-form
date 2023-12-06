
<nav class="navbar justify-content-between">
  <p class="navbar-brand">Mis Formularios</p>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateNewForm">
    Crear formulario
  </button>

  <!-- Modal -->
  <div class="modal fade" id="modalCreateNewForm" tabindex="-1" aria-labelledby="modalCreateNewFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <form id="form-create-new-form">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCreateNewFormLabel">Nuevo formulario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="mb-3">
              <label for="form_name" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="form_name">
            </div>

            <div class="mb-3">
              <label for="form_description" class="form-label">Descripción</label>
              <input type="text" class="form-control" name="form_description">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Crear</button>
          </div>
        </form>
      
      </div>
    </div>
  </div>
</nav>

<ul class="d-flex gap-3 flex-wrap list-unstyled" id="forms-list">
  <?php foreach ($forms as $form) : ?>
    <li class="card border-2 shadow col-12 col-md-4">
        <div class="card-body d-flex flex-column justify-content-between p-3">
          <h5 class="card-title d-block " style="min-height: 40px;"><?php echo strlen($form->name) <= 70 ? $form->name : (substr($form->name, 0, 70) . "..."); ?></h5>
   
          <div class="">
            <div class="btn-group w-100 mb-2" role="group">
                <button type="button" class="btn btn-secondary"
                onClick='cargarFuncion("<?php echo "/formularios/".$form->id."/config-aspects"; ?>", "Formularios", "Editar formulario", "rol descripton")'>
                <i class="ti-pencil"></i> Editar</button>
                <button type="button" class="btn btn-secondary"
                onClick='cargarFuncion("<?php echo "/formularios/".$form->id."/show"; ?>", "Formularios", "Editar formulario", "rol descripton")'>
                <i class="ti-eye"></i> Ver</button>
                <button type="button" class="btn btn-secondary"
                onClick='cargarFuncion("<?php echo "/formularios/".$form->id."/users"; ?>", "Formularios", "Editar formulario", "rol descripton")'>
                <i class="ti-user"></i> IIEE</button>
            </div>

            <p class="card-text text-end"><span class="fw-semibold  ">Creado:</span> <?php echo $form->created_at ?></p>
          </div>
        </div>
    </li>
  <?php endforeach; ?>
</ul>

<script>
    $('#form-create-new-form').submit(function(e){
        e.preventDefault();
        openCargar();
        $.post("<?php echo base_url("/formularios/create-form") ?>", $(this).serialize(), function(data){
            data=JSON.parse(data);

            if(!data.error_occurred)
            {
              $('#modalCreateNewForm').modal('hide');
              
              $.post("<?php echo base_url("/formularios") ?>", {}, function(data){
                $("#bodyApp").html(data);
              });
            }
            closeCargar();
            
            show_toast(data.message, data.error_occurred);
        });
    });
</script>