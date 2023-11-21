<nav class="navbar justify-content-between">
  <p class="navbar-brand">Configurar Preguntas</p>

  <div>
    <button type="button" class="btn btn-outline-secondary">Aspectos <i class="ti-settings"></i></button>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateNewAspect">
    Crear pregunta
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalCreateNewAspect" tabindex="-1" aria-labelledby="modalCreateNewAspectLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

              <form id="form-create-new-aspect">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalCreateNewAspectLabel">Nueva pregunta</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <div class="mb-3">
                    <label for="aspect_name" class="form-label">Aspecto</label>
                    <select class="form-select" aria-label="Default select example" name="aspects">
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label for="aspect_name" class="form-label">Tipo de pregunta</label>
                    <select class="form-select" aria-label="Default select example" name="types-question">
                      <option value="politomicas">One</option>
                      <option value="eleccion-multiple">Two</option>
                      <option value="3">Three</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label for="aspect_name" class="form-label">Pregunta</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                  </div>

                  <div class="mb-3">
                    <label for="aspect_name" class="form-label">Nota</label>
                    <input type="text" class="form-control" name="aspect_name" id="aspect_name">
                  </div>

                  <div class="mb-3">
                    <div class="d-flex justify-content-between">
                      <label for="aspect_name" class="form-label">Alternativas</label>
                      <button type="button" class="btn btn-light btn-sm" id="add-alternative-btn"><i class="ti-plus"></i> alternativa</button>
                    </div>
                    <ul class="list-unstyled mt-2" id="alternatives-container">
                      <li class="d-flex align-items-center gap-1 mb-1">
                        <input class="form-check-input" type="radio" name="default">
                        <input type="text" class="form-control" name="alternative_name" placeholder="alternativa">
                        <button type="button" class="btn btn-danger btn-sm" id="add-alternative-btn"><i class="ti-trash fs-5 py-1"></i></button>
                      </li>
                      
                      <li class="d-flex align-items-center gap-2 mb-1">
                        <input class="form-check-input" type="radio" name="default">
                        <input type="text" class="form-control" name="alternative_name" placeholder="alternativa">
                      </li>
                    </ul>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="free-answer" id="free-answer">
                      <label class="form-check-label" for="free-answer">
                        Habilitar respuesta libre
                      </label>
                    </div>
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
  </div>

</nav>

<div class="accordion gap-2 col-12 col-md-9 m-auto " id="accordionPanelsStayOpenExample">

  <div class="accordion-item border border-2">
    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
        Aspecto #1
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
      <div class="accordion-body" style="background-color: #f0eaf9;">
        <ul class="list-unstyled d-flex flex-column gap-3">
          
          <li class="position-relative border border-1  rounded shadow-sm" style="background-color: white; border-color: #ccc !important;" id="item-1" data-aspect-id="aspect-1">
            <div class="drag-button-container p-2 w-100" style="cursor: move;">
              <i class="ti-move fs-5 d-block text-center"></i>
            </div>

            <div class="question-body p-3 pt-0">
              <div class="question-first-part d-flex gap-2">
                <input class="question form-control p-1 px-2" type="text" placeholder="Pregunta">

                <select class="form-select" data-item-id="item-1" onChange="change_item_type(this)">
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
                <i class="ti-trash fs-4 p-2 cursor-pointer rounded-circle" style="cursor: pointer; background-color: #eee;" data-item-id="item-1" onClick="delete_item(this)" title="Eliminar"></i>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" data-item-id="item-1" onChange="change_state_mandatory_item(this)" id="switch-mandatory-item-1">
                  <label class="form-check-label" for="switch-mandatory-item-1">Obligatorio</label>
                </div>
              </div>
            </div>
            
            <i class="position-absolute border ti-plus fs-4 p-2 cursor-pointer rounded-circle d-inline-block mx-auto" style="cursor: pointer; background-color: #eee; bottom: -25px; left:50%; transform: translateX(-50%); border-color: #ccc !important;" data-item-id="item-1" onClick="add_item(this)" title="Añadir pregunta"></i>
          </li>

          <li class="border rounded p-2 shadow " style="background-color: white;">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum neque cum cumque adipisci assumenda, laboriosam architecto exercitationem eaque quas numquam!
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="accordion-item border-2">
    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
        Aspecto #2
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
      <div class="accordion-body">
        <ul class="list-unstyled">
          <li>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum neque cum cumque adipisci assumenda, laboriosam architecto exercitationem eaque quas numquam!
          </li>
        </ul>
      </div>
    </div>
  </div>

</div>

<div class="d-flex justify-content-center mt-3">
    <button type="button" class="btn btn-secondary d-flex gap-2 align-items-center" id="btn-continue-config-aspects"><span>Guardar orden</span><i class="ti-save"></i></button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js"
        integrity="sha512-UNM1njAgOFUa74Z0bADwAq8gbTcqZC8Ej4xPSzpnh0l6KMevwvkBvbldF9uR++qKeJ+MOZHRjV1HZjoRvjDfNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  function change_item_type(element){
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
        var unique_identifier = "a" + uuid.v4(); // always start with a letter ("a"), so it's a valid identifier
        var alternative_id = item_id + "_" + unique_identifier;

        var alternatives_body_html = `<div class="col-12 col-md-10 d-flex flex-column gap-2">
                                        <div class="alternatives draggable-container d-flex flex-column gap-2" data-item-type="simple-select-answer">
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
        var alternatives_body_html = `<div class="col-12 col-md-10 d-flex flex-column gap-2">
                                        <div class="alternatives draggable-container d-flex flex-column gap-2" data-item-type="multiple-select-answer">
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
      var draggable_container_e = document.querySelector(`#${item_id} .draggable-container`);
  
      var sortable = new Sortable(draggable_container_e, {
          animation: 150, // Duración de la animación en milisegundos
          direction: "vertical",
          handle: ".ti-move"
      });
    }
  }
</script>

<script>
  function delete_alternative(element){
    var alternative_id = element.dataset.alternativeId;
    var item_id = alternative_id.split("_")[0];

    var alternative_element = document.querySelector(`#${alternative_id}`);

    // removing alternative
    alternative_element.remove();
  }

  function add_alternative(element){
    var item_id = element.dataset.itemId;

    var alternative_container = document.querySelector(`#${item_id} .alternatives`);

    var item_type = alternative_container.dataset.itemType;

    var unique_identifier = "a" + uuid.v4(); // always start with a letter ("a"), so it's a valid identifier

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
  function delete_item(element){
    var item_id = element.dataset.itemId;

    var item_element = document.querySelector(`#${item_id}`);

    // removing alternative
    item_element.remove();
  }

  function change_state_mandatory_item(element)
  {
    var item_id = element.dataset.itemId;
    var mandatory = element.checked;
    console.log( item_id );
    console.log( mandatory );

  }

  function add_item(element)
  {

  }
</script>