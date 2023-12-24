
<nav class="navbar justify-content-between">
  <p class="navbar-brand">Asignar instituciones</p>
</nav>

<div>
  <div class="mb-3">
    <label for="">Seleccione el Nivel</label>
    <div class="row">
      <div class="col-12 col-md-4">
        <select class="form-select border-2" onChange="handle_change_nivel(this)">
          <?php foreach ($niveles as $i => $nivel) : ?>
            <option value="<?php echo $nivel->nive_ide ?>" <?php echo $i == 0 ? "selected" : ""; ?>><?php echo $nivel->nive_nombre ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <p class="mt-2 mb-0 "><span class="fw-semibold ">Nº Instituciones seleccionadas:</span> <span id="num_checked_institutions"><?php echo count($instituciones_ids_checked) ?></span></p>

    <div class="mt-2 d-flex align-items-center gap-1">
      <input type="checkbox" name="check_institutions" id="check_institutions">
      <label for="check_institutions">Marcar todos los elementos actuales</label>
    </div>
  </div>

  <?php foreach ($niveles as $i => $nivel) : ?>
    <table id="instituciones-nivel-<?php echo $nivel->nive_ide ?>" data-nivel-id="<?php echo $nivel->nive_ide ?>" class="institutions-table mt-3">
      <thead>
        <tr>
            <th>Nombre</th>
            <th>Modular</th>
            <th>Provincia</th>
            <th>Distrito</th>
            <th>Gestión</th>
            <th>Asignar</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($nivel->instituciones as $j => $institucion) : ?>
          <tr>
              <td><?php echo $institucion->inst_nombre; ?></td>
              <td><?php echo $institucion->inst_modular; ?></td>
              <td><?php echo $institucion->inst_provincia; ?></td>
              <td><?php echo $institucion->inst_distrito; ?></td>
              <td><?php echo $institucion->inst_gestion; ?></td>
              <td><input onChange="handle_change_check_institution(this)" class="mt-1 asignar_checkbox" <?php echo $institucion->checked ? "checked" : ""; ?> data-institucion-id="<?php echo $institucion->inst_ide; ?>" type="checkbox" style="transform: scale(1.3);"></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
  </table>
  <?php endforeach; ?>
</div>

<div class="d-flex justify-content-center mt-3">
  <button type="button" class="btn btn-secondary d-flex gap-2 align-items-center" onClick="handle_click_btn_asign_institutions(this)" id="btn-asign-institutions"><span>Asignar</span><i class="ti-save"></i></button>
</div>

<script>
  var instituciones_ids = <?php echo json_encode($instituciones_ids_checked); ?>;

  console.log( instituciones_ids );
</script>

<script>
  function handle_click_btn_asign_institutions(element)
  {
    var form_id = <?php echo $form_id; ?>;
    var checkboxes =  document.querySelectorAll('.asignar_checkbox');
    var checked_checkboxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);

    //var instituciones_ids = checked_checkboxes.map(checkbox => checkbox.dataset.institucionId);

    if (!form_id || instituciones_ids.length == 0) {
      alert("No existen instituciones seleccionadas.")
      throw new Error("No existen instituciones seleccionadas.")
    }

    openCargar();
    $.post("<?php echo base_url("/institucion-form/create") ?>", {form_id, instituciones_ids}, function(data){
        data=JSON.parse(data);
        
        closeCargar();

        if(!data.error_occurred)
        {
          Swal.fire({
            title: "Asignación realizada!",
            text: data.message,
            icon: "success"
          });
        }
        else
        {
          Swal.fire({
            title: "Oops...!",
            text: data.message,
            icon: "error"
          });
        }
    });
  }
</script>

<script>
  function handle_change_check_institution(element)
  {
    var institucion_id = element.dataset.institucionId; 
    console.log( "xd", element.checked, institucion_id );
    if(element.checked)
    {
      instituciones_ids.push(institucion_id);
    }
    else{
      instituciones_ids = instituciones_ids.filter(item => item !== institucion_id);
    }
    console.log( instituciones_ids );

    var num_checked_checkboxes = instituciones_ids.length;

    document.querySelector("#num_checked_institutions").innerText = num_checked_checkboxes;
  }
</script>


<script>
  function init_tables_to_datatables()
  {
    var institutions_tables = document.querySelectorAll(".institutions-table");
  
    var first_loop = true;
    institutions_tables.forEach((institutions_table) => {
      var table = new DataTable(institutions_table, {
          // options
      });

      var wrapper_table = document.querySelector(`#${institutions_table.id}_wrapper`);
      if (first_loop){
        wrapper_table.classList.add("visible-wrapper-table");
      } 
      else {
        wrapper_table.style.display = 'none';
      } 

      first_loop = false;
    });
  }

  $(document).ready( () => {
    init_tables_to_datatables();
  } );
</script>

<script>
  function handle_change_nivel(element)
  {
    var nivel_id = element.value;

    // hiding current visible wrapper table
    var visible_wrapper_table = document.querySelector('.visible-wrapper-table');
    visible_wrapper_table.classList.remove("visible-wrapper-table");
    visible_wrapper_table.style.display = 'none';

    // displaying new wrapper table
    var table_to_display = document.querySelector(`#instituciones-nivel-${nivel_id}_wrapper`);
    table_to_display.classList.add("visible-wrapper-table");
    table_to_display.style.display = '';
  }
</script>