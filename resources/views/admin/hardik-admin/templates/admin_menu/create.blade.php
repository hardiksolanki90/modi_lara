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
                        {!! $form->start('admin_menu-create-form', 'myForm tab-pad') !!}
          <div class="tab-content">
            <div class="tab-pane container active" id="information">

                      {!! $form->text([
                        'name' => 'name',
                        'required' => false,
                        'label' => t('Name'),
                        'value' => model($obj, 'name'),
                        'class' => ''
                        ]) !!}

                        {!! $form->choice([
                            'name' => 'id_head',
                            'required' => true,
                            'label' => t('Head'),
                            'value' => model($obj->menu_heading, 'id'),
                            'class' => '',
                            'options' => $context->menu_heading->get()->toArray(),
                            'reverse' => true,
                            'text_key' => 'name',
                            'value_key' => 'id',
                            'type' => 'select',
                            ]) !!}

                      {!! $form->text([
                        'name' => 'slug',
                        'required' => false,
                        'label' => t('Slug'),
                        'value' => model($obj, 'slug'),
                        'class' => ''
                        ]) !!}

                      {!! $form->text([
                        'name' => 'position',
                        'required' => false,
                        'label' => t('Position'),
                        'value' => model($obj, 'position'),
                        'class' => ''
                        ]) !!}

                      {!! $form->text([
                        'name' => 'icons',
                        'required' => false,
                        'label' => t('Icons'),
                        'value' => model($obj, 'icons'),
                        'class' => ''
                        ]) !!}
                                                              </div>
                      <div class="page_footer flex space-between">
            <div class="_ls">
                                        </div>
            <div class="_rs">
              <button type="submit" class="btn btn-primary btn-submit has-icon-right" name="button">
                <i class="ion-ios-download-outline"></i>
                {{ t('Save') }} Admin Menu              </button>
            </div>
          </div>
      {!! $form->end() !!}
        </div>
  </div>
</div>
@endsection
