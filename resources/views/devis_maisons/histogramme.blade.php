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
                                <h5 class="card-title">Histogramme</h5>
                            </div>
                            <div class="card-body pad table-responsive">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $montantTotal }} Ar</h3>

                                        <p>Montant Total Devis</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Devis pendant l'année : {{ $annee }}</h5>
                                <div class="card-tools">
                                    <form action="{{ route('stat_devisDate') }}" method="post">
                                        @csrf
                                        <div class="input-group input-group-sm" style="width: 200px;padding: 5px">
                                            <select class="form-control" name="annee" onchange="this.form.submit()">
                                                <option value="">Trie par année</option>
                                                @foreach($anneDistinct as $an)
                                                    <option value="{{ $an->year }}">{{ $an->year }}</option>
                                                @endforeach

{{--                                                <option value="2023">2023</option>--}}
{{--                                                <option value="2022">2022</option>--}}
{{--                                                <option value="2021">2021</option>--}}
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body pad table-responsive">
                                <div class="chart">
                                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                @error('error')
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h4>{{ $message }}</h4>
                                    </div>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
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
    <script>
        //-------------
        //- BAR CHART -
        //-------------
        var dataStat = {!! json_encode($dataStat) !!};
        var areaChartDataBar = {
            labels  : ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août','Septembre','Octobre','Novembre','Decembre'],
            datasets: [
                {
                    label               : 'Devis',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : dataStat.map(function(montant, index) {
                        // Utilisez l'index pour mapper le montant sur le label correspondant
                        return montant;
                    }),
                },
            ]
        }

        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartDataBar)
        var temp0 = areaChartDataBar.datasets[0]
        barChartData.datasets[0] = temp0

        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
    </script>
@endsection
