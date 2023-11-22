<nav class="navbar justify-content-between">
  <p class="navbar-brand">Configurar Preguntas</p>

  <div>
    <button type="button" class="btn btn-outline-secondary">Aspectos <i class="ti-settings"></i></button>
  </div>
</nav>

<div class="accordion gap-2 col-12 col-md-9 m-auto " id="accordion-panels">

  <?php $first_loop = true; ?>
  <?php foreach ($aspects as $aspect) : ?>
    <div class="accordion-item border border-2" id="a<?php echo $aspect->id; ?>">
      <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-linked-<?php echo $aspect->id; ?>"  aria-controls="accordion-linked-aspect1">
        <?php echo $aspect->name; ?>
        </button>
      </h2>
      <div id="accordion-linked-<?php echo $aspect->id; ?>" class="accordion-collapse collapse <?php echo $first_loop ? 'show' : ''; ?>">
        <div class="accordion-body" style="background-color: #f0eaf9;">
          <ul class="list-unstyled d-flex flex-column gap-3 draggable-items-container">
            <?php foreach ($aspect->items as $item) : ?>
              <li class="position-relative border border-1  rounded shadow-sm" style="background-color: white; border-color: #ccc !important;" id="a<?php echo $aspect->id . "_" . $item->id; ?>">
                <div class="drag-button-container p-2 w-100" style="cursor: move;">
                  <i class="ti-move fs-5 d-block text-center"></i>
                </div>

                <div class="question-body p-3 pt-0">
                  <div class="question-first-part d-flex gap-2">
                    <input class="question form-control p-1 px-2" value="<?php echo $item->question; ?>" type="text" placeholder="Pregunta">

                    <select class="form-select" data-item-id="a<?php echo $aspect->id . "_" . $item->id; ?>" onChange="change_item_type(this)">
                      <option <?php echo ($item->item_type_id == 1) ? 'selected' : ''; ?> value="text-answer">Respuesta textual</option>
                      <option <?php echo ($item->item_type_id == 2) ? 'selected' : ''; ?> value="number-answer">Respuesta numérica</option>
                      <option <?php echo ($item->item_type_id == 3) ? 'selected' : ''; ?> value="simple-select-answer">Selección simple</option>
                      <option <?php echo ($item->item_type_id == 4) ? 'selected' : ''; ?> value="multiple-select-answer">Selección multiple</option>
                    </select>
                  </div>

                  <div class="question-second-part py-3 alternatives-container">
                    <?php switch ($item->item_type_id) : 
                            case 1: ?>
                        <div class="col-12 alternatives col-md-8">
                          <input class="form-control form-control-sm" type="text" placeholder="Respuesta textual" readonly>
                        </div>
                        <?php break; ?>
                      <?php case 2: ?>
                        <div class="col-12 alternatives col-md-8">
                          <input class="form-control form-control-sm" type="number" placeholder="Respuesta numérica" readonly>
                        </div>
                        <?php break; ?>
                      <?php case 3: ?>
                        
                      <?php case 4: ?>
                        <div class="col-12 col-md-10 d-flex flex-column gap-2">
                          <ul class="alternatives draggable-alternatives-container d-flex flex-column gap-2 list-unstyled" data-item-type="<?php echo ($item->item_type_id == 3) ? 'simple-select-answer' : 'multiple-select-answer'; ?>">
                            <?php foreach ($item->alternatives as $alternative) : ?>
                              <li class="d-flex justify-content-center align-items-center gap-2" id="a<?php echo $aspect->id . "_" . $item->id . "_" . $alternative->id; ?>">
                                <i class="ti-move fs-6 p-1" style="cursor:pointer;"></i>
                                <?php echo ($item->item_type_id == 3) ? '<i class="ti-control-record fs-3"></i>' : '<i class="ti-control-stop fs-3"></i>'; ?>
                                <input class="alternative form-control form-control-sm" type="text" value="<?php echo $alternative->alternative ?>" data-alternative-id="a<?php echo $aspect->id . "_" . $item->id . "_" . $alternative->id; ?>">
                                <i class="ti-close fs-5" style="cursor:pointer;" data-alternative-id="a<?php echo $aspect->id . "_" . $item->id . "_" . $alternative->id; ?>" onClick="delete_alternative(this)"></i>
                              </li>
                            <?php endforeach; ?>
                          </ul>

                          <div class="d-flex justify-content-start align-items-center gap-2">
                            <i class="ti-move fs-6 p-1" style="visibility:hidden;"></i>
                            <?php echo ($item->item_type_id == 3) ? '<i class="ti-control-record fs-3"></i>' : '<i class="ti-control-stop fs-3"></i>'; ?>
                            <span class="p-1 px-2 rounded" style="cursor:pointer; background-color: #eee;" data-item-id="a<?php echo $aspect->id . "_" . $item->id; ?>" onClick="add_alternative(this)">Añadir opción</span>
                          </div>
                        </div>
                        <?php break; ?>
                    <?php endswitch; ?>
                  </div>

                  <div class="question-third-part border-top d-flex justify-content-end align-items-center gap-3 pt-2">
                    <i class="ti-layers fs-4 p-2 cursor-pointer rounded-circle" style="cursor: pointer; background-color: #eee; visibility:hidden;" title="Duplicar"></i>
                    <i class="ti-trash fs-4 p-2 cursor-pointer rounded-circle" style="cursor: pointer; background-color: #eee;" data-item-id="a<?php echo $aspect->id . "_" . $item->id; ?>" onClick="delete_item(this)" title="Eliminar"></i>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" data-item-id="a<?php echo $aspect->id . "_" . $item->id; ?>" <?php echo $item->mandatory ? 'checked' : ''; ?> onChange="change_state_mandatory_item(this)" id="switch-mandatory-<?php echo $aspect->id . "_" . $item->id; ?>">
                      <label class="form-check-label" for="switch-mandatory-<?php echo $aspect->id . "_" . $item->id; ?>">Obligatorio</label>
                    </div>
                  </div>
                </div>
                
                <i class="position-absolute border ti-plus fs-4 p-2 cursor-pointer rounded-circle d-inline-block mx-auto" style="cursor: pointer; background-color: #eee; bottom: -25px; left:50%; transform: translateX(-50%); border-color: #ccc !important; z-index:100;" data-item-id="a<?php echo $aspect->id . "_" . $item->id; ?>" onClick="add_item(this)" title="Añadir pregunta"></i>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>

    <?php $first_loop = false; ?>
  <?php endforeach; ?>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js"
        integrity="sha512-UNM1njAgOFUa74Z0bADwAq8gbTcqZC8Ej4xPSzpnh0l6KMevwvkBvbldF9uR++qKeJ+MOZHRjV1HZjoRvjDfNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  function init_make_dragabble_items_containers()
  {
    var draggable_items_containers = document.querySelectorAll(".draggable-items-container");
    console.log( "AAA",draggable_items_containers );
  
    draggable_items_containers.forEach((draggable_items_container) => {
      var sortable = new Sortable(draggable_items_container, {
          animation: 150, // Duración de la animación en milisegundos
          direction: "vertical",
          handle: ".drag-button-container",
      });
    });
  }
  init_make_dragabble_items_containers();

  function init_make_dragabble_alternatives_containers()
  {
    var draggable_alternatives_containers = document.querySelectorAll(".draggable-alternatives-container");
    console.log( "AAA",draggable_alternatives_containers );
  
    draggable_alternatives_containers.forEach((draggable_alternatives_container) => {
      var sortable = new Sortable(draggable_alternatives_container, {
          animation: 150, // Duración de la animación en milisegundos
          direction: "vertical",
          handle: ".ti-move",
      });
    });
  }
  init_make_dragabble_alternatives_containers();
