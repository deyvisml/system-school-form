<nav class="navbar">
  <p class="navbar-brand">Completar formulario</p>
</nav>

<div class="accordion gap-2 col-12 col-md-9 m-auto " id="accordion-panels">

  <div class="border border-2 rounded p-3 mb-3" style="border-top: 10px solid #25476A !important;">
    <div class="mb-2">
      <h3><?php echo $form->form_title; ?></h3>
    </div>

    <div class="mb-2">
      <p class="p-0 m-0"><?php echo $form->form_description; ?></p>
    </div>

    <p class="p-0 m-0 pt-2 text-danger">* Indica que la pregunta es obligatoria</p>
  </div>

  <form action="" id="form-submit-form">
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
                <li class="item position-relative border border-1 rounded shadow-sm p-3" style="background-color: white; border-color: #ccc !important;" data-aspect-id="<?php echo $aspect->id; ?>" data-item-id="<?php echo $item->id; ?>" id="item-<?php echo $item->id; ?>">
                  <div class="question-first-part mb-3">
                    <p class="fs-5 m-0"> <?php echo $item->question; ?> <?php if ($item->mandatory) : ?> <span class="text-danger">*</span> <?php endif; ?></p>
                  </div>

                  <div class="question-second-part alternatives-container">
                    <?php switch ($item->item_type_id) : 
                            case 1: ?>
                        <div class="col-12 response col-md-8">
                          <input class="form-control form-control-sm" type="text" placeholder="Respuesta textual" name="answer_question_<?php echo $item->id; ?>">
                        </div>
                        <?php break; ?>
                      <?php case 2: ?>
                        <div class="col-12 response col-md-8">
                          <input class="form-control form-control-sm" type="number" placeholder="Respuesta numérica" name="answer_question_<?php echo $item->id; ?>">
                        </div>
                        <?php break; ?>
                      <?php case 3: ?>
                        <div class="col-12 col-md-10 d-flex flex-column gap-2">
                          <ul class="alternatives d-flex flex-column gap-2 list-unstyled">
                            <?php foreach ($item->alternatives as $alternative) : ?>
                              <?php if ($alternative->free) : ?>
                                <li class="mt-0 d-flex justify-content-start align-items-center gap-1"  id="alternative-<?php echo $alternative->id; ?>">
                                  <input class="form-check-input " type="radio" name="answer_question_<?php echo $item->id ?>" id="option-<?php echo $alternative->id; ?>" value="<?php echo $alternative->id; ?>">
                                  <label class="form-check-label ms-2" for="option-<?php echo $alternative->id; ?>">Otro: </label>
                                  <div class="d-inline-block w-75 ">
                                      <input class="form-control form-control-sm" type="text" name="free_answer_question_<?php echo $item->id; ?>">
                                  </div>
                                </li>
                              <?php else: ?>
                                <li class="mt-2" id="alternative-<?php echo $alternative->id; ?>">
                                  <input class="form-check-input " type="radio" name="answer_question_<?php echo $item->id ?>" id="option-<?php echo $alternative->id; ?>" value="<?php echo $alternative->id; ?>">
                                  <label class="form-check-label ms-2" for="option-<?php echo $alternative->id; ?>"><?php echo $alternative->alternative; ?></label>
                                </li>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                        <?php break; ?>
                      <?php case 4: ?>
                        <div class="col-12 col-md-10 d-flex flex-column gap-2">
                          <ul class="alternatives d-flex flex-column gap-2 list-unstyled">
                            <?php foreach ($item->alternatives as $alternative) : ?>
                              <?php if ($alternative->free) : ?>
                                <li class="mt-0 d-flex justify-content-start align-items-center gap-1"  id="alternative-<?php echo $alternative->id; ?>">
                                  <input class="form-check-input " type="checkbox" name="answer_question_<?php echo $item->id ?>[]" id="option-<?php echo $alternative->id; ?>" value="<?php echo $alternative->id; ?>">
                                  <label class="form-check-label ms-2" for="option-<?php echo $alternative->id; ?>">Otro: </label>
                                  <div class="d-inline-block w-75 ">
                                      <input class="form-control form-control-sm" type="text" name="free_answer_question_<?php echo $item->id; ?>">
                                  </div>
                                </li>
                              <?php else: ?>
                                <li class="mt-2" id="alternative-<?php echo $alternative->id; ?>">
                                  <input class="form-check-input " type="checkbox" name="answer_question_<?php echo $item->id ?>[]" id="option-<?php echo $alternative->id; ?>" value="<?php echo $alternative->id; ?>">
                                  <label class="form-check-label ms-2" for="option-<?php echo $alternative->id; ?>"><?php echo $alternative->alternative; ?></label>
                                </li>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                        <?php break; ?>
                    <?php endswitch; ?>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>

      <?php $first_loop = true; /* true to show all collapse divs, if you want to show only the first then set this variable with "false" */ ?>
    <?php endforeach; ?>

    <div class="d-flex justify-content-center mt-3">
      <button type="submit" class="btn btn-secondary d-flex gap-2 align-items-center"><span>Enviar formulario</span><i class="ti-save"></i></button>
    </div>
  </form>
</div>


<script>
    $('#form-submit-form').submit(function(e){
        e.preventDefault();
        openCargar();

        $.post("<?php echo base_url("/instituciones/".$institucion_id."/formularios-asignados/".$form->id."/submit-form") ?>", $(this).serialize(), function(data){
            data=JSON.parse(data);

            if (!data.error_occurred) {
              $.post("<?php echo base_url("/formularios-asignados") ?>", {}, function(data){
                $("#bodyApp").html(data);
              });
            }
            show_toast(data.message, data.error_occurred);
            
            closeCargar();
        });
    });
</script>