<div class="_input_type_wrapper">
  {!! $form->choice([
    'label' => 'Input Type',
    'name' => 'input_type',
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
