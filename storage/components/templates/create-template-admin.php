@extends('layouts.dashboard')
@section('content')
<div class="con">
  <div class="card _main_card">
    @if (count($page['action_links']))
      <div class="_ph">
        <div class="_pas">
          <div class="action-bar-panel">
            @foreach ($page['action_links'] as $link)
              <a data-toggle="tooltip" data-placement="top" data-original-title="{{ $link['text'] }}" class="rounded-s action-link {{ (isset($link['class']) ? $link['class'] : '') }}" href="{{ $link['slug'] }}">
                @if ($link['icon'])
                  {!! $link['icon'] !!}
                @endif
                <span>{{ $link['text'] }}</span>
              </a>
            @endforeach
          </div>
        </div>
        <div class="_h">
          {{ $page['title'] }}
        </div>
      </div>
    @endif
      <div class="card-body">
        <?php if ($component->is_meta_needed) : ?>
          <ul class="nav nav-tabs main-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#information" role="tab" data-toggle="tab">Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#seo" role="tab" data-toggle="tab">SEO</a>
            </li>
          </ul>
        <?php endif; ?>
        <?php if (count($fillable)) : ?>
        {!! $form->start('<?php echo $component->variable . '-create-form' ?>', 'myForm tab-pad') !!}
          <div class="tab-content">
            <div class="tab-pane container active" id="information">
              <?php foreach ($fillable as $field) : ?>
                <?php if ($field->field_name != 'status') : ?>
                    <?php if ($field->input_type == 'text') : ?>

                      {!! $form->text([
                        'name' => '<?php echo makeColumn($field->field_name) ?>',
                        'required' => <?php echo ($field->required ? 'true' : 'false') ?>,
                        'label' => t('<?php echo str_text($field->field_name) ?>'),
                        'value' => model($obj, '<?php echo makeColumn($field->field_name) ?>'),
                        'class' => '<?php echo $field->class ?>'
                        ]) !!}
                    <?php elseif ($field->input_type == 'textarea') : ?>

                      {!! $form->text([
                        'name' => '<?php echo makeColumn($field->field_name) ?>',
                        'required' => <?php echo ($field->required ? 'true' : 'false') ?>,
                        'label' => t('<?php echo str_text($field->field_name) ?>'),
                        'value' => model($obj, '<?php echo makeColumn($field->field_name) ?>'),
                        'class' => '<?php echo $field->class ?>',
                        'textarea' => true
                        ]) !!}
                    <?php elseif  ($field->input_type == 'file') : ?>
                      {!! $form->file([
                        'name' => '<?php echo makeColumn($field->field_name) ?>',
                        'required' => <?php echo ($field->required ? 'true' : 'false') ?>,
                        'label' => t('<?php echo str_text($field->field_name) ?>'),
                        'value' => model($obj, '<?php echo makeColumn($field->field_name) ?>'),
                        'class' => '<?php echo $field->class ?>',
                        'type' => '<?php echo $field->input_type ?>',
                        'multiple' => false
                        ]) !!}
                    <?php elseif ($field->input_type == 'media_image' || $field->input_type == 'media_video' || $field->input_type == 'media_pdf' ) : ?>
                      {!! $form->media([
                        'name' => '<?php echo makeColumn($field->field_name) ?>',
                        'required' => <?php echo ($field->required ? 'true' : 'false') ?>,
                        'label' => t('<?php echo str_text($field->field_name) ?>'),
                        'media' => model($obj, '<?php echo makeColumn(str_replace('id_', '', $field->field_name)) ?>'),
                        'object_type' => '<?php echo str_replace('media_', '', str_replace('media_pdf', 'media_application', $field->input_type)) ?>',
                        'multiple' => <?php echo ($field->relationship_type == 'belongsToMany' ? 'true' : 'false') ?>
                        ]) !!}
                    <?php elseif ($field->input_type == 'select' || $field->input_type == 'radio' || $field->input_type == 'checkbox' ) : ?>
                      <?php if ($field->column_type == 'relationship') : ?>
                        <?php $opt = 'app()->context->' . $field->component->variable . '->get()->toArray()' ?>
                        <?php if ($field->relationship_type == 'belongsToMany') : ?>
                          <?php $obje = '$obj->' . $field->component->variable . "->pluck('id')->toArray()" ?>
                          {!! $form->choice([
                            'name' => '<?php echo makeColumn($field->field_name) ?>[]',
                            'required' => <?php echo ($field->required ? 'true' : 'false') ?>,
                            'label' => t('<?php echo str_text($field->field_name) ?>'),
                            'value' => <?php echo $obje ?>,
                            'class' => '<?php echo $field->class ?>',
                            'options' => <?php echo $opt ?>,
                            'reverse' => true,
                            'text_key' => 'name',
                            'value_key' => 'id',
                            'type' => '<?php echo $field->input_type ?>',
                            'multiple' => true,
                            ]) !!}
                        <?php elseif ($field->relationship_type == 'belongsTo') : ?>
                          <?php $obje = '$obj->' . $field->component->variable ?>
                          {!! $form->choice([
                            'name' => '<?php echo makeColumn($field->field_name) ?>',
                            'required' => <?php echo ($field->required ? 'true' : 'false') ?>,
                            'label' => t('<?php echo str_text($field->field_name) ?>'),
                            'value' => model(<?php echo $obje ?>, 'id'),
                            'class' => '<?php echo $field->class ?>',
                            'options' => <?php echo $opt ?>,
                            'reverse' => true,
                            'text_key' => 'name',
                            'value_key' => 'id',
                            'type' => '<?php echo $field->input_type ?>',
                            ]) !!}
                      <?php elseif ($field->relationship_type == 'hasMany') : ?>
                        <?php $obje = '$obj->' . str_plural($field->field_name) ?>
                        {!! $form->text([
                          'name' => '<?php echo makeColumn($field->field_name) ?>',
                          'required' => <?php echo ($field->required ? 'true' : 'false') ?>,
                          'label' => t('<?php echo str_text(str_plural($field->field_name)) ?>'),
                          'value' => model(<?php echo $obje ?>, '<?php echo $field->field_name ?>', '', 'object', true),
                          'class' => '<?php echo $field->class ?> tags-input',
                          'textarea' => true,
                          ]) !!}
                      <?php endif; ?>
                    <?php else : ?>
                      <?php if ($field->field_name != 'status') : ?>
                      {!! $form->choice([
                        'name' => '<?php echo makeColumn($field->field_name) ?>',
                        'required' => <?php echo ($field->required ? 'true' : 'false') ?>,
                        'label' => t('<?php echo str_text($field->field_name) ?>'),
                        'value' => model($obj, '<?php echo makeColumn($field->field_name) ?>'),
                        'class' => '<?php echo $field->class ?>',
                        'options' => ['No', 'Yes'],
                        'reverse' => true
                        ]) !!}
                      <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
            <?php if ($component->is_meta_needed) : ?>
              <div role="tabpanel" class="tab-pane fade" id="seo">
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
              </div>
          </div>
        <?php endif; ?>
          <div class="page_footer flex space-between">
            <div class="_ls">
              <?php $status = $fillable->where('field_name', 'status')->first() ?>
              <?php if ($status) : ?>
                {!! $form->choice([
                  'name' => '<?php echo makeColumn($status->field_name) ?>',
                  'required' => <?php echo ($status->required ? 'true' : 'false') ?>,
                  'label' => t('<?php echo str_text($status->field_name) ?>'),
                  'value' => model($obj, '<?php echo makeColumn($status->field_name) ?>'),
                  'class' => '<?php echo $status->class ?>',
                  'options' => ['No', 'Yes'],
                  'wrapper_class' => 'css_switch',
                  'type' => 'radio',
                  'reverse' => true
                ]) !!}
              <?php endif; ?>
            </div>
            <div class="_rs">
              <button type="submit" class="btn btn-primary btn-submit has-icon-right" name="button">
                <i class="ion-ios-download-outline"></i>
                {{ t('Save') }} <?php echo $component->name ?>
              </button>
            </div>
          </div>
      {!! $form->end() !!}
    <?php endif; ?>
    </div>
  </div>
</div>
@endsection
