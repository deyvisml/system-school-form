<!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->


<nav class="navbar justify-content-between">
  <p class="navbar-brand">Configurar Aspectos</p>

  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateNewAspect">
  Crear aspecto
</button>

<!-- Modal -->
<div class="modal fade" id="modalCreateNewAspect" tabindex="-1" aria-labelledby="modalCreateNewAspectLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form id="form-create-new-aspect">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCreateNewAspectLabel">Nuevo aspecto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="aspect_name" class="form-label">Nombre del aspecto</label>
            <input type="text" class="form-control" name="aspect_name" id="aspect_name">
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
  <?php foreach ($aspects as $aspect) : ?>
    <li class="aspect list-group-item border border-2 border-primary-subtle" data-id="<?php echo $aspect->id; ?>">
        <div class="d-flex justify-content-between align-items-center">
          <span class="d-flex align-items-center">
              <i class="ti-menu-alt fs-5 "></i>
              <div class="ms-2"><?php echo $aspect->name; ?></div>
          </span>
          <i class="ti-trash fs-5" style="cursor: pointer;" onClick="delete_aspect(<?php echo $aspect->id; ?>)"></i>
        </div>
    </li>
  <?php endforeach; ?>
</ul>

<div class="d-flex justify-content-center mt-3">
  <button type="button" class="btn btn-secondary d-flex gap-2 align-items-center" id="btn-continue-config-aspects"><span>Continuar</span><i class="ti-arrow-right"></i></button>
</div>

<script>
  var btn_continue = document.querySelector("#btn-continue-config-aspects");

  btn_continue.addEventListener("click", () => {
    var aspect_ids = Array.from(document.querySelectorAll('li.aspect'), elemento => Number(elemento.dataset.id));
    console.log(aspect_ids);

    openCargar();
    $.post("<?php echo base_url("/aspects/update-order") ?>", {"aspect_ids": aspect_ids}, function(data){
        data=JSON.parse(data);

        if(!data.error_occurred)
        {
          console.log( "xdxd" );
        }
        closeCargar();
        
        show_toast(data.message, data.error_occurred);
    });

  });
</script>

<script>
  function delete_aspect(aspect_id)
  {
    openCargar();
    $.post("<?php echo base_url("/aspects/delete") ?>", {"aspect_id": aspect_id}, function(data){
        data=JSON.parse(data);

        if(!data.error_occurred)
        {
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
  function show_toast(message, error_occurred)
  {
    var background_color = "#5cb85c";
    if(error_occurred)
    {
      background_color = "#d9534f";
    }

    Toastify({
      text: message,
      style: {
        background: background_color,
      },
      duration: 5000,
      close: true,
      gravity: "top", // `top` or `bottom`
      position: "right", // `left`, `center` or `right`
      stopOnFocus: true, // Prevents dismissing of toast on hover
      onClick: function(){} // Callback after click
    }).showToast();
  }
</script>

<script>
    $('#form-create-new-aspect').submit(function(e){
        e.preventDefault();
        openCargar();
        $.post("<?php echo base_url("/formularios/create-aspect") ?>", $(this).serialize(), function(data){
            data=JSON.parse(data);

            if(!data.error_occurred)
            {
              $('#modalCreateNewAspect').modal('hide');
              
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
    var aspects_list_element = document.querySelector("#aspects-list");
    var sortable = new Sortable(aspects_list_element, {
        animation: 150, // Duración de la animación en milisegundos
    });
</script>


