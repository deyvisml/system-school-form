<nav class="navbar justify-content-between">
  <p class="navbar-brand">Configurar Preguntas</p>

  <div>
    <button type="button" class="btn btn-outline-secondary">Aspectos <i class="ti-settings"></i></button>
  </div>
</nav>

<div class="accordion gap-2 col-12 col-md-9 m-auto " id="accordion-panels">

  <?php $first_loop = true; ?>
  <?php foreach ($aspects as $aspect) : ?>
    <div class="accordion-item border border-2" id="aspect-<?php echo $aspect->id; ?>">
      <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-linked-aspect-<?php echo $aspect->id; ?>"  aria-controls="accordion-linked-aspect1">
        <?php echo $aspect->name; ?>
        </button>
      </h2>
      <div id="accordion-linked-aspect-<?php echo $aspect->id; ?>" class="accordion-collapse collapse <?php echo $first_loop ? 'show' : ''; ?>">
        <div class="accordion-body" style="background-color: #f0eaf9;">
          <ul class="items list-unstyled d-flex flex-column gap-3 draggable-items-container">
            <?php foreach ($aspect->items as $item) : ?>
              <li class="position-relative border border-1 rounded shadow-sm" style="background-color: white; border-color: #ccc !important;" data-aspect-id="<?php echo $aspect->id; ?>" data-item-id="<?php echo $item->id; ?>" id="item-<?php echo $item->id; ?>">
                <div class="drag-button-container p-2 w-100" style="cursor: move;">
                  <i class="ti-move fs-5 d-block text-center"></i>
                </div>

                <div class="question-body p-3 pt-0">
                  <div class="question-first-part d-flex gap-2">
                    <input class="question form-control p-1 px-2" value="<?php echo $item->question; ?>" type="text" placeholder="Pregunta" data-item-id="<?php echo $item->id; ?>" onChange="change_item_value(this)">

                    <select class="form-select" data-item-id="<?php echo $item->id; ?>" onChange="change_item_type(this)">
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
                              <li class="d-flex justify-content-center align-items-center gap-2" data-item-id="<?php echo $item->id; ?>" data-alternative-id="<?php echo $alternative->id; ?>" id="alternative-<?php echo $alternative->id; ?>">
                                <i class="ti-move fs-6 p-1" style="cursor:pointer;"></i>
                                <?php echo ($item->item_type_id == 3) ? '<i class="ti-control-record fs-3"></i>' : '<i class="ti-control-stop fs-3"></i>'; ?>
                                <input class="alternative form-control form-control-sm" type="text" value="<?php echo $alternative->alternative ?>" data-alternative-id="<?php echo $alternative->id; ?>" onChange="change_alternative_value(this)">
                                <i class="ti-close fs-5" style="cursor:pointer;" data-alternative-id="<?php echo $alternative->id; ?>" data-item-id="<?php echo $item->id; ?>" onClick="delete_alternative(this)"></i>
                              </li>
                            <?php endforeach; ?>
                          </ul>

                          <div class="d-flex justify-content-start align-items-center gap-2">
                            <i class="ti-move fs-6 p-1" style="visibility:hidden;"></i>
                            <?php echo ($item->item_type_id == 3) ? '<i class="ti-control-record fs-3"></i>' : '<i class="ti-control-stop fs-3"></i>'; ?>
                            <span class="p-1 px-2 rounded" style="cursor:pointer; background-color: #eee;" data-item-id="<?php echo $item->id; ?>" onClick="add_alternative(this)">Añadir opción</span>
                          </div>
                        </div>
                        <?php break; ?>
                    <?php endswitch; ?>
                  </div>

                  <div class="question-third-part border-top d-flex justify-content-end align-items-center gap-3 pt-2">
                    <i class="ti-layers fs-4 p-2 cursor-pointer rounded-circle" style="cursor: pointer; background-color: #eee; visibility:hidden;" title="Duplicar"></i>
                    <i class="ti-trash fs-4 p-2 cursor-pointer rounded-circle" style="cursor: pointer; background-color: #eee;" data-item-id="<?php echo $item->id; ?>" onClick="delete_item(this)" title="Eliminar"></i>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" data-item-id="<?php echo $item->id; ?>" <?php echo $item->mandatory ? 'checked' : ''; ?> onChange="change_mandatory_item(this)" id="switch-mandatory-item-<?php echo $item->id; ?>">
                      <label class="form-check-label" for="switch-mandatory-item-<?php echo $item->id; ?>">Obligatorio</label>
                    </div>
                  </div>
                </div>
                
                <i class="position-absolute border ti-plus fs-4 p-2 cursor-pointer rounded-circle d-inline-block mx-auto" style="cursor: pointer; background-color: #eee; bottom: -25px; left:50%; transform: translateX(-50%); border-color: #ccc !important; z-index:100;" data-item-id="<?php echo $item->id; ?>" data-aspect-id="<?php echo $aspect->id ?>" onClick="add_item(this)" title="Añadir pregunta"></i>
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
  
    draggable_items_containers.forEach((draggable_items_container) => {
      var sortable = new Sortable(draggable_items_container, {
          animation: 150, // Duración de la animación en milisegundos
          direction: "vertical",
          handle: ".drag-button-container",
          onSort: function (/**Event*/evt) {
            var aspect_id = evt.item.dataset.aspectId;
            change_items_order(aspect_id);
          },
      });
    });
  }
  init_make_dragabble_items_containers();

  function init_make_dragabble_alternatives_containers()
  {
    var draggable_alternatives_containers = document.querySelectorAll(".draggable-alternatives-container");
  
    draggable_alternatives_containers.forEach((draggable_alternatives_container) => {
      var sortable = new Sortable(draggable_alternatives_container, {
          animation: 150, // Duración de la animación en milisegundos
          direction: "vertical",
          handle: ".ti-move",
          onSort: function (/**Event*/evt) {
            var item_id = evt.item.dataset.itemId;
            change_alternatives_order(item_id);
          },
      });
    });
  }
  init_make_dragabble_alternatives_containers();
