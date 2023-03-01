<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
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
    <li class="nav-item {{ request()->is('admin/product') ?'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.product.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Produk</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/member') || request()->is('admin/member/show/*')  ?'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.member.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Member</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/sale') ?'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.sale.index') }}">
            <i class="fas fa-fw fa-cart-arrow-down"></i>
            <span>Penjualan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->