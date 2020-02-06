var AdminURL = ADMIN_URL;
$(document).on('click', '._delete', function () {
  $(this).parent().parent().remove();
});
$(document).on('click', '._add', function () {
  var tr = '<tr>' + $(this).parent().parent().find('tr').last().html() + '</tr>';

  $(this).parent().parent().find('table > tbody').append(tr);
  $(this).parent().parent().find('tr').last().find('._delete').removeClass('none');
});

$(document).on('change', '[id=change_status]', function() {
  if ($(this).is(':checked')) {
    status = 1;
  } else {
    status = 0;
  }
  component = $(this).attr('component');
  id = $(this).attr('id_component');
  column = $(this).attr('column');

  $.get(AdminURL + '/status/' + component + '/' + column + '/' + id + '/' + status, '', '', 'json').always(function(data) {
    if (data.status == 'success') {
      Swal.fire({
        position: 'top-end',
        type: 'success',
        title: data.message,
        showConfirmButton: false,
        timer: 10500
      });
    }
    if (data.status == 'error') {
      Swal.fire({
        position: 'top-end',
        type: 'error',
        title: data.message,
        showConfirmButton: false,
        timer: 10500
      });
    }
  }).fail(function(data) {});
});

$(document).on('click', '._pns', function(e){
    e.preventDefault();
    $(this).addClass('loadingi');
    id = $(this).attr('id');
    const elem = $(this);
    $.post(AdminURL + '/push/notification/' + id, {id:id, _token:CSRF}, '', 'json').always(function(data){
      if (data.status == 'success') {
        Swal.fire({
          position: 'top-end',
          type: 'success',
          title: data.message,
          showConfirmButton: false,
          timer: 10500
        });
      }
      if (data.status == 'error') {
          Swal.fire(data.message);
      }
      if (data.status == 'redirect') {
        if (data.message.msg) {
          toastr.success(data.message.msg);
        }
        window.location = data.message.url;
      }
      elem.removeClass('loadingi');
    });
});

$(document).on('click', '#_generate', function () {
  var val = new Array();
  var error = false;
  $('.option_variants').each(function () {
    if ($(this).is(':checked')) {
      val.push($(this).val());
    }
  });

  if (val.length < 2) {
    Swal.fire({
      position: 'top-end',
      type: 'error',
      title: 'Please choose at least two options to generate a variant.',
      showConfirmButton: false,
      timer: 5000
    });
    error = true
  }

  if (error) {
    return true;
  }

  data = {
    variants: val,
    desc: $('#variant_description').val(),
    label: $('#variant_label').val(),
    id_equipment: $('#id_equipment').val(),
    id_part_section: $('#part_section').val(),
    variants_identifier: $('#variants_identifier').val(),
    _token: CSRF
  };

  $.post(AdminURL + '/generate/variants', data, '', 'json').always(function (data) {
    // Swal.fire({
    //   position: 'top-end',
    //   type: 'success',
    //   title: data.message,
    //   showConfirmButton: false,
    //   timer: 5000
    // });
    $('._variants_list ._list').html(data.message);
    // $('._variants_list').load(window.location + ' ._list', function () {
    //
    // });
  });
})
$(document).on('blur', 'input#name', function () {
  var str = $(this).val();
  var small = str.toLowerCase();
  var replace_space = small.replace(' ', '_');
  var replace_with_forward_slash = small.replace(' ', '/');
  $('.component-add #table').val(replace_space);
  $('.component-add #table').parent().addClass('is-focused');
  $('.component-add #variable').val(replace_space);
  $('.component-add #variable').parent().addClass('is-focused');
  $('.component-add #slug').val(replace_with_forward_slash);
  $('.component-add #slug').parent().addClass('is-focused');
});
$(document).on('change', '[id=mediator_table]', function () {
  $(this).parent().parent().parent().find('.mediator_table_key_wrapper input').val('id_' + $(this).val());
});
$(document).on('keyup', '.field_name', function() {
  var parent_class = $(this).parent().parent().parent();

  if (parent_class.find('._ref').length == 0) {
    parent_class.find('._ref').hide();
  } else {
    parent_class.find('._ref').show();
  }

  parent_class.find('._ref').text($(this).val());
});

$('#meta_keywords, #ADMIN_EMAIL').tagsinput();

$('.tags-input').tagsinput();
$('.tags-input').each(function(index, value) {
    var tags = $(this).val();
    var splitted = tags.split(',');
    var elem = $(this);
    splitted.forEach(function(currentValue, index) {
      elem.tagsinput('add', currentValue);
    });
});