</script>

<script>
  async function change_item_type(element)
  {
    var item_id = element.dataset.itemId;
    var item_type = element.value;

    var question_second_part_element = document.querySelector(`#item-${item_id} .question-second-part`)

    switch (item_type) {
      case "text-answer":
        var item_type_id = 1;
        var result = api_call_update_item_type_id_item(item_id, item_type_id);
        if(result.error_occurred) throw new Error(result.message);

        var alternatives_body_html = `<div class="col-12 alternatives col-md-8">
                                        <input class="form-control form-control-sm" type="text" placeholder="Respuesta textual" readonly>
                                      </div>`;
        break;
      case "number-answer":
        var item_type_id = 2;
        var result = api_call_update_item_type_id_item(item_id, item_type_id);
        if(result.error_occurred) throw new Error(result.message);

        var alternatives_body_html = `<div class="col-12 alternatives col-md-8">
                                        <input class="form-control form-control-sm" type="number" placeholder="Respuesta numérica" readonly>
                                      </div>`;
        break;
      case "simple-select-answer":
        var item_type_id = 3;
        var result = await api_call_update_item_type_id_item(item_id, item_type_id);
        if(result.error_occurred) throw new Error(result.message);

        var result = await api_call_create_alternative("Opción 1", order=1, item_id);
        if(result.error_occurred) throw new Error(result.message);

        var alternative_id = result.alternative_id;

        var alternatives_body_html = `<div class="col-12 col-md-10 d-flex flex-column gap-2">
                                        <ul class="alternatives draggable-alternatives-container d-flex flex-column gap-2 list-unstyled" data-item-type="simple-select-answer">
                                          <li class="d-flex justify-content-center align-items-center gap-2" id="alternative-${alternative_id}">
                                            <i class="ti-move fs-6 p-1" style="cursor:pointer;"></i>
                                            <i class="ti-control-record fs-3"></i>
                                            <input class="alternative form-control form-control-sm" type="text" value="Opción 1" data-alternative-id="${alternative_id}" onChange="change_alternative_value(this)">
                                            <i class="ti-close fs-5" style="cursor:pointer;" data-alternative-id="${alternative_id}" onClick="delete_alternative(this)"></i>
                                          </li>
                                        </ul>

                                        <div class="d-flex justify-content-start align-items-center gap-2">
                                          <i class="ti-move fs-6 p-1" style="visibility:hidden;"></i>
                                          <i class="ti-control-record fs-3"></i>
                                          <span class="p-1 px-2 rounded" style="cursor:pointer; background-color: #eee;" data-item-id="${item_id}" onClick="add_alternative(this)">Añadir opción</span>
                                        </div>
                                      </div>`;
        break;
      case "multiple-select-answer":
        var item_type_id = 4;
        var result = await api_call_update_item_type_id_item(item_id, item_type_id);
        if(result.error_occurred) throw new Error(result.message);

        var result = await api_call_create_alternative("Opción 1", order=1, item_id);
        if(result.error_occurred) throw new Error(result.message);

        var alternative_id = result.alternative_id;

        var alternatives_body_html = `<div class="col-12 col-md-10 d-flex flex-column gap-2">
                                        <ul class="alternatives draggable-alternatives-container d-flex flex-column gap-2 list-unstyled" data-item-type="multiple-select-answer">
                                          <li class="d-flex justify-content-center align-items-center gap-2" id="alternative-${alternative_id}">
                                            <i class="ti-move fs-6 p-1" style="cursor:pointer;"></i>
                                            <i class="ti-control-stop fs-3"></i>
                                            <input class="alternative form-control form-control-sm" type="text" value="Opción 1" data-alternative-id="${alternative_id}" onChange="change_alternative_value(this)">
                                            <i class="ti-close fs-5" style="cursor:pointer;" data-alternative-id="${alternative_id}" onClick="delete_alternative(this)"></i>
                                          </li>
                                        </ul>

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
      var draggable_container_e = document.querySelector(`#item-${item_id} .draggable-alternatives-container`);
  
      var sortable = new Sortable(draggable_container_e, {
          animation: 150, // Duración de la animación en milisegundos
          direction: "vertical",
          handle: ".ti-move",
          onSort: function (/**Event*/evt) {
            var item_id = evt.item.dataset.itemId;
            change_alternatives_order(item_id);
          },
      });
    }
  }
