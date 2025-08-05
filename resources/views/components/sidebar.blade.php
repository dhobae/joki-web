  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
          <div class="nav">
              <div class="sb-sidenav-menu-heading">Main</div>
              @if (Auth::user()->role === 'admin')
                  <a class="nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}"
                      href="{{ route('admin.dashboard') }}">
                      <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                      Dashboard
                  </a>
                  <a class="nav-link {{ Request::is('admin/rooms*') ? 'active' : '' }}"
                      href="{{ route('admin.rooms.index') }}">
                      <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                      Rooms
                  </a>

                  <a class="nav-link {{ Request::is('admin/bookings*') ? 'active' : '' }}"
                      href="{{ route('admin.bookings.index') }}">
                      <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                      Bookings
                  </a>
              @endif
              @if (Auth::user()->role === 'user')
                  <a class="nav-link {{ Request::is('user/dashboard*') ? 'active' : '' }}"
                      href="{{ route('user.dashboard') }}">
                      <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                      Dashboard
                  </a>
                  <a class="nav-link {{ Request::is('user/bookings*') ? 'active' : '' }}"
                      href="{{ route('user.bookings.index') }}">
                      <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                      Bookings
                  </a>
              @endif

              {{-- @php
                  if (Auth::user()->peran === 'admin') {
                      $dashlink = 'admin.dashboard';
                  } else {
                      $dashlink = 'karyawan.dashboard';
                  }
              @endphp
              <a class="nav-link {{ Request::is('*/dashboard') ? 'active' : '' }}" href="{{ route($dashlink) }}">
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Dashboard
              </a>
              <a class="nav-link {{ Request::is('admin/jenis*') ? 'active' : '' }}"
                  href="{{ route('admin.jenis.index') }}">
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Jenis
              </a>

              <a class="nav-link {{ Request::is('admin/merk*') ? 'active' : '' }}"
                  href="{{ route('admin.merk.index') }}">
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Merk
              </a>
              <a class="nav-link {{ Request::is('admin/mobil*') ? 'active' : '' }}"
                  href="{{ route('admin.mobil.index') }}">
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Mobil
              </a> --}}
              {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                  aria-expanded="false" aria-controls="collapseLayouts">
                  <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                  Layouts
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a> --}}

              {{-- <div class="sb-sidenav-menu-heading">Interface</div>
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                  aria-expanded="false" aria-controls="collapseLayouts">
                  <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                  Layouts
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                  data-bs-parent="#sidenavAccordion">
                  <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="layout-static.html">Static Navigation</a>
                      <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                  </nav>
              </div>
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                  aria-expanded="false" aria-controls="collapsePages">
                  <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                  Pages
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a> --}}
              <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                  <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                          data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                          Authentication
                          <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                      </a>
                      <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                          data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                              <a class="nav-link" href="login.html">Login</a>
                              <a class="nav-link" href="register.html">Register</a>
                              <a class="nav-link" href="password.html">Forgot Password</a>
                          </nav>
                      </div>
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                          data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                          Error
                          <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                      </a>
                      <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                          data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                              <a class="nav-link" href="401.html">401 Page</a>
                              <a class="nav-link" href="404.html">404 Page</a>
                              <a class="nav-link" href="500.html">500 Page</a>
                          </nav>
                      </div>
                  </nav>
              </div>
              {{-- <div class="sb-sidenav-menu-heading">Addons</div>
              <a class="nav-link" href="charts.html">
                  <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                  Charts
              </a>
              <a class="nav-link" href="tables.html">
                  <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                  Tables
              </a> --}}
          </div>
      </div>
