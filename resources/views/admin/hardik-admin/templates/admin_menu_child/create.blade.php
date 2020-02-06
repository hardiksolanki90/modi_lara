@extends('layouts.dashboard')
@section('content')
<div class="con">
  <div class="card">
    <div class="card-body">
          {!! $form->start('admin_menu_child-create-form', 'myForm') !!}
          
        {!! $form->text([
          'name' => 'name',
          'required' => true,
          'label' => t('Name'),
          'value' => model($obj, 'name'),
          'class' => ''
          ]) !!}
                          
        {!! $form->text([
          'name' => 'slug',
          'required' => true,
          'label' => t('Slug'),
          'value' => model($obj, 'slug'),
          'class' => ''
          ]) !!}
                                                                                                          {!! $form->choice([
                    'name' => 'id_menu',
                    'required' => true,
                    'label' => t('Menu'),
                    'value' => model($obj->admin_menu, 'id'),
                    'class' => '',
                    'options' => $context->admin_menu->get()->toArray(),
                    'reverse' => true,
                    'text_key' => 'name',
                    'value_key' => 'id',
                    'type' => 'select',
                    ]) !!}
                                                                                  <button type="submit" class="btn btn-primary btn-submit has-icon-right" name="button">
                    <i class="ion-ios-download-outline"></i>
                    {{ t('Save') }} Admin Child Menu
                  </button>
                  {!! $form->end() !!}
                    </div>
  </div>
</div>
@endsection