</script>

<script>
  async function delete_alternative(element)
  {
    var alternative_id = element.dataset.alternativeId;
    var alternative_element = document.querySelector(`#alternative-${alternative_id}`);

    var result = await api_call_delete_alternative(alternative_id);
    if(result.error_occurred) throw new Error(result.message);

    // removing alternative
    alternative_element.remove();
  }

  async function add_alternative(element)
  {
    var item_id = element.dataset.itemId;
    var alternative_container = document.querySelector(`#item-${item_id} ul.alternatives`);
    var item_type = alternative_container.dataset.itemType;

    var num_alternatives = alternative_container.querySelectorAll('li').length;
    var order = num_alternatives + 1;
    var alternative = "Opción " + order;

    var result = await api_call_create_alternative(alternative, order, item_id);
    if(result.error_occurred) throw new Error(result.message);

    var alternative_id = result.alternative_id;

    var alternative_html = `<li class="d-flex justify-content-center align-items-center gap-2" data-item-id="${item_id}" data-alternative-id="${alternative_id}" id="alternative-${alternative_id}">
                              <i class="ti-move fs-6 p-1" style="cursor:pointer;"></i>`
    if(item_type == "simple-select-answer")
    {
      alternative_html += `<i class="ti-control-record fs-3"></i>`;
    }
    else
    {
      alternative_html += `<i class="ti-control-stop fs-3"></i>`;
    }
    alternative_html += `<input class="alternative form-control form-control-sm" type="text" value="${alternative}" data-alternative-id="${alternative_id}" onChange="change_alternative_value(this)">
                        <i class="ti-close fs-5" style="cursor:pointer;" data-alternative-id="${alternative_id}" onClick="delete_alternative(this)"></i>
                      </li>`;

    alternative_container.insertAdjacentHTML("beforeend", alternative_html)
  }

  async function change_alternative_value(element)
  {
    var alternative_id = element.dataset.alternativeId;
    var alternative_value = element.value;

    var result = await api_call_update_alternative_value_alternative(alternative_value, alternative_id);

    if(result.error_occurred) throw new Error(result.message);
  }

  async function change_alternatives_order(item_id)
  {
    var alternatives = document.querySelectorAll(`#item-${item_id} ul.alternatives > li`);

    var alternatives_ids = [];
    alternatives.forEach(alternative => {
        var alternative_id = Number(alternative.dataset.alternativeId);
        alternatives_ids.push(alternative_id);
    });

    var result = await api_call_update_alternatives_order_alternative(alternatives_ids);

    if(result.error_occurred) throw new Error(result.message);
  }
