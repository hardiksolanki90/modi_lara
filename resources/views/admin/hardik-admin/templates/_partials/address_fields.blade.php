{!! $form->text([
  'name' => 'location',
  'required' => false,
  'label' => t('Location'),
  'value' => model($add, 'location'),
  'class' => ''
  ]) !!}
  <div class="address-temp none"></div>

{!! $form->text([
  'name' => 'street',
  'required' => true,
  'label' => t('Street'),
  'value' => model($add, 'street'),
  'class' => ''
  ]) !!}

{!! $form->text([
  'name' => 'add2',
  'required' => false,
  'label' => t('Address2'),
  'value' => model($add, 'address2'),
  'class' => ''
  ]) !!}

{!! $form->text([
  'name' => 'city',
  'required' => true,
  'label' => t('City'),
  'value' => model($add, 'city'),
  'class' => ''
  ]) !!}

{!! $form->text([
  'name' => 'state',
  'required' => true,
  'label' => t('State'),
  'value' => model($add, 'state'),
  'class' => ''
  ]) !!}

{!! $form->text([
  'name' => 'zip',
  'required' => true,
  'label' => t('Zipcode'),
  'value' => model($add, 'zip'),
  'class' => ''
  ]) !!}
