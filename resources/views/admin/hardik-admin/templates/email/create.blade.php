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
      {!! $form->start('email-create-form', 'myForm tab-pad') !!}
          <div class="tab-content">
            <div class="tab-pane container active" id="information">

                      {!! $form->text([
                        'name' => 'subject',
                        'required' => true,
                        'label' => t('Subject'),
                        'value' => model($obj, 'subject'),
                        'class' => ''
                        ]) !!}

                      {!! $form->text([
                        'name' => 'content',
                        'required' => true,
                        'label' => t('Content'),
                        'value' => model($obj, 'content'),
                        'class' => 'html-editor',
                        'textarea' => true
                        ]) !!}

                      {!! $form->text([
                        'name' => 'sms',
                        'required' => false,
                        'label' => t('SMS'),
                        'value' => model($obj, 'sms'),
                        'class' => 'html-editor',
                        'textarea' => true
                        ]) !!}

                        {!! $form->choice([
                            'name' => 'id_component',
                            'required' => true,
                            'label' => t('Component'),
                            'value' => model($obj->component, 'id'),
                            'class' => '',
                            'options' => app()->context->component->orderBy('name', 'desc')->get()->toArray(),
                            'reverse' => true,
                            'text_key' => 'name',
                            'value_key' => 'id',
                            'type' => 'select',
                            ]) !!}

                      {!! $form->text([
                        'name' => 'identifier',
                        'required' => true,
                        'label' => t('Identifier'),
                        'value' => model($obj, 'identifier'),
                        'class' => ''
                        ]) !!}
            </div>
            <div class="page_footer flex space-between">
              <div class="_ls">
              </div>
              <div class="_rs">
                <button type="submit" class="btn btn-primary btn-submit has-icon-right" name="button">
                  <i class="ion-ios-download-outline"></i>
                  {{ t('Save') }} Email
                </button>
              </div>
            </div>
          {!! $form->end() !!}
      </div>
  </div>
</div>
@endsection