</script>

<script>
  function delete_item(element)
  {
    var item_id = element.dataset.itemId;
    var item_element = document.querySelector(`#item-${item_id}`);

    var result = api_call_delete_item(item_id);

    if(result.error_occurred) throw new Error(result.message);

    // removing alternative
    item_element.remove();
  }

  function change_mandatory_item(element)
  {
    var item_id = element.dataset.itemId;
    var mandatory = element.checked ? 1 : 0;

    var result = api_call_update_mandatory_item(item_id, mandatory);

    if(result.error_occurred) throw new Error(result.message);
  }

  async function change_item_value(element)
  {
    var item_id = element.dataset.itemId;
    var item_value = element.value;

    var result = await api_call_update_item_value_item(item_value, item_id);

    if(result.error_occurred) throw new Error(result.message);
  }

  async function add_item(element)
  {
    var item_id = element.dataset.itemId;
    var aspect_id = element.dataset.aspectId;
    var item_element = document.querySelector(`#item-${item_id}`);

    var result = await api_call_create_item(aspect_id);

    if(result.error_occurred) throw new Error(result.message);
    
    var new_item_id = result["item_id"];
    
    var new_item_html = `<li class="position-relative border border-1  rounded shadow-sm" style="background-color: white; border-color: #ccc !important;" data-aspect-id="${aspect_id}" data-item-id="${new_item_id}" id="item-${new_item_id}">
                          <div class="drag-button-container p-2 w-100" style="cursor: move;">
                            <i class="ti-move fs-5 d-block text-center"></i>
                          </div>

                          <div class="question-body p-3 pt-0">
                            <div class="question-first-part d-flex gap-2">
                              <input class="question form-control p-1 px-2" type="text" placeholder="Pregunta" data-item-id="${new_item_id}" onChange="change_item_value(this)">

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
                                <input class="form-check-input" type="checkbox" data-item-id="${new_item_id}" checked onChange="change_mandatory_item(this)" id="switch-mandatory-${new_item_id}">
                                <label class="form-check-label" for="switch-mandatory-${new_item_id}">Obligatorio</label>
                              </div>
                            </div>
                          </div>
                          
                          <i class="position-absolute border ti-plus fs-4 p-2 cursor-pointer rounded-circle d-inline-block mx-auto" style="cursor: pointer; background-color: #eee; bottom: -25px; left:50%; transform: translateX(-50%); border-color: #ccc !important; z-index:100;" data-item-id="${new_item_id}" data-aspect-id="${aspect_id}" onClick="add_item(this)" title="Añadir pregunta"></i>
                        </li>`;
    
    item_element.insertAdjacentHTML("afterend", new_item_html);
  }

  async function change_items_order(aspect_id)
  {
    var items = document.querySelectorAll(`#aspect-${aspect_id} ul.items > li`);

    var items_ids = [];
    items.forEach(item => {
        var item_id = Number(item.dataset.itemId);
        items_ids.push(item_id);
    });

    var result = await api_call_update_items_order_item(items_ids);

    if(result.error_occurred) throw new Error(result.message);
  }
