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
                  <ul class="nav nav-tabs main-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#information" role="tab" data-toggle="tab">Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#seo" role="tab" data-toggle="tab">SEO</a>
            </li>
          </ul>
                        {!! $form->start('privacy_policy-create-form', 'myForm tab-pad') !!}
          <div class="tab-content">
            <div class="tab-pane container active" id="information">
                                                  
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
                        'required' => false,
                        'label' => t('Content'),
                        'value' => model($obj, 'content'),
                        'class' => 'html-editor',
                        'textarea' => true
                        ]) !!}
                                                                                                                                                                                                                {!! $form->choice([
                            'name' => 'id_key',
                            'required' => false,
                            'label' => t('Key'),
                            'value' => model($obj->admin_menu_child, 'id'),
                            'class' => '',
                            'options' => app()->context->admin_menu_child->get()->toArray(),
                            'reverse' => true,
                            'text_key' => 'name',
                            'value_key' => 'id',
                            'type' => 'select',
                            ]) !!}
                                                                                                        </div>
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
                  <div class="page_footer flex space-between">
            <div class="_ls">
                                        </div>
            <div class="_rs">
              <button type="submit" class="btn btn-primary btn-submit has-icon-right" name="button">
                <i class="ion-ios-download-outline"></i>
                {{ t('Save') }} Privacy Policy              </button>
            </div>
          </div>
      {!! $form->end() !!}
        </div>
  </div>
</div>
@endsection
