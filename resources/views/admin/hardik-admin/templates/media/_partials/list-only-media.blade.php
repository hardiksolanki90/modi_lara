@if (count($media))
  <div class="flex row-wrap row _media_libarary_wrapper">
    @foreach ($media as $med)
      <div class="media-col">
        <div class="inner-div" id_media="{{ $med->id }}">
          @if ($med->type ==  'image')

            <img id_media="{{ $med->id }}" class="select-library-img" type="image" src="{{ getMedia($med, '150, 150') }}" alt="">
            
          @elseif ($med->type == 'application' && $med->format == 'pdf')
            <div class="select-library-img video-selector select-library-img" id_media="{{ $med->id }}"></div>
            <a target="_blank" href="{{ getMedia($med) }}" id_media="{{ $med->id }}">
              <i class="material-icons">picture_as_pdf</i>
              {{ $med->name }}
            </a>

          @elseif ($med->type == 'video')
            @if ($med->format == 'embeded')
              <div class="select-library-img video-selector" id_media="{{ $med->id }}"></div>
              {!! $med->name !!}
            @else
              <div class="select-library-img video-selector" id_media="{{ $med->id }}"></div>
              <video width="150" height="150" class="select-library-img" src="{{ getMedia($med) }}" id_media="{{ $med->id }}"></video>
            @endif
          @endif
        </div>
      </div>
    @endforeach
  </div>
  <div class="links">
    {{ $media->links() }}
  </div>
@endif
