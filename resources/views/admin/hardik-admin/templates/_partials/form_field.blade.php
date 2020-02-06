@if (count($obj))
  <div class="_options flex row-wrap">
    @foreach($obj as $o)
      @if ($o->input_type == 'text' || $o->input_type == 'textarea')
        <div class="_block">
          {!! $form->text([
            'name' => 'option['.$o->id.']',
            'required' => false,
            'label' => t($o->name),
            'value' => model($selected_options_values[$o->id], 'value', null, 'array'),
            'class' => '',
            'textarea' => ($o->input_type == 'textarea' ? true : false)
            ]) !!}
        </div>
      @endif
      @if ($o->input_type == 'select' || $o->input_type == 'radio' || $o->input_type == 'checkbox')
        <div class="_block">
          {!! $form->choice([
            'name' => 'option['.$o->id.']' ,
            'required' => false,
            'label' => t($o->name),
            'value' => model($selected_options_values[$o->id], 'value', null, 'array'),
            'class' => '',
            'options' => $o->options->toArray(),
            'reverse' => true,
            'text_key' => 'value',
            'value_key' => 'id',
            'type' => $o->input_type,
            ]) !!}
        </div>
      @endif
    @endforeach
  </div>
@endif
