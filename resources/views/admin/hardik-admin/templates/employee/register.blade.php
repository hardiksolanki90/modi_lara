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
        {!! $form->start('employee-create-form', 'myForm tab-pad') !!}
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
                'type' => 'email',
                'label' => t('E-Mail Address'),
                'value' => model($obj, 'email'),
                'class' => ''
                ]) !!}

              {!! $form->text([
                'name' => 'password',
                'required' => false,
                'type' => 'password',
                'label' => t('Password'),
                'class' => ''
                ]) !!}

              {!! $form->text([
                'name' => 'password_confirmation',
                'required' => false,
                'type' => 'password',
                'label' => t('Confirm Password'),
                'class' => ''
                ]) !!}
                <div class="form-group myForm-group is-focused">
                  <label for="password_confirmation">User Access Permission</label>
                  <select multiple="multiple" class="form-control multi selectized" name="permission[]" id="permission">
                    @if(count($admin_menu))
                      @foreach ($admin_menu as $am)
                        <option {{ (in_array($am->id, $selected_admin_menu) ? 'selected' : '') }} value="{{ $am->id }}">{{ $am->name }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
            </div>
          <div class="page_footer flex space-between">
            <div class="_ls">
            </div>
            <div class="_rs">
              <button type="submit" class="btn btn-primary btn-submit has-icon-right" name="button">
                <i class="ion-ios-download-outline"></i>
                {{ t('Save') }} Employee
              </button>
            </div>
          </div>
      {!! $form->end() !!}
        </div>
  </div>
</div>
@endsection