</script>

<script>
  function change_item_type(element)
  {
    var item_id = element.dataset.itemId;
    var item_type = element.value;

    var question_second_part_element = document.querySelector(`#${item_id} .question-second-part`)

    switch (item_type) {
      case "text-answer":
        var alternatives_body_html = `<div class="col-12 alternatives col-md-8">
                                        <input class="form-control form-control-sm" type="text" placeholder="Respuesta textual" readonly>
                                      </div>`;
        break;
      case "number-answer":
        var alternatives_body_html = `<div class="col-12 alternatives col-md-8">
                                        <input class="form-control form-control-sm" type="number" placeholder="Respuesta numérica" readonly>
                                      </div>`;
        break;
      case "simple-select-answer":
        var unique_identifier = uuid.v4(); // always start with a letter ("a"), so it's a valid identifier
        var alternative_id = item_id + "_" + unique_identifier;

        var alternatives_body_html = `<div class="col-12 col-md-10 d-flex flex-column gap-2">
                                        <div class="alternatives draggable-alternatives-container d-flex flex-column gap-2" data-item-type="simple-select-answer">
                                          <div class="d-flex justify-content-center align-items-center gap-2" id="${alternative_id}">
                                            <i class="ti-move fs-6 p-1" style="cursor:pointer;"></i>
                                            <i class="ti-control-record fs-3"></i>
                                            <input class="alternative form-control form-control-sm" type="text" value="Opción" data-alternative-id="${alternative_id}">
                                            <i class="ti-close fs-5" style="cursor:pointer;" data-alternative-id="${alternative_id}" onClick="delete_alternative(this)"></i>
                                          </div>
                                        </div>

                                        <div class="d-flex justify-content-start align-items-center gap-2">
                                          <i class="ti-move fs-6 p-1" style="visibility:hidden;"></i>
                                          <i class="ti-control-record fs-3"></i>
                                          <span class="p-1 px-2 rounded" style="cursor:pointer; background-color: #eee;" data-item-id="${item_id}" onClick="add_alternative(this)">Añadir opción</span>
                                        </div>
                                      </div>`;
        break;
      case "multiple-select-answer":
        var unique_identifier = "a" + uuid.v4(); // always start with a letter ("a"), so it's a valid identifier
        var alternative_id = item_id + "_" + unique_identifier;

        var alternatives_body_html = `<div class="col-12 col-md-10 d-flex flex-column gap-2">
                                        <div class="alternatives draggable-alternatives-container d-flex flex-column gap-2" data-item-type="multiple-select-answer">
                                          <div class="d-flex justify-content-center align-items-center gap-2" id="${alternative_id}">
                                            <i class="ti-move fs-6 p-1" style="cursor:pointer;"></i>
                                            <i class="ti-control-stop fs-3"></i>
                                            <input class="alternative form-control form-control-sm" type="text" value="Opción" data-alternative-id="${alternative_id}">
                                            <i class="ti-close fs-5" style="cursor:pointer;" data-alternative-id="${alternative_id}" onClick="delete_alternative(this)"></i>
                                          </div>
                                        </div>

                                        <div class="d-flex justify-content-start align-items-center gap-2">
                                        <i class="ti-move fs-6 p-1" style="visibility:hidden;"></i>
                                          <i class="ti-control-stop fs-3"></i>
                                          <span class="p-1 px-2 rounded" style="cursor:pointer; background-color: #eee;" data-item-id="${item_id}" onClick="add_alternative(this)">Añadir opción</span>
                                        </div>
                                      </div>`;
        break;
      default:
        break;
    }

    question_second_part_element.innerHTML = alternatives_body_html;

    if(item_type == "simple-select-answer" || item_type == "multiple-select-answer")
    {
      var draggable_container_e = document.querySelector(`#${item_id} .draggable-alternatives-container`);
  
      var sortable = new Sortable(draggable_container_e, {
          animation: 150, // Duración de la animación en milisegundos
          direction: "vertical",
          handle: ".ti-move"
      });
    }
  }
