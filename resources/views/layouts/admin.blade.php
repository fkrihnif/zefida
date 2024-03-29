<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Tim Zefida">
    <meta name="keywords" content="Tim Zefida" />
    <meta name="description" content="Tim Zefida">
    <link rel="icon" type="image/favicon.png" href="{{ url('template/img/favl.png') }}">

    <title>Tim Zefida | {{ Auth::user()->name }}</title>
    @include('includes.admin.style')
    @stack('addon-style')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @if(auth()->user()->role == '0')
            @include('includes.admin.sidebar_admin')
        @elseif (auth()->user()->role == '1')
            @include('includes.admin.sidebar_reseller')
        @elseif (auth()->user()->role == '2')
            @include('includes.admin.sidebar_agent')
        @endif

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('includes.admin.navbar')
                @include('sweetalert::alert')
                @yield('content')


            </div>
            <!-- End of Main Content -->

            @include('includes.admin.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Anda Yakin Ingin Logout?</div>
                <div class="modal-footer">
                    <form action="{{ url('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @stack('prepend-script')
    @include('includes.admin.script')
    @stack('addon-script')
</body>

</html>