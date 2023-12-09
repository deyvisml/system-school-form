
<nav class="navbar justify-content-between">
  <p class="navbar-brand">Mis Formularios</p>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateForm">
    Crear formulario
  </button>

  <!-- Modal -->
  <div class="modal fade" id="modalCreateForm" tabindex="-1" aria-labelledby="modalCreateFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <form id="form-create-form">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCreateFormLabel">Nuevo formulario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="mb-3">
              <label for="form_name" class="form-label">Nombre</label>
              <input type="text" class="form-control p-2" name="form_name">
            </div>

            <div class="mb-3">
              <label for="form_description" class="form-label">Descripción</label>
              <input type="text" class="form-control p-2" name="form_description">
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
          <div class="d-flex justify-content-between align-items-start gap-1">
            <h5 class="card-title d-block " style="min-height: 40px;"><?php echo strlen($form->name) <= 70 ? $form->name : (substr($form->name, 0, 70) . "..."); ?></h5>
            
            <div class="btn-group">
              <i class="ti-angle-down p-2 rounded-circle" style="background-color: #eee; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false"></i>
           
              <ul class="dropdown-menu dropdown-menu-end">
                <li><button class="dropdown-item" type="button" onClick='load_edit_form(<?php echo $form->id; ?>)'>Editar</button></li>
                <li><button class="dropdown-item" type="button" onClick='delete_form(<?php echo $form->id; ?>)'>Eliminar</button></li>
              </ul>
            </div>
          </div>

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

<!-- Modal -->
<div class="modal fade" id="modalEditForm" tabindex="-1" aria-labelledby="modalEditFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form id="form-edit-form" >
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditFormLabel">Editar formulario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="form_name" class="form-label">Nombre</label>
            <input type="text" class="form-control p-2" name="form_name">
          </div>

          <div class="mb-3">
            <label for="form_description" class="form-label">Descripción</label>
            <input type="text" class="form-control p-2" name="form_description">
          </div>

          <div class="mb-3">
            <input type="text" class="form-control p-2" name="form_id" hidden>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Editar</button>
        </div>
      </form>
    
    </div>
  </div>
</div>



<script>
    $('#form-create-form').submit(function(e){
        e.preventDefault();
        openCargar();
        $.post("<?php echo base_url("/formularios/create-form") ?>", $(this).serialize(), function(data){
            data=JSON.parse(data);

            if(!data.error_occurred)
            {
              $('#modalCreateForm').modal('hide');
              
              $.post("<?php echo base_url("/formularios") ?>", {}, function(data){
                $("#bodyApp").html(data);
              });
            }
            closeCargar();
            
            show_toast(data.message, data.error_occurred);
        });
    });
</script>

<script>
  function load_edit_form(form_id)
  {
    $.post("<?php echo base_url("/forms/get-data-by-id") ?>", {"form_id": form_id}, function(data){
        data = JSON.parse(data);

        if (!data.error_occurred) 
        {
          var input_name_element = document.querySelector('#form-edit-form input[name="form_name"]');
          var input_description_element = document.querySelector('#form-edit-form input[name="form_description"]');
          var input_id_element = document.querySelector('#form-edit-form input[name="form_id"]');

          input_name_element.value = data.form.name;
          input_description_element.value = data.form.description;
          input_id_element.value = data.form.id;

          $('#modalEditForm').modal('show');
        }
        else
        {
          show_toast(data.message, data.error_occurred);
        }
    });
  }

  $('#form-edit-form').submit(function(e){
        e.preventDefault();
        openCargar();

        $.post("<?php echo base_url('/forms/update') ?>", $(this).serialize(), function(data){
            data = JSON.parse(data);

            if(!data.error_occurred)
            {
              $('#modalEditForm').modal('hide');
              
              $.post("<?php echo base_url("/formularios") ?>", {}, function(data){
                $("#bodyApp").html(data);
              });
            }
            closeCargar();
            
            show_toast(data.message, data.error_occurred);
        });
    });
</script>


<script>
  function delete_form(form_id)
  {
    Swal.fire({
      title: "¿Estas seguro?",
      text: "¡No sera posible revertir esta acción!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, eliminarlo!",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {

        $.post("<?php echo base_url("/forms/delete") ?>", {"form_id": form_id}, function(data){
          data=JSON.parse(data);

          if(!data.error_occurred)
          {
            Swal.fire({
              title: "Eliminado!",
              text: "El aspecto ha sido eliminado.",
              icon: "success"
            });

            $.post("<?php echo base_url("/formularios") ?>", {}, function(data){
              $("#bodyApp").html(data);
            });
          }
      });
      }
    });
  }
</script>