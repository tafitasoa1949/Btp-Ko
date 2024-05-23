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
                                <h5 class="card-title">Detail devis</h5>
                            </div>
                            <div class="card-body">
                                <h5>Travail : {{ $maison->nom }}</h5>
                                <h5>Durée : {{ $maison->duree }} jour(s)</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Designation</th>
                                        <th>U</th>
                                        <th>Q</th>
                                        <th>PU</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($maison->comptes as $compte)
                                            <tr>
                                                <td>{{ $compte->code }}</td>
                                                <td>{{ $compte->nom }}</td>
                                                <td>{{ $compte->unite->nom }}</td>
                                                <td>{{ $compte->quantite }}</td>
                                                <td>{{ $compte->pu }} Ar</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tr>
                                        <td colspan="4" style="text-align: center">Total</td>
                                        <td>
                                            <?php
                                                $total = 0;
                                                foreach ($maison->comptes as $compte){
                                                    $prix = $compte->quantite * $compte->pu;
                                                    $total += $prix;
                                                }
                                            ?>
                                            {{ $total }} Ar
                                        </td>
                                    </tr>
                                </table>
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
@endsection
