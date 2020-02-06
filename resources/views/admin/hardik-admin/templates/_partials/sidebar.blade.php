<div class="sidebar">
  <ul class="navbar-nav">
    <li class="nav-item _logo_">
      <img src="/storage/image/Fluent-Logo.svg" alt="">
    </li>
    {{--
    <li class="nav-item">
      <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
    </li>
    --}}
    @if (count($sidebar_menu))
      @foreach ($sidebar_menu as $k => $head)
        <li class="_h">{{ $head->name }}</li>
        @if (count($head->menu))
          @foreach ($head->menu as $key => $m)
          <li class="nav-item">
            <a href="{{ ($m->slug ? route($m->slug) : '#') }}" class="nav-link">
              {{ $m->name }}
            </a>
            @if (count($m->child))
            <ul class="submenu">
              @foreach ($m->child as $child)
              <li class="nav-item">
                <a class="item-link" href="{{ route($child->slug) }}">{{ $child->name }}</a>
              </li>
              @endforeach
            </ul>
            @endif
          </li>
          @endforeach
        @endif
      @endforeach
    @endif
  </ul>
  {{--
  <ul class="nav-footer">
    <li><a data-toggle="tooltip" data-placement="top" title="Configuration" href="{{ route('employee.logout') }}" class="link"><i class="ion-android-options"></i></a></li>
    <li>
      <a data-toggle="tooltip" data-placement="top" title="Components" href="{{ route('component.list') }}" class="link">
        <i class="ion-network"></i>
      </a>
    </li>
    <li><a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('employee.logout') }}" class="link"><i class="ion-power"></i></a></li>
  </ul>
  --}}
</div>