$(document).on('itemAdded', '#meta_keywords', function () {
  $('#meta_keywords').parent().addClass('is-focused');
});

$(document).on('#meta_keywords', function () {
  $('#meta_keywords').parent().addClass('is-focused');
});

$(document).on('itemAdded', '#ADMIN_EMAIL', function () {
  $('#ADMIN_EMAIL').parent().addClass('is-focused');
});

$(document).on('change', '.myForm input[type="file"]', function () {
  var string = $(this).val();
  if (string) {
    var result = string.split('\\');
    var final = result[result.length -1];
    var find_ext = final.split('.');
    var ext = find_ext[find_ext.length - 1];
  }
  //   var allowed = ['doc', 'docx', 'pdf'];
  //   if (allowed.indexOf(ext) < 0) {
  //     var final = '<div class="alert alert-danger">File type not allowed</div>';
  //   }
  // } else {
  //   var final = 'Only pdf and docx files are allowed.';
  // }
  console.log(final);
  $(this).parent().find('.custom-file-label').html(final);
});

$(document).ready(function(){
  $(document).on('blur', '.my-input', function() {
    val = $(this).val();
    if (val.length > 0) {
      $(this).parent().addClass('is-focused');
    } else {
      $(this).parent().removeClass('is-focused');
    }
  });

  $(document).on('focus', '.my-input', function() {
    $(this).parent().addClass('is-focused');
  });

  // geo();

  $('.my-input').each(function() {

    if ($(this).val().length > 0) {
      $(this).parent().addClass('is-focused');
    }

  });
});

$('.foreign-select').selectize({
  create: true,
  sortField: {
    field: 'text',
  },
  dropdownParent: 'body'
});

$('.multi').selectize({
  persist: false,
  delimiter: ',',
  create: function(input) {
    return {
        value: input,
        text: input
    }
  },
});

$('.html-editor').summernote({
  codemirror: {
    mode: 'text/html',
    htmlMode: true,
    lineNumbers: true,
    theme: 'monokai'
  },
});

$(document).on('change', '[id=relational_component_name]', function(){
    var rel_comp_id = $(this).val();
    const parent = $(this).parent().parent().parent();
    var id = $(this).val();
    $.post(AdminURL + '/component/relational',{rel_comp_id:rel_comp_id, _token:CSRF, id:id},'','json').always(function(data){
        if (data.status == 'error') {

        }

        if(data.status == 'success') {
          console.log(data.message);
          parent.find('.foreign-select').selectize()[0].selectize.destroy();
          parent.find('.selectize-control').remove();
          parent.find('#foreign-select').html(data.message);
          var relationship_type = parent.find('#relationship_type');
          if (relationship_type == 'belongsToMany') {
            parent.find('.local_key input').val('id_' + data.data.component.variable);
            parent.parent().parent().find('.field_name').val(data.data.component.variable);
          }
          parent.find('#foreign-select').selectize({
            create: true,
            sortField: {
              field: 'text',
            },
            dropdownParent: 'body'
          });
        }
    });
});

$(window).on('load', function() {
  $('[id=column_type]').trigger('change');
  $('[id=relationship_type]').trigger('change');
});



$(document).on('click', '._ac', function(e) {
  e.preventDefault();
  $('._mc').first().clone().insertBefore('.new-column');
});

$(document).on('click', '._close_field', function(e) {
  e.preventDefault();
  var parent = $(this).parent().parent();
  parent.remove();
});

column_type();
function column_type() {
  $(document).on('change', '#column_type', function(e) {
    var parent = $(this).parent().parent();
    parent.find('._input_type_wrapper').removeClass('none');
    parent.find('._input_defult').removeClass('none');
    parent.find('._replationship_type_wrapper').addClass('none');
    parent.find('._components_wrapper').addClass('none');
    parent.find('._field_name').removeClass('none');
    parent.find('.foreign-select-wrapper').addClass('none');
    parent.find('.local_key').addClass('none');
    parent.find('.middle_table_wrapper').addClass('none');
    parent.find('.mediator_table_key_wrapper').addClass('none');


    if ($(this).val() == 'relationship') {
      parent.find('._input_defult').addClass('none');
      parent.find('._replationship_type_wrapper').removeClass('none');
      parent.find('._components_wrapper').removeClass('none');
      parent.parent().find('._input_type_wrapper .input_type').html("<option value='select'>Select Dropdown</option><option value='checkbox'>Checkbox</option><option value='media_image'>Media - Image</option><option value='media_video'>Media- Video</option><option value='media_pdf'>Media - PDF</option>");
      // $(this).parent().parent().parent().find('._input_type_wrapper .input_type').addClass('hardiksolanki');
    } else {
      parent.parent().find('._input_type_wrapper .input_type').html('<option value="">Input Type</option> <option value="text" selected="selected">Text</option> <option value="textarea">Textarea</option> <option value="number">Number</option> <option value="tel">Phone</option> <option value="select">Select Dropdown</option> <option value="radio">Radio</option> <option value="checkbox">Checkbox</option> <option value="file">File</option> <option value="media_image">Media - Image</option> <option value="media_video">Media- Video</option> <option value="media_pdf">Media - PDF</option>');
    }
  });
}