</script>

<script>
  function delete_alternative(element)
  {
    var alternative_id = element.dataset.alternativeId;
    var item_id = alternative_id.replace(/_[^_]*$/, '');

    var alternative_element = document.querySelector(`#${alternative_id}`);

    // removing alternative
    alternative_element.remove();
  }

  function add_alternative(element)
  {
    var item_id = element.dataset.itemId;

    var alternative_container = document.querySelector(`#${item_id} .alternatives`);

    var item_type = alternative_container.dataset.itemType;

    var unique_identifier = uuid.v4();

    var alternative_id = item_id + "_" + unique_identifier;

    var alternative_html = `<div class="d-flex justify-content-center align-items-center gap-2" id="${alternative_id}">
                              <i class="ti-move fs-6 p-1" style="cursor:pointer;"></i>`
    if(item_type == "simple-select-answer")
    {
      alternative_html += `<i class="ti-control-record fs-3"></i>`;
    }
    else
    {
      alternative_html += `<i class="ti-control-stop fs-3"></i>`;
    }
    alternative_html += `<input class="alternative form-control form-control-sm" type="text" value="Opción" data-alternative-id="${alternative_id}">
                        <i class="ti-close fs-5" style="cursor:pointer;" data-alternative-id="${alternative_id}" onClick="delete_alternative(this)"></i>
                      </div>`;

    alternative_container.insertAdjacentHTML("beforeend", alternative_html)
  }
