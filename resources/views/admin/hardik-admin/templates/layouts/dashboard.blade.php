<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700" rel="stylesheet">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ url('favicon.ico') }}" type="image/gif">
    <title>{{ $page['title'] }} • {{ config('app.name', 'Laravel') }}</title>

    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Styles -->
    @if (count($css_files))
      @foreach ($css_files as $css)
        <link type="text/css" href="{{ $css }}" rel="stylesheet">
      @endforeach
    @endif
    <script type="text/javascript">
      CSRF = '{{ csrf_token() }}';
      CURRENT_URL = '{{ url()->current() }}';
      const ADMIN_URL = '{{ url(config('modilara.admin_route')) }}';
      var images_block_count = 1;
      var saved_parts = [];
      var static_blocks_count = 1;
      var equipment_colors = [];
      var equipment = [];
    </script>
</head>
<body>
    @include('media._partials.upload')
    @include('media._partials.library')
    <div id="app">
      <nav class="navbar navbar-expand-md navbar-light navbar-adlara">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li><a class="nav-link" href="#">{{ $page['title'] }}</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto dropdown _lll align-center">
              @if (count($page['action_links']))
                @foreach ($page['action_links'] as $link)
                  <li>
                    <a href="{{ $link['slug'] }}" data-toggle="tooltip" title="{{ $link['text'] }}" class="{{ (isset($link['class']) ? $link['class'] : '') }}">
                      @if ($link['icon'])
                        {!! $link['icon'] !!}
                      @endif
                      {{ $link['text'] }}
                    </a>
                  </li>
                @endforeach
              @endif
              <li>
                <a class="nav-link _vl" href="{{ url('') }}" target="_balnk">
                  Visit Site
                  <i class="ion-ios-redo-outline"></i>
                </a>
              </li>
              <li class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Jigesh
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <div class="dropdown-item noti-title">
                      <h6 class="text-overflow m-0">Welcome !</h6>
                  </div>
                  <li><a class="dropdown-item" href="{{ route('employee.logout') }}">Logout</a></li>
                </ul>
              </li>
            </ul>
        </div>
      </nav>
      <div class="flex wr">
        @include('_partials.sidebar')
        <main class="py-4 main-app">
          @yield('content')
        </main>
      </div>
    </div>

    <!-- Scripts -->
    @if (count($js_files))
      @foreach ($js_files as $js)
        <script src="{{ $js }}"></script>
      @endforeach
    @endif
    @yield('footer_script')
</body>
</html>