relation_type();
function relation_type() {
  $(document).on('change', '#relationship_type', function(e) {
    var parent = $(this).parent().parent().parent();
    parent.find('._field_name').removeClass('none');
    parent.find('.foreign-select-wrapper').addClass('none');
    parent.find('.local_key').addClass('none');
    parent.find('.middle_table_wrapper').addClass('none');
    parent.find('.mediator_table_key_wrapper').addClass('none');

    if ($(this).val() == 'belongsToMany') {
      parent.find('.middle_table_wrapper').removeClass('none');
      parent.find('.foreign-select-wrapper').addClass('none');
      parent.find('.local_key').removeClass('none');
      parent.find('.mediator_table_key_wrapper').removeClass('none');
      parent.find('._input_type_wrapper').addClass('none');
      parent.find('._field_name').addClass('none');
    }

    if ($(this).val() == 'belongsTo' || $(this).val() == 'hasMany') {
      parent.find('.foreign-select-wrapper').removeClass('none');
      parent.find('._input_type_wrapper').removeClass('none');
      parent.find('.local_key').removeClass('none');
      parent.find('._field_name').addClass('none');
    }
  });
}

$(document).on('click', '#saveAddNew', function(e) {
    e.preventDefault();
    var id_equip_option = $(this).attr('id_equip_option');
    var url = $(this).attr('url');
    var value = $('#value').val();

    $.post(url, {id:id_equip_option, _token: CSRF, id_equip_option: id_equip_option, value: value, addNew:true}, '', 'json').always(function (data) {
        if (data.status == 'redirect') {
          window.location = data.message;
        }
    });
});

// $(document).on('submit', '.myForm', function(e) {
//   e.preventDefault();
//   var form_data = new FormData($(this).serialize());
//   const form = $(this);
//   if (!formValidate(form)) {
//     return false;
//   }
//   form.find('button[type="submit"]').addClass('loadingi');
//   url = form.attr('action');
//   var fields = $(this).serializeArray();
//   $(fields).each(function (index, data) {
//     form_data.append(data.name, data.value);
//   });
//   const id_form = $(this).attr('id');
//   $('form#' + id_form + ' input:file').each(function () {
//     form_data.append($(this).attr('name'), $(this).prop("files")[0]);
//   });
//
//   console.log(form_data);
//
//   $.ajax({
//       url: url,
//       data: form_data,
//       method: 'post',
//       cache: false,
//       type: 'post',
//       processData: false,
//       contentType: false,
//       dataType: 'json',
//     }).always(function(data) {
//       if (data.status == 'success') {
//         Swal.fire({
//           position: 'top-end',
//           type: 'success',
//           title: data.message,
//           showConfirmButton: false,
//           timer: 10500
//         })
//       }
//
//       if (data.status == 'error') {
//         console.log(data.status);
//         Swal.fire(data.message);
//       }
//
//       if (data.status == 'redirect') {
//         window.location = data.message;
//       }
//
//       form.find('button[type="submit"]').removeClass('loadingi');
//     }).fail(function (data) {
//       console.log(data);
//       console.log(data.responseJSON.trace[0]);
//       Swal.fire({
//         position: 'top-end',
//         type: 'error',
//         title: data.responseJSON.message,
//         showConfirmButton: false,
//         html: data.responseJSON.trace[0].file + ': line - ' + data.responseJSON.trace[0].line,
//         timer: 10500
//       })
//     });
// });
//
//

