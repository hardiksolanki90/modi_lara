@if (!isset($media->id))
  @foreach ($media as $med)
    @include('media._partials.med')
  @endforeach
@else
  <?php $med = $media; ?>
  @include('media._partials.med')
@endif
