<div class="select-media-wrapper">
  <?php $div_id = str_replace('[]', '', $data['id']); ?>
  <button {{ $data['object_type'] ? 'object_type='.$data['object_type'].'' : '' }}  {{ ($data['multiple'] ? 'multiple' : '') }} type="button" id="{{ $div_id }}" class="btn btn-media select-media">
    <i class="material-icons">&#xE2C3;</i>
    {{ $data['label'] }}
  </button>
{{--
  @if ($data['object_type'] != 'application' || $data['object_type'] != 'pdf')
  <input type="hidden" id="{{ $div_id }}" name="{{ $div_id }}{{ ($data['multiple'] ? '[]' : '') }}" value="">
  @endif
--}}

  @if ($data['media'])
    {!! generateMedia([
      'id' => $data['id'],
      'media' => $data['media']
    ]) !!}
  @endif
</div>
