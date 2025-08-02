<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    @stack('css')
</head>

<body class="sb-nav-fixed">
    @include('components.navbar')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('components.sidebar')
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Start Bootstrap
            </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" style="background-color: #eaeaea!important;">
            <main>
                <div class="container-fluid px-4" style="margin-top: 4rem;">
                    @yield('content')
                </div>
                <div>
                    @if (session('success'))
                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div class="toast show" role="alert">
                                <div class="toast-header bg-success text-white">
                                    <strong class="me-auto">Success</strong>
                                    <button type="button" class="btn-close btn-close-white"
                                        data-bs-dismiss="toast"></button>
                                </div>
                                <div class="toast-body">
                                    {{ session('success') }}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error') || $errors->any())
                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div class="toast show" role="alert">
                                <div class="toast-header bg-danger text-white">
                                    <strong class="me-auto">Error</strong>
                                    <button type="button" class="btn-close btn-close-white"
                                        data-bs-dismiss="toast"></button>
                                </div>
                                <div class="toast-body">
                                    {{ session('error') ?? $errors->first() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script> --}}
    {{-- <script src="{{ asset('js/datatables-simple-demo.js') }}"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.forEach(function(toastEl) {
                const bsToast = new bootstrap.Toast(toastEl, {
                    delay: 3000, // 3000ms = 3 detik
                    autohide: true
                });
                bsToast.show();
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
