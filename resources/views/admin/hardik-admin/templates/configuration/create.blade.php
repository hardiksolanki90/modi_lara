@extends('layouts.dashboard')
@section('content')
<div class="con">
  <div class="card">
    @if (count($page['action_links']))
      <div class="_ph">
        <div class="_pas">
          <div class="action-bar-panel">
            @foreach ($page['action_links'] as $link)
              <a data-toggle="tooltip" data-placement="top" data-original-title="{{ $link['text'] }}" target="_blank" class="rounded-s action-link {{ (isset($link['class']) ? $link['class'] : '') }}" href="{{ $link['slug'] }}">
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
      {!! $form->start('configuration', 'myForm') !!}
        {!! $form->text([
          'name' => 'ADMIN_EMAIL',
          'label' => t('ADMIN_EMAIL'),
          'required' => true,
          'value' => $ADMIN_EMAIL,
        ]) !!}
        {!! $form->text([
          'name' => 'SITE_URL',
          'label' => t('SITE_URL'),
          'required' => true,
          'value' => $SITE_URL,
        ]) !!}

        <div class="twof">
          <div class="_field">
            {!! $form->choice([
              'name' => 'SSL',
              'options' => ['No', 'Yes'],
              'value' => $SSL,
              'label' => 'SSL',
              'wrapper_class' => 'switch',
              'type' => 'radio',
              'reverse' => true,
              ]) !!}
          </div>
          <div class="_field">
            {!! $form->choice([
              'name' => 'CACHE',
              'options' => ['No', 'Yes'],
              'value' => $CACHE,
              'label' => 'CACHE',
              'wrapper_class' => 'switch',
              'type' => 'radio',
              'reverse' => true,
              ]) !!}
          </div>
        </div>
        <hr>
        <div class="twof">
          <div class="_field">
            {!! $form->choice([
                'name' => 'DEBUG_MODE',
                'options' => ['No', 'Yes'],
                'value' => $DEBUG_MODE,
                'label' => 'DEBUG MODE',
                'wrapper_class' => 'switch',
                'type' => 'radio',
                'reverse' => true
            ]) !!}
          </div>
        </div>
        <hr>
        <div class="twof">
          <div class="_field">
            {!! $form->choice([
              'name' => 'CSS_MINIFICATION',
              'options' => ['No', 'Yes'],
              'value' => $CSS_MINIFICATION,
              'label' => 'CSS MINIFICATION',
              'wrapper_class' => 'switch',
              'type' => 'radio',
              'reverse' => true
              ]) !!}
            </div>
            <div class="_field">
              {!! $form->choice([
                'name' => 'JS_MINIFICATION',
                'options' => ['No', 'Yes'],
                'value' => $JS_MINIFICATION,
                'label' => 'JS MINIFICATION',
                'wrapper_class' => 'switch',
                'type' => 'radio',
                'reverse' => true
                ]) !!}
            </div>
        </div>
        <hr>
        <button type="submit" name="button" class="btn btn-primary btn-submit has-icon-right"><i class="ion-ios-download-outline"></i>
          {{ t('Save Configuration') }}
        </button>
      {!! $form->end() !!}
    </div>
  </div>
</div>
@endsection
