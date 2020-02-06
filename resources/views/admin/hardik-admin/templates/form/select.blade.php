@if ($data['type'] == 'select')
<div class="form-group myForm-group is-focused">
  @if ($data['label'])
    <label for="{{ $data['id'] }}">{{ $data['label'] }}</label>
  @endif
  <select class="{{ $data['class'] }} form-control  @if ($data['multiple']) multi @endif" name="{{ $data['name'] }}" id="{{ $data['id'] }}" {{ ($data['multiple'] ? 'multiple' : '') }}>
    @if ($data['show_label_as_option'] && $data['label'])
      <option value="">{{ $data['label'] }}</option>
    @endif
    @foreach ($data['options'] as $value => $option)
      @if ($data['value_key'] && $data['text_key'])
        @if ($data['multiple'])
          <option value="{{ $option[$data['value_key']] }}" {{ (in_array($option[$data['value_key']], $data['value']) ? 'selected' : '') }}>{{ $option[$data['text_key']] }}</option>
        @else
          <option value="{{ $option[$data['value_key']] }}" {{ ($option[$data['value_key']] == $data['value'] ? 'selected' : '') }}>{{ $option[$data['text_key']] }}</option>
        @endif
      @elseif ($data['text_as_value'])
        <option value="{{ $option }}" {{ ($option == $data['value'] ? 'selected' : '') }}>{{ $option }}</option>
      @else
        <option value="{{ $value }}" {{ ($value == $data['value'] ? 'selected' : '') }}>{{ $option }}</option>
      @endif
    @endforeach
  </select>
</div>
@endif


@if ($data['type'] == 'radio')
@if ($data['label'])
<label class="_radio_label" for="">{{ $data['label'] }}</label>
@endif
<div class="custom-control custom-radio-wrap {{ ($data['wrapper_class'] == 'css_switch') ? 'switch_css switch--horizontal' : '' }} {{ $data['wrapper_class'] }}">
  @if ($data['wrapper_class'] != 'css_switch')
    @foreach ($data['options'] as $value => $option)
      @if ($data['wrapper_class'] != 'switch')
      <div class="custom-control custom-radio {{ ($data['inline'] ? 'custom-control-inline' : '') }}">
      @endif
        @if ($data['value_key'] && $data['text_key'])
          <input {{ ($data['value'] == $option[$data['value_key']] ? 'checked' : '') }} type="radio" id="{{ $data['name'] }}_{{ $option[$data['value_key']] }}" name="{{ $data['name'] }}" class="custom-control-input" value="{{ $option[$data['value_key']] }}">
          <label class="custom-control-label" for="{{ $data['name'] }}_{{ $option[$data['value_key']] }}">{{ $option[$data['text_key']] }}</label>
        @elseif ($data['text_as_value'])
          <input {{ ($data['value'] == $option ? 'checked' : '') }} type="radio" id="{{ $data['name'] }}_{{ $option }}" name="{{ $data['name'] }}" class="custom-control-input" value="{{ $option }}">
          <label class="custom-control-label" for="{{ $data['name'] }}_{{ $option }}">{{ $option }}</label>
        @else
          <input {{ ($data['value'] == $value ? 'checked' : '') }} type="radio" id="{{ $data['name'] }}_{{ $value }}" name="{{ $data['name'] }}" class="custom-control-input" value="{{ $value }}">
          <label class="custom-control-label" for="{{ $data['name'] }}_{{ $value }}">{{ $option }}</label>
        @endif
      @if ($data['wrapper_class'] != 'switch')
      </div>
      @endif
    @endforeach
    <a class="radio_slider"></a>
  @else
    <div class="switch_css switch--horizontal">
      @foreach ($data['options'] as $value => $option)
        <input {{ ($data['value'] == $value ? 'checked' : '') }} type="radio" id="{{ $data['name'] }}_{{ $value }}" name="{{ $data['name'] }}" class="{{ $data['name'] }}_{{ $value }}" value="{{ $value }}">
        <label for="{{ $data['name'] }}_{{ $value }}">{{ $option }}</label>
      @endforeach
      <span class="toggle-outside">
        <span class="toggle-inside"></span>
      </span>
    </div>
  @endif
</div>
@endif

@if ($data['type'] == 'checkbox')
<div class="custom-control custom-checkbox">
  @if ($data['label'])
    <label class="_checkbox_label" for="">{{ $data['label'] }}</label>
  @endif
  @foreach ($data['options'] as $value => $option)
    @if ($data['value_key'] && $data['text_key'])
      @if ($data['multiple'])
        <div class="custom-control custom-checkbox">
          <label>
            <input {{ (in_array($option[$data['value_key']], $data['value']) ? 'checked' : '') }} type="checkbox" id="{{ $data['name'] }}_{{ $option[$data['value_key']] }}" name="{{ $data['name'] }}" class="custom-control-input {{ $data['class'] }}" value="{{ $option[$data['value_key']] }}">
              {{ $option[$data['text_key']] }}
              <span class="custom-control-label"></span>
            </label>
        </div>
      @else
        <div class="custom-control custom-checkbox">
          <input {{ ($data['value'] == $option[$data['value_key']] ? 'checked' : '') }} type="checkbox" id="{{ $data['name'] }}_{{ $option[$data['value_key']] }}" name="{{ $data['name'] }}" class="custom-control-input {{ $data['class'] }}" value="{{ $option[$data['value_key']] }}">
          <label class="custom-control-label" for="{{ $data['name'] }}_{{ $option[$data['value_key']] }}">{{ $option[$data['text_key']] }}</label>
        </div>
      @endif
    @elseif ($data['text_as_value'])
      <div class="custom-control custom-checkbox {{ ($data['inline'] ? 'custom-control-inline' : '') }}">
        <input type="checkbox" id="{{ $data['name'] }}_{{ $option }}" name="{{ $data['name'] }}" class="custom-control-input" value="{{ $option }}">
        <label class="custom-control-label" for="{{ $data['name'] }}_{{ $option }}">{{ $option }}</label>
      </div>
    @else
      <div class="custom-control custom-checkbox {{ ($data['inline'] ? 'custom-control-inline' : '') }}">
        <input type="checkbox" id="{{ $data['name'] }}_{{ $value }}" name="{{ $data['name'] }}" class="custom-control-input" value="{{ $value }}">
        <label class="custom-control-label" for="{{ $data['name'] }}_{{ $value }}">{{ $option }}</label>
      </div>
    @endif
  @endforeach
</div>
@endif
