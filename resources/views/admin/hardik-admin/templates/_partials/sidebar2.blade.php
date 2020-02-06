<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
  
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
              <i class="nav-icon mdi mdi-view-dashboard-outline"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          @if (count($sidebar_menu))
            @foreach ($sidebar_menu as $k => $head)
              <li class="nav-header">{{ $head->name }}</li>
              @if (count($head->menu))
                @foreach ($head->menu as $key => $m)
                    @if (in_array($m->id, $admin_user_permission))
                        <li class="nav-item has-treeview">
                          <a href="{{ ($m->slug ? route($m->slug) : '#') }}" class="nav-link flex align-center">
                              @if ($m->icons)
                                <i class="nav-icon mdi mdi-{{ $m->icons }}"></i>
                              @else
                                <i class="nav-icon mdi mdi-cursor-default-click-outline"></i>
                              @endif
                            <p>
                              {{ $m->name }}
                              @if (count($m->child) > 1)
                                  <i class="mdi mdi-chevron-right right"></i>
                              @endif
                            </p>
                          </a>
                            @if (count($m->child))
                              <ul class="nav nav-treeview">
                                @foreach ($m->child as $child)
                                    <li class="nav-item">
                                      <a href="{{ route($child->slug) }}" class="nav-link flex align-center">
                                      <i class="mdi mdi-arrow-right-bold-outline left"> </i>
                                        <p>{{ $child->name }}</p>
                                      </a>
                                    </li>
                                @endforeach
                              </ul>
                            @endif
                        </li>
                    @endif
                  @endforeach
                @endif
            @endforeach
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  