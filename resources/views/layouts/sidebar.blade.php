<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/dashboard" class="brand-link">
      <img src="{{ asset('assets/img/pastelin.jpg') }}" alt="Toko Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Toko</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
              <img src="assets/img/woman.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
              <a href="#" class="d-block"><p>Halo, {{ auth()->user()->username }}</p></a>
              <p class="text-muted">Online <i class ="fas fa-circle text-success size"></i></p>
          </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              
              <li class="nav-item">
                  <a href="/dashboard" class="nav-link">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                          Beranda
                          <span class="right badge badge-danger">Home</span>
                      </p>
                  </a>
              </li>
              
              @if(auth()->user()->level == 'admin')
                  <li class="nav-item">
                      <a href="{{route('user.index')}}" id="user" class="nav-link">
                          <i class="nav-icon fas fa-user"></i>
                          <p>
                              User
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/barang" class="nav-link">
                          <i class="nav-icon fas fa-archive"></i>
                          <p>
                              Barang
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/suppliers" class="nav-link">
                          <i class="nav-icon fas fa-users"></i>
                          <p>
                              Supplier
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/laporan" class="nav-link">
                          <i class="nav-icon fas fa-chart-pie"></i>
                          <p>
                              Laporan
                          </p>
                      </a>
                  </li>
              @endif

              @if(auth()->user()->level == 'pegawai')
                  <li class="nav-item">
                      <a href="/penjualan" class="nav-link">
                          <i class="nav-icon fas fa-list-alt"></i>
                          <p>
                              Penjualan
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/pembelian" class="nav-link">
                          <i class="nav-icon fas fa-shopping-bag"></i>
                          <p>
                              Pembelian
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/biaya" class="nav-link">
                          <i class="nav-icon fas fa-credit-card"></i>
                          <p>
                              Biaya
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                    <a href="/laporan" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Laporan
                        </p>
                    </a>
                </li>
              @endif

              @if(auth()->user()->level == 'pemilik')
              <li class="nav-item">
                <a href="{{route('user.index')}}" id="user" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        User
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/barang" class="nav-link">
                    <i class="nav-icon fas fa-archive"></i>
                    <p>
                        Barang
                    </p>
                </a>
            </li>
              <li class="nav-item">
                <a href="/suppliers" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Supplier
                    </p>
                </a>
            </li>
            
            <li class="nav-item">
              <a href="/biaya" class="nav-link">
                    <i class="nav-icon fas fa-credit-card"></i>
                    <p>
                        Biaya
                    </p>
              </a>
            </li>
              <li class="nav-item">
                <a href="/penjualan" class="nav-link">
                    <i class="nav-icon fas fa-list-alt"></i>
                    <p>
                        Penjualan
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/pembelian" class="nav-link">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>
                        Pembelian
                    </p>
                </a>
            </li>
                  <li class="nav-item">
                      <a href="/laporan" class="nav-link">
                          <i class="nav-icon fas fa-chart-pie"></i>
                          <p>
                              Laporan
                          </p>
                      </a>
                  </li>
              @endif
              
              <li class="nav-item">
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                  <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="nav-icon fas fa-sign-out-alt"></i>
                      <p>
                          Logout
                      </p>
                  </a>
              </li>
          </ul>
      </nav>
      <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<!-- /.Main Sidebar Container -->
