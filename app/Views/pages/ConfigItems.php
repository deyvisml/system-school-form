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
                    <label for="aspect_name" class="form-label">Pregunta</label>
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
  </div>

</nav>

<div class="accordion gap-2" id="accordionPanelsStayOpenExample">

  <div class="accordion-item border border-2">
    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
        Accordion Item #1
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
      <div class="accordion-body">
        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>

  <div class="accordion-item border-2">
    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
        Accordion Item #2
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
      <div class="accordion-body">
        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>

</div>

<div class="d-flex justify-content-center mt-3">
    <button type="button" class="btn btn-secondary d-flex gap-2 align-items-center" id="btn-continue-config-aspects"><span>Guardar orden</span><i class="ti-save"></i></button>
</div>