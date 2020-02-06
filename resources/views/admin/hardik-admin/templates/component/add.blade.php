@extends('layouts.dashboard')
@section('content')
<div class="con">
  <div class="card">
    <div class="card-body">
      {!! $form->start('admin-user-create', 'component-add myForm') !!}
        <div class="flex space-between">
          {!! $form->text([
            'name' => 'name',
            'label' => t('Component Name'),
            'required' => true,
            'value' => model($component, 'name'),
          ]) !!}

          {!! $form->text([
            'name' => 'table',
            'label' => t('Table'),
            'value' => model($component, 'table'),
            'required' => true,
          ]) !!}

          {!! $form->text([
            'name' => 'variable',
            'label' => t('Variable'),
            'value' => model($component, 'variable'),
            'required' => true,
          ]) !!}
          {!! $form->text([
            'name' => 'slug',
            'label' => t('Slug'),
            'value' => model($component, 'slug'),
            'required' => true,
            ]) !!}
        </div>

        {!! $form->choice([
          'label' => 'Controller',
          'name' => 'controller',
          'show_label_as_option' => false,
          'value' => model($component, 'controller'),
          'options' => ['none' => 'None', 'front' => 'Front', 'admin' => 'Admin', 'both' => 'Both']
        ]) !!}

          <hr>
          <h4>Fields</h4>
          <div class="_mc_wrapper">
            @if (c($component) && count($component->fields))
              <?php $fields = $component->fields()
              ->where('field_name', '!=', 'meta_title')
              ->where('field_name', '!=', 'meta_description')
              ->where('field_name', '!=', 'meta_keywords')
              ->get(); ?>

              @foreach ($fields as $field)
                @include('component._partials.fields')
              @endforeach
            @else
              @include('component._partials.fields', ['field' => ''])
            @endif
            <div class="new-column"></div>
            <a href="#" class="_ac _afb"><i class="material-icons">add_circle_outline</i> Add fields</a>
          </div>
          <hr>
          <h4>Other Config</h4>
          <div class="flex space-between">
            {!! $form->choice([
                'name' => 'is_login_needed',
                'options' => ['No', 'Yes'],
                'value' => model($component, 'is_login_needed'),
                'label' => 'Is route need login?',
                'type' => 'radio',
                'reverse' => 'true',
                'wrapper_class' => 'switch'
            ]) !!}
            {!! $form->choice([
                'name' => 'is_meta_needed',
                'options' => ['No', 'Yes'],
                'value' => model($component, 'is_meta_needed'),
                'label' => 'Is Meta Fields Needed?',
                'type' => 'radio',
                'reverse' => 'true',
                'wrapper_class' => 'switch'
            ]) !!}
            {!! $form->choice([
                'name' => 'reset',
                'options' => ['No', 'Yes'],
                'value' => 0,
                'label' => 'Reset Component?',
                'type' => 'radio',
                'reverse' => 'true',
                'wrapper_class' => 'switch'
            ]) !!}
          </div>
          <hr>
          <div class="flex space-between">
            {!! $form->choice([
                'name' => 'is_admin_create',
                'options' => ['No', 'Yes'],
                'value' => model($component, 'is_admin_create'),
                'label' => 'Is Admin Create?',
                'type' => 'radio',
                'reverse' => 'true',
                'wrapper_class' => 'switch'
            ]) !!}
            {!! $form->choice([
                'name' => 'is_admin_list',
                'options' => ['No', 'Yes'],
                'value' => model($component, 'is_admin_list'),
                'label' => 'Is Admin List?',
                'type' => 'radio',
                'reverse' => 'true',
                'wrapper_class' => 'switch'
            ]) !!}
            {!! $form->choice([
                'name' => 'is_admin_delete',
                'options' => ['No', 'Yes'],
                'value' => model($component, 'is_admin_delete'),
                'label' => 'Is Admin Delete?',
                'type' => 'radio',
                'reverse' => 'true',
                'wrapper_class' => 'switch'
            ]) !!}
          </div>
          <hr>
          <div class="flex space-between">
            {!! $form->choice([
                'name' => 'is_front_create',
                'options' => ['No', 'Yes'],
                'value' => model($component, 'is_front_create'),
                'label' => 'Is Front Delete?',
                'wrapper_class' => 'switch',
                'type' => 'radio',
                'reverse' => true
            ]) !!}
            {!! $form->choice([
                'name' => 'is_front_list',
                'options' => ['No', 'Yes'],
                'value' => model($component, 'is_front_list'),
                'label' => 'Is Front List?',
                'wrapper_class' => 'switch',
                'type' => 'radio',
                'reverse' => true
            ]) !!}
            {!! $form->choice([
                'name' => 'is_front_view',
                'options' => ['No', 'Yes'],
                'value' => model($component, 'is_front_view'),
                'label' => 'Is Front View?',
                'wrapper_class' => 'switch',
                'type' => 'radio',
                'reverse' => true
            ]) !!}
          </div>
          <hr>
          <button type="submit" class="btn btn-primary btn-lg" name="button">Save Component</button>
        {!! $form->end() !!}
      </div>
    </div>
  </div>
</div>
@endsection
