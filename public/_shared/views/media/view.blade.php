<?php $ids = array(); ?>
@if (count($media) > 1)
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
@elseif ($media && count($media) == 1)
  <div id="{{ $id }}_wrapper" class="preview-wrapper">
    <div class="selected-img-preview">
      {!! generateMediaHTML($media) !!}
    </div>
  </div>
  <input type="hidden" id="{{ $id }}" name="{{ $id }}" value="{{ $media->id }}">
@endif
