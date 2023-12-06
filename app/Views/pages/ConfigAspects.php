
<nav class="navbar justify-content-between">
  <p class="navbar-brand">Configurar Aspectos</p>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateAspect">
    Crear aspecto
  </button>

  <!-- Modal -->
  <div class="modal fade" id="modalCreateAspect" tabindex="-1" aria-labelledby="modalCreateAspectLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <form id="form-create-aspect">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCreateAspectLabel">Nuevo aspecto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="mb-3">
              <label for="aspect_name" class="form-label">Nombre del aspecto</label>
              <input type="text" class="form-control" name="aspect_name">
            </div>

            <input type="hidden" class="d-none" name="form_id" value="<?php echo $form_id; ?>">
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

<ul class="list-group gap-1" id="aspects-list">
  <?php foreach ($aspects as $i => $aspect) : ?>
    <li class="aspect list-group-item border border-2 border-primary-subtle p-2" data-id="<?php echo $aspect->id; ?>">
        <div class="d-flex justify-content-between align-items-center">
          <span class="d-flex align-items-center">
              <div class="drag-button-container p-1" style="cursor: move;">
                <i class="ti-move fs-6 d-block text-center"></i>
              </div>
              <div class="ms-2"><?php echo $aspect->name; ?></div>
          </span>
          <div class="d-flex justify-content-between align-items-center gap-3">
            <i class="ti-trash fs-5 p-1" style="cursor: pointer;" title="Eliminar" onClick="delete_aspect(<?php echo $aspect->id; ?>)"></i>
            <i class="ti-pencil-alt fs-5 p-1" style="cursor: pointer;" title="Editar" data-bs-toggle="modal" data-bs-target="#modalEditAspect<?php echo $aspect->id; ?>"></i>

            <!-- Modal -->
            <div class="modal fade" id="modalEditAspect<?php echo $aspect->id; ?>" tabindex="-1" aria-labelledby="modalEditAspect<?php echo $aspect->id; ?>Label" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                  <form id="form-edit-aspect<?php echo $aspect->id; ?>" onsubmit="return false;">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalEditAspect<?php echo $aspect->id; ?>Label">Editar aspecto</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="aspect_name" class="form-label">Nombre del aspecto</label>
                        <input type="text" class="form-control" name="aspect_name" value="<?php echo $aspect->name; ?>" required>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary" onClick="handle_submit_edit_aspect(<?php echo $aspect->id; ?>)">Editar</button>
                    </div>
                  </form>
                
                </div>
              </div>
            </div>
          </div>
        </div>
    </li>
  <?php endforeach; ?>
</ul>



<?php if (count($aspects)) : ?>
  <div class="d-flex justify-content-center mt-3">
    <button type="button" class="btn btn-secondary d-flex gap-2 align-items-center" id="btn-continue-config-aspects"><span>Continuar</span><i class="ti-arrow-right"></i></button>
  </div>
<?php else: ?>
  <div class="d-flex justify-content-center mt-3">
    <p>Aún existen aspectos creados en este formulario.</p>
  </div>
<?php endif; ?>


<script>
  var btn_continue = document.querySelector("#btn-continue-config-aspects");

  btn_continue?.addEventListener("click", () => {
    var aspect_ids = Array.from(document.querySelectorAll('li.aspect'), elemento => Number(elemento.dataset.id));

    openCargar();
    $.post("<?php echo base_url("/aspects/update-order") ?>", {"aspect_ids": aspect_ids}, function(data){
        data=JSON.parse(data);

        if(!data.error_occurred)
        {
          $.post("<?php echo base_url("/formularios") ?>" + "/<?php echo $form_id; ?>/config-items", {}, function(data){
            console.log( "xdxd2" );
            $("#bodyApp").html(data);
          });
        }
        closeCargar();
        
        show_toast(data.message, data.error_occurred);
    });

  });
</script>

<script>
  function delete_aspect(aspect_id)
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

        $.post("<?php echo base_url("/aspects/delete") ?>", {"aspect_id": aspect_id}, function(data){
          data=JSON.parse(data);

          if(!data.error_occurred)
          {
            Swal.fire({
              title: "Eliminado!",
              text: "El aspecto ha sido eliminado.",
              icon: "success"
            });

            $.post("<?php echo base_url("/formularios") ?>" + "/<?php echo $form_id; ?>/config-aspects", {}, function(data){
              $("#bodyApp").html(data);
            });
          }
      });
      }
    });
  }
</script>

<script>
    $('#form-create-aspect').submit(function(e){
        e.preventDefault();
        openCargar();
        $.post("<?php echo base_url("/formularios/create-aspect") ?>", $(this).serialize(), function(data){
            data=JSON.parse(data);

            if(!data.error_occurred)
            {
              $('#modalCreateAspect').modal('hide');
              
              $.post("<?php echo base_url("/formularios") ?>" + "/<?php echo $form_id; ?>/config-aspects", {}, function(data){
                $("#bodyApp").html(data);
              });
            }
            closeCargar();
            
            show_toast(data.message, data.error_occurred);
        });
    });
</script>

<script>

function handle_submit_edit_aspect(aspect_id)
{
  var aspect_name = document.querySelector(`#form-edit-aspect${aspect_id} input[name="aspect_name"]`).value;

  if (aspect_name.length == 0) throw new Error("El nombre del aspecto esta vacio.");

  openCargar();
  $.post("<?php echo base_url("/aspects/update-name") ?>", {aspect_id, aspect_name,}, function(data){
      data=JSON.parse(data);

      if(!data.error_occurred)
      {
        $(`#modalEditAspect${aspect_id}`).modal('hide');
        
        $.post("<?php echo base_url("/formularios") ?>" + "/<?php echo $form_id; ?>/config-aspects", {}, function(data){
          $("#bodyApp").html(data);
        });
      }
      closeCargar();
      
      show_toast(data.message, data.error_occurred);
  });
}

    
</script>

<script>
    var aspects_list_element = document.querySelector("#aspects-list");

    var sortable = new Sortable(aspects_list_element, {
          animation: 150, // Duración de la animación en milisegundos
          direction: "vertical",
          handle: ".drag-button-container",
      });
</script>
