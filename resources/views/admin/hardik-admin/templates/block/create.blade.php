@extends('layouts.dashboard')
@section('content')
<div class="con">
  <div class="card">
    <div class="card-body">
      {!! $form->start('block-create-form', 'myForm') !!}

        {!! $form->text([
          'name' => 'name',
          'required' => true,
          'label' => t('Name'),
          'value' => model($obj, 'name'),
          'class' => ''
          ]) !!}

        {!! $form->text([
          'name' => 'identifier',
          'required' => true,
          'label' => t('Identifier'),
          'value' => model($obj, 'identifier'),
          'class' => ''
        ]) !!}

        {!! $form->text([
          'name' => 'content',
          'required' => true,
          'label' => t('Content'),
          'value' => model($obj, 'content'),
          'class' => 'html-editor',
          'wrapper_class' => 'html-editor-wrap',
          'textarea' => true
        ]) !!}


        {!! $form->media([
          'name' => 'id_cover',
          'required' => true,
          'label' => t('Image'),
          'media' => model($obj, 'id_cover'),
          'multiple' => false
          ]) !!}


        {!! $form->media([
          'name' => 'id_pdf',
          'required' => true,
          'label' => t('PDF'),
          'media' => model($obj, 'id_pdf'),
          'object_type' => 'application',
          'multiple' => false
          ]) !!}

        {!! $form->choice([
          'name' => 'status',
          'required' => true,
          'label' => t('Status'),
          'value' => model($obj, 'status'),
          'wrapper_class' => 'switch',
          'type' => 'radio',
          'options' => ['Disabled', 'Enabled'],
          'reverse' => true
          ]) !!}
          <hr>
          <button type="submit" class="btn btn-primary btn-submit has-icon-right" name="button">
            <i class="ion-ios-download-outline"></i>
              {{ t('Save') }} block
          </button>
          {!! $form->end() !!}
      </div>
  </div>
</div>
@endsection
