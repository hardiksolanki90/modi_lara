<?php $ids = array(); ?>
@if (is_object($media) && isset($media[0]))
  <div id="{{ $id }}_wrapper" class="preview-wrapper">
    @foreach ($media as $med)
      @if (!$med)
        @continue;
      @endif
      <div class="selected-img-preview">
        {!! generateMediaHTML($med) !!}
      </div>
      <input type="hidden" id="{{ $id }}" name="{{ $id }}[]" value="{{ $med->id }}">
    @endforeach
  </div>
@elseif ($media && isset($media->id))
  <div id="{{ $id }}_wrapper" class="preview-wrapper">
    <div class="selected-img-preview">
      {!! generateMediaHTML($media) !!}
    </div>
      <input type="hidden" id="{{ $id }}" name="{{ (isset($media->id) ? $id : $id . '[]') }}" value="{{ (isset($media->id) ? $media->id : $media->first()->id) }}">
  </div>
@endif
