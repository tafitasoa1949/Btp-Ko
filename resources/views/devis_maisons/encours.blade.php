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
                        <h1 class="m-0"></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                            <li class="breadcrumb-item active">Travaux</li>
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
                                <h5 class="card-title">Devis en cours</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Travail</th>
                                        <th>Reference</th>
                                        <th>Client</th>
                                        <th>Debut de projet</th>
                                        <th>Durée de travail</th>
                                        <th>Fin de travail</th>
                                        <th>Finition</th>
                                        <th>Prix</th>
                                        <th>Paiement effectué</th>
                                        <th>Reste à payer</th>
                                        <th style="width: 100px;"></th>
                                        <th></th>
                                        <th style=""></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($achat_final as $achat)
                                        <tr>
                                            <td>{{ $achat['travail'] }}</td>
                                            <td>{{ $achat['reference'] }}</td>
                                            <td>{{ $achat['client'] }}</td>
                                            <td>{{ $achat['debut'] }}</td>
                                            <td>{{ $achat['duree'] }} jour(s)</td>
                                            <td>{{ $achat['fin_travail'] }}</td>
                                            <td>{{ $achat['finition'] }}</td>
                                            <td>{{ $achat['prix'] }} Ar</td>
                                            <td>{{ $achat['payer'] }} Ar</td>
                                            <td>{{ $achat['reste'] }} Ar</td>
                                                <?php
                                                if($achat['pourcentage'] < 50){ ?>
                                            <td>
                                                <div style="margin-top: 6px" class="progress mb-3">
                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="{{ $achat['pourcentage'] }}" aria-valuemin="0"
                                                         aria-valuemax="100" style="width: {{ $achat['pourcentage'] }}%">
                                                    </div>
                                                </div>
                                            </td>

                                            <td><span class="badge bg-danger">{{ $achat['pourcentage'] }} %</span></td>
                                                <?php } else if($achat['pourcentage'] > 50){ ?>
                                            <td>
                                                <div style="margin-top: 6px" class="progress mb-3">
                                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{ $achat['pourcentage'] }}" aria-valuemin="0"
                                                         aria-valuemax="100" style="width: {{ $achat['pourcentage'] }}%">
                                                    </div>
                                                </div>
                                            </td>

                                            <td><span class="badge bg-success">{{ $achat['pourcentage'] }} %</span></td>
                                                <?php }else if ($achat['pourcentage'] == 50){ ?>
                                                    <td>
                                                        <div style="margin-top: 6px" class="progress mb-3">
                                                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{ $achat['pourcentage'] }}" aria-valuemin="0"
                                                                 aria-valuemax="100" style="width: {{ $achat['pourcentage'] }}%">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-info">{{ $achat['pourcentage'] }} %</span></td>
                                                <?php } ?>


                                            <td>
                                                <a class="btn btn-sm btn-warning" href="{{ route('deviss.export',['id' => $achat['id']]) }}" style="margin-right: 10px;">
                                                    <i class="fas fa-eye"></i>
                                                    Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @error('error')
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h4>{{ $message }}</h4>
                                    </div>
                                </div>
                                @enderror
                            </div>
                            <div class="card-footer clearfix">
                                <div class="float-right">
                                    {{ $pagination->links() }}
                                </div>
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
@endsection
