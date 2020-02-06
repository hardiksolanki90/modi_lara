$(document).on('blur', 'input#name', function () {
  var str = $(this).val();
  var small = str.toLowerCase();
  var split = small.split(' ');
  var replace_space = split.join('_');
  var replace_with_forward_slash = split.join('/');
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
      parent.parent().find('._input_type_wrapper .input_type').html('<option value="">Input Type</option> <option value="text" selected="selected">Text</option> <option value="textarea">Textarea</option> <option value="email">Email</option> <option value="password">Password</option> <option value="number">Number</option> <option value="tel">Phone</option> <option value="select">Select Dropdown</option> <option value="radio">Radio</option> <option value="checkbox">Checkbox</option> <option value="file">File</option> <option value="media_image">Media - Image</option> <option value="media_video">Media- Video</option> <option value="media_pdf">Media - PDF</option>');
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
