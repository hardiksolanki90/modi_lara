$(document).ready(function () {
  $(document).on('click', '#_library .pagination > li > a', function (e) {
    e.preventDefault();
    console.log();
    $.get($(this).attr('href') + '&media=' + $('#object-type-selector').val(), '', '', 'html').always(function (data) {
      $('#_library').html(data);
    });
  });
  $(document).on('change', '#object-type-selector', function() {
    $.post(ADMIN_URL + '/media/get/list', {media: $(this).val(), _token: CSRF}, '', 'html').always(function (data) {
      $('#_library').html(data);
    });
  });
  $(document).on('submit', '#embeded-form', function (e) {
    e.preventDefault();
    const form = $(this);
    form.find('button[type="submit"]').addClass('loadingi');
    $.post(form.attr('action'), $(this).serialize(), '', 'json').always(function (data) {
      if (data.status == 'success') {
        $.get(ADMIN_URL + '/media/get/list', '', '', 'html').always(function (data) {
          $('#_library').html(data);
          $('#_library-tab').trigger('click');
        });
      }
      form.find('button[type="submit"]').removeClass('loadingi');
    });
  });
  // $(document).on('click', '.inner-div', function () {
  //   $(this).find('.select-library-img').trigger('click');
  // });
  $(document).on('click', '.select-library-img', function () {
    $('.select-media-wrapper.active .current-activated-media-wrapper').remove();
    id_img = $(this).attr('id_media');
    multiple = $('.select-media.current-activated-media').attr('multiple');
    if (id_img) {
      if (multiple) {
        if ($(this).parent().hasClass('selected')) {
          $(this).parent().removeAttr('order');
          $(this).parent().removeClass('selected');
        } else {
          total_selected = $('.inner-div.selected').length;
          $(this).parent().attr('order', total_selected + 1);
          $(this).parent().addClass('selected');
        }
        $('.media-action-bar').show();
      } else {
        $('.inner-div').removeClass('selected');
        $(this).parent().addClass('selected');
        $(this).parent().attr('order', 1);
        $('.media-action-bar').show();
      }
    }
    if ($('.inner-div.selected').length) {
      $('#_media_upload .modal-footer').css('display', 'flex');
    } else {
      $('#_media_upload .modal-footer').hide();
    }
  });
  // onLibraryShown();
  // function onLibraryShown() {
  //   $(document).on('shown.bs.modal', '#_media_upload', function() {
  //     $.get(ADMIN_URL + '/media/get/list', '', '', 'html').always(function (data) {
  //       $('#_library').html(data);
  //     })
  //   });
  // }

  $(document).on('click', '.select-media', function() {
    $('.select-media').removeClass('current-activated-media');
    $(this).addClass('current-activated-media');
    $(this).parent().find('.preview-wrapper').remove();
    var id_this = $(this).attr('id');
    if (!$(this).parent().find('#' + id_this)) {
      if ($(this).attr('multiple')) {
        $(this).parent().append('<input type="hidden" id="' + id_this + '" name="' + id_this + '[]">');
      } else {
        $(this).parent().append('<input type="hidden" id="' + id_this + '" name="' + id_this + '">');
      }
    }
    old_html = $(this);
    old_class = old_html.parent()[0].className;
    html = $(this)[0].outerHTML;
    if (old_class == 'select-media-wrapper') {
      $(this).parent().addClass('active');
    }
    if (old_class != 'select-media-wrapper' && old_class != 'select-media-wrapper active') {
      new_html = '<div class="select-media-wrapper active">' + html + '</div>';
      $(this).replaceWith(new_html);
    }
    id = $(this).attr('id');
    multiple = $(this).attr('multiple');
    chosen_object = $(this).attr('object_type');
    if (chosen_object) {
      $("#object-type-selector option[value='" + chosen_object + "']").prop('selected', true);
      $('#object-type-selector').trigger('change');
    }
    $('#_media_upload').modal('show');
    $('#media-library-input').val(id);
    if (multiple) {
      $('#media-library-input').attr('multiple', 1);
    }
    $('#media-type-input').val($(this).attr('media_type'));
  });

  $(document).on('click', '#insert-selected-image', function() {
    current_elem = $('.current-activated-media');
    current_elem.parent().find('input#' + current_elem.attr('id')).remove();
    ot = current_elem.attr('object_type');
    object_type = $('#object-type-selector').val();
    if (ot && ot != object_type) {
      swal('Sorry! We are expecting <strong>' + ot + '</strong> file');
      return true;
    }
    console.log(current_elem);
    // element = $('#media-library-input').val();
    var element = current_elem.attr('id');
    multiple = $('.select-media.current-activated-media').attr('multiple');
    output = $('.select-media.current-activated-media').attr('output');
    $('.select-media-wrapper.active .preview-wrapper').remove();
    $('.current-activated-media-wrapper').removeClass('current-activated-media-wrapper');
    $('<div id="' + element + '_wrapper" class="preview-wrapper current-activated-media-wrapper"></div>').insertAfter('.current-activated-media');
    my_inputs = new Array();
    $('._media_libarary_wrapper .inner-div.selected').each(function(i, obj) {
      my_inputs[$(this).attr('order')] = $(this);
    });
    console.log(my_inputs);
    for (i = 1; i < my_inputs.length; i++) {
      el = my_inputs[i];
      if (object_type == 'image') {
        img = el.find('img');
      }

      if (object_type == 'application') {
        img = el.find('a');
      }

      if (object_type == 'video') {
        img = el.find('.video-selector');
      }

      img_html = '<div class="selected-img-preview">' + el.html() + '</div>';
      $('.current-activated-media-wrapper').append(img_html);
      console.log(element);
      input_element = $('.select-media-wrapper.active').find('input#' + element);
      // value = input_element.val();
      var value = img.attr('id_media');
      console.log(value);
      if (multiple) {
        html = '<input type="hidden" id="' + element + '" name="' + element + '[]" value="' + value + '">';
      } else {
        html = '<input type="hidden" id="' + element + '" name="' + element + '" value="' + value + '">';
      }
      $('.current-activated-media-wrapper').append(html);

    }
    $('#_media_upload').modal('hide');
    $('.select-media-wrapper').removeClass('active');
  });

  // $('#_media_upload').modal('show');
});