$(document).on('submit', '.myForm', async function(e) {
  e.preventDefault();

  var form_data = new FormData();
  const form = $(this);
  // var form_data = new FormData($(this).serialize());
  // const form = $(this);
  if (!formValidate(form)) {
    return false;
  }
  form.find('button[type="submit"]').addClass('loadingi');
  url = form.attr('action');
  var fields = $(this).serializeArray();

  $(fields).each(function (index, data) {
    form_data.append(data.name, data.value);
  });

  const id_form = $(this).attr('id');

  $('form#' + id_form + ' input:file').each(function () {
    form_data.append($(this).attr('name'), $(this).prop("files")[0]);
  });


  // if (vApp.editor) {

  //   var editorData = await vApp.getEditorData();
  //   var blocks = editorData.blocks;
  //   form_data.append('blocks', JSON.stringify(blocks));

  // }

  console.log(form_data);

  $.ajax({
      url: url,
      data: form_data,
      method: 'post',
      cache: false,
      type: 'post',
      processData: false,
      contentType: false,
      dataType: 'json',
    }).always(function(data) {
      if (data.status == 'success') {
        Swal.fire({
          position: 'top-end',
          type: 'success',
          title: data.message,
          showConfirmButton: false,
          timer: 10500
        })
      }

      if (data.status == 'error') {
        console.log(data.status);
        Swal.fire(data.message);
      }

      if (data.status == 'redirect') {
        window.location = data.message;
      }
      form.find('button[type="submit"]').removeClass('loadingi');

    }).fail(function (data) {
      console.log(data);
      console.log(data.responseJSON.trace[0]);
      Swal.fire({
        position: 'top-end',
        type: 'error',
        title: data.responseJSON.message,
        showConfirmButton: false,
        html: data.responseJSON.trace[0].file + ': line - ' + data.responseJSON.trace[0].line,
        timer: 10500
      })
    });
});

function formValidate(form) {
  rf = form.find('#required').val();

  if (!rf) {
    return true;
  }
  rf = rf.replace('[]', '');
  rf = rf.split(',');
  errors = false;
  fields = new Array();
  $.each(rf, function(i) {
    input = '#' + rf[i];
    input_bar = form.find(input);

    if (!input_bar) {
      return;
    }
    myVal = input_bar.val();
    if (!myVal) {
      console.log(input);
      label = $(input_bar).parent().find('label');
      $(input_bar).parent().addClass('invalid');
      $(input_bar).parent().find('.invalid_text').remove();
      if (label.text() != '') {
        $(input_bar).parent().append('<p class="invalid_text">' + label.text() + ' is required' + '</p>');
      } else {
        label = $(input_bar).parent().parent().find('label');
        if (label.text() != '') {
        }
      }
      errors = true;
    } else {
      $(input_bar).parent().removeClass('invalid');
      $(input_bar).parent().find('.invalid_text').remove();
    }
  });

  if (errors) {
    return false;
  }

  return true;
}

var xhr = null;
var write = false;
$(document).on('keyup', '._tf', function(e) {
  if (
    !url_get($(this).attr('filter')) &&
    !$(this).val() && e.keyCode &&
    (e.keyCode <= 48 || e.keyCode >= 90)
  ) {
    return true;
  }

  if (xhr != null && typeof xhr.readyState !== 'undefined') {
    xhr.abort();
    xhr = null;
  }

  $('._tf').removeClass('active');
  $(this).addClass('active');
  const ID_TABLE = $(this).parent().parent().parent().parent().attr('id');

  // url = window.location.protocol + '//' + window.location.hostname + window.location.pathname;

  query_string('page', 1);
  query_string($(this).attr('filter'), $(this).val());


  write = true;
  data = {};
  data[$(this).attr('filter')] = $(this).val();
  data['page'] = 1;
  xhr = $.post(window.location.href, { _token: CSRF }, '', 'json')
  .then((res) => {

    $('#' + ID_TABLE + ' tbody').html(res.message);
    $('.links').html(res.field);

  });

});

table_filter();
function table_filter() {
  $('.table').each(function() {
    tr_filter = $(this).find('tr.filter');
    thead = $(this).find('thead');
    th = $(this).find('th');

    html = '<tr class="filter"></tr>';
    $(tr_filter).remove();
    $(thead).append(html);

    tr_filter = $(this).find('tr.filter');
    $(th).each(function() {
      filter = $(this).attr('filter');
      filter_type = $(this).attr('filter_type');
      range = $(this).attr('range');
      if (filter && filter.length) {
        filter_id = filter.replace('.', '_', filter);
        if (filter_type && filter_type == 'date') {
          if (range) {
            html = '<td class="flex"><input placeholder="From" type="text" id="' + filter_id + '--start" filter="' + filter + '--start" class="form-control _dt _tf">';
            html += '<input type="text" placeholder="To" id="' + filter_id + '--end" filter="' + filter + '--end" class="form-control _dt _tf"></td>';
          } else {
            html = '<td><input placeholder="Choose Date" type="text" id="' + filter_id + '--start" filter="' + filter + '--start" class="form-control _dt _tf"></td>';
          }
        } else {
          html = '<td><input type="text" id="' + filter_id + '" filter="' + filter + '" class="form-control _tf" value="' + url_get(filter) + '"></td>';
        }
      } else {
        html = '<td>-</td>';
      }
      $(tr_filter).append(html);
    });
  });
}