</script>

<script>
  function delete_item(element)
  {
    var item_id = element.dataset.itemId;
    var item_element = document.querySelector(`#${item_id}`);
    // ! WORKING HERE
    console.log( "gaa", item_id );
    //var item_deleted = api_delete_item(item_id);

    // removing alternative
    //item_element.remove();
  }

  function change_state_mandatory_item(element)
  {
    var item_id = element.dataset.itemId;
    var mandatory = element.checked;
    console.log( mandatory );

  }

  function add_item(element)
  {
    var item_id = element.dataset.itemId;
    var item_element = document.querySelector(`#${item_id}`);
    var aspect_id = item_id.split("_")[0];

    var unique_identifier = uuid.v4();
    var new_item_id = aspect_id + "_" + unique_identifier;

    var new_item_html = `<li class="position-relative border border-1  rounded shadow-sm" style="background-color: white; border-color: #ccc !important;" id="${new_item_id}" data-aspect-id="${aspect_id}">
                          <div class="drag-button-container p-2 w-100" style="cursor: move;">
                            <i class="ti-move fs-5 d-block text-center"></i>
                          </div>

                          <div class="question-body p-3 pt-0">
                            <div class="question-first-part d-flex gap-2">
                              <input class="question form-control p-1 px-2" type="text" placeholder="Pregunta">

                              <select class="form-select" data-item-id="${new_item_id}" onChange="change_item_type(this)">
                                <option value="text-answer">Respuesta textual</option>
                                <option value="number-answer">Respuesta numérica</option>
                                <option value="simple-select-answer">Selección simple</option>
                                <option value="multiple-select-answer">Selección multiple</option>
                              </select>
                            </div>

                            <div class="question-second-part py-3 alternatives-container">
                              <div class="col-12 alternatives col-md-8">
                                <input class="form-control form-control-sm" type="text" placeholder="Respuesta textual" readonly>
                              </div>
                            </div>

                            <div class="question-third-part border-top d-flex justify-content-end align-items-center gap-3 pt-2">
                              <i class="ti-layers fs-4 p-2 cursor-pointer rounded-circle" style="cursor: pointer; background-color: #eee; visibility:hidden;" title="Duplicar"></i>
                              <i class="ti-trash fs-4 p-2 cursor-pointer rounded-circle" style="cursor: pointer; background-color: #eee;" data-item-id="${new_item_id}" onClick="delete_item(this)" title="Eliminar"></i>
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" data-item-id="${new_item_id}" checked onChange="change_state_mandatory_item(this)" id="switch-mandatory-${new_item_id}">
                                <label class="form-check-label" for="switch-mandatory-${new_item_id}">Obligatorio</label>
                              </div>
                            </div>
                          </div>
                          
                          <i class="position-absolute border ti-plus fs-4 p-2 cursor-pointer rounded-circle d-inline-block mx-auto" style="cursor: pointer; background-color: #eee; bottom: -25px; left:50%; transform: translateX(-50%); border-color: #ccc !important; z-index:100;" data-item-id="${new_item_id}" onClick="add_item(this)" title="Añadir pregunta"></i>
                        </li>`;
    
    item_element.insertAdjacentHTML("afterend", new_item_html);
  }
</script>

<!-- ============================================================= -->
<!-- ========================= API CALLS ========================= -->
<!-- ============================================================= -->

<script>
  function api_delete_item(item_id)
  {
    openCargar();
    $.post("<?php echo base_url("/items/delete") ?>", {"item_id": item_id}, function(data){
        data=JSON.parse(data);
        closeCargar();

        return !data.error_occurred;
    });
  }
</script>