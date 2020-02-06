@if (!$data['material'])
  @if ($data['type'] != 'file')
  <div class="form-group myForm-group {{ ($data['class'] == 'html-editor' ? 'html-editor-wrap' : '') }} {{ ($data['wrapper_class'] ? $data['wrapper_class'] : '') }} {{ (($data['textarea']) ? 'mytexta' : '') }} ">
    @if ($data['label'])
      <label for="{{ $data['id'] }}">{{ $data['label'] }}{{ ($data['required'] ? '*' : '') }}</label>
    @endif
    @if (!$data['textarea'])
      <input id="{{ $data['id'] }}" class="form-control my-input {{ $data['class'] }}" type="{{ $data['type'] }}" name="{{ $data['name'] }}" value="{{ $data['value'] }}" {{ ($data['required'] ? 'required' : '') }}>
    @else

      <textarea id="{{ $data['id'] }}" class="form-control my-input {{ $data['class'] }}" type="{{ $data['type'] }}" name="{{ $data['name'] }}" rows="3" {{ ($data['required'] ? 'required' : '') }}>{{ $data['value'] }}</textarea>
    @endif
  </div>
  @else
  <div class="custom-file">
    <input type="file" class="custom-file-input {{ $data['class'] }}" name="{{ $data['name'] }}" value="{{ $data['value'] }}" id="{{ $data['id'] }}">
    <label class="custom-file-label" for="{{ $data['id'] }}">Choose file</label>
  </div>
  @endif
@endif
