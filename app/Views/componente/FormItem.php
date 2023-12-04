<div class="card border shadow col-12 col-md-3">
  <div class="card-body pb-0 ">
    <h5 class="card-title"><?php echo $form_name ?></h5>
    <p class="card-text"><?php echo $form_description ?></p>
  </div>

  <div class="card-body">
    <div class="btn-group w-100" role="group">
        <button type="button" class="btn btn-secondary"
        onClick='cargarFuncion("<?php echo "/formularios/".$id."/config-aspects"; ?>","<?php echo $modulo; ?>","<?php echo $nombre; ?>","<?php echo $descripcion; ?>")'>
        <i class="ti-pencil"></i> Editar</button>
        <button type="button" class="btn btn-secondary"
        onClick='cargarFuncion("<?php echo "/formularios/".$id."/show"; ?>","<?php echo $modulo; ?>","<?php echo $nombre; ?>","<?php echo $descripcion; ?>")'>
        <i class="ti-eye"></i> Ver</button>
        <button type="button" class="btn btn-secondary"
        onClick='cargarFuncion("<?php echo "/formularios/".$id."/users"; ?>","<?php echo $modulo; ?>","<?php echo $nombre; ?>","<?php echo $descripcion; ?>")'>
        <i class="ti-user"></i> IIEE</button>
    </div>
  </div>
</div>