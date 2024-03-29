<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard.index') }}">
        <div class="sidebar-brand-icon">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">Zefida</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('admin/dashboard') || request()->is('home') ?'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/banner') ?'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.banner.index') }}">
            <i class="fas fa-film"></i>
            <span>Banner</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/product') ?'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.product.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Produk</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/user') || request()->is('admin/tim') || request()->is('admin/tim/detail/*') || request()->is('admin/tim/detailSelling/*') || request()->is('admin/tim/detail/*/detailReseller/*')  ?'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user"></i>
            <span>User</span>
        </a>
        <div id="collapseTwo" class="collapse {{ request()->is('admin/user') || request()->is('admin/tim') || request()->is('admin/tim/detail/*') || request()->is('admin/tim/detailSelling/*') || request()->is('admin/tim/detail/*/detailReseller/*')  ?'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('admin/user') ?'active' : '' }}" href="{{ route('admin.user.index') }}">All Agent/Reseller</a>
                <a class="collapse-item {{ request()->is('admin/tim') || request()->is('admin/tim/detail/*') || request()->is('admin/tim/detailSelling/*') || request()->is('admin/tim/detail/*/detailReseller/*')  ?'active' : '' }}" href="{{ route('admin.tim.index') }}">Tim</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->is('admin/selling') ?'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.selling.index') }}">
            <i class="fas fa-fw fa-cart-arrow-down"></i>
            <span>Data Penjualan</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/profile/changePassword') ?'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.profile.changePassword') }}">
            <i class="fas fa-fw fa-cogs""></i>
            <span>Ganti Password</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->