</script>

<!-- ============================================================= -->
<!-- ========================= API CALLS ========================= -->
<!-- ============================================================= -->

<script>
  async function api_call_create_item(aspect_id)
  {
    openCargar();
    var result;

    await $.post("<?php echo base_url("/items/create") ?>", {"aspect_id": aspect_id}, async function(data){
        result = await JSON.parse(data);
        closeCargar();
    });

    return result;
  }

  async function api_call_delete_item(item_id)
  {
    openCargar();
    var result;

    await $.post("<?php echo base_url("/items/delete") ?>", {"item_id": item_id}, async function(data){
      result = await JSON.parse(data);
        closeCargar();
    });

    return result;
  }

  async function api_call_update_mandatory_item(item_id, mandatory)
  {
    openCargar();
    var result;

    await $.post("<?php echo base_url("/items/update-mandatory") ?>", {"item_id": item_id, "mandatory": mandatory}, async function(data){
      result = await JSON.parse(data);
      closeCargar();
    });

    return result;
  }

  async function api_call_update_item_type_id_item(item_id, item_type_id)
  {
    openCargar();
    var result;

    await $.post("<?php echo base_url("/items/update-item-type-id") ?>", {"item_id": item_id, "item_type_id": item_type_id}, async function(data){
      result = await JSON.parse(data);
      closeCargar();
    });

    return result;
  }

  async function api_call_update_item_value_item(item_value, item_id)
  {
    //openCargar();
    var result;

    await $.post("<?php echo base_url("/items/update-item-value") ?>", {"item_value": item_value, "item_id": item_id,}, async function(data){
      result = await JSON.parse(data);
      closeCargar();
    });

    return result;
  }

  async function api_call_update_items_order_item(items_ids)
  {
    openCargar();
    var result;

    await $.post("<?php echo base_url("/items/update-items-order") ?>", {"items_ids": items_ids,}, async function(data){
      result = await JSON.parse(data);
      closeCargar();
    });

    return result;
  }
</script>

<script>
  async function api_call_create_alternative(alternative="", order, item_id)
  {
    openCargar();
    var result;

    await $.post("<?php echo base_url("/alternatives/create") ?>", {"alternative": alternative, "order": order, "item_id": item_id,}, async function(data){
      result = await JSON.parse(data);
      closeCargar();
    });

    return result;
  }

  async function api_call_delete_alternative(alternative_id)
  {
    openCargar();
    var result;

    await $.post("<?php echo base_url("/alternatives/delete") ?>", {"alternative_id": alternative_id,}, async function(data){
      result = await JSON.parse(data);
      closeCargar();
    });

    return result;
  }

  async function api_call_update_alternative_value_alternative(alternative_value, alternative_id)
  {
    //openCargar();
    var result;

    await $.post("<?php echo base_url("/alternatives/update-alternative-value") ?>", {"alternative_value": alternative_value, "alternative_id": alternative_id,}, async function(data){
      result = await JSON.parse(data);
      closeCargar();
    });

    return result;
  }

  async function api_call_update_alternatives_order_alternative(alternatives_ids)
  {
    openCargar();
    var result;

    await $.post("<?php echo base_url("/alternatives/update-alternatives-order") ?>", {"alternatives_ids": alternatives_ids,}, async function(data){
      result = await JSON.parse(data);
      closeCargar();
    });

    return result;
  }
</script>