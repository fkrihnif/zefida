<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('member.dashboard.index') }}">
        <div class="sidebar-brand-text mx-3">Zefida</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('member/dashboard') || request()->is('home') ?'active' : '' }}">
        <a class="nav-link" href="{{ route('member.dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item {{ request()->is('member/reseller') || request()->is('member/reseller/detail/*/detailReseller/*') ?'active' : '' }}">
        <a class="nav-link" href="{{ route('member.reseller.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Tim</span></a>
    </li>
    <li class="nav-item {{ request()->is('member/profile/changePassword') ?'active' : '' }}">
        <a class="nav-link" href="{{ route('member.profile.changePassword') }}">
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