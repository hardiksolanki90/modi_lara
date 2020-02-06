@if ($med->type == 'image')
  <img id_media="{{ $med->id }}" src="{{ getMedia($med, '150, 150') }}" class="full select-library-img">
  <div class="img-action">
    <button type="button" class="btn btn-success" id="edit-media-img" id_media="{{  $media_opt->id }}">Edit</button>
    <button type="button" class="btn btn-danger" id="delete-media-img" id_media="{{ $media_opt->id }}">Delete</button>
  </div>
@elseif ($med->type == 'pdf')
  <div class="select-library-img video-selector" id_media="{{ $med->id }}"></div>
  <a type="pdf" class="pdf-list select-library-img" id_media="{{ $med->id }}" href="getMedia($med)">
    <i class="mdi mdi-file-pdf"></i>
    <p class="file_name_pdf">{{ $med->name }}</p>
  </a>
  <div class="img-action">
    <button type="button" class="btn btn-danger" id="delete-media-img" id_media="{{ $med->id }}">Delete</button>
  </div>
@elseif ($med->type == 'video')
  <div class="select-library-img video-selector" id_media="{{ $med->id }}"></div>
    @if ($med->format == 'embed')
      {!! $med->name !!}
    @else
      <video width="150" height="135" controls id_media="{{ $med->id }}">
        <source src="{{ getMedia($med->name, '150, 150') }}" type="video/{{ $media_opt->format }}">
      </video>
    @endif
@endif
