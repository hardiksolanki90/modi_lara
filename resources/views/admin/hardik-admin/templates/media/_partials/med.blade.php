@if ($med->type == 'image')
  <img id_media="{{ $med->id }}" src="{{ getMedia($med, '150, 150') }}" class="full select-library-img">
@elseif ($med->type == 'application' ||  $med->type == 'pdf')
  <div class="select-library-img video-selector" id_media="{{ $med->id }}"></div>
  <a type="pdf" class="pdf-list select-library-img" id_media="{{ $med->id }}" href="{{getMedia($med)}}">
    <i class="material-icons"> picture_as_pdf </i>
    <p class="file_name_pdf">{{ $med->name }}</p>
  </a>
@elseif ($med->type == 'video')
  <div class="select-library-img video-selector" id_media="{{ $med->id }}"></div>
    @if ($med->format == 'embeded')
      {!! $med->name !!}
    @else
      <video src="{{ getMedia($med) }}"></video>
    @endif
@endif
