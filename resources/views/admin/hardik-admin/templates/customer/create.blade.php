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
                        {!! $form->start('customer-create-form', 'myForm tab-pad') !!}
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
                        'name' => 'email',
                        'required' => true,
                        'label' => t('Email'),
                        'value' => model($obj, 'email'),
                        'class' => ''
                        ]) !!}
                                                                                                                                                        
                      {!! $form->text([
                        'name' => 'password',
                        'required' => true,
                        'label' => t('Password'),
                        'value' => model($obj, 'password'),
                        'class' => ''
                        ]) !!}
                                                              </div>
                      <div class="page_footer flex space-between">
            <div class="_ls">
                                        </div>
            <div class="_rs">
              <button type="submit" class="btn btn-primary btn-submit has-icon-right" name="button">
                <i class="ion-ios-download-outline"></i>
                {{ t('Save') }} customer              </button>
            </div>
          </div>
      {!! $form->end() !!}
        </div>
  </div>
</div>
@endsection
