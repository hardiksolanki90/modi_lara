var AdminURL = ADMIN_URL;
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

  keyupURL('#name', '#url');
  keyupURL('#name', '#slug');
  keyupURL('#name', '#identifier');
  keyupURL('#title', '#url');

  $(document).on('focus', '.my-input', function() {
    $(this).parent().addClass('is-focused');
  });


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

$(window).on('load', function() {
  $('[id=column_type]').trigger('change');
  $('[id=relationship_type]').trigger('change');
});

$('.html-editor').summernote({
  codemirror: {
    mode: 'text/html',
    htmlMode: true,
    lineNumbers: true,
    theme: 'monokai'
  },
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

function keyupURL(focus_element, result_element) {
  $(document).on('keyup', focus_element, function () {
    var url = $(focus_element).val().toLowerCase().replace(/[^a-z0-9]+/g,'-');
    $(result_element).parent().addClass('is-focused');
    $(result_element).val(url);
  });
}

$(document).on('submit', '.myForm', function(e) {
  e.preventDefault();
  var form_data = new FormData($(this).serialize());
  const form = $(this);
  if (!formValidate(form)) {
    return false;
  }
  form.find('button[type="submit"]').addClass('loadingi');
  url = form.attr('action');
  var fields = $(this).serializeArray();
  $(fields).each(function (index, data) {
    form_data.append(data.name, data.value);
  });
  console.log(form_data);
  const id_form = $(this).attr('id');
  $('form#' + id_form + ' input:file').each(function () {
    form_data.append($(this).attr('name'), $(this).prop("files")[0]);
  });

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
        // Jigesh.toast(label.text() + ' is required', 5000);
      } else {
        label = $(input_bar).parent().parent().find('label');
        if (label.text() != '') {
          // Jigesh.toast(label.text() + ' is required', 5000);
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
$(document).on('change keyup', '._tf', function(e) {
  if (!url_get($(this).attr('filter')) && !$(this).val() && e.keyCode && (e.keyCode <= 48 || e.keyCode >= 90)) {
    return true;
  }

  if (xhr != null && typeof xhr.readyState !== 'undefined') {
    xhr.abort();
    xhr = null;
  }

  $('._tf').removeClass('active');
  $(this).addClass('active');
  const ID_TABLE = $(this).parent().parent().parent().parent().attr('id');
  url = window.location.protocol + '//' + window.location.hostname + window.location.pathname;
  query_string('page', 1);
  query_string($(this).attr('filter'), $(this).val());

  write = true;
  data = {};
  data[$(this).attr('filter')] = $(this).val();
  data['page'] = 1;
  xhr = $.get(window.location.href, {}, '', 'json').always(function(data) {
    $('#' + ID_TABLE + ' tbody').html(data.message);
    $('.links').html(data.field);
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
  const ID_TABLE = $(this).parent().parent().parent().attr('table');
  if (active_filter.length) {
    active_filter.each(function(index, value) {
      if ($(this).val()) {
        vari = $(this).attr('filter');
        valuee = $(this).val();
        url = url + '&' + vari + '=' + valuee;
      }
    });
    redirect(url);
    $.get(url, '', '', 'json').always(function(data) {
      $('#' + ID_TABLE + ' tbody').html(data.message);
      $('.links').html(data.field);
    });
  } else {
    redirect(url);
    $.get(window.location.href, {}, '', 'json').always(function(data) {
      $('#' + ID_TABLE + ' tbody').html(data.message);
      $('.links').html(data.field);
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
