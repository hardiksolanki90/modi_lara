@extends('layouts.dashboard')
@section('content')
<div class="con">
  <div class="card">
    <div class="card-body">
          {!! $form->start('page-create-form', 'myForm') !!}

        {!! $form->text([
          'name' => 'name',
          'required' => true,
          'label' => t('Name'),
          'value' => model($obj, 'name'),
          'class' => ''
          ]) !!}

        {!! $form->media([
          'label' => 'Featured Image',
          'name' => 'featured_image',
          'media' => model($obj, 'featured_image')
        ]) !!}

        {!! $form->media([
          'label' => 'Multiple Featured Image',
          'name' => 'featured_image',
          'media' => model($obj, 'featured_image'),
          'multiple' => true,
        ]) !!}

        {!! $form->media([
          'label' => 'Multiple Featured PDF',
          'name' => 'featured_image',
          'media' => model($obj, 'featured_pdf'),
          'multiple' => true,
          'object_type' => 'application'
        ]) !!}

          {!! $form->text([
            'name' => 'content',
            'required' => false,
            'label' => t('Content'),
            'value' => model($obj, 'content'),
            'class' => '',
            'class' => 'html-editor',
            'wrapper_class' => 'html-editor-wrap',
            'textarea' => true
            ]) !!}

        {!! $form->text([
          'name' => 'url',
          'required' => true,
          'label' => t('Url'),
          'value' => model($obj, 'url'),
          'class' => ''
          ]) !!}
          {!! $form->text([
            'name' => 'body_class',
            'required' => false,
            'label' => t('Body Class'),
            'value' => model($obj, 'body_class'),
            'class' => ''
            ]) !!}
          {!! $form->choice([
              'name' => 'status',
              'required' => false,
              'label' => t('Status'),
              'value' => model($obj, 'status'),
              'class' => '',
              'options' => ['No', 'Yes'],
              'reverse' => true
              ]) !!}
                                                  <hr>
              {!! $form->text([
                'name' => 'meta_title',
                'value' => model($obj, 'meta_title'),
                'label' => 'Meta Title',
                ]) !!}
                {!! $form->text([
                  'name' => 'meta_description',
                  'value' => model($obj, 'meta_description'),
                  'label' => 'Meta Description',
                  'textarea' => true,
                  ]) !!}
                  {!! $form->text([
                    'name' => 'meta_keywords',
                    'value' => model($obj, 'meta_keywords'),
                    'type' => 'text',
                    'label' => 'Meta Keywords',
                    ]) !!}
                                    <button type="submit" class="btn btn-primary btn-submit has-icon-right" name="button">
                    <i class="ion-ios-download-outline"></i>
                    {{ t('Save') }} page
                  </button>
                  {!! $form->end() !!}
                    </div>
  </div>
</div>
@endsection