$(document).on('click', '._tw_w .pagination a', function(event) {
  event.preventDefault();
  event.stopImmediatePropagation();
  url = $(this).attr('href');
  active_filter = $('._tf');
  const ID_TABLE = $(this).parent().parent().parent().parent().attr('table');

  if (active_filter.length) {
    active_filter.each(function(index, value) {
      if ($(this).val()) {
        vari = $(this).attr('filter');
        valuee = $(this).val();
        url = url + '&' + vari + '=' + valuee;
      }
    });
    redirect(url);

    var d = {
      _token: CSRF
    };

    $.post(url, d, '', 'json').always(function(data) {
      $('#' + ID_TABLE + ' tbody').html(data.message);
      $('.links').html(data.data);
    });
  } else {
    redirect(url);
    $.get(window.location.href, {}, '', 'json').always(function(data) {
      $('#' + ID_TABLE + ' tbody').html(data.message);
      $('.links').html(data.data);
    });
  }
});

function url_get($param) {
  var geturl = new URLSearchParams(window.location.search);
  var c = geturl.get($param);
  if (c != null) {
    return c;
  }

  return '';
}

var query_string = function (key, value) {

    var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
        urlQueryString = document.location.search,
        newParam = key + '=' + value,
        params = '?' + newParam;
    // If the "search" string exists, then build params from it
    if (urlQueryString) {
        var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
        var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

        if( typeof value == 'undefined' || value == null || value == '' ) { // Remove param if value is empty
            params = urlQueryString.replace(removeRegex, "$1");
            params = params.replace( /[&;]$/, "" );

        } else if (urlQueryString.match(updateRegex) !== null) { // If param exists already, update it
            params = urlQueryString.replace(updateRegex, "$1" + newParam);

        } else { // Otherwise, add it to end of query string
            params = urlQueryString + '&' + newParam;
        }
    }

    // no parameter was set so we don't need the question mark
    params = params == '?' ? '' : params;

    window.history.replaceState({}, "", baseUrl + params);
};

function keyupURL(focus_element, result_element) {
  $(document).on('keyup', focus_element, function () {
    var url = $(focus_element).val().toLowerCase().replace(/[^a-z0-9]+/g,'-');
    $(result_element).parent().addClass('is-focused');
    $(result_element).val(url);
  });
}

function geo()
  {
      var countries = {
        componentRestrictions: {country: ["usa"]}
      };

      $('#location').geocomplete(countries).bind("geocode:result", function(event, result) {
          event.preventDefault();
          console.log(result);

        $.post(AdminURL + '/get/latlng', {location: $('#location').val(), _token: CSRF}, '', 'json').always(function (data) {
            if (data.status == 'success') {
              $('#lat').val(data.message.lat);
              $('#lng').val(data.message.lng);
            }
          }).fail(function(data) {
            Swal.fire({
              position: 'top-end',
              type: 'error',
              title: 'Please choose other location',
              showConfirmButton: false,
              timer: 10500
            })
          });

          $('.address-temp').html(result.adr_address);
          var streetAddress = $('.street-address').html();
          var state = $('.region').html();
          var city = $('.locality').html();
          var postalcode = $('.postal-code').html();

          $('#street').val(streetAddress);
          $('#street').parent().addClass('is-focused');

          $('#state').val(state);
          $('#state').parent().addClass('is-focused');

          $('#city').val(city);
          $('#city').parent().addClass('is-focused');

          $('#zip').val(postalcode);
          $('#zip').parent().addClass('is-focused');
      });

      var options = {
        types: ['(cities)'],
        componentRestrictions: {country: ["usa"]}
      };

      var states = {
          types: ['(regions)'],
          componentRestrictions: {
              country: ["usa"]
          }
      };


      $('#city').geocomplete(options).bind("geocode:result", function(event, result) {
          $("#city").val(result.name);
      });

      $('#state').geocomplete(states).bind("geocode:result", function(event, result) {
          $("#state").val(result.name);
      });

      $('#zip').geocomplete(states).bind("geocode:result", function(event, result) {
          $("#zip").val(result.name);
      });

      $('.mdl-textfield').removeClass('has-placeholder');
      $('.mdl-textfield > input').removeAttr('placeholder');
  }

function redirect(url) {
  var stateObject = {};
  var title = '';
  var data = history.pushState(stateObject, title, url);
  // window.location = url;
}
