<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Pos_Inventory</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">

            {{-- MENU PENGGUNA --}}
            {{-- SEMUA PENGGUNA / USER MEMPUNYAI MENU INI --}}
            <li class="menu-header">Pengguna</li>
            <li class="" id="liDashboard"><a class="nav-link" href="{{ URL::to('/dashboard') }}"><i
                        class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
            <li class="" id="liProfile"><a class="nav-link" href="{{ URL::to('/profile') }}"><i class="fas fa-user"></i>
                    <span>Profile</span></a></li>
            <li class="" id="liBantuan"><a class="nav-link" href="{{ URL::to('/bantuan') }}"><i
                        class="fas fa-question-circle"></i> <span>Bantuan</span></a></li>



            @if (auth()->user()->role == 'Administrator')
            {{-- MENU ADMIN --}}
            <li class="menu-header">Admin</li>
            <li class="nav-item dropdown " id="liPengguna">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i>
                    <span>Pengguna</span></a>
                <ul class="dropdown-menu">
                    <li id="liManajemenPengguna"><a class="nav-link" href="/admin/pengguna">Manajemen Pengguna</a></li>
                </ul>
            </li>


            <li class="nav-item dropdown " id="liDataBarang">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-database"></i>
                    <span>Data Barang</span></a>
                    <ul class="dropdown-menu">
                        <li id="liPembelian"><a class="nav-link" href="/admin/pembelian">Pembelian</a></li>
                        <li id="liPenyesuaianStok"><a class="nav-link" href="/admin/penyesuaian_stok">Penyesuaian Stok</a></li>
                        <li id="liStokDibawahMin"><a class="nav-link" href="/admin/stok_dibawah_minimum">Stok Dibawah Minimum</a></li>
                    </ul>
                </li>

            <li class="" id="liSatuan"><a class="nav-link" href="{{ URL::to('/admin/satuan') }}"><i
                class="fas fa-tape"></i><span>Satuan</span></a></li>

            {{-- END OF MENU ADMIN --}}
            @endif

            @if (auth()->user()->role == 'kasir')
            {{-- MENU KASIR --}}
            <li class="menu-header">Kasir</li>

            <li class="" id="liPenjualan"><a class="nav-link" href="{{ URL::to('/kasir/penjualan') }}"><i class="fas fa-cart-plus"></i><span>Penjualan</span></a></li>
            <li class="" id="liRetur"><a class="nav-link" href="{{ URL::to('/kasir/retur') }}"><i class="fas fa-cart-arrow-down"></i><span>Retur</span></a></li>
            <li class="" id="liDataPenjualan"><a class="nav-link" href="{{ URL::to('/kasir/data_penjualan') }}"><i
                class="fas fa-tape"></i><span>Data Penjualan</span></a></li>
            <li class="" id="liDataKasir"><a class="nav-link" href="{{ URL::to('/kasir/data_kasir') }}"><i
                class="fas fa-database"></i><span>Data Kasir</span></a></li>

            {{-- END OF MENU KASIR --}}
            @endif
            @if (auth()->user()->role == 'pimpinan')
            {{-- MENU PIMPINAN --}}
            <li class="menu-header">Pimpinan</li>

            <li class="" id="liDataPenjualan"><a class="nav-link" href="{{ URL::to('/pimpinan/data_penjualan') }}"><i
                class="fas fa-tape"></i><span>Data Penjualan</span></a></li>
            <li class="" id="liGrafikPemasukan"><a class="nav-link" href="{{ URL::to('/pimpinan/grafik_pemasukan') }}"><i
                class="fas fa-chart-bar"></i><span>Grafik Pemasukan</span></a></li>

            {{-- END OF MENU PIMPINAN --}}
            @endif







        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ URL::to('/logout') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
</div>
