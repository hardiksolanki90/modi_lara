<div class="_mc">
  @if (model($field, 'field_text'))
      <div class="_ref">{{ model($field, 'field_text') }}</div>
  @else
  <div class="_ref" style="display:none;"></div>
  @endif
  <div class="_cfb">
    <a href="#" class="_close_field">Remove</a>
  </div>
  <div class="flex space-between full">
    <div class="_main">
      {!! $form->choice([
        'label' => 'Column Type',
        'name' => 'column_type[]',
        'value' => model($field, 'column_type'),
        'options' => $column_types
        ]) !!}
        <div class="rel_wrap">
          <div class="_replationship_type_wrapper none">
            {!! $form->choice([
              'label' => 'Relationship Type',
              'name' => 'relationship_type[]',
              'value' => model($field, 'relationship_type'),
              'options' => [
              'belongsTo' => 'Belongs To',
              'belongsToMany' => 'Belongs To Many',
              'hasMany' => 'hasMany',
              ],
              ]) !!}
            </div>
            <div class="_components_wrapper none">
              {!! $form->choice([
                'name' => 'relational_component_name[]',
                'label' => 'Relational Component Name',
                'value' => model($field, 'relational_component_name'),
                'options' => app()->context->component->orderBy('name', 'asc')->get()->toArray(),
                'value_key' => 'id',
                'text_key' => 'name',
                ]) !!}
              </div>
              <div class="local_key none">
                {!! $form->text([
                  'name' => 'local_key[]',
                  'label' => t('Local Key of current table'),
                  'value' => model($field, 'local_key')
                  ]) !!}
              </div>
              <div class="middle_table_wrapper none">
                {!! $form->choice([
                  'name' => 'mediator_table[]',
                  'label' => t('Mediator Table'),
                  'value' => model($field, 'mediator_table'),
                  'options' => $table_list,
                  'value_key' => 'value',
                  'text_key' => 'name',
                  ]) !!}
                </div>
                <div class="mediator_table_key_wrapper none">
                  {!! $form->text([
                    'name' => 'mediator_table_key[]',
                    'label' => t('Mediator Table Key'),
                    'value' => model($field, 'mediator_table_key')
                    ]) !!}
                  </div>
                  <div class="foreign-select-wrapper none">
                    <label for="foreign-select">Foreign Key</label>
                    <select class="foreign-select" id="foreign-select" name="foreign_key[]" >
                      @if (isset($field->foreign_key) && $field->foreign_key)
                      <?php $cp = Schema::getColumnListing($component->table); ?>
                        @if (count($cp))
                          @foreach ($cp as $c)
                            <option value="{{ $c }}" {{ ($c == $field->foreign_key ? 'selected' : '') }}>{{ $c }}</option>
                          @endforeach
                        @endif
                      @endif
                    </select>
                  </div>
                  </div>
                </div>
    <div class="_flex_column _center">
      <div class="_field_name">
        {!! $form->text([
          'name' => 'field[]',
          'label' => t('Field Name'),
          'value' => model($field, 'field_text'),
          'class' => 'field_name'
          ]) !!}
        </div>
        <div class="_input_type_wrapper">
          {!! $form->choice([
            'label' => 'Input Type',
            'name' => 'input_type[]',
            'class' => 'input_type',
            'value' => model($field, 'input_type', 'text'),
            'options' => [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'number' => 'Number',
            'tel' => 'Phone',
            'select' => 'Select Dropdown',
            'radio' => 'Radio',
            'checkbox' => 'Checkbox',
            'file' => 'File',
            'media_image' => 'Media - Image',
            'media_video' => 'Media- Video',
            'media_pdf' => 'Media - PDF'
            ]
            ]) !!}
          </div>
          <div class="_input_defult none">
            {!! $form->text([
              'name' => 'default[]',
              'label' => t('Default'),
              'value' => model($field, 'default')
              ]) !!}
            </div>
            {!! $form->text([
              'name' => 'class[]',
              'label' => t('HTML Class'),
              'value' => model($field, 'class')
              ]) !!}
            </div>
    <div class="_flex_column">
      {!! $form->choice([
        'label' => 'Input Required',
        'name' => 'required_field[]',
        'value' => model($field, 'required', 1),
        'options' => ['No', 'Yes']
      ]) !!}
        {!! $form->choice([
          'label' => 'Use in Listing',
          'name' => 'use_in_listing[]',
          'wrapper_class' => 'form-group myForm-group is-focused',
          'class' => 'form-control',
          'value' => model($field, 'use_in_listing', 1),
          'options' => ['No', 'Yes']
          ]) !!}
          {!! $form->choice([
            'name' => 'fillable[]',
            'label' => 'Fillable',
            'value' => model($field, 'is_fillable', 1),
            'options' => ['No', 'Yes']
            ]) !!}
          </div>
  </div>
</div>
