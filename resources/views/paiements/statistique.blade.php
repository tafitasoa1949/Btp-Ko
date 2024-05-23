@extends('layouts.menu')
@section('content')
    {{-- content --}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Devis</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                            <li class="breadcrumb-item active">Devis</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Statistique</h5>
                            </div>
                            <div class="card-body pad table-responsive">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>@isset($totalPaiment) {{ $totalPaiment }} @else 0 @endif Ar</h3>
                                        <p>Paiement Total</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="row">--}}
{{--                    <div class="col-lg-12">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header">--}}
{{--                                <h5 class="card-title">Statistique</h5>--}}
{{--                            </div>--}}
{{--                            <div class="card-body pad table-responsive">--}}
{{--                                <div class="small-box bg-primary">--}}
{{--                                    <div class="inner">--}}
{{--                                        <h3>@isset($totalPaiment) {{ $totalPaiment }} @else 0 @endif Ar</h3>--}}
{{--                                        <p>Paiement Total</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div><!-- /.container-fluid -->
        </div>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{--  --}}
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
@endsection
