@extends('layouts.app')
@section('content')
@if (count($fillable))
  {!! $form->start($component->variable . '-create-form', 'myForm') !!}
  @foreach ($fillable as $field)
    @if ($field->column_type == 'string')
      {!! $form->mdtext([
        'name' => makeColumn($field->field_name),
        'required' => $field->required,
        'label' => $field->field_name,
        'value' => model($obj, makeColumn($field->field_name))
      ]) !!}
    @elseif ($field->column_type == 'longText')
      {!! $form->mdtextarea([
        'name' => makeColumn($field->field_name),
        'required' => $field->required,
        'label' => $field->field_name,
        'value' => model($obj, makeColumn($field->field_name))
      ]) !!}
    @endif
  @endforeach
  <button type="submit" class="btn btn-primary btn-submit has-icon-right" name="button">
    <i class="ion-ios-download-outline"></i>
    {{ t('Save') }} {{ $component->name }}
  </button>
  {!! $form->end() !!}
@endif
@endsection
