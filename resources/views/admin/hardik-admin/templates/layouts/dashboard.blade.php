<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700|Material+Icons" rel="stylesheet">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page['title'] }} • {{ config('app.name', 'Modilara') }}</title>

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
      const ADMIN_URL = '{{ url(config('modilara.admin_route')) }}'
    </script>
</head>
<body class="sidebar-mini layout-fixed">
    @include('media._partials.upload')
    @include('media._partials.library')
    <div id="app" class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="mdi mdi-reorder-horizontal left" style="font-size: 20px;"></i></a>
              </li>
              <li class="nav-item"><a class="nav-link" href="#">{{ $page['title'] }}</a></li>
          </ul>


          <!-- Right navbar links -->
          <ul class="navbar-nav ml-auto _lll align-center">
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
                <a class="_vl" href="{{ url('') }}" class="hidden-sm-and-down" target="_balnk">
                  Visit Site
                  <i class="mdi mdi-open-in-new"></i>
                </a>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link" data-toggle="dropdown" href="#">
                    {{ app()->context->admin_user->getAdminUser()->name }}
                  </a>
                  <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                      <a href="{{ route('employee.logout') }}" class="dropdown-item">
                        <i class="mdi mdi-power-standby mr-2"></i> Logout
                      </a>
                  </div>
              </li>
          </ul>
        </nav>
        <!-- /.navbar -->
        @include('_partials.sidebar')
        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
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
